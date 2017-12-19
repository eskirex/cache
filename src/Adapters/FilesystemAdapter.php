<?php

namespace Eskirex\Component\Cache\Adapters;

use Eskirex\Component\Cache\Traits\FilesystemTrait;
use Eskirex\Component\Cache\Interfaces\CacheInterface;

class FilesystemAdapter implements CacheInterface
{
    use FilesystemTrait;

    public function __construct(string $namespace = null, string $directory = null)
    {
        $this->init($namespace, $directory);
    }


    /**
     * @param string $key
     * @param string|array $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
        return $this->doSet([$key => $value]);
    }


    /**
     * @param array $key
     * @return bool
     */
    public function setMultiple($key)
    {
        return $this->doSet($key);
    }


    /**
     * @param string $key
     *
     * @return string|array
     */
    public function get($key)
    {
        return $this->doFetch([$key]);
    }


    /**
     * @param array $key
     * @return bool
     */
    public function getMultiple($key)
    {
        return $this->doFetch($key);
    }


    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->doCheck([$key]);
    }


    /**
     * @param array $key
     *
     * @return bool
     */
    public function hasMultiple($key)
    {
        return $this->doCheck($key);
    }


    /**
     * @param string $key
     *
     * @return bool
     */
    public function del($key)
    {
        return $this->doDelete([$key]);
    }


    /**
     * @param array $key
     * @return bool
     */
    public function delMultiple($key)
    {
        return $this->doDelete($key);
    }
}