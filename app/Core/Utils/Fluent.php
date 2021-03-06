<?php

namespace App\Core\Utils;

class Fluent implements \ArrayAccess
{
    protected $items = [];
    protected $originalItem = [];
    function __construct(&$items)
    {
        if(is_array($items)) {
            $this->items = $items;
        }else {
            foreach($items as $key => $value){
                $this->items[$key] = $value;
            }
        }
        $this->originalItem = $items;
    }
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }
    public function __set ($name ,$value )
    {
        $this->items[$name] = $value;
    }

    public function __get ($name )
    {
        if(array_key_exists($name, $this->items)){
            return $this->items[$name];
        }
        return null;
    }
    public function __isset($name)
    {
        return isset($this->items[$name]);
    }

    public function __unset($name)
    {
        unset($this->items[$name]);
    }
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }
    
    public function remove($name)
    {
        unset($this->items[$name]);
    }

    public function flush(){
        $this->items = [];
    }
}
