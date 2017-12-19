<?php

namespace Eskirex\Component\Cache\Traits;

use Eskirex\Component\Cache\Exceptions\CacheException;
use Eskirex\Component\Cache\Exceptions\InvalidArgumentException;

trait FilesystemTrait
{
    protected $directory;

    protected function init($namespace, $directory)
    {
        if (!isset($directory[0])) {
            $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'eskirex' . DIRECTORY_SEPARATOR . 'cache';
        } else {
            $directory = realpath($directory) ?: $directory;
        }
        if (isset($namespace[0])) {
            if (preg_match('#[^-+_.A-Za-z0-9]#', $namespace, $match)) {
                throw new InvalidArgumentException(sprintf('Namespace contains "%s" but only characters in [-+_.A-Za-z0-9] are allowed.', $match[0]));
            }
            $directory .= DIRECTORY_SEPARATOR . $namespace;
        }
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $directory .= DIRECTORY_SEPARATOR;
        // On Windows the whole path is limited to 258 chars
        if ('\\' === DIRECTORY_SEPARATOR && strlen($directory) > 234) {
            throw new InvalidArgumentException(sprintf('Cache directory too long (%s)', $directory));
        }

        $this->directory = $directory;
    }

    protected function doSet(array $ids)
    {
        foreach ($ids as $name => $data) {

            if (!$this->have($name)) {
                $this->create($name);
            }

            $data = serialize($data);
            $this->write($name, $data);
        }

        return true;
    }

    protected function doFetch(array $ids)
    {
        $return = [];
        $response = null;

        foreach ($ids as $name) {

            if ($this->have($name)) {
                $file = $this->getFile($name);

                $response = unserialize(file_get_contents($file));
            }

            $return[$name] = $response;
        }

        return count($return) > 1 ? $return : array_values($return)[0];
    }

    protected function doCheck(array $ids)
    {
        $return = [];
        $response = null;

        foreach ($ids as $name) {

            if ($this->have($name)) {
                $response = true;
            }

            $return[$name] = $response;
        }

        return count($return) > 1 ? $return : array_values($return)[0];
    }

    protected function doDelete(array $ids)
    {
        $return = [];
        $response = false;

        foreach ($ids as $name) {
            $file = $this->getFile($name);

            if ($this->have($name) && unlink($file)) {
                $response = true;
            }

            $return[$name] = $response;
        }

        return count($return) > 1 ? $return : array_values($return)[0];
    }

    protected function write($name, $data)
    {
        if (!is_writable($this->directory)) {
            throw new CacheException(sprintf('Cache directory is not writable (%s)', $this->directory));
        }

        $file = $this->getFile($name);

        return file_put_contents($file, $data);
    }

    protected function create($key)
    {
        $key = explode('.', $key);
        $cache = end($key);
        array_pop($key);

        $name = $this->directory;

        foreach ($key as $folder) {
            $name .= $folder . DIRECTORY_SEPARATOR;
        }

        if (!is_dir($name)) {
            mkdir($name, 0777, true);
        }

        touch($name . $cache);


    }

    protected function getFile($name)
    {
        $name = str_replace('.', DIRECTORY_SEPARATOR, $name);

        return $this->directory . $name;
    }

    protected function have($name)
    {
        $file = $this->getFile($name);

        return file_exists($file);
    }
}