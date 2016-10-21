<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 06/10/2016
 * Time: 14:18
 */

namespace User\Controller;


use User\Authentication\UserAuth;
use User\Form\AddUser;
use User\Form\LoginForm;
use User\Repository\UserTable;
use Zend\Debug\Debug;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;


class UserController extends AbstractActionController
{
    /** @var  UserTable */
    protected $userTable;


    /**
     * UserController constructor.
     * @param $userTable
     */
    public function __construct($userTable)
    {
        $this->userTable = $userTable;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel([
            'users' => $this->userTable->getAll()
        ]);
    }

    /**
     * @return ViewModel
     */
    public function profileAction()
    {
        $auth = new UserAuth($username = 'james@email.com', $password = 'secret');

        $id = $this->params()->fromRoute('id');
        $user = $this->userTable->getOneByName($id);
        return new ViewModel([
            'user' => $user
        ]);
    }


    /**
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {

        $logout = $this->userTable->logout();
        if($logout){
            $this->flashMessenger()->addSuccessMessage('Logout successful');
            return $this->redirect()->toRoute('home');
        }
    }


    /**
     * @return array
     */
    public function addAction()
    {
        $form = new AddUser();
        $request = $this->getRequest();
        if($request->isPost()){
            Debug::dump($request->getPost());
        }
        return ['form' => $form];
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function loginAction()
    {
        /** @var FlashMessenger $flashMessenger */
        $flashMessenger = $this->flashMessenger();

        $authService = $this->userTable->getAuthenticationService();
        if($authService->hasIdentity()){
            $loggedUser = $authService->getIdentity();
            $flashMessenger->addSuccessMessage('You are already logged in as '.$loggedUser->first_name.' '.$loggedUser->last_name);
            return $this->redirect()->toRoute('user', ['action' => 'profile', 'id' => $loggedUser->first_name.'-'.$loggedUser->last_name]);
        }
        $form = new LoginForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                $user = $this->userTable->login(trim($data['email']), $data['password']);

                if ($user) {

                    $flashMessenger->addSuccessMessage('login was successful');
                    return $this->redirect()->toRoute('user', ['action' => 'profile', 'id' => $user->first_name.'-'.$user->last_name]);

                } else {

                    $flashMessenger->addWarningMessage('Login failed. Check your email or password.');

                    return ['form' => $form];
                }
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }


    /**
     *
     */
    public function eventAction()
    {
        $events = new EventManager();
        $method = __METHOD__;
        $events->attach('do', function(Event $e) use ($method){
            $event = $e->getName();
            $params = $e->getParams();
            $class = __CLASS__;
            $params['class'] = $class;
            $params['method'] = $method;
            printf(
                'Handles event "%s", with parameters "%s"',
                $event,
                json_encode($params)
            );
        });

        $params = ['foo'=>'bar', 'baz'=>'bat'];
        $events->trigger('do', null, $params);
    }

}