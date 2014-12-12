<?php
namespace Xtlan\Core\Component;

use Yii;
use yii\helpers\Json;
use Xtlan\Core\Helper\Text;
use yii\base\Model;
use yii\web\Response;
use yii\helpers\Html;


/**
 * Ajax
 *
 * @package
 * @version
 * @copyright 2011 Ixtlan
 * @author Kirya <cloudkserg11@gmail.com>
 * @license http://www.php.net/license/ PHP
 */
class Ajax
{






    /**
     * sendValidateErrors
     *
     * @param Model $model
     * @param string $message
     * @return void
     */
    public function sendValidateErrors(Model $model, $message = 'error in data') 
    {
        $ajaxErrors = array();
        foreach ($model->errors as $name => $msg) {
            $ajaxErrors[Html::getInputId($model, $name)] =  $msg;
        }

        $this->sendRespond(false, $message, $ajaxErrors);
    }

    /**
     * throwValidateErrors
     *
     * @param Model $model
     * @param mixed $message
     * @return void
     */
    public function throwValidateErrors(Model $model, $message = null)
    {
        $this->sendValidateErrors($model, $message);
        Yii::$app->end();
    }



    /**
     * sendRespond
     * alias for future to ajaxRespong
     */
    public function sendRespond($status, $message ="", $results = array(), $jsonEncode = true) 
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //Выводим результат
        //Форматируем в JSON
        $resultsJson = $results;
        if ($jsonEncode) {
            $resultsJson = Json::encode($resultsJson);
        } 

        //Статус сообщения
        $statusText = $status ? "true" : "false";

        $output = '{"results":' . $resultsJson . ', ' .
            ' "success": "'. $statusText.  '", "message": "' . $message . '"}';
        echo  $output;
    }



}
