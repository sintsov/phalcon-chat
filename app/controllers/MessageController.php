<?php
/**
 * Controller index
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use MainSource\Models\Messages;
use Phalcon\Mvc\Model\Message,
    MainSource\Messages\Exception as MessageException,
    Phalcon\Http\Response,
    Phalcon\Mvc\View;

class MessageController extends ControllerBase {

    /**
     * ToDo: Need logged error message and monitoring
     * ToDo: Optimized code for formation json
     * @return Phalcon\Http\Response Response return json result
     */
    public function sendAction(){
        $this->view->disable();
        $response = new Response();
        try {
            if ($this->request->isPost()) {
                $message = new Messages();
                $user = $this->session->get('auth');
                if ($user){
                    $message->assign(array(
                        'message' => $this->request->getPost('message', 'striptags'),
                        'userId' => $user['id']
                    ));

                    if ($message->save()){
                        $html = $this->view->getRender('chat', 'message', array('message' => $message), function ($view) {
                            $view->setRenderLevel(View::LEVEL_LAYOUT);
                        });
                        $response->setJsonContent(array('status' => 'success', 'html' => utf8_encode($html)));
                    } else {
                        $errorStr = '';
                        foreach ($message->getMessages() as $error) {
                            $errorStr .= $error .' ';
                        }
                        $response->setJsonContent(array('status' => 'error', 'message' => 'Datebase error when trying to save: '.$errorStr));
                    }
                } else {
                    $response->setJsonContent(array('status' => 'error', 'message' => 'User id fail'));
                }
            } else {
                $response->setJsonContent(array('status' => 'error', 'message' => 'Not post params'));
            }
        } catch (MessageException $e) {
            $response->setJsonContent(array('status' => 'error', 'message' => $e));
        }

        return $response;
    }

    public function getMessagesAction(){
        $this->view->disable();
        $response = new Response();
        if ($this->request->isPost()) {

            $id = $this->request->getPost('lastId');
            if ($id){
                $messages = $this->messages->getMessages($id);
                if ($messages){
                    // TODO: future need js templater and response json data
                    $html = $this->view->getRender('chat', 'messages', array('messages' => $messages), function ($view) {
                        $view->setRenderLevel(View::LEVEL_LAYOUT);
                    });
                    $response->setJsonContent(array('status' => 'success', 'html' => utf8_encode($html)));
                }
            } else {
                // $response->setJsonContent(array('status' => 'error', 'message' => 'Could not get the message'));
            }
            return $response;
        }
    }

} 