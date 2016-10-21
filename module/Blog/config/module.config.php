<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 25/08/2016
 * Time: 20:11
 */

namespace Blog;

use Blog\Navigation\Factory\NavigationFactory;
use User\Controller\UserController;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
//        'factories' => [
//            //Controller\BlogController::class => InvokableFactory::class,
//        ],
    ],
    'router' => [
        'routes' => [
            'blog' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/blog[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\BlogController::class,
                        'action' => 'index',
                    ],
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9-_]*',
                        'id' => '[a-zA-Z0-9][a-zA-Z0-9-_]*',
                    ]
                ]
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation-example' => NavigationFactory::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'blog' => __DIR__ . '/../view',
        ]
    ],
//    'navigation' => [
//        'default' => [
//            [
//                'label' => 'Blog',
//                'route' => 'blog',
//                'pages' => [
//                    [
//                        'label' => 'Add',
//                        'route' => 'blog',
//                        'action' => 'add',
//                    ],
//                    [
//                        'label' => 'Edit',
//                        'route' => 'blog',
//                        'action' => 'edit'
//                    ],
//                    [
//                        'label' => 'Post',
//                        'route' => 'blog',
//                        'action' => 'post',
//                    ],
//                    [
//                        'label' => 'Delete',
//                        'route' => 'blog',
//                        'action' => 'delete',
//                    ],
//                    [
//                        'label' => 'Tag',
//                        'route' => 'blog',
//                        'action' => 'tag'
//                    ]
//                ]
//            ]
//        ]
//    ],

    'navigation' => [
        'navigation-example' => [
            [
                'label' => 'Google',
                'uri' => 'https://www.google.com',
                'target' => '_blank'
            ],
            [
                'label' => 'Home',
                'route' => 'home'
            ],
            [
                'label' => 'Modules',
                'uri' => '#',
                'pages' => [
                    [
                        'label' => 'LearnZF2Ajax',
                        'route' => 'learnZF2Ajax'
                    ],
                    [
                        'label' => 'LearnZF2FormUsage',
                        'route' => 'learn-zf2-form-usage'
                    ],
                    [
                        'label' => 'LearnZF2Barcode',
                        'route' => 'learn-zf2-barcode-usage'
                    ],
                    [
                        'label' => 'LearnZF2Pagination',
                        'route' => 'learn-zf2-pagination'
                    ],
                    [
                        'label' => 'LearnZF2Log',
                        'route' => 'learn-zf2-log'
                    ]
                ]
            ]
        ]
    ]
];