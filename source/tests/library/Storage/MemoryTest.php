<?php
/**
 * Description of MemoryTest.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Tests\Storage;


use UWC\Storage\Memory;

class MemoryTest extends \UWC\Tests\TestCase
{

    public function testSet()
    {
        $storage = $this->getStorage();
        $storage->set('key', 'value');
        return $storage;
    }

    /**
     * @depends testSet
     */
    public function testGet(Memory $storage)
    {
        $value = $storage->get('key');

        $this->assertNotEmpty($value);
        $this->assertEquals('value', $value);
    }

    /**
     * @depends testSet
     */
    public function testExist(Memory $storage)
    {
        $result = $storage->exist('key');

        $this->assertTrue($result);
    }

    /**
     * @depends testSet
     */
    public function testRemove(Memory $storage)
    {
        $storage->remove('key');

        $result = $storage->exist('key');
        $this->assertFalse($result);
    }

    public function testGetFirst()
    {
        $storage = $this->getStorage();
        $storage->set('key1', 'value1');
        $storage->set('key2', 'value2');
        $storage->set('key3', 'value3');

        $result = $storage->getFirst();
        $this->assertEquals('value1', $result);
    }

    /**
     * @return \UWC\Storage\Memory
     */
    private function getStorage()
    {
        return new Memory();
    }


//    public function set($key, $value);
//    public function get($key);
//    public function exist($key);
//    public function remove($key);
//    public function getFirst();
}