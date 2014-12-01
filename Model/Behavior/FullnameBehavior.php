<?php
namespace Xtlan\Core\Model\Behavior;

use yii\base\Behavior;

/**
* FullnameBehavior
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class FullnameBehavior extends Behavior
{
    /**
     * getFullname
     *
     * @return void
     */
    public function getFullname()
    {
        $fullName = $this->owner->surname . ' ';

        if (!empty($this->owner->name)) {
            $fullName .= $this->owner->name . ' ';
        }

        if (!empty($this->owner->patronymic)) {
            $fullName .= $this->owner->patronymic . ' ';
        }
        return $fullName;
    }

    /**
     * getAbbrname
     *
     * @return void
     */
    public function getAbbrFullname()
    {
        $abbrName = $this->owner->surname . " ";

        if (!empty($this->owner->name)) {
            $abbrName .= mb_substr($this->owner->name, 0, 1) . '.';
        }

        if (!empty($this->owner->patronymic)) {
            $abbrName .= mb_substr($this->owner->patronymic, 0, 1). '.';
        }

        return $abbrName;
    }
    
}
