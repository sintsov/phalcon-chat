<?php
/**
 * Controller management users
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use MainSource\Models\Users;
use Phalcon\Mvc\Model\Message,
    MainSource\Messages\Exception as MessageException,
    Phalcon\Http\Response,
    Phalcon\Mvc\View;

class UsersController extends ControllerBase {

    public function getActualUsersAction(){
        $this->view->disable();
        $response = new Response();
        $users = $this->users->getUsersList();
        if ($users){
            // TODO: future need js templater and response json data and think only status!!! If users > 100
            $html = $this->view->getRender('chat', 'users', array('users' => $users), function ($view) {
                $view->setRenderLevel(View::LEVEL_LAYOUT);
            });
            $response->setJsonContent(array('status' => 'success', 'html' => utf8_encode($html)));
        } else {
            // TODO
        }
        return $response;
    }

} 