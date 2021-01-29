{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="col-xs-12 col-md-3 payment_option">
    <div class="displayCell verticalAlignMiddle bordered">
        <a href="{$link->getModuleLink('bankwire', 'payment')|escape:'html':'UTF-8'}" title="{l s='Pay by bank wire' mod='bankwire'}">
            <div class="icon_payment">
                <img src="{$img_dir}/bankwire.png" alt="">
            </div>
            <p class="payment_title">
                <h3>{l s='Pay by bank wire' mod='bankwire'}</h3>
            </p>
            <p class="payment_subtitle">
                {l s='(order processing will be longer)' mod='bankwire'}
            </p>
        </a>
    </div>
</div>