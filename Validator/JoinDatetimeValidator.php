<?php
namespace Xtlan\Core\Validator;

use yii\validators\Validator;

/**
* JoinDatetimeValidator
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class JoinDatetimeValidator extends Validator
{

    public $date;

    public $time;

    /**
     * validateAttribute
     *
     * @param mixed $model
     * @param mixed $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute)
    {
        $dateField = $this->date;
        $timeField = $this->time;

        $errors = array_merge($model->getErrors($this->date), $model->getErrors($this->time));
        if (empty($errors)) {
            $value = $model->$dateField;
            $timeValue = $model->$timeField;
            if (!empty($value)) {
                $value->setTime($timeValue->format('h'), $timeValue->format('i'));

                $model->$attribute = $value;
            }
        
        }

    } 
    
}
