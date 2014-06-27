<?php
/**
 * Users profile model
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Models;

use Phalcon\Mvc\Model,
    MainSource\Models\Messages,
    Phalcon\Mvc\Model\Validator\Email,
    Phalcon\Mvc\Model\Validator\PresenceOf,
    Phalcon\Mvc\Model\Validator\Uniqueness,
    Phalcon\Mvc\Model\Validator\StringLength;

class Users extends Model{

    public $id;

    public $name;

    public $email;

    public $password;

    public $password_confirm;

    public $avatar;

    public $time_visited;

    // time active in minute
    const ONLINE_TIME_ACTIVE = 5;

    public function initialize(){
        $this->hasMany('id', 'MainSource\Models\ResetPasswords', 'usersId', array(
            'alias' => 'resetPasswords',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', 'MainSource\Models\Messages', 'userId', array(
            'alias' => 'messages',
        ));
    }

    public function validation(){
        $this->validate(new Uniqueness(array(
            "field" => "email",
            "message" => "The email is already registered"
        )));

        return $this->validationHasFailed() != true;
    }

    public function getUserAvatar(){
        if ($this->avatar)
            return $this->avatar;
        else
            return $this->getDI()->getShared('config')->user->defaultAvatar;
    }

    public function getStatus(){
        if ($this->time_visited > time()-($this::ONLINE_TIME_ACTIVE*60)){
            return 'online';
        } else{
            return 'offline';
        }
    }

} 