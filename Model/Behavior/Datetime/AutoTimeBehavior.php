<?php
namespace Xtlan\Core\Model\Behavior\Datetime;

use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
* AutoTimeBehavior
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class AutoTimeBehavior extends Behavior
{

    public $createdField = 'created';

    public $modifiedField = 'modified';

    /**
     * events
     *
     * @return void
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate'
        ];
    }


    /**
     * beforeInsert
     *
     * @param mixed $event
     * @return void
     */
    public function beforeInsert($event)
    {
        $createdField = $this->createdField;
        $modifiedField = $this->modifiedField;

        $event->sender->$createdField = new \DateTime();
        $event->sender->$modifiedField = new \DateTime();
    }

    /**
     * beforeUpdate
     *
     * @param mixed $event
     * @return void
     */
    public function beforeUpdate($event)
    {
        $modifiedField = $this->modifiedField;

        $event->sender->$modifiedField = new \DateTime();
    }

    
}


