<?php

namespace Yandex\Direct\Structure;

/**
 * Class IdsCriteria
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 *
 * @property int[]    $Ids
 */
class IdsCriteria extends BaseCriteria {
    protected $fields = [
        'Ids' => ['required' => true],
    ];
}
