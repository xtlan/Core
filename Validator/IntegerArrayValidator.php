<?php
namespace Xtlan\Core\Validator;

use yii\validators\Validator;

/**
* IntegerArrayValidator
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class IntegerArrayValidator extends Validator
{


    /**
     * validateAttribute
     *
     * @param mixed $model
     * @param mixed $attribute
     * @return void
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (empty($value)) {
            return true;
        }

        if (!is_array($value)) {
            return $this->addError($model, $attribute, 'Передан не массив');
        }

        foreach ($value as $val) {
            if (!is_numeric($val)) {
                return $this->addError($model, $attribute, 'Передан не числовой массив');
            }
        }

    } 
    
}
