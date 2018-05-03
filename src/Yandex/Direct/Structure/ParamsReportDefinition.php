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
 *
 * @method $this addSelectionCriteria(...$values)
 * @method $this addFieldNames(...$values)
 * @method $this addPage(...$values)
 * @method $this addOrderBy(...$values)
 * @method $this addReportType(...$values)
 * @method $this addDateRangeType(...$values)
 * @method $this addFormat(...$values)
 * @method $this addIncludeVAT(...$values)
 * @method $this addIncludeDiscount(...$values)
 *
 * @method $this setSelectionCriteria(array|SelectionCriteria $value)
 * @method $this setFieldNames(array $value)
 * @method $this setPage(array|Page $value)
 * @method $this setOrderBy(array|OrderBy $value)
 * @method $this setReportName(string $value)
 * @method $this setReportType(string $value)
 * @method $this setDateRangeType(string $value)
 * @method $this setFormat(string $value)           TSV
 * @method $this setIncludeVAT(string $value)       YES|NO
 * @method $this setIncludeDiscount(string $value)  YES|NO
 *
 * @method SelectionCriteria getSelectionCriteria()
 * @method getFieldNames()
 * @method getPage()
 * @method getOrderBy()
 * @method getReportName()
 * @method getReportType()
 * @method getDateRangeType()
 * @method getFormat()
 * @method getIncludeVAT()
 * @method getIncludeDiscount()
 */
class ParamsReportDefinition extends Params {

    protected $fields = [
        'SelectionCriteria' => ['required' => true, 'default' => [], 'class' => SelectionCriteria::class],
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
