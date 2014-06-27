<?php
/**
 * Class released base functional work with users
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Users;

use Phalcon\Mvc\User\Component,
    MainSource\Models\Users;

class Common extends Component {

    public function getUsersList(){
        $user = $this->auth->getUser();
        if ($user){
            return Users::find("id <> '" . $user->id . "'");
        } else {
            return Users::find();
        }
    }

    public function setUserTimeActive($user){
        if ($user){
            $user->time_visited = time();
            if (!$user->save()) return false;
        } else
            return false;
    }

} 