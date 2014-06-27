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

    public function getMessages($time = false){
        if ($time){
            //every 10 min
            Messages::find('createdAt > ' . time()-10);
        } else {
            return Messages::find();
        }
    }

} 