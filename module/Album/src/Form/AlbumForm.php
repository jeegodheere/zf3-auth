<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 30/08/2016
 * Time: 21:55
 */

namespace Album\Form;


use Zend\Captcha\Dumb;
use Zend\Form\Element\Captcha;
use Zend\Form\Form;

class AlbumForm extends Form
{
    /**
     * AddForm constructor.
     * @param string $name
     */
    public function __construct($name = 'addform')
    {
        parent::__construct($name);


        // id inputfield
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        // title inputfield
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Title',
                'class' => 'form-control'
            ]
        ]);

        // artist inputfield
        $this->add([
            'name' => 'artist',
            'type' => 'text',
            'options' => [
                'label' => 'Artist',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Artist',
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type' => Captcha::class,
            'name' => 'captcha',
            'options' => [
                'label' => 'Please verify that you are a human',
                'captcha' => new Dumb(),
            ]

        ]);


        //submit inputfield
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ],
        ]);
    }

}