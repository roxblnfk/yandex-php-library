<?php

namespace Yandex\Direct\Structure;

/**
 * Class CampaignsSelectionCriteria
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class CampaignsSelectionCriteria extends BaseCriteria {
    protected $fields = [
        'Ids'             => ['default' => []],
        'Types'           => ['default' => null],
        'States'          => ['default' => null],
        'Statuses'        => ['default' => null],
        'StatusesPayment' => ['default' => null],
    ];
}
