<?php

namespace Yandex\Direct\Structure;


/**
 * Class SelectionCriteria
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class SelectionCriteria extends BaseCriteria {
    protected $fields = [
        'DateFrom' => [],
        'DateTo'   => [],
        'Filter'   => [],
    ];
}
