<?php

namespace App\Helpers;

use Exception;
use ReflectionProperty;

trait MagicAccess
{
    public function __get($var)
    {
        $method = $this->getValidMethod('get', $var);

        return $this->$method();
    }

    public function __set($var, $val)
    {
        $method = $this->getValidMethod('set', $var);

        $this->$method($val);
    }

    private function getValidMethod($access, $var)
    {
        $method = $access . ucfirst($var);

        if (! is_callable([$this, $method])) {
            throw new Exception("Inaccessible property does not have {$access}ter method.");
        }

        return $method;
    }

    public function offsetGet($offset)
    {
        if ($this->isPublic($offset)) {
            return $this->$offset;
        }

        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        if ($this->isPublic($offset)) {
            $this->$offset = $value;
        }

        return $this->__set($offset, $value);
    }

    public function offsetExists($offset)
    {
        try {
            $this->offsetGet($offset);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function offsetUnset($offset)
    {
        $this->offsetSet($offset, null);
    }

    private function isPublic($key)
    {
        $prop = new ReflectionProperty($this, $key);

        return $prop->isPublic();
    }
}