<?php
/**
 * Index base file
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

    error_reporting(E_ALL);

    define('APP_PATH', realpath('..'));
    define('APP_DIR', APP_PATH . '/app');

    /**
     * Read the configuration
     */
    $config = require APP_DIR . "/config/config.php";
    /**
     * Include the loader
     */
    require APP_DIR . "/config/loader.php";

try {
    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    /**
     * Include the application services
     */
    require APP_DIR . "/config/services.php";

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
    if ($config->application->debug){
        echo "PhalconException: ", $e->getMessage();
    } else {
        echo 'Sorry, an error has ocurred :(';
    }
}