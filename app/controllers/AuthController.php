<?php
/**
 * Controller index
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use MainSource\Forms\SignForm;
use MainSource\Forms\JoinForm;
use Phalcon\Mvc\Model\Message,
    Phalcon\Http\Response,
    MainSource\Models\Users,
    MainSource\Auth\Exception as AuthException;

class AuthController extends ControllerBase {

    public function signinAction(){
        $form = new SignForm();

        try {

            if ($this->request->isPost()) {

                if ($form->isValid($this->request->getPost()) == false) {
                    $msg = '';
                    foreach ($form->getMessages() as $message) {
                        $msg .= $message . "<br/>";
                    }
                    $this->flashSession->error($msg);
                } else {

                    $this->auth->check(array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password')
                    ));

                }
            }
        } catch (AuthException $e) {
            $this->flashSession->error($e->getMessage());
        }

        $this->view->form = $form;

        return $this->response->redirect();
    }

    public function joinAction(){
        $form = new JoinForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) != false) {

                $user = new Users();
                $user->assign(array(
                    'name' => $this->request->getPost('name', 'striptags'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->security->hash($this->request->getPost('password'))
                ));
                $id = $user->save();
                if (!$id) {
                    $this->flashSession->error($user->getMessages());
                } else {
                    $this->auth->authUserById($user->id);
                    return $this->response->redirect();
                }
            } else{
                $msg = '';
                foreach ($form->getMessages() as $message) {
                    $msg .= $message . "<br/>";
                }
                $this->flashSession->error($msg);
            }
        }

        return $this->response->redirect('#join');
    }

    public function singoutAction(){
        $this->auth->logout();
        return $this->response->redirect();
    }

} 