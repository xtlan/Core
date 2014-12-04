<?php
namespace Xtlan\Core\Helper;

use yii\web\GroupUrlRule;

/**
* RouteHelper
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class RouteHelper
{

    public static function getModuleRoute($moduleName, array $controllers = array(), $prefix = '')
    {
        $controllerString = '';
        if (!empty($controllers)) {
            $controllerString = '(' . implode('|', $controllers) . ')';
        }

        return [
            "{$moduleName}/<controller:{$controllerString}>" => "{$moduleName}/<controller>/index",
            "{$moduleName}/<controller:{$controllerString}>/<id:\d+>" => "{$moduleName}/<controller>/edit",
            "{$moduleName}/<controller:{$controllerString}>/<action>" => "{$moduleName}/<controller>/<action>"
        ];
    }
    
}
