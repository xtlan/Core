<?php
namespace Xtlan\Core\Asset;

use yii\web\AssetBundle;

/**
* ActiveFormAsset
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ActiveFormAsset extends AssetBundle
{

    public $sourcePath = '@vendor/xtlan/core/resources';
    public $js = [
        'js/xtlanActiveForm.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    
}
