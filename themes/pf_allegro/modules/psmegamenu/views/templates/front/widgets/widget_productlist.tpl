{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psmegamenu
* @version   2.5
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($products) && !empty($products)}
	<div class="widget-products block">
		{if isset($widget_heading)&&!empty($widget_heading)}
			<div class="widget-heading title_block">
				{$widget_heading|escape:'html':'UTF-8'}
			</div>
		{/if}
		<div class="widget-inner block_content">
			{if isset($products) AND $products}
				<ul class="products-block row">					
					{$mproducts=array_chunk($products,$limit)}
					{foreach from=$products item=product name=homeFeaturedProducts}
					 	<li class="w-product pull-left  col-xs-12">
							<div class="product-block clearfix" >
									<div class="product-container media" itemscope="" itemtype="https://schema.org/Product">
										<div class="pull-left">
											<div class="product-image-container image">
												<a class="img product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
													<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
												</a>
											</div>
										</div>
										<div class="media-body">
							                <div class="product-content">
							                    <h4 class="name media-heading" itemprop="name">
							                       {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
														<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
															{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
														</a>
							                    </h4>
							                    {hook h='displayProductListReviews' product=$product}
							                    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
													<div itemprop="offers" itemscope="" itemtype="https://schema.org/Offer" class="content_price price">
														{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
															<span itemprop="price" class="product-price">
																{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
															</span>
															{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
																<span class="old-price">
																	{displayWtPrice p=$product.price_without_reduction}
																</span>
																
															{/if}
															<meta itemprop="priceCurrency" content="{$priceDisplay}" />								
														{/if}
													</div>
												{/if}
							                </div>
							            </div>
													
									</div><!-- .product-container> -->
								</div>	
						</li>					
					{/foreach}
				</ul>
			{/if}
		</div>
	</div>
{/if}