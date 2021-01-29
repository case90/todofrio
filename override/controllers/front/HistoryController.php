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

class HistoryController extends HistoryControllerCore
{

	/**
     * Assign template vars related to page content
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();
 
        $p = Tools::getValue('p');
        $n = 5;
        if ($orders = Order::getCustomerOrders($this->context->customer->id, false, null, $p, $n))
            foreach ($orders as &$order)
            {
                $myOrder = new Order((int)$order['id_order']);
                if (Validate::isLoadedObject($myOrder))
                    $order['virtual'] = $myOrder->isVirtual(false);
            }
 
 
        // to paginate, get the total order number 
        $nb_orders = Order::getCustomerNbOrders($this->context->customer->id);
        $pages_nb = ceil($nb_orders / (int)$n);
 
        $range = 2; /* how many pages around page selected */
        $start = (int)($p - $range);
        if ($start < 1)
            $start = 1;
        $stop = (int)($p + $range);
        if ($stop > $pages_nb)
            $stop = (int)$pages_nb;
 
        if (!$p) $p = 1;
 
        $this->context->smarty->assign(array(
            'pages_nb' => $pages_nb,
            'prev_p' => $p != 1 ? $p - 1 : 1,
            'next_p' => (int)$p + 1  > $pages_nb ? $pages_nb : $p + 1,
            'requestPage' => $this->context->link->getPageLink('history'),
            'p' => $p,
            'n' => $n,
            'range' => $range,
            'start' => $start,
            'stop' => $stop,
        ));
 
        $this->context->smarty->assign(array(
            'orders' => $orders,
            'invoiceAllowed' => (int)(Configuration::get('PS_INVOICE')),
            'reorderingAllowed' => !(int)(Configuration::get('PS_DISALLOW_HISTORY_REORDERING')),
            'slowValidation' => Tools::isSubmit('slowvalidation')
        ));
 
        $this->setTemplate(_PS_THEME_DIR_.'history.tpl');
    }
    
}
