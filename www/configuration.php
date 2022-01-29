<?php

/*
This is the configuration file of PSX. Every parameter can be used inside your
application or in the DI container. Which configuration file gets loaded depends 
on the DI container parameter "config.file". See the container.php if you want 
load an different configuration depending on the environment.
*/

if (!getenv('APP_ENV')) {
    $dotenv = new \Symfony\Component\Dotenv\Dotenv();
    $dotenv->usePutenv(true);
    $dotenv->load(__DIR__ . '/.env');
}

return array(

    // The url to the psx public folder (i.e. http://127.0.0.1/psx/public, 
    // http://localhost.com or //localhost.com)
    'psx_url'                 => getenv('APP_URL'),

    // The input path 'index.php/' or '' if you use mod_rewrite
    'psx_dispatch'            => '',

    // The default timezone
    'psx_timezone'            => 'UTC',

    // Whether PSX runs in debug mode or not. If not error reporting is set to 0
    // Also several caches are used if the debug mode is false
    'psx_debug'               => getenv('APP_ENV') === 'debug',

    // Database parameters which are used for the doctrine DBAL connection
    // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
    'psx_connection'          => [
        'path'                => __DIR__ . '/cache/void.db',
        'driver'              => 'pdo_sqlite',
    ],

    // Path to the routing file
    'psx_routing'             => __DIR__ . '/routes.php',

    // Folder locations
    'psx_path_cache'          => __DIR__ . '/cache',
    'psx_path_public'         => __DIR__ . '/public',
    'psx_path_src'            => __DIR__ . '/src',

    // Supported writers
    'psx_supported_writer'    => [
        \PSX\Data\Writer\Json::class,
        \PSX\Data\Writer\Jsonp::class,
        \PSX\Data\Writer\Jsonx::class,
    ],

    // Global middleware which are applied before and after every request. Must
    // bei either a classname, closure or PSX\Dispatch\FilterInterface instance
    //'psx_filter_pre'          => [],
    //'psx_filter_post'         => [],

    // A closure which returns a doctrine cache implementation. If null the
    // filesystem cache is used
    //'psx_cache_factory'       => null,

    // A closure which returns a monolog handler implementation. If null the
    // system handler is used
    //'psx_logger_factory'      => null,

    // Class name of the error controller
    //'psx_error_controller'    => null,

    // If you only want to change the appearance of the error page you can 
    // specify a custom template
    //'psx_error_template'      => null,

);
