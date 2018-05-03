<?php

namespace Yandex\Direct\Structure;

/**
 * Class Params
 *
 * @category Yandex
 * @package  Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 *
 * @method getSelectionCriteria
 */
class Params extends BaseStructure
{
    protected $fields = [
        'SelectionCriteria' => [],
        'FieldNames'        => ['required' => true],
        'Page'              => ['class' => Page::class],
    ];

    // public $TextCampaignFieldNames = null;
    // public $MobileAppCampaignFieldNames = null;
    // public $DynamicTextCampaignFieldNames = null;

    /**
     * @param BaseCriteria $SelectionCriteria
     * @return Params
     */
    public function setSelectionCriteria(BaseCriteria $SelectionCriteria) {
        $this->data['SelectionCriteria'] = $SelectionCriteria;
        return $this;
    }

    /**
     * @param array|Page $page
     * @return Params
     */
    public function setPage($page) {
        $this->data['Page'] = $page instanceof Page ? $page : new Page($page);
        return $this;
    }
}
