<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 29/08/2016
 * Time: 14:46
 */

namespace Album\Model;


use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Album implements InputFilterAwareInterface
{
    /** @var  int $id */
    public $id;

    /** @var  string $artist */
    public $artist;

    /** @var  string $title */
    public $title;

    /** @var  string $created_at */
    public $created_at;


    /** @var   */
    private $inputFilter;


    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->artist = !empty($data['artist']) ? $data['artist'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->created_at = !empty($data['created_at']) ? $data['created_at'] : null;
    }


    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * Set input filter
     *
     * @param  InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if($this->inputFilter){
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        // id inputfilter
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class]
            ]
        ]);

        // title inputFilter
        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ]
                ]
            ]
        ]);

        // artist inputFilter
        $inputFilter->add([
            'name' => 'artist',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 100,
                    ]
                ]
            ]
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }


}