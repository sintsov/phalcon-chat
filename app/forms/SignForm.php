<?php
/**
 * Sign In form for project
 *
 * @author Sintsov Roman <romiras_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

namespace MainSource\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Forms\Element\Hidden,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Identical;

class SignForm extends Form {

    public function initialize(){
        // Email
        $email = new Text('email', array(
            'placeholder' => 'Email',
            'class' => 'form-control'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'The e-mail is required'
            )),
            new Email(array(
                'message' => 'The e-mail is not valid'
            ))
        ));

        $this->add($email);

        // Password
        $password = new Password('password', array(
            'placeholder' => 'Password',
            'class' => 'form-control'
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'The password is required'
        )));

        $this->add($password);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('Sign In', array(
            'class' => 'btn btn-success'
        )));
    }
} 