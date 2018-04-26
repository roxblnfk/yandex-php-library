<?php

namespace Yandex\Direct\Structure;

use Yandex\Common\ObjectModel;
use Yandex\Direct\Model\CampaignObject;

/**
 * Class AdsSelectionCriteria
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class AdsSelectionCriteria extends BaseCriteria {
    protected $fields = [
        'Ids'                         => ['default' => []],
        'States'                      => ['default' => null],
        'Statuses'                    => ['default' => null],
        'AdGroupIds'                  => ['default' => []],
        'CampaignIds'                 => ['default' => []],
        'Types'                       => ['default' => null],
        'Mobile'                      => ['default' => null],
        'VCardIds'                    => ['default' => []],
        'SitelinkSetIds'              => ['default' => []],
        'AdImageHashes'               => ['default' => null],
        'VCardModerationStatuses'     => ['default' => null],
        'SitelinksModerationStatuses' => ['default' => null],
        'AdImageModerationStatuses'   => ['default' => null],
        'AdExtensionIds'              => ['default' => []],
    ];
}
