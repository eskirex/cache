<?php

namespace Eskirex\Component\Cache\Interfaces;

interface CacheInterface
{

    /**
     * @param string $key
     * @param string|array $value
     *
     * @return bool
     */
    public function set($key, $value);


    /**
     * @param array $key
     * @return bool
     */
    public function setMultiple($key);


    /**
     * @param string $key
     *
     * @return string|array
     */
    public function get($key);


    /**
     * @param array $key
     * @return bool
     */
    public function getMultiple($key);


    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);


    /**
     * @param array $key
     *
     * @return bool
     */
    public function hasMultiple($key);


    /**
     * @param string $key
     *
     * @return bool
     */
    public function del($key);


    /**
     * @param array $key
     * @return bool
     */
    public function delMultiple($key);
}