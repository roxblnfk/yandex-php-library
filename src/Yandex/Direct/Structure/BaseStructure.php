<?php

namespace Yandex\Direct\Structure;
use Yandex\Direct\Exception\MissedParameterException;

/**
 * Class CampaignsSelectionCriteria
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
abstract class BaseStructure implements \ArrayAccess {

    /** @var mixed[] */
    protected $data = [];
    /** @var mixed[] */
    protected $subData = [];
    /** @var mixed[] */
    protected $container = [];

    protected $fields = [];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->fromArray($data);
    }

    public function __get($name) {
        return property_exists($this, $name) ? $this->$name : null;
    }
    public function __set($name, $value) {
        $this->{"set{$name}"}($value);
    }
    public function __call($name, $arguments) {
        # Prefixes [get, set, add]
        $method = substr($name, 0, 3);
        if (in_array($method, ['set', 'get', 'add'], true)) {
            $varName = substr($name, 3);
            if (strlen($varName)) {
                if (key_exists($varName, $this->fields)) {
                    if (!key_exists($varName, $this->data))
                        $this->data[$varName] = null;
                    $vl = &$this->data[$varName];
                } else {
                    if (!key_exists($varName, $this->subData))
                        $this->subData[$varName] = null;
                    $vl = &$this->subData[$varName];
                }
                if ($method === 'get')
                    return $vl;
                if ($method === 'add') {
                    if (is_null($vl))
                        $vl = $arguments;
                    elseif (is_object($vl) && method_exists($vl, 'add'))
                        call_user_func_array([$vl, 'add'], $arguments);
                    else
                        $vl = is_array($vl) ? array_merge($vl, $arguments) : array_merge([$vl], $arguments);
                    return $this;
                }
                # method set
                switch (count($arguments)) {
                    case 0:
                        $vl = null;
                        break;
                    case 1;
                        $vl = $arguments[0];
                        break;
                    default:
                        $vl = $arguments;
                }
                return $this;
            }
        }

        return $this;
    }

    /**
     * Set from array
     *
     * @param array $data
     * @return $this
     */
    public function fromArray($data)
    {
        foreach ($data as $key => $val) {
            if (is_int($key)) {
                if (method_exists($this, "add"))
                    $this->add($val);
                else
                    $this->container[] = $val;
                continue;
            }
            if (key_exists($key, $this->fields) || method_exists($this, "set{$key}"))
                $this->{"set{$key}"}($val);
            else
                $this->subData[$key] = $val;
        }
        # set defaults
        foreach ($this->fields as $key => $field) {
            if (key_exists($key, $this->data) || !key_exists('default', $field))
                continue;
            if (isset($field['class']) && class_exists($field['class'])) {
                $className = $field['class'];
                $this->data[$key] = new $className($field['default']);
            } else {
                $this->data[$key] = $field['default'];
            }
        }
        return $this;
    }

    /**
     * Set from json
     *
     * @param string $json
     * @return $this
     */
    public function fromJson($json)
    {
        $this->fromArray(json_decode($json, true));
        return $this;
    }

    /**
     * Get array from object
     *
     * @return array
     */
    public function toArray()
    {
        return $this->toArrayRecursive($this);
    }

    /**
     * Get array from object
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArrayRecursive($this));
    }

    /**
     * Get array from object
     *
     * @param array|object $data
     * @return array
     */
    protected function toArrayRecursive($data) {
        $recObj = is_object($data) && method_exists($data, "toArrayRecursive") ? $data : $this;
        if (is_object($data) && method_exists($data, "getAll")) {
            $result = $recObj->toArrayRecursive($data->getAll());
        } elseif (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                if (is_null($value))
                    continue;
                $result[$key] = is_scalar($value) ? $value : $recObj->toArrayRecursive($value);
            }
        } else {
            return $data;
        }
        return $result;
    }
    /**
     * @return array
     */
    public function getAll() {
        $result = [];
        foreach ($this->fields as $name => $prop) {
            $field = new Field($name, $prop);
            $result[$name] = $this->{"get{$name}"}();
            if ($field->required and is_null($result[$name]) || is_array($result[$name]) && !$result[$name])
                throw new MissedParameterException();
        }
        return array_merge($result, $this->subData);
    }

    /**
     * @param $offset mixed
     * @return bool
     */
    public function offsetExists($offset) {
        return key_exists($offset, $this->data) || key_exists($offset, $this->subData);
    }
    /**
     * @param $offset mixed
     * @return BaseObject
     */
    public function offsetGet ($offset) {
        return call_user_func([$this, "get{$offset}"]);
    }
    public function offsetSet ($offset, $value) {
        return call_user_func([$this, "set{$offset}"], $value);
    }
    public function offsetUnset($offset) {
        return call_user_func([$this, "set{$offset}"], null);
    }
}
