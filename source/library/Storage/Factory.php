<?php
/**
 * Description of Factory.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Storage;


class Factory
{

    const STORAGE_MEMORY = 'memory';
    const STORAGE_LOCAL_FILE = 'localFile';

    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function create($type)
    {
        switch ($type) {
            case self::STORAGE_MEMORY:
                return new Memory();
            case self::STORAGE_LOCAL_FILE:
                return new LocalFile($this->config[$type]['storageRoot']);
            default:
                throw new StorageException("Undefined storage type.");
        }
    }

}