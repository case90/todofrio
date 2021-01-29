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
{if $categories_tabs}
<!-- Block categories module -->
<div  class="block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{else}block-borderbox{/if}">
	<div class="widget-inner  pts-tab clearfix">
            <div class="category-sub">
				{if isset($widget_heading)&&!empty($widget_heading)}
					<h4 class="title_block">
						{$widget_heading|escape:'html':'UTF-8'}
					</h4>
				{/if}
				
				{if isset($subtitle)&& !empty($subtitle)}
			        <div class="subtitle">{$subtitle|escape:'html':'UTF-8'}</div>
			    {/if}	
				<ul class="nav nav-tabs">
				  {foreach $categories_tabs as $key=>$category}
					<li{if $key == 0} class="active"{/if}>
						<a  href="#cattab{$category.category_obj->id}" data-toggle="tab" title="{l s={$category.category_obj->name|escape:'html':'UTF-8'} mod='pspagebuilder'}">
							{if $category.category_info && $category.category_info.icon_class}	
								<i class="{$category.category_info.icon_class|escape:'html':'UTF-8'}"></i>
							{elseif $category.category_info && $category.category_info.icon}
								<img src="{$category.category_info.icon|escape:'htmlall':'UTF-8'}" alt="{$category.category_obj->name|escape:'html':'UTF-8'}">
							{/if}
							<span class="tab-name">{$category.category_obj->name|escape:'html':'UTF-8'}</span>
						</a>
					</li>
				  {/foreach}
				</ul>
            </div>
		<div class="tab-content nopadding clearfix">
			{foreach $categories_tabs as $key=>$category}
				<div class="tab-pane{if $key == 0} active{/if}" id="cattab{$category.category_obj->id|escape:'html':'UTF-8'}">
					{assign var="tabname" value="categoriestabs_{$category.category_obj->id|escape:'html':'UTF-8'}"} 
					{if isset($layout_type) && $layout_type == 'carousel'}
						{include file="{$items_owl_carousel_tpl}" items=$category.products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}" carousel_style="boxcarousel"}
					{elseif isset($layout_type) && $layout_type == 'layout1'}

						{if isset($columns)}
							{if $columns == 5}
								{assign var='nbItemsPerLine' value=$columns} 
							{else}
								{assign var='nbItemsPerLine' value=12/$columns}
							{/if}
						{else}
							{assign var='columns' value=4}
							{assign var='nbItemsPerLine' value=4}
						{/if}
						{if isset($nbr_desktops)}
							{if $nbr_desktops == 5}
								{assign var='nbItemsPerLineDesktop' value=$nbr_desktops} 
							{else}
								{assign var='nbItemsPerLineDesktop' value=12/$nbr_desktops}
							{/if}
						{else}
							{assign var='nbItemsPerLineDesktop' value=4}
						{/if}
						{if isset($nbr_tablets)}
							{assign var='nbItemsPerLineTablet' value=12/$nbr_tablets}
						{else}
							{assign var='nbItemsPerLineTablet' value=3}
						{/if}
						{if isset($nbr_mobile)}
							{assign var='nbItemsPerLineMobile' value=12/$nbr_mobile}
						{else}
							{assign var='nbItemsPerLineMobile' value=2}
						{/if}
						<div class="{if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'} style3 {/if} {if isset($class) && $class} {$class}{/if}">
							<div class="row">
								{foreach from=$category.products item=product name=items_name}
									<div class="owl-wrapper col-lg-{if $nbItemsPerLine==5}cus-{/if}{$nbItemsPerLine|escape:'html':'UTF-8'} col-md-{if $nbItemsPerLineDesktop==5}cus-{/if}{$nbItemsPerLineDesktop|escape:'html':'UTF-8'} col-sm-{$nbItemsPerLineTablet|escape:'html':'UTF-8'} col-xs-{$nbItemsPerLineMobile|escape:'html':'UTF-8'} col-xs-cus-12 {if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLine) == 1} first-in-line{/if}{if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLineTablet) == 1} first-item-of-tablet-line{/if} {if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLineMobile) == 1} first-item-of-mobile-line{/if} ">
										<div class="item">
											{include file="{$list_mode_tpl}" product=$product}
										</div>
									</div>
								{/foreach}
							</div>		
						</div>
						 

					{else}

						{foreach from=$category.products item=product name=items_name}
							{if $smarty.foreach.items_name.iteration == 1}
								<div class="owl-wrapper item-special products-block style3 grid col-md-6 col-xs-12 {if $layout_type == 'layout3'}pull-right{/if}">
									
									{include file="$tpl_dir./sub/product/item-special.tpl" product=$product class=''}
								</div>
								
							{else}
								{if $smarty.foreach.items_name.iteration == 2}
									<div class="owl-wrapper item-product-list col-md-6 col-xs-12 style3 grid">
										<ul class="list-unstyled products products-block grid {if $layout_type == 'layout3'}list-left{/if}">
								{/if}

								<li class="clearfix owl-wrapper col-md-6 col-sm-6 col-xs-12">
									{include file="$tpl_dir./sub/product/style3.tpl" product=$product class=''}
								</li>	

								{if $smarty.foreach.items_name.iteration == count($category.products)}
										</ul>
									</div>
								{/if}
								<!-- <div class="view-more"><a href="#" title="view more">View More</a></div> -->
							{/if}

						{/foreach}
					
					{/if}

				</div>
			{/foreach}
		</div>
 
	</div>
</div>
<!-- /Block categories module -->
{/if}
