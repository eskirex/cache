<?php

namespace Eskirex\Component\Cache\Traits;


use Eskirex\Component\Dotify\Dotify;

trait VariableTrait
{
    /**
     * @var Dotify
     */
    protected static $data;
    protected $namespace;

    protected function init($namespace)
    {
        self::$data = dotify(self::$data);

        $s = '';

        if (isset($namespace[0])) {
            if (preg_match('#[^-+_.A-Za-z0-9]#', $namespace, $match)) {
                throw new InvalidArgumentException(sprintf('Namespace contains "%s" but only characters in [-+_.A-Za-z0-9] are allowed.', $match[0]));
            }
            $s .= $namespace . '.';
        }


        $this->namespace = $s;
    }

    protected function doSet(array $arr)
    {
        foreach ($arr as $name => $data) {
            $this->write($name, $data);
        }

        return true;
    }

    protected function doFetch(array $arr)
    {
        $return = [];
        $response = null;

        foreach ($arr as $name) {

            if ($this->have($name)) {
                $response = $this->fetch($name);
            }

            $return[$name] = $response;
        }

        if (count($return) === 1) {
            return array_values($return)[0];
        }

        if (count($return) > 1) {
            return $return;
        }

        return null;
    }

    protected function doCheck(array $arr)
    {
        $return = [];
        $response = null;

        foreach ($arr as $name) {

            if ($this->have($name)) {
                $response = true;
            }

            $return[$name] = $response;
        }

        if (count($return) === 1) {
            return array_values($return)[0];
        }

        if (count($return) > 1) {
            return $return;
        }

        return null;
    }

    protected function doDelete(array $arr)
    {
        $return = [];
        $response = false;

        foreach ($arr as $name) {

            if ($this->have($name)) {
                $this->delete($name);

                $response = true;
            }

            $return[$name] = $response;
        }

        if (count($return) === 1) {
            return array_values($return)[0];
        }

        if (count($return) > 1) {
            return $return;
        }

        return null;
    }

    protected function write($name, $data)
    {
        $name = $this->getName($name);

        return self::$data->set($name, $data);
    }


    protected function delete($name)
    {
        $name = $this->getName($name);

        return self::$data->del($name);
    }


    protected function have($name)
    {
        $name = $this->getName($name);

        return self::$data->has($name);
    }


    protected function fetch($name)
    {
        $name = $this->getName($name);

        return self::$data->get($name);
    }


    protected function getName($name)
    {
        return $this->namespace . $name;
    }
}