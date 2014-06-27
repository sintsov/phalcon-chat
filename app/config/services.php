<?php
/**
 * Index base file
 *
 * @author Sintsov Roman <roman_spb@mail.ru>
 * @copyright Copyright (c) 2014, MainSource
 */

use Phalcon\Mvc\View,
    Phalcon\Http\Response\Cookies,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Db\Adapter\Pdo\Mysql as DatabaseConnection,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    MainSource\Auth\Auth,
    MainSource\Mail\Mail,
    MainSource\Messages\Common as MessagesCommon,
    MainSource\Users\Common as UsersCommon,
    Phalcon\Mvc\Dispatcher as MvcDispatcher,
    Phalcon\Mvc\Model\Manager as ModelsManager,
    Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter,
    Phalcon\Forms\Manager as FormManager,
    Phalcon\Mvc\View\Engine\Volt;

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set(
    'url',
    function () use ($config) {
        $url = new UrlResolver();
        if (!$config->application->debug) {
            $url->setBaseUri($config->application->production->baseUri);
            $url->setStaticBaseUri($config->application->production->staticBaseUri);
        } else {
            $url->setBaseUri($config->application->development->baseUri);
            $url->setStaticBaseUri($config->application->development->staticBaseUri);
        }
        return $url;
    },
    true
);

/**
 * create modelsManager
 */
$di->set('modelsManager', new ModelsManager());

/**
 * Setting up volt
 */
$di->set(
    'volt',
    function ($view, $di) use ($config) {
        $volt = new Volt($view, $di);
        $volt->setOptions(
            array(
                "compiledPath"      => $config->application->voltCacheDir,
                "compiledSeparator" => "_",
                "compileAlways"     => $config->application->debug
            )
        );
        return $volt;
    },
    true
);

/**
 * Setting up the view component
 */
$di->set(
    'view',
    function () use ($config) {
        $view = new View();
        $view->setViewsDir($config->application->viewsDir);
        $view->registerEngines(
            array(
                ".volt" => 'volt'
            )
        );
        return $view;
    },
    true
);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set(
    'db',
    function() use ($config) {
        $connection = new DatabaseConnection($config->database->toArray());
        return $connection;
});

/**
 * Start the session the first time some component request the session service
 */
$di->set(
    'session',
    function(){
        $session = new SessionAdapter();
        $session->start();
        $session->set('ip', $_SERVER['REMOTE_ADDR']);
        return $session;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set(
    'modelsMetadata',
    function () use ($config) {
        return new MetaDataAdapter(array(
            'metaDataDir' => $config->application->metaDataCacheDir
        ));
    },
    true
);

// Registering a router
$di->set(
    'router',
    function(){
        return require APP_PATH . "/app/config/routes.php";
});

/**
 * Register the configuration itself as a service
 */
$di->set('config', $config);

$di->set(
    'security',
    function (){
        $security = new Phalcon\Security();
        $security->setWorkFactor(12);
        return $security;
    },
    true
);

/**
 * Register the flash service with the Twitter Bootstrap classes
 */
$di->set(
    'flash',
    function () {
        return new Phalcon\Flash\Direct(array(
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
        ));
    }
);

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set(
    'flashSession',
    function () {
        return new Phalcon\Flash\Session(array(
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
        ));
    }
);

$di->set(
    'dispatcher',
    function () {
        $dispatcher = new MvcDispatcher();
        $dispatcher->setDefaultNamespace('MainSource\Controllers');
        return $dispatcher;
    }
);

$di->set(
    'forms',
    function() {
        return new FormManager();
    }
);

$di->set(
    'cookies',
    function() {
        $cookies = new Cookies();
        $cookies->useEncryption(false);
        return $cookies;
});


/**
 * Our class business logic
 */
$di->set('auth', function (){
    return new Auth();
});

$di->set('mail', function () {
    return new Mail();
});

$di->set('messages', function () {
    return new MessagesCommon();
});

$di->set('users', function () {
    return new UsersCommon();
});

