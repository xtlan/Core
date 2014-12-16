<?php
namespace Xtlan\Core\Model;

use yii\base\Model;
use yii\db\QueryInterface;

/**
 * SearchModel
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class SearchModel extends Model
{

    /**
     * search
     *
     * @param QueryInterface $query
     * @return void
     */
    public function search(QueryInterface $query)
    {
        foreach ($this->attributes as $name => $attribute) {
            if (!empty($attribute)) {
                $methodName = 'for' . ucfirst($name);
                if (method_exists($query, $methodName)) {
                    $query->$methodName($attribute);
                }
            }
        }



        return $query;
    }

}
