<?php
namespace Xtlan\Core\Model\Behavior\User;

use yii\base\Behavior;
use Yii;

/**
* ActivationBehavior
*
*
* create fields
* activpassword - string
* activkey - string
* activtime - int
*
*
* @version 1.0.0
* @author Kirya <cloudkserg11@gmail.com>
*/
class ActivationBehavior extends Behavior
{

    const PUBLISHED_MARK = -1;

    /**
     * maxDiffActivtime максимальное количество времени
     * активации
     *
     * @var int
     */
    public $maxActiveTime = 604800;


    /**
     * initActivation
     *
     * @return void
     */
    public function initActivationReg()
    {
        $this->owner->published = self::PUBLISHED_MARK;
        $this->setActivateInfo($this->owner->password);
        return $this->owner->save();
    }

    /**
     * initActivationPassword
     *
     * @return void
     */
    public function initActivationPassword() 
    {
        $password = Yii::$app->security->generateRandomString(7);
        $this->setActivateInfo($password);
        if (!$this->owner->update()) {
            return false;
        }
        return $password;
    }

    /**
     * activate
     *
     * @return void
     */
    public function activateReg()
    {
        //Проверяем активацию
        if ($this->owner->published != self::PUBLISHED_MARK or !$this->checkActivate()) {
            return false;
        }
        //Публикуем пользователя и активируем пароль
        $this->owner->published = 1;
        $this->clearActivateInfo();
        return $this->owner->update();
    }



    /**
     * activatePassword
     *
     * @return void
     */
    public function activatePassword()
    {
        if (!$this->checkActivate()) {
            return false;
        }
        //Активируем пароль
        $this->owner->setEncodePassword(false);
        $this->owner->password = $this->owner->activpassword;
        $this->owner->repeatPassword = $this->owner->activpassword;
        $this->clearActivateInfo();
        return $this->owner->update();
    }
    

    /**
     * setActivateInfo
     *
     * @param mixed $password
     * @return void
     */
    private function setActivateInfo($password)
    {
        //Шифруем пароль и сохраняем актив инфу
        $this->owner->activpassword = $this->owner->getHashPassword($password);
        $this->owner->activkey = md5($password . microtime());
        $this->owner->activtime = time();
    }


    /**
     * activate
     *
     * @return void
     */
    public function checkActivate()
    {
        //Если ссылка уже устарела
        $diffTime = time() - $this->owner->activtime;
        if ($diffTime > $this->maxActiveTime) {
            return false;
        }
        return true;
    }

    /**
     * clearActivateInfo
     *
     * @return void
     */
    private function clearActivateInfo()
    {
        $this->owner->activpassword = null;
        $this->owner->activkey = null;
        $this->owner->activtime = null;
    }

    
}
