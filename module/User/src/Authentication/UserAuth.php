<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 11/10/2016
 * Time: 13:10
 */

namespace User\Authentication;


use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Debug\Debug;

class UserAuth implements AdapterInterface
{

    /** @var  user $username */
    private $username;

    /** @var  user $password */
    private $password;

    /**
     * UserAuth constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->password = $password;
        $this->username = $username;

        $this->hashPassword();
    }
    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {

    }


    /**
     * hashes a users password
     * @return string hashes password
     */
    public function hashPassword()
    {
        $pass = new Bcrypt();
        $pass->setCost(10);
        $hashedPassword = $pass->create($this->password);
        return $hashedPassword;
    }

}