<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 25/08/2016
 * Time: 21:08
 */

namespace Blog;


use Blog\Controller\BlogController;
use Blog\Model\BlogTable;
use Blog\Model\Post;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
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
                Controller\BlogController::class => function($container){
                    return new BlogController($container->get(Model\BlogTable::class));
                }
            ],
        ];
    }


    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\BlogTable::class => Model\Factory\BlogTableGateway::class,

//                Model\BlogTable::class => function($container){
//                    $dbAdapter = $container->get(AdapterInterface::class);
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new Post());
//                    $tableGateway = new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
//                    return new BlogTable($tableGateway, $dbAdapter);
//                },
//                Model\BlogTableGateway::class => function($container){
//                    $dbAdapter = $container->get(AdapterInterface::class);
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new Post());
//
//                    return new TableGateway('post', $dbAdapter, null, $resultSetPrototype);
//                }
            ],
        ];
    }

}