<?php

namespace Yandex\Direct\Manager;

use Yandex\Direct\Model\CampaignObject;
use Yandex\Direct\Request\GetRequest;
use Yandex\Direct\Structure\CampaignsSelectionCriteria;
use Yandex\Direct\Structure\ParamsGetRequest;


/**
 * Class CampaignsManager
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class CampaignsManager extends BaseManager {


    protected static $methods = ['add', 'update', 'delete', 'suspend', 'resume', 'archive', 'unarchive', 'get'];
    protected $resource = 'campaigns';
    protected $resultsContainer = [
        'get' => 'Campaigns',
        'suspend' => 'SuspendResults',
        'resume' => 'ResumeResults',
    ];
    protected $objectsClass = CampaignObject::class;
    static $allGetFields = [
        "BlockedIps",
        "ExcludedSites",
        "Currency",
        "DailyBudget",
        "Notification",
        "EndDate",
        "Funds",
        "ClientInfo",
        "Id",
        "Name",
        "NegativeKeywords",
        "RepresentedBy",
        "StartDate",
        "Statistics",
        "State",
        "Status",
        "StatusPayment",
        "StatusClarification",
        "SourceId",
        "TimeTargeting",
        "TimeZone",
        "Type",
    ];

    /**
     * @inheritdoc
     */
    protected function createGetRequest($params) {
        $params['params'] = new ParamsGetRequest();
        $params['params']->setSelectionCriteria(new CampaignsSelectionCriteria());
        return new GetRequest($params);
    }
}
