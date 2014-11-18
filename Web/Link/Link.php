<?php
namespace Xtlan\Core\Web\Link;

use yii\base\Object;

/**
 * Link
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class Link extends Object
{
    /**
     * _url
     *
     * @var Url
     */
    protected $_url;
    /**
     * _title
     *
     * @var string
     */
    protected $_title;

    /**
     * __construct
     *
     * @param mixed $url
     * @param string $title
     * @return void
     */
    public function __construct($url, $title = '')
    {
        $this->_url = $url;
        $this->_title = $title;
    }

    /**
     * getUrl
     *
     * @return Url
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * setAUrl
     *
     * @param AUrl $url
     * @return void
     */
    public function setUrl(Url $url)
    {
        $this->_url = $url;
    }

    /**
     * getTitle
     *
     * @return void
     */
    public function getTitle()
    {
        return $this->_title;
    }
}
