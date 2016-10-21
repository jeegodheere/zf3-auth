<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 12/10/2016
 * Time: 12:27
 */

namespace User\Utility;


use Zend\Crypt\Password\Bcrypt;

class Password
{
    public $salt = 'nfi39yjakn990';
    public $method = 'sha1';

    /**
     *
     */
    public function __construct($method = null)
    {
        if(! is_null($method)){
            $this->method = $method;
        }
    }


    /**
     * Create password
     * @param $password
     * @return string
     */
    public function create($password)
    {
        if($this->method == 'md5'){
            return md5($this->salt . $password);
        }elseif ($this->method == 'sha1'){
            return sha1($this->salt . $password);
        }

        $bcrypt = new Bcrypt();
        $bcrypt->setCost(12);

        return $bcrypt->create($password);
    }


    /**
     * @param $password
     * @param $hashedPassword
     * @return bool
     */
    public function verify($password, $hashedPassword)
    {
        if($this->method == 'md5'){
            return $hashedPassword == md5($this->salt . $password);
        }elseif ($this->method == 'sha1'){
            return $hashedPassword == sha1($this->salt . $password);
        }

        $bcrypt = new Bcrypt();
        $bcrypt->setCost(12);

        return $bcrypt->verify($password, $hashedPassword);

    }



}