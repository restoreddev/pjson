<?php

namespace Pjson;

use Closure;

class Pjson
{
    /**
     * Attributes of pjson
     *
     * @var array
     */
    protected $attributes;

    /**
     * Sets attribute on internal array
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Maps attribute on internal array
     *
     * @return Pjson
     */
    public function __call($name, $args)
    {
        if (count($args) == 1) {
            $this->object($name, $args[0]);
        } elseif (count($args) == 2) {
            $this->array($name, $args[0], $args[1]);
        }

        return $this;
    }

    /**
     * Emulates json array
     *
     * @param string $name
     * @param mixed $collection
     * @param Closure $callback
     * @return Pjson
     */
    public function array($name, $collection, Closure $callback)
    {
        $this->attributes[$name] = $this->mapArray($collection, $callback);

        return $this;
    }

    /**
     * Emulates json object
     *
     * @param string $name
     * @param Closure $callback
     * @return Pjson
     */
    public function object($name, Closure $callback)
    {
        $this->attributes[$name] = $this->mapObject($callback);

        return $this;
    }

    /**
     * Set property on json object
     *
     * @param string $name
     * @param mixed $value
     * @return Pjson
     */
    public function set($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Returns attributes as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->convertAttributesToArray($this->attributes);
    }

    /**
     * Serializes object as json
     *
     * @return string
     */
    public function serialize()
    {
        return json_encode($this->toArray());
    }

    /**
     * Converts pjson attributes to array
     *
     * @param array $attributes
     * @return array
     */
    protected function convertAttributesToArray($attributes)
    {
        foreach ($attributes as $key => $attribute) {
            if ($attribute instanceof Pjson) {
                $attributes[$key] = $attribute->toArray();
            } else if (is_array($attribute)) {
                $attributes[$key] = $this->convertAttributesToArray($attribute);
            }
        }

        return $attributes;
    }

    /**
     * Takes user callback for creating pjson as attribute
     *
     * @param Closure $callback
     * @return Pjson
     */
    protected function mapObject(Closure $callback)
    {
        $pjson = new Pjson;

        $callback($pjson);

        return $pjson;
    }

    /**
     * Takes user collection and callback for
     * mapping collection to pjson objects
     *
     * @param mixed $collection
     * @param Closure $callback
     * @return Pjson
     */
    protected function mapArray($collection, Closure $callback)
    {
        $list = [];

        foreach($collection as $item) {
            $pjson = new Pjson;
            $callback($pjson, $item);
            $list[] = $pjson;
        }
        
        return $list;
    }
}

