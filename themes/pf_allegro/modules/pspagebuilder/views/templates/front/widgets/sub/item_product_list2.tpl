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

{if !empty($products)}
	<div class="product-block" >
		<div class="product-container row" itemscope="" itemtype="https://schema.org/Product">
			<div class="product-image-container image col-xs-cus-12 col-xs-5 col-sm-6 col-md-6">
				<a class="img product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
					<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
					{if isset($iteration)}<span class="hidden count">{$iteration}</span>{/if}
				</a>
						
			</div>
			<div class="col-xs-cus-12 col-xs-7 col-sm-6 col-md-6">
                <div class="product-content">
                    {hook h='displayProductListReviews' product=$product}                    
                    <h4 class="name media-heading" itemprop="name">
                       {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
							<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
								{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
							</a>
                    </h4>
                    <div class="product-desc description" itemprop="description">
						{$product.description_short|strip_tags:'UTF-8'|truncate:60:'...'|escape:'html':'UTF-8'}
					</div>
                    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						<div itemprop="offers" itemscope="" itemtype="https://schema.org/Offer" class="content_price price">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
								{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
									<span class="old-price">
										{displayWtPrice p=$product.price_without_reduction}
									</span>
									
								{/if}
								<span itemprop="price" class="product-price {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}new-price {/if}">
									{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
								</span>
								<meta itemprop="priceCurrency" content="{$priceDisplay}" />								
							{/if}
						</div>
					{/if}
					{if isset($product.js)}
					<div class="pts-countdown-{$product.id_product|escape:'html':'UTF-8'} item-countdown">
		                {if $product.js == 'unlimited'}<div class="labelexpired">{l s='Unlimited'}</div>{/if}
		            </div>
		            {if $product.js != 'unlimited'}	
		                <script type="text/javascript">
		                    {literal}
		                    jQuery(document).ready(function($) {{/literal}
		                        $(".pts-countdown-{$product.id_product|escape:'html':'UTF-8'}").lofCountDown({literal}{{/literal}
		                            TargetDate:"{$product.js.month|escape:'html':'UTF-8'}/{$product.js.day|escape:'html':'UTF-8'}/{$product.js.year|escape:'html':'UTF-8'} {$product.js.hour|escape:'html':'UTF-8'}:{$product.js.minute|escape:'html':'UTF-8'}:{$product.js.seconds|escape:'html':'UTF-8'}",
		                            DisplayFormat:"<div><div><div class=\"countdown_num\">%%D%% </div><div>{l s='Days'}</div></div><div><div class=\"countdown_num\">%%H%% </div><div>{l s='Hrs'}</div></div><div><div class=\"countdown_num\">%%M%%</div> <div>{l s='Mins'}</div></div><div><div class=\"countdown_num\">%%S%%</div><div> {l s='Secs'}</div></div></div>",
		                            FinishMessage: "{$product.finish|escape:'html':'UTF-8'}"
		                        {literal}
		                        });
		                    });
		                    {/literal}
		                </script>
		            {/if}
	            {/if}
	            <div class="button-container action">
					<div>
						{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
							<div class="addtocart">
								{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
									{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}{/capture}
									<a class="button ajax_add_to_cart_button btn" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
										<i class="icon icon-shopping-bag"></i><span>{l s='Add to cart'}</span>
									</a>
								{else}
									<a class="button ajax_add_to_cart_button btn disabled"  title="{l s='Add to cart'}" href="#">
										<i class="icon icon-shopping-bag"></i><span>{l s='Add to cart'}</span>
									</a>
								{/if}
							</div>
						{/if}
						{if isset($quick_view) && $quick_view}
							<div class="pts-atchover">
								<a class="quick-view btn" title="{l s='Quick view'}" href="{$product.link|escape:'html':'UTF-8'}">
									<i class="icon icon-retweet"></i><span>{l s='quick view'}</span>
								</a>
							</div>
						{/if}													
						{hook h='displayProductListFunctionalButtons' product=$product}
						{if isset($comparator_max_item) && $comparator_max_item}
							<div class="compare">
								<a class="btn add_to_compare" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}" title="{l s='Add to Compare'}">
									<i class="icon icon-refresh"></i><span>{l s='Add to Compare'}</span>
								</a>
							</div>
						{/if}
					</div>
				</div>
                </div>
            </div>
						
		</div><!-- .product-container> -->
	</div>				
{/if}
