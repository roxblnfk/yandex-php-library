<?php

namespace Yandex\Direct\Structure;


/**
 * Class FilterItem
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class FilterItem extends BaseStructure {
    protected $fields = [
        'Field'    => ['required' => true],
        'Operator' => ['required' => true, 'default' => 'IN'],
        'Values'   => ['required' => true],
    ];
}
