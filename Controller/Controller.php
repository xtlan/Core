<?php
namespace Xtlan\Core\Controller;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorException;
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

    /**
     * getFilter
     *
     * @param string $filterName
     * @param array $params
     * @return yii\base\Model
     */
    public function getFilter($filterName, array $params)
    {
        if (!class_exists($filterName)) {
            throw new ServerErrorException('Нет такого класса с фильтром: ' . $filterName);
        }
        $filter = new $filterName;
        $filter->load($params);
        if (!$filter->validate()) {
            throw new NotFoundHttpException('Фильтр неверный');
        }

        return $filter;
    }
    
}
