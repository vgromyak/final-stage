<?php
/**
 * Description of Memory.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Storage;

class Memory implements Storage
{

    private $storage = [];

    public function set($key, $value)
    {
        $this->storage[$key] = $value;
    }
    public function get($key)
    {
        return $this->storage[$key];
    }

    public function exist($key)
    {
        return isset($this->storage[$key]);
    }

    public function remove($key)
    {
        unset($this->storage[$key]);
    }

    public function getFirst()
    {
        return reset($this->storage);
    }
}