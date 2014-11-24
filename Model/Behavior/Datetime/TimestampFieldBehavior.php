<?php
namespace Xtlan\Core\Model\Behavior\Datetime;

use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
* TimestampFieldBehavior
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class TimestampFieldBehavior extends Behavior
{

    public $fields = ['time'];

    /**
     * events
     *
     * @return void
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function afterFind($event)
    {
        $sender = $event->sender;
        foreach ($this->fields as $field) {
            $oldValue = $sender->$field;

            $newValue = new \DateTime();
            $newValue->setTimestamp($oldValue);

            $sender->$field = $newValue;
        }
    
    }


    /**
     * beforeSave
     *
     * @param mixed $event
     * @return void
     */
    public function beforeSave($event)
    {
        $sender = $event->sender;
        foreach ($this->fields as $field) {
            $oldValue = $sender->$field;

            $sender->$field = $oldValue->getTimestamp();
        }
    }


    
}


