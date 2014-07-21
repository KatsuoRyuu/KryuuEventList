<?php

namespace KryuuEventList;

return array(
    __NAMESPACE__ => array(
    ),

    'controllers' => array(
        'invokables' => array(
            'KryuuEventList\Controller\Index' => 'KryuuEventList\Controller\IndexController',
            'KryuuEventList\Controller\Admin' => 'KryuuEventList\Controller\AdminController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'kryuu-event' => array(
                'type'    => 'literal',
                'options' => array(
                    'route' => '/event',
                    'defaults' => array(
                        'controller'    => 'KryuuEventList\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'next-event' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route' => '/next',
                            'defaults' => array(
                                'controller'    => 'KryuuEventList\Controller\Index',
                                'action'        => 'nextEvent',
                            ),
                        ),
                    ),
                ),
            ),
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
    'service_manager' => array(
        'factories' => array(
            __NAMESPACE__.'\Config'                   => __NAMESPACE__.'\Service\ConfigServiceFactory',
            __NAMESPACE__.'\GlobalConfig'             => __NAMESPACE__.'\Service\GlobalConfigServiceFactory',
            __NAMESPACE__.'\AddressServiceFactory'    => __NAMESPACE__.'\Service\AddressServiceFactory',
        ),
        'invokables'  => array(
            //'BjyAuthorize\View\RedirectionStrategy' => 'BjyAuthorize\View\RedirectionStrategy',
        ),
        'aliases'     => array(
            //'bjyauthorize_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
        ),
        'initializers' => array(
            //'BjyAuthorize\Service\AuthorizeAwareServiceInitializer'
            //    => 'BjyAuthorize\Service\AuthorizeAwareServiceInitializer'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'kryuueventlist' => __DIR__ . '/../view',
        ),
    ),
);