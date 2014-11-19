<?php
namespace app\vendor\xtlan\core\Controller;

use Yii;
use yii\widgets\ActiveForm;

/**
* Controller
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class Controller
{
    /**
     * performAjaxValidation
     *
     * @param mixed $model
     * @return void
     */
    public function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax) {
            echo ActiveForm::validate($model);
            Yii::$app->end();
        }
    }
    
}
