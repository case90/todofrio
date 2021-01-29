{if !isset($product_style)}
	{$product_style = Configuration::get('PTS_CP_PRODUCT_STYLE')}
{/if}

<div class="{if isset($carousel_style) && $carousel_style} {$carousel_style}{/if} widget-content owl-carousel-play" data-ride="owlcarousel">
	{$count= (count($items)/($rows))}
	{$count= ceil($count)}
 	{if $count > $columns}
	 	<div class="carousel-controls">
		 	<a class="left carousel-control left_carousel" href="#"><i class="icon icon-chevron-up"></i></a>
			<a class="right carousel-control right_carousel" href="#"><i class="icon icon-chevron-up"></i></a>
		</div>
	{/if}

	
	<div class="owl-carousel {if isset($class) && $class} {$class}{/if} {if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'}{/if} {if ({$columns|escape:'html':'UTF-8'} === '4')}custom-4pro {/if} {if ({$nbr_desktops|escape:'html':'UTF-8'} === '4')} custom-4pro-res {/if}" data-columns="{$columns|escape:'html':'UTF-8'}" {if isset($pagination) && $pagination} data-pagination="true" {else} data-pagination="false" {/if} data-navigation="true"
		{if isset($nbr_desktops)}data-desktop="[1200,{$nbr_desktops|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_tablets)}data-desktopsmall="[992,{$nbr_tablets|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_mobile)}data-tablet="[768,{$nbr_mobile|escape:'html':'UTF-8'}]"{/if}

		data-mobile="[480,1]">
		{if $rows > 1}	
		
			{for $foo=1 to $count}
				<div class="item">		
				{foreach from=$items item=item name=item_name key=key}
					{if $key >= ($rows*($foo - 1)) && $key <= ($foo*$rows - 1 ) }
						{include file="{$list_mode_tpl}" product=$item}
					{/if}	
				{/foreach}
				</div>
			{/for}
		{else}
			{foreach from=$items item=item name=item_name key=key}
				<div class="item">		
					{include file="{$list_mode_tpl}" product=$item}
				</div>
			{/foreach}	
		{/if}
	</div>
</div>