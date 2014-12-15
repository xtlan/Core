<?php
namespace Xtlan\Core\Model\Behavior\User;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * PasswordBehavior
 *
 * @version 1.0.0
 * @copyright Copyright 2011 by Kirya <cloudkserg11@gmail.com>
 * @author Kirya <cloudkserg11@gmail.com>
 */
class PasswordBehavior extends Behavior
{

    /**
     * authField
     *
     * @var string|null
     */
    public $authField; 


    /**
     * passwordField
     *
     * @var string
     */
    public $passwordField = 'password';
    
    /**
     * isEncodePassword
     *
     * @var boolean
     */
    private $_isEncodePassword = true;


    /**
     * events
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave'
        ];
    }

    /**
     * afterSave
     *
     * @param mixed $event
     * @return void
     */
    public function afterSave($event)
    {
        $this->_isEncodePassword = true;
        return true;
    }



    /**
     * beforeInsert
     *
     * @param mixed $event
     * @return void
     */
    public function beforeInsert($event)
    {
        $this->updatePassword($event);

        if (isset($this->authField)) {
            $this->createAuthKey($event);
        }
    }

    /**
     * beforeUpdate
     *
     * @param mixed $event
     * @return void
     */
    public function beforeUpdate($event)
    {
        $this->updatePassword($event);
    }

    /**
     * setEncodePassword
     *
     * @param boolean $flag
     * @return void
     */
    public function setEncodePassword($flag)
    {
        $this->_isEncodePassword = $flag;
    }

    /*
     ** Функция перед сохранением 
     * пользователя
     */
    public function updatePassword($event)
    {
        $sender = $event->sender;
        if (!$this->_isEncodePassword) {
            return;
        }

        $password = $sender->getAttribute($this->passwordField);
        if (empty($password)) {
            $sender->setAttribute(
                $this->passwordField, 
                $sender->getOldAttribute($this->passwordField)
            );
        } 

        if ($this->isChangedPassword()) {
            $hash = $this->getHashPassword($password);
            $sender->setAttribute($this->passwordField, $hash);
        } 

    }

    /**
     * createAuthKey
     *
     * @param mixed $event
     * @return void
     */
    private function createAuthKey($event)
    {
        $sender = $event->sender;
        
        $sender->setAttribute($this->authField, Yii::$app->security->generateRandomString());
    }

    /**
     * validatePassword
     *
     * @param string $password
     * @param string $hash
     * @return boolean
     */
    public function validatePassword($password, $hash)
    {
        return Yii::$app->security->validatePassword($password, $hash);
    }

    /**
     * getHashPassword
     *
     * @param string $password
     * @return string
     */
    public function getHashPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }
    

    /**
     * isChangedPassword
     *
     * @return boolean
     */
    public function isChangedPassword()
    {
        $password = $this->owner->getAttribute($this->passwordField);
        $oldPassword = $this->owner->getOldAttribute($this->passwordField);
        return ($password !== $oldPassword);
    }

}


