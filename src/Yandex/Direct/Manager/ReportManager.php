<?php

namespace Yandex\Direct\Manager;

use Yandex\Direct\Model\AdObject;
use Yandex\Direct\Model\BaseObject;
use Yandex\Direct\Request\GetRequest;
use Yandex\Direct\Structure\AdsSelectionCriteria;
use Yandex\Direct\Structure\ParamsGetRequest;


/**
 * Class ReportManager
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ReportManager extends BaseManager {

    protected static $methods = ['add', 'update', 'delete', 'suspend', 'resume', 'archive', 'unarchive', 'get', 'moderate'];
    protected $resource = 'ads';
    protected $resultsContainer = [
        'get' => 'Ads',
    ];
    protected $objectsClass = BaseObject::class;

    public $processingMode = 'auto';
    public $returnMoneyInMicros = false;
    public $skipReportHeader = true;
    public $skipColumnHeader = true;
    public $skipReportSummary = true;

    static $allGetFields = [
        'AdCategories',
        'AdCategories',
        'AgeLabel',
        'AdGroupId',
        'CampaignId',
        'Id',
        'State',
        'Status',
        'StatusClarification',
        'Type',
        'Subtype',
        'Subtype',
    ];

    /**
     * @inheritdoc
     */
    protected function createGetRequest($params) {
        $params['params'] = new ParamsGetRequest();
        $params['params']->setSelectionCriteria(new AdsSelectionCriteria());
        return new GetRequest($params);
    }
    /**
     * @inheritdoc
     */
    protected function getClient($defaultOptions = []) {
        if ($this->processingMode)
            $defaultOptions['headers']['processingMode'] = (string)$this->processingMode;
        $defaultOptions['headers']['skipReportHeader'] = $this->skipReportHeader ? 'true' : 'false';
        $defaultOptions['headers']['skipColumnHeader'] = $this->skipColumnHeader ? 'true' : 'false';
        $defaultOptions['headers']['skipReportSummary'] = $this->skipReportSummary ? 'true' : 'false';

        return parent::getClient($defaultOptions);
    }
}
