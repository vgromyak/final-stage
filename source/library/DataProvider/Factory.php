<?php
/**
 * Description of Factory.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


use UWC\App\Forms\Edit;
use UWC\App\Forms\ProvideFile;
use UWC\Storage\Storage;

class Factory
{

    const PROVIDER_POST = 'post';
    const PROVIDER_DOWNLOAD = 'download';
    const PROVIDER_UPLOADED = 'uploaded';

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var DataKeyGenerator
     */
    private $keyGenerator;

    public function __construct(Storage $storage, DataKeyGenerator $keyGenerator)
    {
        $this->storage = $storage;
        $this->keyGenerator = $keyGenerator;
    }

    /**
     * @param string $type
     * @return DataProviderInterface
     * @throws DataProviderException
     */
    public function create($type)
    {
        switch ($type) {
            case self::PROVIDER_POST:
                return new PostData($this->storage, $this->keyGenerator);
            case self::PROVIDER_DOWNLOAD:
                return new DownloadFile($this->storage, $this->keyGenerator);
            case self::PROVIDER_UPLOADED:
                return new UploadedFile($this->storage, $this->keyGenerator);
            default:
                throw new DataProviderException('Unsupported data provider type.');
        }
    }

    public function retrieveSource($type, $data)
    {
        switch ($type) {
            case self::PROVIDER_POST:
                return $data[ProvideFile::FIELD_CONTENT];
            case self::PROVIDER_DOWNLOAD:
                return $data[ProvideFile::FIELD_URL];
            case self::PROVIDER_UPLOADED:
                return $data[ProvideFile::FIELD_FILE];
            default:
                throw new DataProviderException('Unsupported data provider type.');
        }
    }

}