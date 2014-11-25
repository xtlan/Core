<?php
namespace Xtlan\Core\Model;

use yii\db\ActiveRecord as BaseActiveRecord;

/**
* ActiveRecord
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ActiveRecord extends BaseActiveRecord
{
    /**
     * find
     *
     * @return Query
     */
    public static function find()
    {
        return new Query(get_called_class());
    }

    public function getLazyRel($nameRelation, $nameClass)
    {
        if (!isset($this->$nameRelation)) {
            return new $nameClass;
        }
        return $this->$nameRelation;
    }

    
}
