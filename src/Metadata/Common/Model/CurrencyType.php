<?php
/**
 * Created by PhpStorm.
 * User: hrms
 * Date: 8/19/17
 * Time: 3:03 PM
 */

namespace Metadata\Common\Model;

use Classes\SettingsManager;
use Model\BaseModel;

class CurrencyType extends BaseModel
{
    public $table = 'CurrencyTypes';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getUserAccess()
    {
        return array();
    }

    public function getAnonymousAccess()
    {
        return array("get","element");
    }

    // @codingStandardsIgnoreStart
    function Find($whereOrderBy, $bindarr = false, $pkeysArr = false, $extra = array())
    {
        $allowedCountriesStr = SettingsManager::getInstance()->getSetting('System: Allowed Currencies');
        $allowedCountries = array();
        if (!empty($allowedCountriesStr)) {
            $allowedCountries = json_decode($allowedCountriesStr, true);
        }

        if (!empty($allowedCountries)) {
            $res =  parent::Find("id in (".implode(",", $allowedCountries).")", array());
            if (empty($res)) {
                SettingsManager::getInstance()->setSetting('System: Allowed Currencies', '');
            } else {
                return $res;
            }
        }

        return parent::Find($whereOrderBy, $bindarr, $pkeysArr, $extra);
    }
    // @codingStandardsIgnoreEnd
}
