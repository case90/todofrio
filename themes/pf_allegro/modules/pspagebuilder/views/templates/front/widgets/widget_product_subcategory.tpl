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
{if isset($subcategories) && $subcategories}
<div id="product_subcategories{$wkey}" class="block  {$addition_cls} {if isset($stylecls)&&$stylecls}block-{$stylecls}{else}block-borderbox{/if}">
	<div class="clearfix">
		
		{if isset($subtitle) && !empty($subtitle)} 
	        <h5 class="subtitle">{$subtitle|escape:'html':'UTF-8'}</h5>
	    {/if}
	</div>
	<div class="widget-inner block_content clearfix ">
		<div class="row">
			<div class=" col-lg-6 col-md-4 col-xs-12">
				<div class="subcategory-left nopadding clearfix">
					{if $imageurl}
						<div class="col-lg-6 hidden-md banner-categories hidden-sm hidden-xs">
							<div class="category-banner effect-v12">
								{if $url}<a href="{$url|escape:'html':'UTF-8'}" title="{l s='banner' mod='pspagebuilder'}">{/if}
								<img src="{$imageurl}" alt="{l s='banner' mod='pspagebuilder'}">
								{if $url}</a>{/if}
							</div>
						</div>
					{/if}
					<div class="clearfix col-lg-6 col-md-12 col-sm-12 col-xs-12 product_subcategories">
						{if isset($widget_heading)&&!empty($widget_heading)}
							<div class="widget-heading title_block">
									{$widget_heading}
							</div>
						{/if} 
						<ul class="nav nav-tabs-justified ">
							{foreach $subcategories as $key=>$subcategory}
							<li><a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}" title="{$subcategory.name}">{$subcategory.name}</a></li>
							{/foreach}
						</ul>
					</div>
				</div>	
			</div> 
			<div class="{if $imageurl}col-lg-6 col-md-8{else}col-custom-80{/if} col-sm-12 col-xs-12 block-container {if isset($list_mode) && $list_mode == 'list1'}border-box{/if}">
				<div class="block-content">

					{$tabname=rand()+count($products)}
					{if isset($display_mode) && $display_mode == 'carousel'}
						{include file="{$items_owl_carousel_tpl}" items=$products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}" carousel_style="boxcarousel"}
					{else}
						{include file="{$items_normal_tpl}" items=$products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}"}
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>



<!-- /Block categories module -->
{/if}
