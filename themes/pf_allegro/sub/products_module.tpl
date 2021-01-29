{if !isset($product_style)}
	{$product_style = Configuration::get('PTS_CP_PRODUCT_STYLE')}
{/if}

<div class="{if isset($carousel_style) && $carousel_style} {$carousel_style}{/if} widget-content owl-carousel-play" data-ride="owlcarousel">
 	{if count($items) > $columns}
	 	<div class="carousel-controls">
		 	<a class="left carousel-control left_carousel" href="#"><i class="icon icon-chevron-up"></i></a>
			<a class="right carousel-control right_carousel" href="#"><i class="icon icon-chevron-up"></i></a>
		</div>
	{/if}
	<div class="owl-carousel {if isset($class) && $class} {$class}{/if} {if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'}{/if} {if {$columns|escape:'html':'UTF-8'} === '4'} custom-4pro {/if}" data-columns="{$columns|escape:'html':'UTF-8'}" {if isset($pagination) && $pagination} data-pagination="true" {else} data-pagination="false" {/if} data-navigation="true"
		{if isset($nbr_desktops)}data-desktop="[1200,{$nbr_desktops|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_tablets)}data-desktopsmall="[992,{$nbr_tablets|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_mobile)}data-tablet="[768,{$nbr_mobile|escape:'html':'UTF-8'}]"{/if}
		data-mobile="[480,1]">
		{foreach from=$items item=item name=item_name}
			<div class="item">
				{if isset($is_pagebuilder)}
					{include file="{$list_mode_tpl}" product=$item}
				{else}
					{if isset($product_style) && !empty($product_style)}
						{include file="$tpl_dir./sub/product/{$product_style}.tpl" product=$item class=''}
					{else}
						{include file="$tpl_dir./sub/product/default.tpl" product=$item class=''}
					{/if}
				{/if}
			</div>
		{/foreach}
	</div>
</div>