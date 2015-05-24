<?php
/**
 * Description of LocalFile.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Storage;

//todo: directory distribution by first parts of key hash or datetime (if it is a part of key) via decorator
class LocalFile implements Storage
{

    private $storageRoot;

    public function __construct($storageRoot)
    {
        $path = $this->normalizePath($storageRoot);
        $this->validateDirectory($path);
        $this->storageRoot = $path;
    }

    private function normalizePath($path)
    {
        $path = realpath($path);
        if (empty($path)) {
            throw new StorageException("Undefined location '{$path}'.");
        }
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    private function validateDirectory($directoryPath)
    {
        if (!is_dir($directoryPath)) {
            throw new StorageException("'{$directoryPath}' is not a directory.");
        }
        if (!is_writable($directoryPath)) {
            throw new StorageException("'{$directoryPath}' is not writable.");
        }
    }

    public function getFilePath($fileName)
    {
        //currently only single level storage available
        $fileName = pathinfo($fileName, PATHINFO_BASENAME);
        return $this->storageRoot . DIRECTORY_SEPARATOR . $fileName;
    }

    private $storage = [];

    public function set($key, $value)
    {
        if ($this->exist($key)) {
            throw new StorageException("File with same name already exist.");
        }
        $path = $this->getFilePath($key);
        $result = file_put_contents($path, $value);
        if ($result === false) {
            throw new StorageException("Can't write to file.");
        }
    }
    public function get($key)
    {
        if (!$this->exist($key)) {
            throw new StorageException("File not exist.");
        }
        $path = $this->getFilePath($key);
        $result = file_get_contents($path);
        if ($result === false) {
            throw new StorageException("Can't read from file");
        }
        return $result;
    }

    public function exist($key)
    {
        $path = $this->getFilePath($key);
        return file_exists($path);
    }

    public function remove($key)
    {
        if (!$this->exist($key)) {
            throw new StorageException("File not exist.");
        }
        $path = $this->getFilePath($key);
        $result = unlink($path);
        if ($result === false) {
            throw new StorageException("Can't remove file.");
        }
    }

    public function getFirst()
    {
        throw new StorageException("Unsupported method");
    }

}
