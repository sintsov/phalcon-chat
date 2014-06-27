<?php
/**
 * Controller base
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use Phalcon\Translate\Adapter\NativeArray,
    Phalcon\Tag;

class ControllerBase extends \Phalcon\Mvc\Controller {

    protected function _getTransPath(){
        $translationPath = $this->config->application->i18n;
        $language = $this->session->get("language");
        if (!$language) {
            $this->session->set("language", "ru");
        }
        if ($language === 'ru' || $language === 'en') {
            return $translationPath.$language;
        } else {
            return $translationPath.'ru';
        }
    }

    /**
     * Loads a translation for the whole site
     */
    public function loadMainTrans(){
        $translationPath = $this->_getTransPath();
        require $translationPath."/main.php";

        //Return a translation object
        $mainTranslate = new NativeArray(array(
            "content" => $message
        ));

        //Set $mt as main translation object
        $this->view->setVar("i18n", $mainTranslate);
    }

    /**
     * Loads a translation for the active controller
     */
    public function loadCustomTrans($dir, $transFile){
        $translationPath = $this->_getTransPath();
        require $translationPath.'/'.$dir."/".$transFile.'.php';

        //Return a translation object
        $controllerTranslate = new NativeArray(array(
            "content" => $messages
        ));

        //Set $t as controller's translation object
        $this->view->setVar("i18n", $controllerTranslate);
    }

    public function initialize(){
        $this->getUserInfo();
        $this->loadMainTrans();
        $this->loadMainTrans();
    }

    public function showMessage($label){
        $i18n = $this->view->getVar("i18n");
        return isset($i18n[$label]) ? $i18n[$label] : $label;
    }

    /**
     * Get user info and set last time active
     */
    public function getUserInfo(){
        if ($this->auth->isAuth()){
            $user = $this->auth->getUser();
            $this->users->setUserTimeActive($user);
            if ($user){
                $this->view->setVar("user", $user);
            }
        }
    }

}