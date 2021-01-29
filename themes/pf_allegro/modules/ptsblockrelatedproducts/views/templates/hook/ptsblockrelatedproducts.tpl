{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- MODULE Block ptsblockrelatedproducts -->
{if $products|@count gt 0 }
<div id="relatedproducts" class="space-60 block block-borderbox products_bloc widget-products ptsblockrelatedproducts">
		<h4 class="title_block">{l s='You may also like' mod='ptsblockrelatedproducts'}</h4>
		<div class="block_content widget-inner {if $columnspage === 4} custom-4pro {/if}">	
			{if !empty($products )}
				{$column=$columnspage}
				{$tabname="ptsblockrelatedproducts"}
				{$columns = $column}
				{$nbr_desktops = 3}
				{$nbr_tablets = 2}
				{$nbr_mobile = 2}
				{include file="$tpl_dir./sub/products_module.tpl" items=$products class="products-block grid {if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}" carousel_style="boxcarousel"}
			{/if}
		</div>
</div>
{/if}
 