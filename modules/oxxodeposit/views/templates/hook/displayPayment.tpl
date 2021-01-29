{*
* 2007-2018 PrestaShop
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
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<div class="col-xs-12 col-md-3 payment_option">
	<div class="displayCell verticalAlignMiddle bordered">
		<a href="{$link->getModuleLink('oxxodeposit', 'redirect', array(), true)|escape:'htmlall':'UTF-8'}" title="{l s='Pay with my payment module' mod='oxxodeposit'}">
			<div class="icon_payment">
				<img src="{$module_dir|escape:'htmlall':'UTF-8'}/logo.png" alt="{l s='Pay with my payment module' mod='oxxodeposit'}" width="32" height="32" />
			</div>
			<p class="payment_title">
				<h3>{l s='Pay in Oxxo' mod='oxxodeposit'}</h3>
			</p>
			<p class="payment_subtitle">
				{l s='Make deposit' mod='oxxodeposit'}
			</p>
		</a>
	</div>
</div>



