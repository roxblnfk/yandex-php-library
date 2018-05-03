<?php

namespace Yandex\Direct\Structure;

/**
 * Class ParamsIdsRequest
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ParamsIdsRequest extends Params {
    protected $fields = [
        'SelectionCriteria' => ['required' => true, 'default' => [], 'class' => IdsCriteria::class],
    ];
}
