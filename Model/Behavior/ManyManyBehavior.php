<?php
namespace Xtlan\Core\Model\Behavior;

use yii\db\ActiveRecord;
use yii\db\ActiveRecordInterface;
use yii\base\Behavior;
use Xtlan\Core\Helper\ArrayHelper;

/**
* ManyManyBehavior
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ManyManyBehavior extends Behavior
{

    /**
     * relations
     *
     * @var array (name_link => name_relation, ...)
     */
    public $relations = array();

    /**
     * oldLinkValues
     *
     * @var array (name_link => old_value, ...)
     */
    private $oldLinkValues = array();


    /**
     * events
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND  => 'afterFind',

            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',

            ActiveREcord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }



    /**
     * afterFind
     *
     * @param mixed $event
     * @return void
     */
    public function afterFind($event)
    {
        $sender = $event->sender;
        foreach ($this->relations as $link => $rel) {
            $sender->$link = $this->getLinkKeys($sender, $rel); 
            $this->oldLinkValues[$link] = $sender->$link;

        }

    }



    /**
     * afterSave
     *
     * @param mixed $event
     * @return void
     */
    public function afterSave($event)
    {
        $sender = $event->sender;

        foreach ($this->relations as $link => $rel) {
            if ($this->isChanged($sender, $link)) {
                $this->clearRelation($sender, $rel);   
                $this->saveRelation($sender, $rel, $sender->$link);   
            }
        }
    }

    /**
     * beforeDelete
     *
     * @param mixed $event
     * @return void
     */
    public function beforeDelete($event)
    {
        $sender = $event->sender;

        foreach ($this->relations as $rel) {
            $this->clearRelation($rel);
        }
    }

    /**
     * isChanged
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $link
     * @return boolean
     */
    private function isChanged(ActiveRecordInterface $sender, $link)
    {
        if (!isset($this->oldLinkValues[$link])) {
            return !empty($link);
        }
        return $this->oldLinkValues[$link] != $sender->$link; 
    }

    /**
     * clearRelation
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $relationName
     * @return void
     */
    private function clearRelation(ActiveRecordInterface $sender, $relationName)
    {
        $sender->unlinkAll($relationName);
    }

    /**
     * saveRelation
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $relationName
     * @param array $values
     * @return void
     */
    private function saveRelation(ActiveRecordInterface $sender, $relationName, array $values)
    {
        foreach ($values as $value) {
            $relation = $this->loadRelation($sender, $relationName, $value);    
            $sender->link($relationName, $relation);
        }
    }

    /**
     * loadRelation
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $relationName
     * @param mixed $value
     * @return ActiveRecordInterface
     */
    private function loadRelation(ActiveRecordInterface $sender, $relationName, $value)
    {
        $className = $sender->getRelation($relationName)->modelClass;
        $linkField = $this->getLinkField($sender, $relationName);

        $relation = $className::find()->andWhere([$linkField => $value])->one();
        if (!isset($relation)) {
            throw new \Exception('Не удается найти отношение ' . $relationName . ' по ключу ' . $value);
        }

        return $relation;
    }

    /**
     * getLinkField
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $relationName
     * @return string
     */
    private function getLinkField(ActiveRecordInterface $sender, $relationName)
    {
        return key($sender->getRelation($relationName)->link);
    }

    /**
     * getLinkKeys
     *
     * @param ActiveRecordInterface $sender
     * @param mixed $relationName
     * @return array
     */
    private function getLinkKeys(ActiveRecordInterface $sender, $relationName)
    {
        $linkField = $this->getLinkField($sender, $relationName);
        return ArrayHelper::getColumn($sender->$relationName, $linkField);
    } 


}
