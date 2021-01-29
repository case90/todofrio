<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Order extends OrderCore
{
    /**
     * Get customer orders
     *
     * Used for pagination
     *
     * @param int $id_customer Customer id
     * @param bool $show_hidden_status Display or not hidden order statuses
     * @return array Customer orders
     */
    public static function getCustomerOrders($id_customer, $showHiddenStatus = false, Context $context = null, $p = 1, $n = 5)
    {
        if (!$context)
            $context = Context::getContext();
 
        if ($p < 1) $p = 1;
         
        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
        SELECT o.*, (SELECT SUM(od.`product_quantity`) FROM `'._DB_PREFIX_.'order_detail` od WHERE od.`id_order` = o.`id_order`) nb_products
        FROM `'._DB_PREFIX_.'orders` o
        WHERE o.`id_customer` = '.(int)$id_customer.'
        GROUP BY o.`id_order`
        ORDER BY o.`date_add` DESC LIMIT '.(((int)$p - 1) * (int)$n).','.(int)$n );
        if (!$res)
            return array();
 
 
        foreach ($res as $key => $val)
        {
            $res2 = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT os.`id_order_state`, osl.`name` AS order_state, os.`invoice`, os.`color` as order_state_color
                FROM `'._DB_PREFIX_.'order_history` oh
                LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
                INNER JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = '.(int)$context->language->id.')
            WHERE oh.`id_order` = '.(int)($val['id_order']).(!$showHiddenStatus ? ' AND os.`hidden` != 1' : '').'
                ORDER BY oh.`date_add` DESC, oh.`id_order_history` DESC
            LIMIT 1');
 
            if ($res2)
                $res[$key] = array_merge($res[$key], $res2[0]);
 
        }
        return $res;
    }

    
}
