<?php
/**
 * Description of ProvideFile.php
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
use Zend\Validator\Callback;
use Zend\Validator\Uri;

class ProvideFile extends Form
{

    const FIELD_TYPE = 'type';
    const FIELD_URL = 'url';
    const FIELD_FILE = 'file';
    const FIELD_CONTENT = 'content';

    public static $availableMimeTypes = [
        'audio/mpeg',
        'audio/mpeg3',
        'audio/x-mpeg-3',
    ];

    public function __construct()
    {
        parent::__construct('file-provider', [
            'action'        => '/',
            'method'        => 'POST',
            'enctype'       => 'multipart/form-data',
            'accept-charset'=> 'UTF-8',
        ]);

        $type = new Element\Radio(self::FIELD_TYPE, ['default' => DataProviderFactory::PROVIDER_DOWNLOAD]);
        $type->setValueOptions(array(
            DataProviderFactory::PROVIDER_DOWNLOAD => 'Download from url',
            DataProviderFactory::PROVIDER_UPLOADED => 'Upload local file',
        ));
        $this->add($type);


        $url = new Element\Url(self::FIELD_URL);
        $url->setLabel('Url');
        $this->add($url);

        $file = new Element\File(self::FIELD_FILE);
        $file->setLabel('File');
        $this->add($file);

        $send = new Element\Submit('send');
        $send->setValue('Submit');
        $this->add($send);

        $csrf = new Element\Csrf('security');
        $this->add($csrf);

//        $progress = new Element\Hidden(self::getProgressName());
//        $progress->setValue($this->getUniqueValue());
//        $this->add($progress);
    }

//    public static function getProgressName()
//    {
//        return ini_get("session.upload_progress.name");
//    }
//
//    private function getUniqueValue()
//    {
//        return mt_rand(1, 99999) . '.' .  microtime(1);
//    }

    public function setData($data)
    {
        $this->addFiltering($data);
        parent::setData($data);
    }

    public function addFiltering($data)
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFilterFactory();

        $inputFilter->add($factory->createInput([
            'name'      => self::FIELD_TYPE,
            'required'  => true,
        ]));

        $inputFilter->add($factory->createInput([
            'name'     => self::FIELD_URL,
            'required' => false,
        ]));

        $inputFilter->add($factory->createInput([
            'name'     => self::FIELD_FILE,
            'required' => false,
        ]));

        if (@$data[self::FIELD_TYPE] == DataProviderFactory::PROVIDER_DOWNLOAD) {
            $inputFilter->add($factory->createInput([
                'name'     => self::FIELD_URL,
                'required' => true,
                'filters'  => [new StringTrim()],
                'validators'  => [new Uri(['allowRelative' => false])],
            ]));
        } else {
            $inputFilter->add($factory->createInput([
                'name'     => self::FIELD_FILE,
                'required' => true,
                'validators'  => [
                    new \Zend\Validator\File\UploadFile(),
                    new Callback(['callback' => function ($value) {
                        return in_array($value['type'], self::$availableMimeTypes);
                    }])
                ],
            ]));
        }

        $this->setInputFilter($inputFilter);
    }

}