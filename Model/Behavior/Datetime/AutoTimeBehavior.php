<?php
namespace Xtlan\Core\Model\Behavior\Datetime;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use Xtlan\Core\Datetime\NullDatetime;

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
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',

            ActiveRecord::EVENT_AFTER_INSERT => 'afterFind',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterFind'
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

        $datetime = new \DateTime();
        $event->sender->$createdField = $datetime->getTimestamp();
        $event->sender->$modifiedField = $datetime->getTimestamp();
    }

    /**
     * beforeUpdate
     *
     * @param mixed $event
     * @return void
     */
    public function beforeUpdate($event)
    {
        $createdField = $this->createdField;
        $modifiedField = $this->modifiedField;

        $datetime = new \DateTime();
        $event->sender->$modifiedField = $datetime->getTimestamp();


        $createdDatetime = $event->sender->$createdField;
        $event->sender->$createdField = $createdDatetime->getTimestamp();
    }


    /**
     * afterFin d
     *
     * @param mixed $event
     * @return void
     */
    public function afterFind($event)
    {
        $sender = $event->sender;

        $fields = [$this->createdField, $this->modifiedField];
        
        foreach ($fields as $field) {
            $oldValue = $sender->$field;

            $newValue = empty($oldValue) ? new NullDatetime() : new \DateTime();
            $newValue->setTimestamp($oldValue);

            $sender->$field = $newValue;
        }
    
    }




    
}


