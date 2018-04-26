<?php

namespace Yandex\Direct\Model;

use Yandex\Common\Exception\RealizationException;
use Yandex\Direct\Structure\BaseStructure;

/**
 * Class BaseObject
 *
 * @category Yandex
 * @package Direct
 *
 * @author   roxblnfk
 * @created  25.04.18 10:00
 */
class BaseObject extends BaseStructure
{
    /**
     * @param $actionName string
     * @throws RealizationException
     */
    private function throwActionError($actionName) {
        throw new RealizationException("Method {$actionName} not supported");
    }
}
