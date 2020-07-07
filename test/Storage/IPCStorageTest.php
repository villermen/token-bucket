<?php

namespace JouwWeb\TokenBucket\Test\Storage;

use JouwWeb\TokenBucket\Storage\IPCStorage;

class IPCStorageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests building fails for an invalid key.
     *
     * @expectedException \JouwWeb\TokenBucket\Storage\StorageException
     */
    public function testBuildFailsForInvalidKey()
    {
        @new IPCStorage("invalid");
    }

    /**
     * Tests remove() fails.
     *
     * @expectedException \JouwWeb\TokenBucket\Storage\StorageException
     * @expectedExceptionMessage Could not release shared memory.
     */
    public function testRemoveFails()
    {
        $storage = new IPCStorage(ftok(__FILE__, "a"));
        $storage->remove();
        @$storage->remove();
    }

    /**
     * Tests removing semaphore fails.
     *
     * @expectedException \JouwWeb\TokenBucket\Storage\StorageException
     * @expectedExceptionMessage Could not remove semaphore.
     */
    public function testfailRemovingSemaphore()
    {
        $key     = ftok(__FILE__, "a");
        $storage = new IPCStorage($key);
        
        sem_remove(sem_get($key));
        @$storage->remove();
    }

    /**
     * Tests setMicrotime() fails.
     *
     * @expectedException \JouwWeb\TokenBucket\Storage\StorageException
     */
    public function testSetMicrotimeFails()
    {
        $storage = new IPCStorage(ftok(__FILE__, "a"));
        $storage->remove();
        @$storage->setMicrotime(123);
    }

    /**
     * Tests getMicrotime() fails.
     *
     * @expectedException \JouwWeb\TokenBucket\Storage\StorageException
     */
    public function testGetMicrotimeFails()
    {
        $storage = new IPCStorage(ftok(__FILE__, "b"));
        @$storage->getMicrotime();
    }
}
