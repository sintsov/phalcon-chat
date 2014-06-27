<?php
/**
 * Manages Authentication/Identity Management
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Auth;

use Phalcon\Mvc\User\Component,
    MainSource\Models\Users;

class Auth extends Component {

    public function check($credentials){
        // Check if the user exist
        $user = Users::findFirstByEmail($credentials['email']);
        if ($user == false) {
            throw new Exception('Wrong email/password combination');
        }

        // Check the password
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            throw new Exception('Wrong email/password combination');
        }

        $this->session->set('auth', array(
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name
        ));

        return true;
    }

    public function authUserById($id){
        $user = Users::findFirstById($id);
        if ($user == false) {
            throw new Exception('The user does not exist');
        }

        $this->session->set('auth', array(
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name
        ));
    }

    public function isAuth(){
        if (is_null($this->session->get('auth')))
            return false;
        else
            return true;
    }

    public function logout(){
        $this->session->remove('auth');
    }

    public function getUser(){
        $identity = $this->session->get('auth');
        if (isset($identity['id'])) {

            $user = Users::findFirstById($identity['id']);
            if ($user == false) {
                //писать в лог 'The user does not exist'
            }

            return $user;
        }

        return false;
    }

    public function changePassword($user, $password, $password_confirm){
        $user->password = $password;
        $user->password_confirm = $password_confirm;
        if (!$user->save()){
            return $user->getMessages();
        }
        return true;
    }

} 