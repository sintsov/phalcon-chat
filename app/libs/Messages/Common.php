<?php
/**
 * Class released base functional work with users messages
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Messages;

use Phalcon\Mvc\User\Component,
    MainSource\Models\Messages;

class Common extends Component {

    public function getMessages($messageId = false){
        if ($messageId){
            return Messages::find('id > ' . (int) $messageId);
        } else {
            return Messages::find();
        }
    }

} 