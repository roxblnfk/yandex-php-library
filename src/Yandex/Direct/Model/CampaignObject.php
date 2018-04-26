<?php

namespace Yandex\Direct\Model;


/**
 * Class CampaignObject
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 * @api-help https://tech.yandex.ru/direct/doc/dg/objects/campaign-docpage/
 */
class CampaignObject extends BaseObject
{

    protected $fields = [
        'BiddingStrategy'     => [],
        'BlockedIps'          => [],
        'ClientInfo'          => [],
        'CounterIds'          => [],
        'Currency'            => [],
        'DailyBudget'         => [],
        'EndDate'             => [],
        'ExcludedSites'       => [],
        'Funds'               => [],
        'Id'                  => [],
        'Name'                => [],
        'NegativeKeywords'    => [],
        'Notification'        => [],
        'RelevantKeywords'    => [],
        'RepresentedBy'       => [],
        'Settings'            => [],
        'SourceId'            => [],
        'StartDate'           => [],
        'State'               => [],
        'Statistics'          => [],
        'Status'              => [],
        'StatusClarification' => [],
        'StatusPayment'       => [],
        'TimeTargeting'       => [],
        'TimeZone'            => [],
        'Type'                => [],
    ];

    protected $types = ['TEXT_CAMPAIGN', 'MOBILE_APP_CAMPAIGN', 'DYNAMIC_TEXT_CAMPAIGN'];
    protected $states = ['CONVERTED', 'ARCHIVED', 'SUSPENDED', 'ENDED', 'ON', 'OFF', 'UNKNOWN'];
    protected $statuses = ['DRAFT', 'MODERATION', 'ACCEPTED', 'REJECTED', 'UNKNOWN'];
    protected $payStatuses = ['DISALLOWED', 'ALLOWED'];


}
