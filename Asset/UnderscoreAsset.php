<?php
namespace Xtlan\Core\Asset;

use yii\web\AssetBundle;

/**
* UnderscoreAsset
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class UnderscoreAsset extends AssetBundle
{

    public $sourcePath = '@bower/underscore';
    public $js = [
        'underscore.js'
    ];
    
}
