<?php
/**
 * Chat messages
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Models;

use Phalcon\Mvc\Model;

class Messages extends Model{

    public $id;

    public $userId;

    public $message;

    public $createdAt;

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate(){
        $this->createdAt = time();
    }

    public function initialize(){
        $this->belongsTo('userId', 'MainSource\Models\Users', 'id', array(
            'alias' => 'users'
        ));
    }

    public function getUserCreatedAt(){
        return date("d.m.Y h:i", $this->createdAt);
    }

    public function getUserCreateAtAgo(){
        return $this->timeElapsedString(date("c", $this->createdAt));
    }

    function timeElapsedString($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

} 