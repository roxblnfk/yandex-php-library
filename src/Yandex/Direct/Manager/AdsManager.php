<?php

namespace Yandex\Direct\Manager;

use Yandex\Direct\Model\AdObject;
use Yandex\Direct\Request\GetRequest;
use Yandex\Direct\Structure\AdsSelectionCriteria;
use Yandex\Direct\Structure\ParamsGetRequest;


/**
 * Class AdsManager
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class AdsManager extends BaseManager {


    protected static $methods = ['add', 'update', 'delete', 'suspend', 'resume', 'archive', 'unarchive', 'get', 'moderate'];
    protected $resource = 'ads';
    protected $resultsContainer = [
        'get' => 'Ads',
    ];
    protected $objectsClass = AdObject::class;

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
}
