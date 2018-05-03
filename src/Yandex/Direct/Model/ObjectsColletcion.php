<?php

namespace Yandex\Direct\Model;

use Yandex\Common\Exception\InvalidArgumentException;

/**
 * Class ObjectsColletcion
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ObjectsColletcion implements \ArrayAccess, \Iterator, \Countable {

    /** @var BaseObject[] */
    protected $container = [];

    protected $innerCounter = -1;

    /**
     * @param BaseObject[] ...$objects
     */
    public function add(BaseObject ...$objects) {
        foreach ($objects as $obj)
            $this->container[] = $obj;
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->container);
    }
    public function current() {
        return current($this->container);
    }
    public function next() {
        $this->innerCounter++;
        return next($this->container);
    }
    /**
     * @return int
     */
    public function key() {
        return key($this->container);
    }
    /**
     * @return bool
     */
    public function valid() {
        return $this->innerCounter < count($this->container);
    }
    public function rewind() {
        $this->innerCounter = 0;
        reset($this->container);
        return;
    }

    /**
     * @param $name string
     * @return mixed[]
     */
    public function column($name) {
        $result = [];
        foreach ($this->container as $key => $el) {
            $result[$key] = $el[$name];
        }
        return $result;
    }
    /**
     * Filter values by selector
     * @param $selector
     * @return ObjectsColletcion
     */
    public function filter($selector = null) {
        $selected = $this->filterSequence($this->container, $selector);
        $return = new static();
        $return->add(...$selected);
        return $return;
    }

    /**
     * @param $offset mixed
     * @return bool
     */
    public function offsetExists($offset) {
        return key_exists($offset, $this->container);
    }
    /**
     * @param $offset mixed
     * @return BaseObject
     */
    public function offsetGet ($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    public function offsetSet ($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    /**
     * @param       $className
     * @param array ...$elements
     * @return ObjectsColletcion
     * @throws InvalidArgumentException
     */
    public function fromArray($className, ...$elements) {
        if (!class_exists($className))
            throw new InvalidArgumentException();
        foreach ($elements as $element) {
            $obj = new $className($element);
            $this->add($obj);
        }
        return $this;
    }

    protected function filterSequence(&$elements, &$selector, $recursive = true) {
        if (is_null($selector)) return $elements;
        $selected= [];
        if (is_array($selector)) {
            $valsScalars = true;
            $keysStrings = false;
            # analysis of selector
            foreach ($selector as $k => &$sel) {
                if (is_int($k) && (is_scalar($sel) || is_null($sel)))
                    continue;
                if (is_string($k))
                    $keysStrings = true;
                if (!is_scalar($sel))
                    $valsScalars = false;
                if ($keysStrings /*&& !$valsScalars*/) {
                    $recursive = false;
                    break;
                }
            }
            // d($selector);
            // d($keysStrings);
            // d($valsScalars);
            // ddd($recursive);
            if ($valsScalars && !$keysStrings) {
                # find by id in container
                foreach ($selector as &$sel) {
                    if (array_key_exists($sel, $elements)) {
                        $selected[$sel] = &$elements[$sel];
                    }
                }
            } else {
                if (!$recursive) {
                    # custom search
                    foreach ($elements as $kel => &$el) {
                        $addIt = true;
                        foreach ($selector as $k => &$sel) {
                            $val = $el[$k];
                            if (is_null($sel) || is_scalar($sel) || is_object($sel)) {
                                if ($val !== $sel) {
                                    $addIt = false;
                                    break;
                                }
                            }
                            if (is_array($sel)) {
                                if (!in_array($val, $sel, true)) {
                                    $addIt = false;
                                    break;
                                }
                            }
                            if (!is_string($sel) && is_callable($sel)) {
                                if (false === $sel($val)) {
                                    $addIt = false;
                                    break;
                                }
                            }
                        }
                        if ($addIt) {
                            $selected[$kel] = &$el;
                        }
                    }
                } else {
                    foreach ($selector as &$sel) {
                        $res = $this->filterSequence($elements, $sel, false);
                        if ($res) foreach ($res as $kres => &$vres) {
                            $selected[$kres] = &$vres;
                        }
                    }
                }
            }
        } elseif (is_scalar($selector)) {
            if (array_key_exists($selector, $elements)) {
                $selected[$selector] = &$elements[$selector];
            }
        } elseif (is_object($selector)) {
            foreach ($elements as $kel => &$el) {
                if ($el === $selector) {
                    $selected[$kel] = &$el;
                }
            }
        } elseif (!is_string($selector) && is_callable($selector)) {
            foreach ($elements as $kel => &$el) {
                if (false !== $selector($el)) {
                    $selected[$kel] = &$el;
                }
            }
        }
        return $selected;
    }
}
