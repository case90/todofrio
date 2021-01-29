{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   pspagebuilder
* @version   5.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($objCategory) && $objCategory}
<div class="block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{else}block-borderbox{/if}">
	<div class="clearfix">
		<h4 class="widget-heading title_block pull-left">
			{if isset($widget_heading)&&!empty($widget_heading)}
				{$widget_heading}
			{else}
				{$objCategory->name}
			{/if}
		</h4>
		{if $subcategories}
			<ul class="list-unstyled list-inline subcategory_link hidden-xs pull-left">
			{foreach $subcategories as $subcategory}
				<li>
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}" title="{$subcategory.name|escape:'html':'UTF-8'}">
					{$subcategory.name}
					</a>
				</li>
			{/foreach}
			</ul>
		{/if}
	</div>
	
	<div class="widget-inner block_content clearfix">
		<div class="row">
			{if isset($imageurl) && $imageurl && $alignment != ''}
				<div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
					<img src="{$imageurl}" alt="{$objCategory->name|escape:'html':'UTF-8'}">
				</div>
			{/if}
			<div class="col-xs-12 col-sm-12 {if isset($imageurl) && $imageurl && $alignment != '' }col-md-6{else}col-md-8{/if} block-item1">
				{if $products_block1.type == 'newest'}
					<h4 class="sub_title">{l s='New Arrivals' mod='pspagebuilder'}</h4>
				{elseif $products_block1.type == 'bestseller'}
					<h4 class="sub_title">{l s='Bestseller' mod='pspagebuilder'}</h4>
				{elseif $products_block1.type == 'special'}
					<h4 class="sub_title">{l s='Special products' mod='pspagebuilder'}</h4>
				{elseif $products_block1.type == 'toprating'}
					<h4 class="sub_title">{l s='Top Rating' mod='pspagebuilder'}</h4>
				{/if}
				{if isset($products_block1.products) AND $products_block1.products}
					<div class="block_content">
						{$columns = 3}
						{$nbr_desktops = 3}
						{$nbr_tablets = 2}
						{$nbr_mobile = 2}
				 		{include file="{$items_normal_tpl}" items=$products_block1.products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}" carousel_style="boxcarousel"}
					</div>
				{/if}
			</div>
			<div class="col-xs-12 col-sm-12 {if isset($imageurl) && $imageurl && $alignment != '' }col-md-3{else}col-md-4{/if}  block-item2">
				{if $products_block2.type == 'newest'}
					<h4 class="sub_title">{l s='New Arrivals' mod='pspagebuilder'}</h4>
				{elseif $products_block2.type == 'bestseller'}
					<h4 class="sub_title">{l s='Bestseller' mod='pspagebuilder'}</h4>
				{elseif $products_block2.type == 'special'}
					<h4 class="sub_title">{l s='special products' mod='pspagebuilder'}</h4>
				{elseif $products_block2.type == 'toprating'}
					<h4 class="sub_title">{l s='Top Rating' mod='pspagebuilder'}</h4>
				{/if}
				{if isset($products_block2.products) AND $products_block2.products}
					<div class="block_content">
						{$columns = 1}
						{$nbr_desktops = 1}
						{$nbr_tablets = 1}
						{$nbr_mobile = 1}
						{$list_mode=grid}
				 		{include file="{$items_normal_tpl}" items=$products_block2.products class="products-block list1 list" list_mode_tpl=$tlist_mode_tpl}
					</div>
				{/if}
			</div>			
		</div>
	</div>
</div>
{/if}
