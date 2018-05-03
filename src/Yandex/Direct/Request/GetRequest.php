<?php

namespace Yandex\Direct\Request;

use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\InvalidArgumentException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Direct\Exception\BadRequestException;
use Yandex\Direct\Exception\BadResponseException;
use Yandex\Direct\Exception\DirectException;
use Yandex\Direct\Manager\BaseManager;
use Yandex\Direct\Model\ObjectsColletcion;
use Yandex\Direct\Structure\Params;

/**
 * Class GetRequest
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class GetRequest extends BaseManager {
    /** @var string */
    protected $method = '';
    /** @var Params */
    protected $params;

    /**
     * @return Params
     */
    public function Params() {
        return $this->params;
    }

    /**
     * @return ObjectsColletcion
     * @throws BadRequestException
     * @throws BadResponseException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws InvalidArgumentException
     */
    public function execRequest() {
        $response = (array)$this->sendPostRequest($this->resource, [
            'method' => $this->method,
            'params' => $this->params->toArray(),
        ]);

        $this->responseErrors($response);

        if (!key_exists('result', $response) || !is_array($response['result']))
            throw new BadResponseException('Can\'t parse results');

        if (!key_exists($this->resultsContainer[$this->method], $response['result']) || !is_array($response['result'][$this->resultsContainer[$this->method]])) {
            throw new BadResponseException('Can\'t parse results container');
        }

        $result = new ObjectsColletcion();
        $result->fromArray($this->objectsClass, ...$response['result'][$this->resultsContainer[$this->method]]);

        return $result;
    }

    # TODO: next page
}
