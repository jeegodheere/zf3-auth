<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 07/10/2016
 * Time: 08:59
 */

namespace User\Form\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Form\AddUser;
use Zend\Captcha\AdapterInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AddUserFactory implements FactoryInterface
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
        $captcha = $container->get(AdapterInterface::class);
        return new AddUser($container->get(AdapterInterface::class));
    }

}