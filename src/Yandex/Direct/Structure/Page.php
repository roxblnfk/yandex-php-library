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
        'Limit'  => ['required' => true, 'default' => 1000000],
        'Offset' => [],
    ];
}
