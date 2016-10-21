<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 7/10/2016
 * Time: 09:52
 */

namespace User\Form;


use Zend\Captcha\Dumb;
use Zend\Form\Element\Captcha;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

class AddUser extends Form
{
    public function __construct($name = 'adduser')
    {
        parent::__construct($name);

        // id hidden input field
        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);


        // first name input field
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'first_name',
            'options' => [
                'label' => 'first name',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Your name'
            ],
        ]);
        
        // last name input field
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'last_name',
            'options' => [
                'label' => 'last name',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Your name'
            ],
        ]);


        // email address input field
        $this->add([
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'placeholder' => 'Email Address',
                'type' => 'email',
                'required' => true,
            ],
        ]);


        // password input field
        $this->add([
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'options' => [
                'label' => 'Password'
            ],
            'attributes' => [
                'placeholder' => 'Password',
                'required' => 'required',
            ],
        ]);


        // password verify field
        $this->add([
            'type' => 'Zend\Form\Element\Password',
            'name' => 'repeat_password',
            'options' => [
                'label' => 'Repeat password',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Repeat password',
                'type' => 'password',
                'pattern' => '.{6,}'
            ],
        ]);

        //02381206588
        // phone input field
        $this->add([
            'name' => 'phone',
            'options' => [
                'label' => 'Phone',
            ],
            'attributes' => [
                'type' => 'tel',
                'required' => 'required',
                'placeholder' => 'Only numbers, - and /',
                //'pattern' => '^[\d-/],+$'
                'pattern' => '^\s*\(?(020[7,8]{1}\)?[ ]?[1-9]{1}[0-9{2}[ ]?[0-9]{4})|(0[1-8]{1}[0-9]{3}\)?[ ]?[1-9]{1}[0-9]{2}[ ]?[0-9]{3})\s*$',
            ],
        ]);


        // photo input field
        $this->add([
            'type' => 'Zend\Form\Element\File',
            'name' => 'photo',
            'options' => [
                'label' => 'Photo',
            ],
            'attributes' => [
                'required' => 'required',
                'id' => 'photo'
            ],
        ]);


        // crsf protection field
        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 3600
                ]
            ]
        ]);


        // captcha
        $this->add([
            'type' => Captcha::class,
            'name' => 'captcha',
            'options' => [
                'label' => 'Captcha',
                'captcha' => new Dumb(),
            ]
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

            // name input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'name',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Name is required',
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
                    ]
                ]
            ));

            // email address input filter
            $inputFilter->add($factory->createInput(
            // email input field filder
                [
                    'name' => 'email',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'EmailAddress',
                            'options' => [
                                'messages' => [
                                    'emailAddressInvalidFormat' => 'Email address format is invalid',
                                ],
                            ],
                        ],
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Email address is required',
                                ],
                            ],
                        ],
                    ],
                ]
            ));

            // password input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'password',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'NotEmpty',
                            'options' => [
                                'messages' => [
                                    'isEmpty' => 'Password is required',
                                ],
                            ],
                        ],
                    ],
                ]
            ));

            // verify_password input field
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'verify_password',
                    'filters' => [
                        ['name' => 'StripTags'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'identical',
                            'options' => [
                                'token' => 'password'
                            ],
                        ]
                    ],
                ]
            ));

            // phone input filter
            $inputFilter->add($factory->createInput(
                [
                    'name' => 'phone',
                    'filters' => [
                        ['name' => 'digits'],
                        ['name' => 'StringTrim'],
                    ],
                    'validators' => [
                        [
                            'name' => 'regex',
                            'options' => [
                                'pattern' => '/^[\d-\/],+$/',

                            ]
                        ]
                    ]
                ]
            ));

            // photo input filter

            $inputFilter->add($factory->createInput(
                [
                    'name' => 'photo',
                    'validators' => [
                        [
                            'name' => 'filesize',
                            'options' => [
                                'max' => 2097152, // 2 MB
                            ],
                        ],
                        [
                            'name' => 'filemimetype',
                            'options' => [
                                'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gig',
                            ],
                        ],
                        [
                            'name' => 'fileimagesize',
                            'options' => [
                                'maxWidth' => 200,
                                'maxHeight' => 200
                            ],
                        ],
                    ],
                    'filters' => [
                        // this filter will save the uploaded file under
                        // site-root/data/images/photos/<tmp_name>__<random_data>
                        [
                            'name' => 'filerenameupload',
                            'options' => [
                                'target' => 'data/image/photos/',
                                'randomize' => true,
                            ],
                        ],
                    ],
                ]
            ));


            $this->filter = $inputFilter;
        }
        return $this->filter;
    }


    /**
     * @param InputFilterInterface $inputFilter
     * @throws \Exception
     * @return void
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('It is not allowed to st the input filter');
    }

}