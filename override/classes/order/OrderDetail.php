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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
class OrderDetail extends OrderDetailCore
{
    /**
     * Check the order status
     * @param array $product
     * @param int $id_order_state
     */
    /*
    * module: syncinventory
    * date: 2018-06-14 17:27:09
    * version: 1.0.0
    */
    protected function checkProductStock($product, $id_order_state)
    {
        if(Module::isEnabled('syncinventory') &&
            Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_MODE') &&  
            Configuration::get('CONNECTIONEXTERNALSERVER_LIVE_INVENTORY')
        ){
            if ($id_order_state != Configuration::get('PS_OS_CANCELED') && $id_order_state != Configuration::get('PS_OS_ERROR')) {
                Product::updateDefaultAttribute($product['id_product']);
            }
        }else{
            parent::checkProductStock($product, $id_order_state);
        }
    }
}
