<?php
namespace Xtlan\Core\Controller;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorException;
use yii\base\Model;
use Xtlan\Core\Component\Ajax;
use yii\web\Controller as BaseController;
use yii\web\Response;

/**
* Controller
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class Controller extends BaseController
{

    const POST_METHOD = 'POST';

    /**
     * ajaxValidate
     *
     * @param Model $form
     * @return void
     */
    protected function ajaxValidate(Model $form)
    {   
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($form);
    }

    /**
     * isAjaxValidation
     *
     * @param Model $form
     * @param mixed $method
     * @return void
     */
    protected function isAjaxValidation(Model $form, $method = self::POST_METHOD)
    {
        if ($method == self::POST_METHOD) {
            $ajax = Yii::$app->request->post('ajax');
        } else {
            $ajax = Yii::$app->request->get('ajax');
        }

        return (Yii::$app->request->isAjax and isset($ajax));
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
            return $ajax->throwValidateErrors($item, $message);
        }


        if (YII_ENV_DEV) {
            $message .= print_r($item->errors, true);
        }
        throw new NotFoundHttpException($message);
    }

    /**
     * renderOwnAjax
     *
     * @param mixed $view
     * @param mixed $params
     * @return string
     */
    protected function renderOwnAjax($view, $params = [])
    {
        $content = $this->renderAjax($view, $params);
        $ajax = new Ajax;
        return $ajax->sendRespond(true, null, $content);
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
