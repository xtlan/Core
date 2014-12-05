<?php
namespace Xtlan\Core\Validator;

use yii\validators\StringValidator as BaseStringValidator;

/**
* StringValidator
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class StringValidator extends BaseStringValidator
{

    
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = (string)$model->$attribute;
        return parent::validateAttribute($model, $attribute);
    }
    
}
