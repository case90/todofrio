{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psverticalmenu
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($products) && !empty($products)}
<div class="widget-products block">
	{if isset($widget_heading)&&!empty($widget_heading)}
		<div class="widget-heading widget-title">
			{$widget_heading|escape:'htmlall':'UTF-8'}
		</div>
	{/if}
	<div class="widget-inner ">
		{if isset($products) AND $products}
		<div class="product-block">
			{$mproducts=array_chunk($products,$limit)}
			{foreach from=$products item=product name=homeFeaturedProducts}
			 	<div class="product-container clearfix" itemscope itemtype="https://schema.org/Product">
					<div class="image ">
						<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:html:'UTF-8'}" class="product_image">
							<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}"  alt="{$product.name|escape:html:'UTF-8'}" />
							{if isset($product.new) && $product.new == 1}<span class="new">{l s='New' mod='homefeatured'}</span>{/if}
						</a>
					</div>
					<div class="product-meta">
						<h4 class="name"><a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|truncate:50:'...'|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h4>
						{if $product.show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
							<p class="price_container"><span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span></p>
						{else}
							<div style="height:21px;"></div>
						{/if}

					</div>
				</div>
			{/foreach}
		</div>
		{/if}
	</div>
</div>
{/if}