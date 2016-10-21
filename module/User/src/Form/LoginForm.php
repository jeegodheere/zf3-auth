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

class LoginForm extends Form
{
    public function __construct($name = 'loginform')
    {
        parent::__construct($name);


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
     * @return null|InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if(! $this->filter){
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

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