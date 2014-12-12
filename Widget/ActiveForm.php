<?php
namespace Xtlan\Core\Widget;

use yii\widgets\ActiveForm as BaseForm;
use Xtlan\Core\Asset\ActiveFormAsset;
use yii\base\InvalidCallException;
use yii\helpers\Json;
use yii\helpers\Html;


/**
* ActiveForm
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ActiveForm extends BaseForm
{

    /**
     * Runs the widget.
     * This registers the necessary javascript code and renders the form close tag.
     * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching
     */
    public function run()
    {
        if (!empty($this->_fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }

        if ($this->enableClientScript) {
            $id = $this->options['id'];
            $options = Json::encode($this->getClientOptions());
            $attributes = Json::encode($this->attributes);
            $view = $this->getView();
            ActiveFormAsset::register($view);
            $view->registerJs("jQuery('#$id').xtlanActiveForm($attributes, $options);");
        }

        echo Html::endForm();
    }
    
}
