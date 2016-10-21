<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 01/09/2016
 * Time: 18:47
 */

namespace Blog\Model;


class Post
{

    /** @var  int $id */
    public $id;

    /** @var  string $title */
    public $title;

    /** @var  string $slug */
    public $slug;

    /** @var  string $body */
    public $body;

    /** @var  string $author */
    public $author = 1;

    /** @var  string $first_name */
    public $first_name;

    /** @var  string $last_name */
    public $last_name;


    /** @var  string $created */
    public $created;

    /** @var  string $status */
    public $status;

    public $name;



    /**
     * @param $data
     */
    public function exchangeArray($data)
    {
        $first = $data['first_name'];
        $last = $data['last_name'];

        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->slug = !empty($data['slug']) ? $data['slug'] : null;
        $this->body = !empty($data['body']) ? $data['body'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->created = !empty($data['created']) ? $data['created'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->status = !empty($data['status']) ? $data['status'] : null;
    }


    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created' => $this->created,
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
    /**
     * @param null $first
     * @param null $last
     * @return string
     */
    public function getName($first = null, $last = null)
    {
        return $this->author = ucfirst($first).' '.ucfirst($last);
    }


}