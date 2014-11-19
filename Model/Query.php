<?php
namespace Xtlan\Core\Model;

use yii\db\ActiveQuery;

/**
* Query
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class Query extends ActiveQuery
{

    const DESC = 'DESC';
    const ASC = 'ASC';

    /**
     * sort
     *
     * @param string $order
     * @param string $dir
     * @return Query
     */
    public function sort($dir = self::DESC)
    {
        $this->addOrderBy('id ' . $dir);
        return $this;
    }

    /**
     * sortBySort
     *
     * @return Query
     */
    public function sortBySort($dir = self::ASC)
    {
        $this->addOrderBy('sort IS NULL');
        $this->addOrderBy('sort ' . $dir);
        $this->addOrderBy('id ' . $this->notDir($dir));
        return $this;
    }

    /**
     * notDir
     *
     * @param string $dir
     * @return string
     */
    protected function notDir($dir)
    {
        return ($dir == self::ASC ? self::DESC : self::ASC);
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
    
}
