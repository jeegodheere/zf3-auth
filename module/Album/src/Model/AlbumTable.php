<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 29/08/2016
 * Time: 14:56
 */

namespace Album\Model;


use Zend\Db\ResultSet\Exception\RuntimeException;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class AlbumTable
{
    /** @var  TableGateway $tableGateway */
    private $tableGateway;

    /**
     * AlbumTable constructor.
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function fetchAll()
    {
        return $this->tableGateway->select(function(Select $select){
            $select->order(['created_at' => 'DESC']);
        });
        //return $this->tableGateway->select();
    }


    /**
     * @param $id
     * @return array|\ArrayObject|null
     */
    public function getAlbum($id)
    {
        $id = (int) $id;

        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if(!$row){
            throw new RuntimeException(sprintf(
                'Could not find album with with id %d',
                $id
            ));
        }

        return $row;
    }


    /**
     * @param Album $album
     * @return int
     */
    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title' => $album->title,
            'created_at' => $album->created_at,
        ];

        $id = (int) $album->id;

        if($id === 0){
            //var_dump($data); die();
            return $this->tableGateway->insert($data);
        }

        if(!$this->getAlbum($id)){
            throw new \RuntimeException(sprintf(
                'Could update album with id %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }


    /**
     * @param $id
     * @return int
     */
    public function deleteAlbum($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}