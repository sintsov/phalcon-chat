<?php
/**
 * Project autoloader
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    array(
        'MainSource\Models'      => $config->application->modelsDir,
        'MainSource\Controllers' => $config->application->controllersDir,
        'MainSource\Forms'       => $config->application->formsDir,
        'MainSource\Mail'        => $config->application->libraryDir . '/Mail',
        'MainSource\Auth'        => $config->application->libraryDir . '/Auth',
        'MainSource\Messages'    => $config->application->libraryDir . '/Messages',
        'MainSource\Users'       => $config->application->libraryDir . '/Users',
    )
);

$loader->register();