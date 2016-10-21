<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 29/08/2016
 * Time: 14:29
 */

namespace Album;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            //Controller\AlbumController::class => InvokableFactory::class,
        ],
    ],
    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Album',
                'route' => 'album',
                'pages' => [
                    [
                        'label' => 'add',
                        'route' => 'user',
                        'action' => 'add'
                    ],
                    [
                        'label' => 'Edit',
                        'route' => 'user',
                        'action' => 'edit',
                    ],
                    [
                        'label' => 'Delete',
                        'route' => 'user',
                        'action' => 'delete'
                    ],
                    [
                        'label' => 'Login',
                        'route' => 'user',
                        'action' => 'login'
                    ]
                ]
            ]
        ]
    ]
];