<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 06/10/2016
 * Time: 14:23
 */

namespace User;

use Zend\Authentication\AuthenticationService;

return [
    'factories' => [
        Repository\UserTable::class => Repository\Factory\UserTableFactory::class,
        //Form\AddUser::class => Form\Factory\AddUserFactory::class,
        AuthenticationService::class => Service\Factory\AuthenticationServiceFactory::class,

    ]
];