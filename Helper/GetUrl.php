<?php
namespace Xtlan\Core\Helper;

use yii\web\View;
use yii\helpers\Url;

/**
* GetUrl
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class GetUrl extends Url
{

    /**
     * url
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public static function url($route, array $params = [])
    {
        $params[0] = $route;
        return Url::toRoute($params);
    }

    /**
     * assetsUrl
     *
     * @param View $view
     * @param string $bundleName
     * @param string $path
     * @return string
     */
    public static function assetsUrl(View $view, $bundleName, $path)
    {
        return $view->assetManager->getAssetUrl(
            $view->assetManager->getBundle($bundleName), 
            $path
        );
    
    }

    


}
