<?php
namespace Xtlan\Core\Web\Link;

use yii\base\Object;
use Yii;
use yii\web\UrlManager;

/**
 * Url
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class Url extends Object
{
    /**
     * _route
     *
     * @var string
     */
    protected $_route;
    /**
     * _params
     *
     * @var array
     */
    protected $_params;
    /**
     * _current
     *
     * @var string
     */
    private $_current;

    /**
     * _urlManager
     *
     * @var CUrlManager
     */
    private $_urlManager;
    
    /**
     * _withoutAction
     * Флаг показывающий, учитывать или нет 
     * дейстивие при сравнении
     *
     * @var mixed
     */
    protected $_withoutAction;

    private $_childrens = array();

    /**
     * __construct
     *
     * @param mixed $url
     * @return void
     */
    public function __construct($route, $params = array())
    {
        $this->_route = $route;
        $this->_params = $params;

        $this->defineTypeCheck($route);
    }


    /**
     * create
     *
     * @param mixed $route
     * @param array $params
     * @return void
     */
    public static function create($route, $params = array())
    {
        //модульнный ли это url ?
        $countDelimeters = substr_count(ltrim($route, '/'), '/');
        if ($countDelimeters > 1) {
            return new ModuleUrl($route, $params);
        }
 
        return new Url($route, $params);
    }

    /**
     * Gets the value of urlManager
     *
     * @return CUrlManager
     */
    public function getUrlManager()
    {
        if (!isset($this->_urlManager)) {
            $this->_urlManager = Yii::$app->urlManager;
        }
        return $this->_urlManager;
    }
    
    /**
     * Sets the value of urlManager
     *
     * @param UrlManager $urlManager 
     */
    public function setUrlManager(UrlManager $urlManager)
    {
        $this->_urlManager = $urlManager;
        return $this;
    }
    

    /**
     * withoutAction
     * @return \AUrl
     */
    public function withoutAction()
    {
        $this->_withoutAction = true;
        return $this;
    }

    /**
     * getString
     * @return string
     */
    public function getString()
    {
        return  $this->getUrlManager()->createUrl($this->_route, $this->_params);
    }

    /**
     * getRoute
     *
     * @return void
     */
    public function getRoute()
    {
        return $this->_route;
    }

    /**
     * getParams
     *
     * @return void
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * addChildren
     *
     * @param mixed $url
     * @return void
     */
    public function addChildren(Url $url)
    {
        $this->_childrens[] = $url;
        return $this;
    }

    /**
     * getChildrens
     *
     * @return void
     */
    public function getChildrens()
    {
        return $this->_childrens;
    }


    /**
     * hasChildren
     *
     * @return void
     */
    public function hasChildren()
    {
        if (count($this->_childrens) > 0)
            return true;
        return false;
    }


    /**
     * buildCurRoute
     *
     * @return void
     */
    protected function buildCurRoute()
    {
        $controller = Yii::$app->controller;

        $route = $controller->id; 
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
        $parts = explode('/', trim($route, '/'));    
        if (count($parts) == 2) {
            $this->_withoutAction = false;
        } else {
            $this->_withoutAction = true;
        }
    }




    /**
     * isCurrent
     *
     * @return void
     */
    public function isCurrent()
    {
        if (!isset($this->_current)) {
            $this->_current = $this->checkIsCurrent();
        }
        return $this->_current;
    }

    /**
     * checkIsCurrent
     *
     * @return void
     */
    private function checkIsCurrent()
    {
        //Получаем текущий маршрут
        if (!$route = $this->buildCurRoute()) {
            return false;
        }

        //Получаем массив маршрутов 
        //для текущего пункта меню
        $urls = array();
        $urls[] = array($this->route, $this->params);
        //Получаем массив маршрутов 
        //для всех подпунктов меню
        foreach ($this->_childrens as $subLink) {
            $urls[] = array($subLink->route, $subLink->params);
        }

        //Проходим по маршрутам 
        //сверяя их с текущим
        foreach ($urls as $url) {
            if(empty($url))
                continue;

            if (isset($url)
                && is_array($url)
                && !strcasecmp(trim($url[0], '/'), $route)
            ) {
                if (count($url)>1 and !empty($url[1])) {
                    foreach ($url[1] as $name=>$value) {
                        if (isset($_GET[$name]) && $_GET[$name]==$value) {
                            return true;
                        }
                    }
                    continue;
                }
                return true;
            }
        }
        return false;

    
    }
}
