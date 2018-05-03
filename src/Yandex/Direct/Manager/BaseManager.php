<?php

namespace Yandex\Direct\Manager;

use Yandex\Common\Exception\InvalidArgumentException;
use Yandex\Direct\DirectClient;
use Yandex\Direct\Exception\BadResponseException;
use Yandex\Direct\Model\BaseObject;
use Yandex\Direct\Request\GetRequest;
use Yandex\Direct\Structure\ParamsGetRequest;
use Yandex\Direct\Structure\ParamsIdsRequest;


/**
 * Class BaseManager
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
abstract class BaseManager extends DirectClient {

    /** @var string[] */
    protected static $methods = ['add', 'delete', 'get'];
    /** @var string */
    protected $resource = '';
    /** @var string[] */
    protected $resultsContainer = [];
    /** @var string ClassName */
    protected $objectsClass = BaseObject::class;
    static $allGetFields = ['Id'];


    /**
     * @return array
     */
    public static function methods() {
        return static::$methods;
    }
    /**
     * @return string
     */
    public static function resource() {
        return static::$resource;
    }

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct($data) {
        $this->fromArray($data);
    }

    /**
     * @param $method
     * @return GetRequest
     * @throws InvalidArgumentException
     */
    public function createRequest($method) {

        if (!$this->checkMethod($method))
            throw new InvalidArgumentException('Unsupported method for ' . static::class);
        $params = array_merge($this->extendsProps(), ['method' => $method]);

        switch (true) {
            case $method === 'get':
                $request = $this->createGetRequest($params);
                break;
            case $method === 'add':

                break;
            default:
                $request = $this->createIdsRequest($params);
        }

        return $request;
    }

    protected function createGetRequest($params) {
        $params['params'] = new ParamsGetRequest();
        return new GetRequest($params);
    }
    protected function createIdsRequest($params) {
        $params['params'] = new ParamsIdsRequest();
        return new GetRequest($params);
    }

    public function checkMethod($method) {
        return in_array($method, static::$methods, true);
    }
    /**
     * Set from array
     *
     * @param array $data
     * @return $this
     */
    protected function fromArray($data)
    {
        foreach ($data as $key => $val) {
            if (method_exists($this, "set{$key}"))
                call_user_func([$this, "set{$key}"], $val);
            elseif (property_exists($this, $key))
                $this->$key = $val;
        }
        return $this;
    }

    /**
     * @param $response
     * @throws BadResponseException
     */
    protected function responseErrors($response) {
        if (key_exists('error', $response) && is_array($response['error'])) {
            $title = isset($response['error']['error_string'])
                ? $response['error']['error_string']
                : 'Response error';
            $details = isset($response['error']['error_detail'])
                ? $response['error']['error_detail']
                : '(no details)';
            $requestId = isset($response['error']['request_id'])
                ? "[Request ID: {$response['error']['request_id']}]"
                : '';
            $code = isset($response['error']['error_code'])
                ? (int)$response['error']['error_code']
                : 0;
            throw new BadResponseException("{$title}: {$details} {$requestId}", $code);
        }
    }

    /**
     * @return array
     */
    protected function extendsProps() {
        return array_merge(parent::extendsProps(), [
            'resource'         => $this->resource,
            'resultsContainer' => $this->resultsContainer,
            'objectsClass'     => $this->objectsClass,
        ]);
    }
}
