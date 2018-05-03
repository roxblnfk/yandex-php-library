<?php

namespace Yandex\Direct\Model;


/**
 * Class ReportObject
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 * @api-help https://tech.yandex.ru/direct/doc/dg/objects/campaign-docpage/
 */
class ReportObject extends BaseObject {

    protected $fields = [
        'AdFormat'               => [],
        'AdGroupId'              => [],
        'AdGroupName'            => [],
        'AdId'                   => [],
        'AdNetworkType'          => [],
        'Age'                    => [],
        // 'AudienceTargetId'       => [],
        'AvgClickPosition'       => [],
        'AvgCpc'                 => [],
        'AvgImpressionPosition'  => [],
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
        'Criteria'               => [],
        'CriteriaId'             => [],
        'CriteriaType'           => [],
        'Criterion'              => [],
        'CriterionId'            => [],
        'CriterionType'          => [],
        'Ctr'                    => [],
        'Date'                   => [],
        'Device'                 => [],
        // 'DynamicTextAdTargetId'  => [],
        'ExternalNetworkName'    => [],
        'Gender'                 => [],
        'GoalsRoi'               => [],
        'Impressions'            => [],
        'ImpressionShare'        => [],
        // 'Keyword'                => [],
        'LocationOfPresenceId'   => [],
        'LocationOfPresenceName' => [],
        'MatchedKeyword'         => [],
        'MatchType'              => [],
        'MobilePlatform'         => [],
        'Month'                  => [],
        'Placement'              => [],
        'Quarter'                => [],
        'Query'                  => [],
        'Revenue'                => [],
        'RlAdjustmentId'         => [],
        'Sessions'               => [],
        'Slot'                   => [],
        // 'SmartBannerFilterId'    => [],
        'TargetingLocationId'    => [],
        'TargetingLocationName'  => [],
        'Week'                   => [],
        'Year'                   => [],
    ];
}

