<?php

namespace Yandex\Direct\Request;

use Yandex\Common\Exception\ForbiddenException;
use Yandex\Common\Exception\UnauthorizedException;
use Yandex\Common\Exception\TooManyRequestsException;
use Yandex\Direct\Exception\BadRequestException;
use Yandex\Direct\Exception\BadResponseException;
use Yandex\Direct\Exception\DirectException;
use Yandex\Direct\Manager\ReportManager;
use Yandex\Direct\Model\ObjectsColletcion;
use Yandex\Direct\Structure\Params;
use Yandex\Direct\Structure\ParamsReportDefinition;

/**
 * Class ReportRequest
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ReportRequest extends ReportManager {
    /** @var ParamsReportDefinition */
    protected $params;

    /**
     * @return Params
     */
    public function Params() {
        return $this->params;
    }

    /**
     * @return string|ObjectsColletcion
     * @throws BadRequestException
     * @throws BadResponseException
     * @throws DirectException
     * @throws ForbiddenException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    public function execRequest() {

        //*
        $res = $this->sendRequest('POST', $this->getServiceUrl($this->resource), [
            'json' => [
                'params' => $this->params->toArray(),
            ],
        ]);
        $response = $this->getDecodedBody($res->getBody());
        if ($response)
            $this->responseErrors($response);

        $response = (string)$res->getBody();

        if ($this->params->getFormat() === 'TSV') {

            # parse TSV
            try {
                $result = new ObjectsColletcion();
                $posA = 0;
                $posB = strpos($response, "\n", $posA);
                $posZ = $this->skipReportSummary ? strlen($response) - 1 : strrpos($response, "\n");
                $skip = !$this->skipReportHeader + !$this->skipColumnHeader;
                $fields = $this->params->getFieldNames();
                $objClass = $this->objectsClass;
                do {
                    $line = substr($response, $posA, $posB - $posA);
                    if ($skip) {
                        --$skip;
                    } else {
                        $vals = explode("\t", $line);
                        $resLine = array_combine($fields, $vals);
                        $result->add(new $objClass($resLine));
                    }
                    $posA = $posB + 1;
                    $posB = strpos($response, "\n", $posA);
                } while (false !== $posB && $posB < $posZ);
            } catch (\Exception $e) {
                throw new BadResponseException('Can\'t parse results container');
            }
            return $result;

        } else {
            return $response;
        }
    }
}
