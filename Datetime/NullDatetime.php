<?php
namespace Xtlan\Core\Datetime;
/**
 * NullDatetime
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class NullDatetime extends \Datetime
{

    /**
     * format
     *
     * @param mixed $format
     * @return void
     */
    public function format($format)
    {
        return '';
    }

    /**
     * getTimestamp
     *
     * @return void
     */
    public function getTimestamp()
    {
        return 0;
    }



}


