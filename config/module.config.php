<?php

namespace KryuuEventList;

defined('__AUTHORIZE__') or define('__AUTHORIZE__','bjyauthorize');

$router     = include(__DIR__.'/router.config.php');
$service    = include(__DIR__.'/services.config.php');
$authorize  = include(__DIR__.'/authorize.config.php');

$config =  array(
    __NAMESPACE__ => array(
        'config' => array(
            'fileupload' => true,
        ),
    ),
    __AUTHORIZE__       => $authorize,
    
    'router'            => $router,
    
    'service_manager'   => $service,

    'controllers' => array(
        'invokables' => array(
            'KryuuEventList\Controller\Index' => 'KryuuEventList\Controller\IndexController',
            'KryuuEventList\Controller\Admin' => 'KryuuEventList\Controller\AdminController',
        ),
    ),

    'doctrine'=> array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'kryuueventlist' => __DIR__ . '/../view',
        ),
    ),
       
);

return $config;