<?php

namespace Xtlan\Core\Helper;

use yii\helpers\BaseArrayHelper;

/**
 * Description of DateHelper
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class DateHelper extends BaseArrayHelper
{
    /**
     * WEB_MASK
     */
    const WEB_MASK = 'dd.MM.yyyy';

    /**
     * formatWeb
     * 
     * @param type $inputTimestamp
     * @return string
     */
    public static function formatWeb($inputTimestamp)
    {
        if (empty($inputTimestamp)) {
            return '';
        }

        $timestamp = (int) $inputTimestamp;
        $string = \Yii::$app->formatter->asDate($timestamp, static::WEB_MASK);
        return $string;
    }
}