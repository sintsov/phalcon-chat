<?php
/**
 * Routes rules from project
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

// create router
$router = new \Phalcon\Mvc\Router();

$router->add(
    '/',
    array(
        'controller' => 'index',
        'action'     => 'index'
    )
);

return $router;