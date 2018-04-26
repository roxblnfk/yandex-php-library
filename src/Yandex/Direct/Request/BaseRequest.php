<?php
/**
 * @namespace
 */
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
use Yandex\Direct\Structure\ParamsGetRequest;

/**
 * Class BaseRequest
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class BaseRequest extends BaseManager {
    /** @var string */
    protected $method = '';
    /** @var ParamsGetRequest */
    protected $params;

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
        $response = $this->sendPostRequest($this->resource, [
            'method' => $this->method,
            'params' => $this->params->toArray(),
        ]);

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
        if (!key_exists('result', $response) || !is_array($response['result']))
            throw new BadResponseException('Can\'t parse results');

        if (!key_exists($this->resultsContainer[$this->method], $response['result']) || !is_array($response['result'][$this->resultsContainer[$this->method]])) {
            d($response);
            throw new BadResponseException('Can\'t parse results container');
        }

        $result = new ObjectsColletcion();
        $result->fromArray($this->objectsClass, ...$response['result'][$this->resultsContainer[$this->method]]);

        return $result;
    }

    # TODO: next page
}
