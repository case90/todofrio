<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

require_once(dirname(__FILE__).'/../../config/config.inc.php');

$token = Tools::getAdminToken('AdminModules');

if ($token == Tools::getValue('token')) {
    $cookie = new Cookie('psAdmin');
    if ($cookie->id_employee) {
        $sql = 'SELECT * FROM ' . _DB_PREFIX_ . 'rec_whitelist WHERE ip_address LIKE "%' .
            pSQL(Tools::getValue('ip_address')) . '%"';
        if (! $results = Db::getInstance()->ExecuteS($sql)) {
            Db::getInstance()->insert('rec_whitelist', array(
                'ip_address' => pSQL(Tools::getValue('ip_address')),
                'date_added' => pSQL(date('Y-m-d H:i:s'))
            ));
        }
    }
} else {
    die('Wrong token');
}
