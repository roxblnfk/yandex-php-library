<?php

namespace Yandex\Direct\Model;


/**
 * Class AdObject
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 * @api-help https://tech.yandex.ru/direct/doc/dg/objects/campaign-docpage/
 */
class AdObject extends BaseObject
{

    protected $fields = [
        'Id'                   => [],
        'CampaignId'           => [],
        'AdGroupId'            => [],
        'Status'               => [],
        'StatusClarification'  => [],
        'State'                => [],
        'AdCategories'         => [],
        'AgeLabel'             => [],
        'Type'                 => [],
        'Subtype'              => [],
        'TextAd'               => [],
        'MobileAppAd'          => [],
        'DynamicTextAd'        => [],
        'TextImageAd'          => [],
        'MobileAppImageAd'     => [],
        'TextAdBuilderAd'      => [],
        'MobileAppAdBuilderAd' => [],
    ];

}
