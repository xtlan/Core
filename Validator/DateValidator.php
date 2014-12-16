<?php
namespace Xtlan\Core\Validator;

use yii\validators\DateValidator as BaseDateValidator;

/**
* DateValidator
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class DateValidator extends BaseDateValidator
{

    public $format = 'dd.MM.y';

    public function validateAttribute($model, $attribute)
    {
        parent::validateAttribute($model, $attribute);

        $errors = $model->getErrors($attribute);
        $value = $model->$attribute;
        if (empty($errors) and !empty($value)) {
            $value = \DateTime::createFromFormat('d.m.Y', $value);
            $model->$attribute = $value;
        }
    }
    
}
