<?php
/**
 * Stores the reset password codes and their evolution
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Models;

use Phalcon\Mvc\Model;

class ResetPasswords extends \Phalcon\Mvc\Model{
    /**
       *
       * @var integer
       */
      public $id;

      /**
       *
       * @var integer
       */
      public $usersId;

      /**
       *
       * @var string
       */
      public $code;

      /**
       *
       * @var integer
       */
      public $createdAt;

      /**
       *
       * @var integer
       */
      public $modifiedAt;

      /**
       *
       * @var string
       */
      public $reset;

      /**
       * Before create the user assign a password
       */
      public function beforeValidationOnCreate(){
          // Timestamp the confirmaton
          $this->createdAt = time();

          // Generate a random confirmation code
          $this->code = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(24)));

          // Set status to non-confirmed
          $this->reset = 'N';
      }

      /**
       * Sets the timestamp before update the confirmation
       */
      public function beforeValidationOnUpdate(){
          // Timestamp the confirmaton
          $this->modifiedAt = time();
      }

      /**
       * Send an e-mail to restore password
       */
      public function afterCreate(){
          $this->getDI()
              ->getMail()
              ->send(array(
              $this->user->email => $this->user->name
          ), "Restore password", 'reset', array(
              'resetUrl' => '/reset_password/' . $this->code . '/' . $this->user->email
          ));
      }

      public function initialize(){
          $this->belongsTo('usersId', 'MainSource\Models\Users', 'id', array(
              'alias' => 'user'
          ));
      }
}