<?php
/**
 * Description of Edit.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\App\Forms;

use UWC\DataProvider\Factory as DataProviderFactory;
use Zend\Filter\StringTrim;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;
use Zend\Validator\Callback;
use Zend\Validator\StringLength;
use Zend\Validator\Uri;

class Edit extends Form
{

    const FIELD_TITLE   = 'title';
    const FIELD_ARTIST  = 'artist';
    const FIELD_ALBUM   = 'album';
    const FIELD_YEAR    = 'year';
    const FIELD_GENRE   = 'genre';
    const FIELD_COMMENT = 'comment';
    const FIELD_TRACK   = 'track';

    const FIELD_FILE_KEY   = 'fileKey';

    public function __construct($key)
    {
        parent::__construct('tag-editor', [
            'action'        => '/edit/',
            'method'        => 'POST',
            'accept-charset'=> 'UTF-8',
        ]);

        $field = new Element\Text(self::FIELD_TITLE);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_ARTIST);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_ALBUM);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_YEAR);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_GENRE);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_COMMENT);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);

        $field = new Element\Text(self::FIELD_TRACK);
        $field->setLabel(ucfirst($field->getName()));
        $this->add($field);


        $keyField = new Element\Hidden(self::FIELD_FILE_KEY);
        $keyField->setValue($key);
        $this->add($keyField);

        $send = new Element\Submit('send');
        $send->setValue('Edit!');
        $this->add($send);

        $csrf = new Element\Csrf('security');
        $this->add($csrf);
    }

    private function getUniqueValue()
    {
        return mt_rand(1, 99999) . '.' .  microtime(1);
    }

    public function setData($data)
    {
        $this->addFiltering($data);
        parent::setData($data);
    }

    public function addFiltering($data)
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFilterFactory();

        $intFilter = new \Zend\Filter\Callback(function($value) {
            return (int)$value;
        });

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_TITLE,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_ARTIST,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_ALBUM,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_YEAR,
            'required'  => false,
            'filters'   => [$intFilter],
            'validators' => [new Callback(function ($value) {
                if (
                    !empty($value)
                    && ($value < 1000 || $value >= 9999)
                ) {
                    return false;
                }
                return true;
            })]
        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_GENRE,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));
//        $inputFilter->add($factory->createInput([
//            'name'      => self::FIELD_GENRE,
//            'required'  => false,
//            'filters'   => [$intFilter],
//            'validators' => [new Between(['inclusive'=>true, 'max'=>0, 'min'=>147])]
//        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_COMMENT,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_TRACK,
            'required'  => false,
            'filters'   => [new StringTrim()],
            'validators' => [new StringLength(['max'=>30])]
        ]));

//        $inputFilter->add($factory->createInput([
//            'name'      => self::FIELD_TRACK,
//            'required'  => false,
//            'filters'   => [$intFilter],
//            'validators' => [new Between(['inclusive'=>true, 'max'=>0, 'min'=>255])]
//        ]));

        $this->setInputFilter($inputFilter);
    }

}