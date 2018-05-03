<?php

namespace Yandex\Direct\Structure;

/**
 * Class ParamsGetRequest
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ParamsGetRequest extends Params
{
    protected $fields = [
        'SelectionCriteria' => ['required' => false, 'default' => []],
        'FieldNames'        => ['required' => true],
        'Page'              => ['class' => Page::class],
    ];
}
