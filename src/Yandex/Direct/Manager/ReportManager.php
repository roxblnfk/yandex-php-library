<?php

namespace Yandex\Direct\Manager;

use Yandex\Direct\Model\ReportObject;
use Yandex\Direct\Request\ReportRequest;
use Yandex\Direct\Structure\ParamsReportDefinition;


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

    protected static $methods = [];
    protected $resource = 'reports';
    protected $resultsContainer = [];
    protected $objectsClass = ReportObject::class;

    public $processingMode = 'auto';
    public $returnMoneyInMicros = false;
    public $skipReportHeader = true;
    public $skipColumnHeader = true;
    public $skipReportSummary = true;

    static $allGetFields = [
        // 'AdFormat'               => [],
        // 'AdGroupId'              => [],
        // 'AdGroupName'            => [],
        // 'AdId'                   => [],
        // 'AdNetworkType'          => [],
        // 'Age'                    => [],
        // 'AudienceTargetId'       => [],
        'AvgClickPosition'       => [],
        'AvgCpc'                 => [],
        // 'AvgImpressionPosition'  => [],
        'AvgPageviews'           => [],
        'BounceRate'             => [],
        'Bounces'                => [],
        'CampaignId'             => [],
        'CampaignName'           => [],
        'CampaignType'           => [],
        'CarrierType'            => [],
        'Clicks'                 => [],
        'ClickType'              => [],
        'ConversionRate'         => [],
        'Conversions'            => [],
        'Cost'                   => [],
        'CostPerConversion'      => [],
        // 'Criteria'               => [],
        // 'CriteriaId'             => [],
        'CriteriaType'           => [],
        // 'Criterion'              => [],
        // 'CriterionId'            => [],
        // 'CriterionType'          => [],
        // 'Ctr'                    => [],
        'Date'                   => [],
        'Device'                 => [],
        // 'DynamicTextAdTargetId'  => [],
        'ExternalNetworkName'    => [],
        'Gender'                 => [],
        'GoalsRoi'               => [],
        // 'Impressions'            => [],
        // 'ImpressionShare'        => [],
        // 'Keyword'                => [],
        'LocationOfPresenceId'   => [],
        'LocationOfPresenceName' => [],
        // 'MatchedKeyword'         => [],
        'MatchType'              => [],
        'MobilePlatform'         => [],
        'Month'                  => [],
        // 'Placement'              => [],
        // 'Quarter'                => [],
        // 'Query'                  => [],
        'Revenue'                => [],
        // 'RlAdjustmentId'         => [],
        'Sessions'               => [],
        'Slot'                   => [],
        // 'SmartBannerFilterId'    => [],
        'TargetingLocationId'    => [],
        'TargetingLocationName'  => [],
        // 'Week'                   => [],
        // 'Year'                   => [],
    ];

    /**
     * @param $method
     * @return ReportRequest
     */
    public function createRequest($method = 'report') {

        $params = array_merge($this->extendsProps());
        $params['params'] = new ParamsReportDefinition();
        $request = new ReportRequest($params);

        return $request;
    }

    /**
     * @inheritdoc
     */
    protected function getClient($defaultOptions = []) {
        if ($this->processingMode)
            $defaultOptions['headers']['processingMode'] = (string)$this->processingMode;
        $defaultOptions['headers']['returnMoneyInMicros'] = $this->returnMoneyInMicros ? 'true' : 'false';
        $defaultOptions['headers']['skipReportHeader']  = $this->skipReportHeader  ? 'true' : 'false';
        $defaultOptions['headers']['skipColumnHeader']  = $this->skipColumnHeader  ? 'true' : 'false';
        $defaultOptions['headers']['skipReportSummary'] = $this->skipReportSummary ? 'true' : 'false';

        return parent::getClient($defaultOptions);
    }
}
