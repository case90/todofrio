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
{if isset($products) && $products}
	{if !isset($product_style)}
		{$product_style = Configuration::get('PTS_CP_PRODUCT_STYLE')}
	{/if}
	{*define numbers of product per line in other page for desktop*}

	{if Configuration::get('PTS_CP_PRODUCTS_ITEMROW')}
		{assign var='nbItemsPerLine' value=Configuration::get('PTS_CP_PRODUCTS_ITEMROW')}
		{assign var='nbItemsPerLineTablet' value=Configuration::get('PTS_CP_PRODUCTS_ITEMROW')}
	{else}
		{assign var='nbItemsPerLine' value=3}
		{assign var='nbItemsPerLineTablet' value=3}
	{/if}


	{assign var='nbItemsPerLineMobile' value=2}

	{*define numbers of product per line in other page for tablet*}
	{assign var='nbLi' value=$products|@count}
	{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
	{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}

	{math equation="nbLi/nbItemsPerLine" nbLi=12 nbItemsPerLine=$nbItemsPerLine assign=colLap}
	{math equation="nbLi/nbItemsPerLine" nbLi=12 nbItemsPerLine=$nbItemsPerLineTablet assign=colTablet}
	{math equation="nbLi/nbItemsPerLine" nbLi=12 nbItemsPerLine=$nbItemsPerLineMobile assign=colMobile}
	<!-- Products list -->
	<script type="text/javascript">
		var colLap = {$colLap};
		var colTablet = {$colTablet};
		var colMobile = {$colMobile};
	</script>
	<ul{if isset($id) && $id} id="{$id}"{/if} class="list-unstyled row product_list products-block grid clearfix {if isset($class) && $class} {$class}{/if} {if isset($product_style) && !empty($product_style)}{$product_style}{else} style1{/if}">
	{foreach from=$products item=product name=products}
		{math equation="(total%perLine)" total=$smarty.foreach.products.total perLine=$nbItemsPerLine assign=totModulo}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
		{math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
		{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
		{if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
		{if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}
		<li class="owl-wrapper col-xs-cus-12 col-xs-{$colMobile} col-sm-{$colTablet} col-md-{$colLap} col-lg-{$colLap}{if $smarty.foreach.products.iteration%$nbItemsPerLine == 1} first-in-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 1} first-item-of-tablet-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 1} first-item-of-mobile-line{/if}" data-col-lg="{$colLap}" data-col-md="{$colLap}" data-col-sm="{$colTablet}" data-col-xs="{$colMobile}">
			<div class="item clearfix">
				{if isset($product_style) && !empty($product_style)}
					{include file="$tpl_dir./sub/product/{$product_style}.tpl" product=$product class=''}
				{else}
					{include file="$tpl_dir./sub/product/style1.tpl" product=$product class=''}
				{/if}
			</div>
		</li>
	{/foreach}
	</ul>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}