<?php
namespace Xtlan\Core\Component;

use yii\base\Component;
use \Datetime;
use Xtlan\Core\Datetime\NullDatetime;
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
        if ($date instanceof NullDatetime) {
            return '';
        }

        //Форматируем дату по человечески
        $date = Yii::$app->formatter->asDateHuman($datetime);

        //Форматируем время по человечески
        $time = $this->formatTime($datetime);

        //Строка вывода
        $datetimeString = "{$date}, {$time}";
        
        return $datetimeString;
    }

    /**
     * formatDiffDatetime
     *
     * @param Datetime|string $datetimeStart
     * @param Datetime|string $datetimeEnd
     * @param string $formatString
     * @return string
     */
    public function formatDiffDatetime(
        $startDatetime, 
        $endDatetime, 
        $formatString = 'с :startDate по :endDate'
    ) {


        //Если какая та из дат пустая 
        //то приравниваем ее другой
        $startDatetime = empty($startDatetime) ? 
            $endDatetime : $startDatetime;
        $endDatetime = empty($endDatetime) ?  
            $startDatetime : $endDatetime;
        
        //Кастим в интовые значения
        $startTimestamp = $startDatetime->getTimestamp();
        $endTimestamp = $endDatetime->getTimestamp();


        //Есть три варианта
        $formatter = Yii::$app->formatter;


        //3 Дата начала и дата конца разные
        //тогда с 12 марта 2012 по 13 марта 2013
        if (date('Y', $startTimestamp) != date('Y', $endTimestamp)) {
            $startDate = $formatter->asDate($startDatetime, 'd MMMM yyyy HH:mm');
            $endDate = $formatter->asDate($endDatetime, 'd MMMM yyyy HH:mm');
        //2 дата начала и дата конца в один год
        //тогда с 12 марта по 13 арпеля 2012
        } elseif ( date('m', $startTimestamp) != date('m', $endTimestamp)) {
            $startDate = $formatter->asDate($startDatetime, 'd MMMM HH:mm');
            $endDate = $formatter->asDate($endDatetime, 'd MMMM yyyy HH:mm');
        //1 Дата начала и дата конца в один месяц
        //тогда с 9 по 9 апреля 2012
        } else {
            $startDate = $formatter->asDate($startDatetime, 'd MMMM HH:mm');
            $endDate = $formatter->asDate($endDatetime, 'd MMMM yyyy HH:mm');
        }

        $string = strtr($formatString, [':startDate' => $startDate, ':endDate' => $endDate]);

        return $string;
    }

    /**
     * formatTime
     *
     * @param Datetime $datetime
     * @return string
     */
    public function formatTime(Datetime $datetime)
    {
        if ($date instanceof NullDatetime) {
            return '';
        }
        return Yii::$app->formatter->asTime($datetime);
    }

    /**
     * formatWeb
     *
     * @param Datetime $date
     * @returnstring
     */
    public function formatWeb(Datetime $date)
    {
        if ($date instanceof NullDatetime) {
            return '';
        }
        return Yii::$app->formatter->asDateTime($date);
    }


}



