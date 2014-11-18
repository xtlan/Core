<?php
namespace Xtlan\Core\Web\Link;

/**
 * NullUrl
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class NullUrl extends Url
{


    /**
     * __construct
     *
     * @param string $route
     * @param array $params
     * @return void
     */
    public function __construct($route = '', $params = array())
    {
    
    }

    /**
     * create
     *
     * @param string $route
     * @param array $params
     * @return NullUrl
     */
    public static function create($route = '', $params = array())
    {
        return new NullUrl($route, $params);
    }


    /**
     * getString
     *
     * @return string
     */
    public function getString()
    {
        return '';
    }


    /**
     * getRoute
     *
     * @return array
     */
    public function getRoute()
    {
        return '';
    }

    /**
     * getParams
     *
     * @return array
     */
    public function getParams()
    {
        return array();
    }

    /**
     * isCurrent
     *
     * @return boolean
     */
    public function isCurrent()
    {
        return false;
    }


}
