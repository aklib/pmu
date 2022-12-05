<?php

declare(strict_types = 1);

namespace Application;

use Laminas\I18n\Translator\Loader\PhpArray;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router'       => [
        'routes' => [
            'home' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/[:language][/:action][/:slug][/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'language'   => '',
                    ],
                ],
            ]
        ],
    ],
    'controllers'  => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'translator'   => [
        'locale'                    => 'ru',
        'available'                 => [
            'en' => 'english',
            'ru' => 'русский',
        ],
        'translation_file_patterns' => [
            [
                'type'     => PhpArray::class,
                'base_dir' => dirname(__DIR__) . '/view/section/_default/translation/',
                'pattern'  => '%s.php',
            ],
        ],
        'event_manager_enabled'     => true
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
    ],
];
