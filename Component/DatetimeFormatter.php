<?php
namespace Xtlan\Core\Component;

use yii\base\Component;
use \Datetime;
use Yii;

/**
 * DatetimeFormatter
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class DatetimeFormatter extends Component
{



    /**
     * formatMinute
     *
    *  @param Datetime $datetime
     * @return string
     */
    public function formatMinute(Datetime $datetime)
    {
        $timestamp = $datetime->getTimestamp();
        //Разница между датами
        $difference = time() - $timestamp;

        //Получаем разницу в минутах
        $minutes = round($difference/(60));

        //Строка вывода
        return  $minutes . ' мин.';
    }


    /**
     * formatHuman
     *
     * @param Datetime $datetime
     * @return string
     */
    public function formatHuman(Datetime $datetime)
    {

        //Форматируем дату по человечески
        $date = Yii::$app->dateFormatter->formatHuman($datetime);

        //Форматируем время по человечески
        $time = $this->formatTime($datetime);

        //Строка вывода
        $datetimeString = "{$date}, {$time}";
        
        return $datetimeString;
    }

    /**
     * formatDiffDatetime
     *
     * @param int $timestampStart
     * @param int $timestampEnd
     * @param string $formatString
     * @return string
     */
    public function formatDiffDatetime(
        $inputTimestampStart, 
        $inputTimestampEnd, 
        $formatString = '' ) 
    {

        $dateFormatter = Yii::app()->dateFormatter;

        //Если какая та из дат пустая 
        //то приравниваем ее другой
        $timestampStart = empty($inputTimestampStart) ? 
            $inputTimestampEnd : $inputTimestampStart;
        $timestampEnd = empty($inputTimestampEnd) ?  
            $inputTimestampStart : $inputTimestampEnd;
        
        //Кастим в интовые значения
        $timestampStart = (int)$timestampStart;
        $timestampEnd = (int)$timestampEnd;


        //Есть три варианта


        //3 Дата начала и дата конца разные
        //тогда с 12 марта 2012 по 13 марта 2013
        if (date('Y', $timestampStart) != date('Y', $timestampEnd)) {
            $dateStart = $dateFormatter->format('d MMMM yyyy HH:mm', $timestampStart);
            $dateEnd = $dateFormatter->format('d MMMM yyyy HH:mm', $timestampEnd);
        //2 дата начала и дата конца в один год
        //тогда с 12 марта по 13 арпеля 2012
        } elseif ( date('m', $timestampStart) != date('m', $timestampEnd)) {
            $dateStart = $dateFormatter->format('d MMMM HH:mm', $timestampStart);
            $dateEnd = $dateFormatter->format('d MMMM yyyy HH:mm', $timestampEnd);
        //1 Дата начала и дата конца в один месяц
        //тогда с 9 по 9 апреля 2012
        } else {
            $dateStart = $dateFormatter->format('d MMMM HH:mm', $timestampStart);
            $dateEnd = $dateFormatter->format('d MMMM yyyy HH:mm', $timestampEnd);
        }

        if (empty($formatString)) {
            $formatString = 'с :dateStart по :dateEnd';
        }
        $string = Yii::t(
            'cms', 
            $formatString, 
            array(':dateStart' => $dateStart, ':dateEnd' => $dateEnd), 
            'cmsMessages'
        );

        return $string;
    }

    /**
     * formatTime
     *
     * @param Datetime $datetime
     * @return void
     */
    public function formatTime(Datetime$datetime)
    {
        return Yii::$app->formatter->asTime($datetime);
    }

    /**
     * formatWeb
     *
     * @param DateTime $date
     * @return void
     */
    public function formatWeb(DateTime $date)
    {
        return Yii::$app->formatter->asDateTime($date);
    }


}



