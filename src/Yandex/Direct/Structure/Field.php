<?php

namespace Yandex\Direct\Structure;

/**
 * Class BaseField
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 *
 * @property-read $name
 * @property-read $value
 * @property-read $required
 */
class Field
{
    protected $name;
    protected $value;
    protected $required;
    protected $default;


    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($name, $data = [])
    {
        $this->name = $name;
        if (is_array($data))
            $this->fromArray($data);
    }

    public function __get($name) {
        return property_exists($this, $name) ? $this->$name : null;
    }

    /**
     * Set from array
     *
     * @param array $data
     * @return $this
     */
    public function fromArray($data)
    {
        $this->value = isset($data['required']) ? $data['required'] : null;
        $this->required = isset($data['required']) ? (bool)$data['required'] : false;
        return $this;
    }
}
