<?php
/**
 * Description of Storage.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Storage;

interface Storage
{

    public function set($key, $value);
    public function get($key);
    public function exist($key);
    public function remove($key);
    public function getFirst();

}