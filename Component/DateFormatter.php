<?php
namespace Xtlan\Core\Component;

use Xtlan\Core\Helper\Text;
use yii\base\Component;
use \Datetime;

class DateFormatter extends Component
{


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

    public function formatWeb(DateTime $date)
    {
        return Yii::$app->formatter->asDate($date);
    }

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
     * @param Datetime $startDate
     * @param Datetime $endDate
     * @param string $formatString
     * @return string
     */
    public function formatDiffDate(
        $startDate, 
        $endDate, 
        $formatString = '' ) 
    {

        $inputTimestampStart = $startDate->getTimestamp();
        $inputTimestampEnd = $endDate->getTimestamp();

        //Если какая та из дат пустая 
        //то приравниваем ее другой
        $startTimestamp = empty($inputTimestampStart) ? 
            $inputTimestampEnd : $inputTimestampStart;
        $endTimestamp = empty($inputTimestampEnd) ?  
            $inputTimestampStart : $inputTimestampEnd;
        
        //Кастим в интовые значения
        $startTimestamp = (int)$startTimestamp;
        $endTimestamp = (int)$endTimestamp;


        //Есть три варианта
        $dateFormatter = Yii::$app->formatter;


        //3 Дата начала и дата конца разные
        //тогда с 12 марта 2012 по 13 марта 2013
        if (date('Y', $startTimestamp) != date('Y', $endTimestamp)) {
            
            $startDate = $dateFormatter->asDate($timestmapStart, 'd MMMM yyyy');
            $endDate = $dateFormatter->asDate($endTimestamp, 'd MMMM yyyy');
        //2 дата начала и дата конца в один год
        //тогда с 12 марта по 13 арпеля 2012
        } elseif ( date('m', $startTimestamp) != date('m', $endTimestamp)) {
            $startDate = $dateFormatter->asDate('d MMMM', $startTimestamp);
            $endDate = $dateFormatter->asDate('d MMMM yyyy', $endTimestamp);
        //1 Дата начала и дата конца в один месяц
        //тогда с 9 по 9 апреля 2012
        } else {
            $startDate = $dateFormatter->asDate('d', $startTimestamp);
            $endDate = $dateFormatter->asDate('d MMMM yyyy', $endTimestamp);
        }

        if (empty($formatString)) {
            $formatString = 'с :startDate по :endDate';
        }
        $string = str_replace(':startDate', $startDate, $formatString);
        $string = str_replace(':endDate', $endDate, $string);

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



