<?php
/**
 * Description of AbstractProvider.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\DataProvider;


use UWC\Storage\Storage;

abstract class AbstractProvider implements DataProviderInterface
{

    /**
     * @var Storage
     */
    protected $storage;

    /**
     * @var DataKeyGenerator
     */
    protected $keyGenerator;

    public function __construct(Storage $storage, DataKeyGenerator $keyGenerator)
    {
        $this->storage = $storage;
        $this->keyGenerator = $keyGenerator;
    }

    abstract function retrieveData($source);

    final public function retrieveDataAndStore($source)
    {
        //check key at first to avoid expensive operation on storage error
        $key = $this->provideKey();
        if ($this->storage->exist($key)) {
            throw new DataProviderException("Storage key is in use.");
        }

        $data = $this->retrieveData($source);
        if (empty($data)) {
            throw new DataProviderException("Retrieved data is empty.");
        }
        $this->storage->set($key, $data);
        return $key;
    }

    private function provideKey()
    {
        return $this->keyGenerator->generate();
    }

    final public function getData($key)
    {
        if (!$this->storage->exist($key)) {
            throw new DataProviderException("There are no data by provided key.");
        }
        return $this->storage->get($key);
    }

}