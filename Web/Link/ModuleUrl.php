<?php
namespace Xtlan\Core\Web\Link;

use Yii;

/**
 * ModuleUrl
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class ModuleUrl extends Url
{



    /**
     * create
     *
     * @param mixed $route
     * @param array $params
     * @return void
     */
    public static function create($route, $params = array())
    {
        return new ModuleUrl($route, $params);
    }

    /**
     * buildCurRoute
     *
     * @return void
     */
    protected function buildCurRoute()
    {
        $controller = Yii::$app->controller;
        //Если модуль не задан нет смысла сравнивать
        if (!isset($controller->module)) {
            return false;
        }

        $route = $controller->module->id . '/' . $controller->id; 
        if ($this->_withoutAction) {
            return $route;
        }
        return $route . '/' . $controller->action->id;

    }


    /**
     * defineTypeCheck
     *
     * @param mixed $route
     * @return void
     */
    protected function defineTypeCheck($route)
    {
        $parts = explode('/', ltrim($route, '/'));    
        if (count($parts) == 3) {
            $this->_withoutAction = false;
        } else {
            $this->_withoutAction = true;
        }
    }






}

