<?php
/**
 * Config file
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

return new \Phalcon\Config(array(
    'database' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        /*'username' => '032582006_chat',
        'password' => '1234567',
        'dbname' => 'mainsource_phalcon-chat'*/
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'phalcon-chat'
    ),
    'application' => array(
        'controllersDir' => APP_DIR . '/controllers/',
        'modelsDir' => APP_DIR . '/models/',
        'formsDir' => APP_DIR . '/forms/',
        'viewsDir' => APP_DIR . '/views/',
        'libraryDir' => APP_DIR . '/libs/',
        'i18n' => APP_DIR . '/i18n/',
        'cacheDir' => APP_PATH . '/cache/',
        'voltCacheDir' => APP_PATH . '/cache/volt/',
        'metaDataCacheDir' => APP_PATH . '/cache/metaData/',
        'development'    => array(
            'staticBaseUri' => '/',
            'baseUri'       => '/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://phalcon-chat.mainsource.ru/',
            'baseUri'       => '/'
        ),
        'debug'          => true
    ),
    'mail' => array(
        'fromName' => 'Phalcon-Chat',
        'fromEmail' => 'noreply@mainsource.ru'
    ),
    'user' => array(
        'defaultAvatar' => '/images/default_ava.png'
    )
));