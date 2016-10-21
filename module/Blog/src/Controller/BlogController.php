<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 25/08/2016
 * Time: 21:03
 */

namespace Blog\Controller;


use Blog\Form\AddPost;
use Blog\Model\BlogTable;
use Blog\Model\Post;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    /** @var  BlogTable $tableGateway */
    private $tableGateway;


    /**
     * BlogController constructor.
     * @param BlogTable $tableGateway
     */
    public function __construct(BlogTable $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->tableGateway->fetchAll()
        ]);
    }


    /**
     * @return ViewModel
     */
    public function postAction()
    {
        $id = $this->params()->fromRoute('id');
        if(is_int($id)){
            $post = $this->tableGateway->getPostById(trim($id));
        } elseif (is_string($id)){
            $post = $this->tableGateway->getPostBySlug(trim($id));
        }
        return new ViewModel([
            'post' => $post
        ]);
    }


    /**
     * @return array
     */
    public function tagAction()
    {
        $tag = $this->params()->fromRoute('id', 0);
        if($tag === 0){
            $this->redirect()->toRoute('blog');
        }
        $post = $this->tableGateway->getPostByTag($tag)->toArray();
        return ['posts' => $post];
    }

    /**
     * @return ViewModel
     */
    public function addAction()
    {
        $form = new AddPost();

        $request = $this->getRequest();

        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $post = new Post();
                $post->exchangeArray($form->getData());
                $this->tableGateway->savePost($post);
                //$this->flashmessenger()->addSuccess('your post was saved');

                $this->redirect()->toRoute('blog');
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }





    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $post = new Post();

        $data = [
            'id' => 6,
            'title' => 'Turimak teeko',
            'slug' => 'turimak teeko',
            'body' => 'But I must explain to you 
                    how all this mistaken idea of 
                    denouncing pleasure and praising 
                    pain was born and I will give you a 
                    complete account of the system, and 
                    expound the actual teachings of the 
                    great explorer of the truth, the 
                    master-builder of human happiness. 
                    No one rejects, dislikes, or 
                    avoids pleasure itself,',
            'author' => 1,
            'created_at' => null

        ];
        $post->exchangeArray($data);
        //die(var_dump($post));

        $this->tableGateway->savePost($post);


        return new ViewModel();
    }


    /**
     * @return ViewModel
     */
    public function deleteAction()
    {
        return new ViewModel();
    }

}