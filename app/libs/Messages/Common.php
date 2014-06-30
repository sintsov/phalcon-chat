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

    const GET_LAST_MESSAGE_LIMIT = 150;

    public function getMessages($messageId = false){
        // not supported subquery or need find
        // SELECT * FROM (
        //      SELECT * FROM messages ORDER BY id DESC LIMIT 150
        //   ) sub
        //  ORDER BY id ASC
        // need think how make 1 query
        $count = Messages::count();
        $limit = Common::GET_LAST_MESSAGE_LIMIT;
        $offset = $count - $limit;
        if ($offset < 0) $offset = 0;
        if ($messageId){
            return Messages::find("id > " . (int) $messageId);
        } else {
            return Messages::find(array(
                "offset" => $offset,
                "limit" => $limit
            ));
        }
    }

} 