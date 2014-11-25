<?php
namespace Xtlan\Core\Validator;

use yii\validators\DateValidator as BaseDateValidator;

/**
* TimeValidator
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class TimeValidator extends BaseDateValidator
{

    public $format = 'hh:mm';
    
    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);

        $errors = $model->getErrors($attribute);
        $value = $model->$attribute;
        if (empty($errors) and !empty($value)) {
            $value = \DateTime::createFromFormat('h:i', $value);
            $model->$attribute = $value;
        }
    }
    
}
