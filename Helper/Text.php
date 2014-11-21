<?php
namespace Xtlan\Core\Helper;

use yii\helpers\Html;

/**
 * Text
 *
 * Класс для работы с текстом
 *
 *
 * @package components
 * @version
 * @copyright 2011 Ixtlan
 * @author Kirya <cloudkserg11@gmail.com>
 * @license http://www.php.net/license/ PHP
 */
class Text
{

    /* public close_tags($html) {{{ */
    /**
     * close_tags
     * Закрыает теги в переданном тексте
     *
     * @param string $html текст
     * @access public
     * @return string текст
     */
    public static function close_tags($html)
    {
        #put all opened tags into an array
        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result);
        $openedtags=$result[1];

        #put all closed tags into an array
        preg_match_all("#</([a-z]+)>#iU", $html, $result);
        $closedtags=$result[1];
        $lenOpened = count($openedtags);
        # all tags are closed
        if (count($closedtags) == $lenOpened) {
            return $html;
        }

        $openedtags = array_reverse($openedtags);
        # close tags
        for ($i=0;$i < $lenOpened;$i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }
    // }}}

    /* public wordNum($ids, $words) {{{ */
    /**
     * Возвращает текст об удалении элементов в админке
     *
     * @param mixed $ids количество удаленных элементов
     * @param number $words слова для склонения
     * @access public
     * @return string текст с сообщением
     */
    public static function wordNum($ids, $words)
    {
        $number = (int)substr($ids, -2, 2);
        if ($number >= 5 && $number < 21) {
            return $words[2];
        }
        $number %= 10;
        if ($number == 1) {
            return $words[0];
        }
        if ($number >= 2 && $number <= 4) {
            return $words[1];
        }

        return $words[2];
    }
    // }}}


    /**
     * Функция для вывода текста 
     * урезанного либо по размеру либо по тексткату
     *
     * Урезает текст либо по размеру 
     * (если не выставлена переменная только по кату)
     * либо по кату(если он есть)
     * либо возвращает текст как есть
     *
     * @param string $text текст для урезания 
     * (если не задан берется из модели поле text)
     * 
     * @param bool $onlyCut флаг указывающий - 
     * резать только по кату
     * @param bool $size_min размер для обрезания 
     * (если не задан то 1500)
     * @access public
     * @return string $text урезанный текст
     */
    /**
     * cutText
     *
     * @param mixed $text
     * @param mixed $onlyCut
     * @param int $minSize
     * @return void
     */
    public static function cutText($text, $onlyCut = false, $minSize = 1500) 
    {
        //Проверяем есть ли в тексте тег textcut для вырезки
        $posTextcut = mb_strpos($text, '<a name="textcut">');

        //Если необходимо резать 
        //только по тексткату и текстката нет
        if($posTextcut === false and $onlyCut == true)
            return $text;

        //Если данного тега нет вырезаем вручную
        if ( $posTextcut === false) {
            //Определяем ближайшую точку и пробел
            $spaceLen = @mb_strpos($text,' ',$minSize);
            $pointLen = @mb_strpos($text,'.',$minSize);

            //Режем либо по точке либо пробелу
            $len = $minSize;
            if ($spaceLen > $minSize and $spaceLen < $pointLen)
                $len = $spaceLen;
            if ($pointLen > $minSize and $pointLen < $spaceLen)
                $len = $pointLen;
            //Если есть тег режем по нему
        } else {
            $len = $posTextcut;
        }
        //Режем текст
        $minText = mb_substr($text,0,$len);
        $minText = self::close_tags($minText);

        return $minText;
    }
    // }}}


    /**
     * encode
     *
     * @param mixed $text
     * @return void
     */
    public static function encode($text)
    {
        return Html::encode($text);
    }


    /**
     * translit
     *
     * @param mixed $string
     * @return void
     */
    public static function translit($str)
    {
            $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($str, $tr);
    }




}
