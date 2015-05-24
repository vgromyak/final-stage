<?php
/**
 * Description of LocalFileTest.php
 *
 * @author Vladimir Gromyak
 */

namespace UWC\Tests\Storage;


use UWC\Storage\LocalFile;

class LocalFileTest extends \UWC\Tests\TestCase
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
    public function testGet(LocalFile $storage)
    {
        $value = $storage->get('key');

        $this->assertNotEmpty($value);
        $this->assertEquals('value', $value);
    }

    /**
     * @depends testSet
     */
    public function testExist(LocalFile $storage)
    {
        $result = $storage->exist('key');

        $this->assertTrue($result);
    }

    /**
     * @depends testSet
     */
    public function testRemove(LocalFile $storage)
    {
        $storage->remove('key');

        $result = $storage->exist('key');
        $this->assertFalse($result);
    }

    /**
     * @expectedException \UWC\Storage\StorageException
     */
    public function testGetFirst()
    {
        $storage = $this->getStorage();
        $storage->getFirst();
    }

    private function getStorage()
    {
        return new LocalFile('/tmp/storage_tests/');
    }

}