<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 01/09/2016
 * Time: 19:17
 */

namespace Blog\Model;


use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\Exception\RuntimeException;
use Zend\Db\TableGateway\TableGateway;
use Zend\Debug\Debug;

class BlogTable
{
    /** @var  TableGateway $tableGateway */
    private $tableGateway;

    /** @var  Adapter */
    private $dbAdapter;

    /**
     * BlogTable constructor.
     * @param TableGateway $tableGateway
     * @param $dbAdapter
     */
    public function __construct(TableGateway $tableGateway, $dbAdapter)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }


    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        $posts = $this->tableGateway->select(function(Select $select){

            $select->join(
                'user',
                'post.author = user.id',
                ['first_name', 'last_name']
            )
            ->order('created DESC');
        })->toArray();

        $postWithCats = [];
        foreach ($posts as $post){
            $postWithCats[$post['id']] = $post;
            $cat = $this->getPostCategories($post['id']);
            $postWithCats[$post['id']]['name'] = $cat;
        }
        return $postWithCats;
    }


    /**
     * @param $slug
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getPostBySlug($slug)
    {
        if(!empty($slug)){

            $select = new Select(['p' => 'post']);
            $select->join(
                    ['u' => 'user'],
                    'p.author = u.id',
                    ['first_name', 'last_name'],
                    Select::JOIN_INNER
                );
            $select->where(['p.slug' => $slug]);

            //echo $sql->getSqlstringForSqlObject($select);
            $resultSet = $this->tableGateway->selectWith($select);

            if(! $resultSet){
                throw new RuntimeException(sprintf(
                    'Could not find post with id:: %s',
                    $slug
                ));
            }

            $result = $resultSet->current()->getArrayCopy();
            $result['name'][] =$this->getPostCategories($result['id']);
            //Debug::dump($result);
            $post = new Post();
            foreach ($result['name'] as $value) {
                $post->name[] = $value['name'];
            }
            $post->exchangeArray($result);


            //Debug::dump($post);
            return $post;
        }
    }

    /**
     * @param $id
     * @return array|\ArrayObject|null
     */
    public function getPostById($id)
    {
        $id = (int) $id;

        if($id !== 0){
            $select = $this->tableGateway->getSql()->select()
                ->join(
                    'user',
                    'post.author = user.id',
                    ['first_name', 'last_name']
                );
            $select->where(['post.id' => $id]);

            $row = $this->tableGateway->selectWith($select);

            if(! $row){
                throw new RuntimeException(sprintf(
                    'Could not find post with id %d',
                    $id
                ));
            }

            return $row;
        }

    }

    /**
     * @param $tag
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getPostByTag($tag)
    {
        $sql = $this->tableGateway->select(function(Select $select) use ($tag) {
            $select->join(
                ['pc' => 'post_category'],
                'post.id = pc.post_id',
                []
            );
            $select->join(
                ['c' => 'category'],
                'pc.category_id = c.id',
                ['name']
            );
            $select->join(
                ['u' => 'user'],
                'post.author = u.id',
                ['first_name', 'last_name']
            );
            $select->where(['c.name' => $tag]);
        });
        $results = $sql->setArrayObjectPrototype(new Post());

        return $results;
    }

    /**
     * @param $post_id
     * @return array|\ArrayObject|null
     */
    public function getPostCategories($post_id)
    {
        $sql = new TableGateway('category', $this->dbAdapter);
        $select = $sql->select(function(Select $select) use($post_id){
            $select->columns(['name']);
            $select->join(
                'post_category',
                'post_category.category_id = category.id',
                []
            )
                ->where(['post_category.post_id' => $post_id]);
        })->toArray();

        return $select;
    }


    /** Ma Jirtaa 6
     * @param Post $post
     * @return int
     */
    public function savePost(Post $post)
    {

        $data = [
            'title' => $post->title,
            'slug' => $post->slug,
            'body' => $post->body,
            'author' => $post->author,
            'created' => $post->created,
            'status' => $post->status,
        ];

        $id = (int) $post->id;

        // if we have an id, we update database
        // else we insert a new post
        if($id === 0){
            return $this->tableGateway->insert($data);
        }

        if($this->getPostById($id)){
            return $this->tableGateway->update($data, ['id'  => $id]);
        }

    }


    /**
     * @param $id
     * @return int
     */
    public function deleteAlbum($id)
    {
        return $this->tableGateway->delete(['id' => (int) $id]);
    }

}