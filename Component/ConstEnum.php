<?php
namespace Xtlan\Core\Component;

/**
 * ConstEnum
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class ConstEnum
{
    /**
     * _instance
     *
     * @var mixed
     */
    private static $_instance;


    /**
     * getEnum
     *
     * @return void
     */
    public static function getEnum()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new static();
        }
        return self::$_instance;
    }
    
    /**
     * getTitle
     *
     * @param string $name
     * @return string
     */
    public function getTitle($name)
    {
        $titles = $this->getTitles();
        if (!isset($titles[$name])) {
            return null;
        }
        return $titles[$name]; 
    }

    /**
     * getValues
     *
     * @return array 
     */
    public function getValues()
    {
        $reflect = new \ReflectionClass(get_class($this));
        return $reflect->getConstants();
    }


}
