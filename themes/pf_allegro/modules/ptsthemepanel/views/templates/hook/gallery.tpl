{if $ptsimages}
{$tabname="psthumbs_list"}
{$columns = 6}
{$nbr_desktops = 5}
{$nbr_tablets = 5}
{$nbr_mobile = 5}

	<div id="{$tabname|escape:'html':'UTF-8'}_{$ptsgkey|escape:'html':'UTF-8'}" class="  widget-content owl-carousel-play wrap_thumbnail" data-ride="owlcarousel">
	 	{if count($ptsimages) > $columns}
		 	<div class="carousel-controls">
			 	<a class="left carousel-control left_carousel" href="#">&lsaquo;</a>
				<a class="right carousel-control right_carousel" href="#">&rsaquo;</a>
			</div>
		{/if}
		<div class="thumbs_list_frame owl-carousel {if isset($class) && $class} {$class}{/if} {if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'}{/if}" data-columns="{$columns|escape:'html':'UTF-8'}" data-pagination="false" data-navigation="true"
			{if isset($nbr_desktops)}data-desktop="[1200,{$nbr_desktops|escape:'html':'UTF-8'}]"{/if}
			{if isset($nbr_tablets)}data-desktopsmall="[992,{$nbr_tablets|escape:'html':'UTF-8'}]"{/if}
			{if isset($nbr_mobile)}data-tablet="[768,{$nbr_mobile|escape:'html':'UTF-8'}]"{/if}
			data-mobile="[480,4]">
			{foreach from=$ptsimages item=image name=thumbnails}
				{assign var=imageIds value="`$product.id_product`-`$image.id_image`"}
				{if !empty($image.legend)}
					{assign var=imageTitle value=$image.legend|escape:'html':'UTF-8'}
				{else}
					{assign var=imageTitle value=$product.name|escape:'html':'UTF-8'}
				{/if}
				<div class="item {if $smarty.foreach.thumbnails.last} last{/if}">
					<a 
						href="{$link->getImageLink($product.link_rewrite, $imageIds, 'thickbox_default')|escape:'html':'UTF-8'}"
						data-fancybox-group="other-views-{$product.id_product}"
						class="pts-fancybox"
						title="{$imageTitle}">

						<img class="img-responsive" src="{$link->getImageLink($product.link_rewrite, $imageIds, 'cart_default')|escape:'html':'UTF-8'}" alt="{$imageTitle}" title="{$imageTitle}" itemprop="image" />
					</a>
				</div>
			{/foreach}
		</div>
	</div>

{/if}