<?php
namespace Xtlan\Core\Model;

use yii\db\ActiveQuery;
use yii\db\Expression;

/**
* Query
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class Query extends ActiveQuery
{

    const ASC = 0;
    const DESC = 1;
    const DEFAULT_SORT = 'default';

    /**
     * sortDir
     *
     * @var mixed
     */
    public $sortDir;

    /**
     * sortOrder
     *
     * @var mixed
     */
    public $sortOrder;

    /**
     * sort
     *
     * @param string $order
     * @param string $dir
     * @return void
     */
    public function sort($order = self::DEFAULT_SORT, $dir = self::DESC)
    {
        $this->sortId($dir);
        $this->setSortMark(self::DEFAULT_SORT, $dir);
        return $this;
    }

    /**
     * sortId
     *
     * @param string $order
     * @param string $dir
     * @return Query
     */
    public function sortId($dir = self::DESC)
    {
        $this->addOrderBy('id ' . $this->dir($dir));
        return $this;
    }

    /**
     * sortBySort
     *
     * @return Query
     */
    public function sortBySort($dir = self::ASC)
    {
        $this->addOrderBy(new Expression('`sort` IS NOT NULL'));
        $this->addOrderBy(new Expression('sort ' . $this->dir($dir)));
        $this->addOrderBy('id ' . $this->dir(!$dir));
        return $this;
    }

    /**
     * setSortMark
     *
     * @param string $order
     * @param mixed $dir
     * @return void
     */
    protected function setSortMark($order, $dir)
    {
        $this->sortOrder = $order;
        $this->sortDir = $dir;
    }


    /**
     * dir
     *
     * @param boolean $dir
     * @return string
     */
    protected function dir($dir)
    {
        return $dir ? 'DESC' : 'ASC';
    }


    /**
     * published
     *
     * @return Query
     **/
    public function published()
    {
        $this->andWhere(['published'  =>  '1']);
        return $this;
    }

    /**
     * random
     *
     * @return Query
     */
    public function random()
    {
        $this->addOrderBy('RAND()');
        return $this;
    }


    /**
     * forId
     *
     * @param mixed $id
     * @return Query
     */
    public function forId($id)
    {
        $this->andWhere(['id' => $id]);
        return $this;
    }

    
}
