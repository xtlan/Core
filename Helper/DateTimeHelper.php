<?php
namespace Xtlan\Core\Helper;

use yii\helpers\BaseArrayHelper;

/**
 * Description of DateHelper
 *
 * @author art3mk4 <Art3mk4@gmail.com>
 */
class DateTimeHelper extends BaseArrayHelper
{

    const WEB_MASK = 'dd.MM.yyyy HH:mm';
    const TIME_MASK = 'HH:mm';
    const ISO_MASK = 'yyyy-MMTHH:mm';

    /**
     * formatTime
     *
     * @param int $timestamp
     * @param string $default
     * @return string (HH:mm)
     */
    public static function formatTime($timestamp, $default = '')
    {
        if (empty($timestamp)) {
            return $default;
        }

        return \Yii::$app->formatter->asTime((int)$timestamp, self::TIME_MASK);
    }
}