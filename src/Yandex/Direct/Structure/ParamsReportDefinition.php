<?php

namespace Yandex\Direct\Structure;

/**
 * Class ParamsReportDefinition
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class ParamsReportDefinition extends Params {

    protected $fields = [
        'SelectionCriteria' => ['required' => true, 'default' => []],
        'FieldNames'        => ['required' => true],
        'Page'              => ['required' => false, 'class' => Page::class],
        'OrderBy'           => ['required' => false],
        'ReportName'        => ['required' => true],
        'ReportType'        => ['required' => true],
        'DateRangeType'     => ['required' => true],
        'Format'            => ['required' => true, 'default' => 'TSV'],
        'IncludeVAT'        => ['required' => true, 'default' => 'YES'],
        'IncludeDiscount'   => ['required' => true, 'default' => 'NO'],
    ];



}
