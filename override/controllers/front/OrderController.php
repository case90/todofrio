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
class OrderController extends OrderControllerCore
{
    /**
     * Carrier step
     */
    /*
    * module: pickupstore
    * date: 2018-03-27 13:02:55
    * version: 1.0.0
    */
    protected function processCarrier()
    {
        $selectedShipping = (int)Tools::getValue('delivery_option')[8];
        if($selectedShipping == Configuration::get('MYSHIPPINGMODULE_CARRIER_ID')){
            Context::getContext()->cookie->stores = (int)Tools::getValue('stores');;
            Context::getContext()->cookie->pickupDate = Tools::getValue('pickupDate');
            if(Tools::getValue('stores') == 0){
                $this->errors[] = Tools::displayError('Debe seleccionar una sucursal en donde recogerá su mercancía.', Tools::getValue('stores'));
            }
            if(Tools::getValue('pickupDate') == 0){
                $this->errors[] = Tools::displayError('Debe agregar una fecha en la cual recogerá su mercancía.', Tools::getValue('pickupDate'));
            }
        }else{
            unset(Context::getContext()->cookie->stores);
            unset(Context::getContext()->cookie->pickupDate);
        }
        global $orderTotal;
        parent::_processCarrier();
        if (count($this->errors)) {
            $this->context->smarty->assign('errors', $this->errors);
            $this->_assignCarrier();
            $this->step = 2;
            $this->displayContent();
        }
        $orderTotal = $this->context->cart->getOrderTotal();
    }    
}
