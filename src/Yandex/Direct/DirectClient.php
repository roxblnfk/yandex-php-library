<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */


/**
 * @namespace
 */
namespace Yandex\Direct;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Yandex\Common\AbstractServiceClient;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\InvalidArgumentException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Direct\Exception\BadRequestException;
use Yandex\Direct\Exception\DirectException;
use Yandex\Direct\Manager\AdsManager;
use Yandex\Direct\Manager\CampaignsManager;
use Yandex\Direct\Manager\ReportManager;
use Yandex\Direct\Model\BaseObject;
use Yandex\Direct\Request\GetRequest;

/**
 * Class DirectClient
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class DirectClient extends AbstractServiceClient
{
    public $sandboxMode = true;

    public $clientLogin = ''; # Логин рекламодателя — клиента рекламного агентства. Обязателен, если запрос осуществляется от имени агентства
    public $useOperatorUnits = false; # Расходовать баллы агентства, а не рекламодателя при выполнении запроса

    /** @var string API domain */
    protected $serviceDomain = 'api.direct.yandex.com/json/v5';

    /** @var string API sandbox domain */
    protected $serviceSandboxDomain = 'api-sandbox.direct.yandex.com/json/v5';

    /**
     * @param string $token access token
     * @param ClientInterface $client
     */
    public function __construct($token = '', ClientInterface $client = null)
    {
        $this->setAccessToken($token);
        if (!is_null($client)) {
            $this->setClient($client);
        }
    }

    /**
     * Get url to service resource with parameters
     *
     * @param string $resource
     * @param array $params
     * @see http://api.yandex.ru/metrika/doc/ref/concepts/method-call.xml
     * @return string
     */
    public function getServiceUrl($resource = '', $params = [])
    {
        $url = "{$this->serviceScheme}://"
            . ($this->sandboxMode ? $this->serviceSandboxDomain : $this->serviceDomain)
            // . "/{$resource}{$format}?oauth_token=" . $this->getAccessToken();
            . "/{$resource}";

        if ($params) {
            // $url .= '&' . http_build_query($params);
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Sends a request
     *
     * @param string $method  HTTP method
     * @param string $uri     URI object or string.
     * @param array  $options Request options to apply.
     *
     * @return Response
     *
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendRequest($method, $uri, array $options = [])
    {
        try {
            $response = $this->getClient()->request($method, $uri, $options);
        } catch (ClientException $ex) {
            $result = $ex->getResponse();
            $code = $result->getStatusCode();
            $message = $result->getReasonPhrase();

            $body = $result->getBody();
            if ($body) {
                $jsonBody = json_decode($body);
                if ($jsonBody && isset($jsonBody->message)) {
                    $message = $jsonBody->message;
                }
            }

            if ($code === 400) {
                throw new BadRequestException($message);
            }

            if ($code === 403) {
                throw new ForbiddenException($message);
            }

            if ($code === 401) {
                throw new UnauthorizedException($message);
            }

            if ($code === 429) {
                throw new TooManyRequestsException($message);
            }

            throw new DirectException(
                'Service responded with error code: "' . $code . '" and message: "' . $message . '"',
                $code
            );
        }

        return $response;
    }

    /**
     * @param array $defaultOptions
     * @return ClientInterface
     */
    protected function getClient($defaultOptions = []) {
        if (is_null($this->client)) {
            $defaultOptions['base_uri'] = $this->getServiceUrl();
            $defaultOptions['headers'] = isset($defaultOptions['headers']) ? (array)$defaultOptions['headers'] : [];
            $defaultOptions['headers']['Authorization'] = 'Bearer ' . $this->getAccessToken();
            $defaultOptions['headers']['Host'] = $this->getServiceDomain();
            $defaultOptions['headers']['User-Agent'] = $this->getUserAgent();
            $defaultOptions['headers']['Accept'] = '*/*';
            if ($this->clientLogin) {
                $defaultOptions['headers']['Client-Login'] = $this->clientLogin;
                if (is_bool($this->useOperatorUnits))
                    $defaultOptions['headers']['Use-Operator-Units'] = $this->useOperatorUnits ? 'true' : 'false';
            }
            if ($this->getProxy()) {
                $defaultOptions['proxy'] = $this->getProxy();
            }
            if ($this->getDebug()) {
                $defaultOptions['debug'] = $this->getDebug();
            }
            $this->client = new Client($defaultOptions);
        }

        return $this->client;
    }


    /**
     * @return CampaignsManager
     */
    public function CampaignsManager() {
        return new CampaignsManager($this->extendsProps());
    }
    /**
     * @return AdsManager
     */
    public function AdsManager() {
        return new AdsManager($this->extendsProps());
    }
    /**
     * @return ReportManager
     */
    public function ReportManager() {
        return new ReportManager($this->extendsProps());
    }

    protected function extendsProps() {
        $ret = [
            'sandboxMode'      => $this->sandboxMode,
            'clientLogin'      => $this->clientLogin,
            'useOperatorUnits' => $this->useOperatorUnits,
            'AccessToken'      => $this->accessToken,
        ];
        if ($this->client)
            $ret['Client'] = $this->client;
        return $ret;
    }

    /**
     * Send GET request to API resource
     *
     * @param string $resource
     * @param array  $params
     * @return array
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    protected function sendGetRequest($resource, $params = [])
    {
        $response = $this->sendRequest(
            'GET',
            $this->getServiceUrl($resource, $params),
            [
                'headers' => [
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        if (isset($decodedResponseBody['links']) && isset($decodedResponseBody['links']['next'])) {
            $url = $decodedResponseBody['links']['next'];
            unset($decodedResponseBody['rows']);
            unset($decodedResponseBody['links']);
            return $this->getNextPartOfList($url, $decodedResponseBody);
        }
        return $decodedResponseBody;
    }

    /**
     * Send custom GET request to API resource
     *
     * @param string $url
     * @param array  $data
     * @return array
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    protected function getNextPartOfList($url, $data = [])
    {
        $response = $this->sendRequest(
            'GET',
            $url,
            [
                'headers' => [
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );

        $decodedResponseBody = $this->getDecodedBody($response->getBody());

        $mergedDecodedResponseBody = array_merge_recursive($data, $decodedResponseBody);

        if (isset($mergedDecodedResponseBody['links']) && isset($mergedDecodedResponseBody['links']['next'])) {
            $url = $mergedDecodedResponseBody['links'];
            unset($mergedDecodedResponseBody['rows']);
            unset($mergedDecodedResponseBody['links']);
            return $this->getNextPartOfList($url, $response);
        }

        return $mergedDecodedResponseBody;
    }

    /**
     * Send POST request to API resource
     *
     * @param string $resource
     * @param array  $params
     * @return array
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    protected function sendPostRequest($resource, $params)
    {
        $response = $this->sendRequest(
            'POST',
            $this->getServiceUrl($resource),
            [
                // 'headers' => [
                //     'Accept' => 'application/x-yametrika+json',
                //     'Content-Type' => 'application/x-yametrika+json',
                // ],
                'json' => $params,
            ]
        );

        return $this->getDecodedBody($response->getBody());
    }

    /**
     * Send PUT request to API resource
     *
     * @param string $resource
     * @param array  $params
     * @return array
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    protected function sendPutRequest($resource, $params)
    {
        $response = $this->sendRequest(
            'PUT',
            $this->getServiceUrl($resource),
            [
                'headers' => [
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ],
                'json' => $params
            ]
        );

        return $this->getDecodedBody($response->getBody());
    }

    /**
     * Send DELETE request to API resource
     *
     * @param string $resource
     * @return array
     * @throws BadRequestException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    protected function sendDeleteRequest($resource)
    {
        $response = $this->sendRequest(
            'DELETE',
            $this->getServiceUrl($resource),
            [
                'headers' => [
                    'Accept' => 'application/x-yametrika+json',
                    'Content-Type' => 'application/x-yametrika+json',
                ]
            ]
        );

        return $this->getDecodedBody($response->getBody());
    }
}
