<?php
/**
 * Controller index
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Controllers;

use MainSource\Forms\JoinForm;
use MainSource\Forms\SignForm;
use Phalcon\Mvc\Model\Message,
    Phalcon\Http\Response;

class IndexController extends ControllerBase {
    
    public function indexAction(){
        $this->forms->set('joinForm', new JoinForm());
        $this->forms->set('signForm', new SignForm());
        $this->view->setTemplateBefore('public');
    }

} 