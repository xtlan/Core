<?php
namespace Xtlan\Core\Component;

use Xtlan\Core\Helper\Text;
use yii\base\Component;
use \Datetime;
use Yii;
use Xtlan\Core\Datetime\NullDatetime;

/**
 * DateFormatter
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class DateFormatter extends Component
{


    /**
     * formatHuman
     *
     * @param Datetime $date
     * @return string
     */
    public function formatHuman(Datetime $date)
    {
        $timestamp = $date->getTimestamp();

        //Если эту дату можно охарактеризовать
        //словами (вчера сегодна)
        if ($wordDate = $this->getWordDate($timestamp)) {
            return $wordDate;
        }

        //Форматируем дату
        //Если год текущий
        if ($this->isCurrentYear($timestamp)) {
            $dateString = Yii::$app->formatter->asDate($timestamp, 'd MMMM');
        } else {
            $dateString = Yii::$app->formatter->asDate($timestamp, 'd MMMM yyyy');
        }

        return $dateString;

    }

    /**
     * formatWeb
     *
     * @param DateTime $date
     * @return string
     */
    public function formatWeb(DateTime $date)
    {
        if ($date instanceof NullDatetime) {
            return '';
        }
        return Yii::$app->formatter->asDate($date);
    }

    /**
     * formatDatesAgo
     *
     * @param DateTime $date
     * @return string
     */
    public function formatDatesAgo(DateTime $date)
    {
        $timestamp = $date->getTimestamp();
        $daysAgo = ceil(($timestamp - time()) / 86400);
        if ($daysAgo == 0) {   
            return '0 дней'; 
        } 

        return  $daysAgo . ' ' . Text::wordNum( 
            $daysAgo,             
            array(             
                'день',
                'дня',
                'дней'
            )
        );
    
    }
    
    /**
     * asDiffDate
     *
     * @param Datetime|string $startDate
     * @param Datetime|string $endDate
     * @param string $formatString
     * @return string
     */
    public function formatDiffDate(
        $startDatetime, 
        $endDatetime, 
        $formatString = 'с :startDate по :endDate' ) 
    {
        if (empty($startDatetime) and empty($endDatetime)) {
            return '';
        }

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
            
            $startDate = $formatter->asDate($timestmapStart, 'd MMMM yyyy');
            $endDate = $formatter->asDate($endTimestamp, 'd MMMM yyyy');
        //2 дата начала и дата конца в один год
        //тогда с 12 марта по 13 арпеля 2012
        } elseif ( date('m', $startTimestamp) != date('m', $endTimestamp)) {
            $startDate = $formatter->asDate('d MMMM', $startDatetime);
            $endDate = $formatter->asDate('d MMMM yyyy', $endDatetime);
        //1 Дата начала и дата конца в один месяц
        //тогда с 9 по 9 апреля 2012
        } else {
            $startDate = $formatter->asDate('d', $startDatetime);
            $endDate = $formatter->asDate('d MMMM yyyy', $endDatetime);
        }

        $string = strtr($formatString, [':startDate' => $startDate, ':endDate' => $endDate]);

        return $string;
    }

    /**
     * getWordDate
     *
     * @param int $timestamp
     * @return string|boolean
     */
    private function getWordDate($timestamp)
    {
        //Проверяем это сегодня?
        if ($timestamp >= strtotime('today') and $timestamp < strtotime('today +1 day')) {
            return 'Сегодня';
        }

        //Проверяем это вчера?
        if ($timestamp > strtotime('yesterday') and $timestamp < strtotime('today')) {
            return 'Вчера';
        }

        return false;
    }

    /**
     * isCurrentYear
     *
     * @param int $timestamp
     * @return string
     */
    private function isCurrentYear($timestamp)
    {
        if (date('Y', $timestamp) == date('Y')) {
            return true;
        }
        return false;
    }

}



