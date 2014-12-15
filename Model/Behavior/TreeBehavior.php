<?php
namespace Xtlan\Core\Model\Behavior;

use creocoder\behaviors\NestedSet;

/**
* TreeBehavior
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class TreeBehavior extends NestedSet
{


    /**
     * hasManyRoots
     *
     * @var boolean
     */
    public $hasManyRoots = true;


    /**
     * maxLevel
     * Максимальный уровень вложенности
     *
     * @var string
     */
    public $maxLevel = '4';

    
    /**
     * save
     *
     * @return void
     */
    public function saveNode($runValidation = true, $attributes = NULL)
    {
        $model = $this->owner;

         //Если это корень просто сохраняем его
        if (empty($model->parent_id)) {
            return parent::saveNode();
        }

        //Если это ответный комментарий


        //Родитель
        $parentComment = $model::findOne($model->parent_id);
        if (!isset($parentComment->id)) {
            throw new CHttpException('404', 'Идентификатор родителя не верный');
        }

        //Если уровень родителя > 4 значит берем его родителя
        if ($this->owner->level > $this->maxLevel) {
            $parentComment = $model::findOne($parentComment->parent_id);
        }


        //Если это новый комментарий
        if ($this->owner->isNewRecord) {
            return parent::appendTo($parentComment);
        }

        //Если изменяем комментарий
        parent::saveNode();
        return parent::moveAsLast($parentComment);

    }
}
