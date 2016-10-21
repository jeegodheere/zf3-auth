<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 06/10/2016
 * Time: 14:34
 */

namespace User\Repository;


use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter as AuthAdapter;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;

use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Debug\Debug;

class UserTable
{
    /** @var  TableGateway */
    protected $tableGateway;

    /** @var  Adapter */
    protected $dbAdapter;

    /**
     * UserTable constructor.
     * @param $tableGateway
     * @param $dbAdapter
     */
    public function __construct($tableGateway, $dbAdapter)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->tableGateway->select();
    }


    /**
     * @param $name
     * @return array|\ArrayObject|null
     */
    public function getOneByName($name)
    {
        $fullNameArray = explode('-', $name);
        //Debug::dump($fullNameArray);die();
        $sql = $this->tableGateway->select(['first_name' => $fullNameArray[0], 'last_name' => $fullNameArray[1]]);

        return $sql->current();
    }


    /**
     * @param $user
     */
    public function saveUser($user)
    {
        $userId = (int) $user->id;
    }

    /**
     * @return \Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter
     */
    public function getAuthenticationAdapter()
    {
        $callback = function($encryptedPassword, $unencryptedPassword){
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(12);
            return $bcrypt->verify($unencryptedPassword, $encryptedPassword);
        };

        $authenticationAdapter = new CallbackCheckAdapter(
            $this->dbAdapter,
            'user',
            'email',
            'password',
            $callback
        );
        return $authenticationAdapter;
    }


    /**
     * @return CredentialTreatmentAdapter
     */
    public function credentialTreatmentAdapterAuthentication()
    {
        $authAdapter = new CredentialTreatmentAdapter(
            $this->dbAdapter,
            'user',
            'email',
            'password'
        );
        return $authAdapter;
    }


    /**
     * @return CallbackCheckAdapter
     */
    public function callBackCheckAuthentication()
    {
        $passwordValidation = function($hashedPassword, $notHashedPassword){
            return password_verify($notHashedPassword, $hashedPassword);
        };

        $authAdapter = new CallbackCheckAdapter(
            $this->dbAdapter,
            'user',
            'email',
            'password',
            $passwordValidation
        );
        return $authAdapter;
    }


    /**
     * @param $hashedPassword
     * @param $notHashedPassword
     * @return bool
     */
    public function passwordVerify($hashedPassword, $notHashedPassword)
    {
        return password_verify($notHashedPassword, $hashedPassword);
    }


    /**
     * @param $password
     * @return string
     */
    public function hasPassword($password)
    {
        $hash = new Bcrypt();
        $hash->setCost(12);

        return $hash->create($password);
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        $authenticationAdapter = $this->callBackCheckAuthentication();
        return new AuthenticationService(null, $authenticationAdapter); // Storage defaults to session
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return boolean
     */
    public function login($email, $password)
    {
        $authenticationAdapter = $this->callBackCheckAuthentication();
        $authenticationAdapter->setIdentity($email);
        $authenticationAdapter->setCredential($password);
        $result = $authenticationAdapter->authenticate();

        if ($result->isValid()) {
            $detailToWriteToSession = [
                'email',
                'first_name',
                'last_name'

            ];
            //$identityObject = $authenticationAdapter->getResultRowObject(null, ['password']);
            $identityObject = $authenticationAdapter->getResultRowObject($detailToWriteToSession);
            $this->getAuthenticationService()->getStorage()->write($identityObject);
            return $identityObject;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        $this->getAuthenticationService()->clearIdentity();

        return true;
    }


}