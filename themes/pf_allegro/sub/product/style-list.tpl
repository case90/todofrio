{if !empty($products)}
	<div class="product-block" >
		<div class="product-container media" itemscope="" itemtype="https://schema.org/Product">
			<div class="product-image-container image pull-left">
				<a class="img product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
					<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" />
					{if isset($iteration)}<span class="hidden count">{$iteration}</span>{/if}
				</a>
						
			</div>
			<div class="media-body">
                <div class="product-content">
                    {hook h='displayProductListReviews' product=$product}
                    <h4 class="name media-heading" itemprop="name">
                       {if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
							<a href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
								{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
							</a>
                    </h4>
                    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						<div itemprop="offers" itemscope="" itemtype="https://schema.org/Offer" class="content_price price">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
								<span itemprop="price" class="product-price {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}new-price {/if}">
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
                    <!-- <p class="product-description description">{$product.description_short|strip_tags:'UTF-8'|truncate:75:'...'}</p> -->
                </div>
            </div>
						
		</div><!-- .product-container> -->
	</div>				
{/if}