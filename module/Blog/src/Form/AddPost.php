<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 24/03/2016
 * Time: 11:22
 */

namespace Blog\Form;


use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class AddPost extends Form
{
    public function __construct($name = 'addpost')
    {
        parent::__construct($name);

        // id hidden input field
        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);


        // name input field
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'title',
            'options' => [
                'label' => 'Title',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Post title',
                'class' => 'form-control'
            ],
        ]);



        // slug input field
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'slug',
            'options' => [
                'label' => 'Slug',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Post slug',
                'class' => 'form-control'
            ],
        ]);


        // body input field
        $this->add([
            'type' => 'Zend\Form\Element\TextArea',
            'name' => 'body',
            'options' => [
                'label' => 'Body',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Post body',
                'class' => 'form-control',
                'rows' => 8
            ],
        ]);



        // slug input field
        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'published',
                    2 => 'unpublished',
                ]
            ],
        ]);



        // crsf protection field
        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ]);


        // submit button field
        $this->add([
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'required' => 'false',
            ],
        ]);
    }


    /**
     *
     */
    public function getInputFilter()
    {
        if(! $this->filter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            // title input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'title',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Title is required',
                                ],
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 5,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]
            ));


            // title input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'slug',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Slug is required',
                                ],
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 5,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]
            ));




            // slug input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'slug',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Slug is required',
                                ],
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 5,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]
            ));




            // select input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'body',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Body is required',
                                ],
                            ],
                        ],
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min' => 5,
                            ],
                        ],
                    ],
                ]
            ));



            // body input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'status',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Status is required',
                                ],
                            ],
                        ],
                    ]
                ]
            ));



            $this->filter = $inputFilter;
        }
        return $this->filter;
    }


    /**
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     * @return \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('It is not allowed to st the input filter');
    }

}