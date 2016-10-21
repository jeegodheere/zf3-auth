<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 06/10/2016
 * Time: 14:49
 */

namespace User\Controller\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Controller\UserController;
use User\Repository\UserTable;
use Zend\Captcha\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userTable = $container->get(UserTable::class);
        return new UserController($userTable);
    }


}