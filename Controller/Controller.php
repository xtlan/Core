<?php
namespace Xtlan\Core\Controller;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\base\Model;
use Xtlan\Core\Component\Ajax;
use yii\web\Controller as BaseController;

/**
* Controller
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class Controller extends BaseController
{
    /**
     * performAjaxValidation
     *
     * @param mixed $model
     * @return void
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::$app->request->isAjax) {
            echo ActiveForm::validate($model);
            Yii::$app->end();
        }
    }


    /**
     * throwValidateErrors
     *
     * @param Model $item
     * @param mixed $message
     * @return mixed
     */
    protected function throwValidateErrors(Model $item, $message = null)
    {
        if (Yii::$app->request->isAjax) {
            $ajax = new Ajax();
            $ajax->throwValidateErrors($item, $message);
        }


        return new NotFoundHttpException($message);
    }

    
    /**
     * flashErrors
     *
     * @param Model $item
     * @return void
     */
    public function flashErrors(Model $item)
    {
        foreach ($item->errors as $errors) {
            Yii::$app->session->setFlash('error', implode(', ', $errors));
        }
    }
    
}
