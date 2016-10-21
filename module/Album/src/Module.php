<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 29/08/2016
 * Time: 14:35
 */

namespace Album;


use Album\Controller\AlbumController;
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    /**
     * @return mixed
     */
//    public function getServiceConfig()
//    {
//        return [
//            'factories' => [
//                Model\AlbumTable::class => function($container){
//                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
//                    return new Model\AlbumTable($tableGateway);
//                },
//                Model\AlbumTableGateway::class => function($container){
//                    $dbAdapter = $container->get(AdapterInterface::class);
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
//                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
//                }
//            ],
//        ];
//    }


    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }


    /**
     * @return array
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function($container){
                    return new AlbumController($container->get(Model\AlbumTable::class));
                }
            ],
        ];
    }

}