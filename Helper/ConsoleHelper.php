<?php
namespace Xtlan\Core\Helper;

use Yii;

/**
* ConsoleHelper
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ConsoleHelper
{
    
    /**
     * debug
     *
     * @param mixed $msg
     * @return void
     */
    public static function debug($msg)
    {
        echo "DEBUG: ".$msg."\n";
        Yii::info($msg);
    }

    /**
     * warning
     *
     * @param mixed $msg
     * @return void
     */
    public static function warning($msg)
    {
        echo "WARNING: ".$msg."\n";
        Yii::warning($msg);
    }


    /**
     * error
     *
     * @param mixed $msg
     * @return void
     */
    public static function error($msg)
    {
        echo "ERROR: ".$msg."\n";
        Yii::error($msg, 'error');
        throw new \Exception($msg);
    }
}
