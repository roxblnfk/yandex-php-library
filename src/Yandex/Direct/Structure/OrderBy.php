<?php

namespace Yandex\Direct\Structure;

/**
 * Class Page
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class Page extends BaseStructure {
    protected $fields = [
        'Field'     => ['required' => true, 'default' => 'Id'],
        // DESCENDING | ASCENDING
        'SortOrder' => ['default' => 'ASCENDING'],
    ];
}
