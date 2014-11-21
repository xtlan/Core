<?php
namespace Xtlan\Core\Helper;

use yii\helpers\ArrayHelper as BaseArrayHelper;

/**
* ArrayHelper
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ArrayHelper extends BaseArrayHelper
{

    /**
     * isLastKey
     *
     * @param array $array
     * @param int $index
     * @return boolean
     */
    public static function isLastKey(array $array, $index)
    {
        return count($array) == ($index+1);
    }
    /**
     * withoutFirst
     *
     * @param array $arr
     * @return array
     */
    public static function withoutFirst(array $arr)
    {
        return array_slice($arr, 1);
    }

    /**
     * mergeToString
     *
     * @param array $objects - массив объектов
     * @param string $nameField - поле объекта, которое объединяется в строку 'title'
     * @param string $template - шаблон которым объекты объединяются (например ', ')
     * @return string
     */
    public static function mergeToString($objects, $nameField = 'title', $template = ', ')
    {
        $values = array();
        foreach ($objects as $object) {
            $values[] = $object->$nameField;
        }

        return implode($template, $values);
        
    }
    
}


