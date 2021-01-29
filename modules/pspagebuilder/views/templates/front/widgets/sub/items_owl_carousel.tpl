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

<div id="{$tabname|escape:'html':'UTF-8'}" class="widget-content owl-carousel-play" data-ride="owlcarousel">

	{$count= (count($items)/($rows))}
	{$count= ceil($count)}
 	{if $count > $columns}
	 	<div class="carousel-controls">
		 	<a class="left carousel-control left_carousel" href="#">&lsaquo;</a>
			<a class="right carousel-control right_carousel" href="#">&rsaquo;</a>
		</div>
	{/if}
	<div class="owl-carousel product_list products-block {if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'}{/if}" data-columns="{$columns|escape:'html':'UTF-8'}" data-pagination="false" data-navigation="true"
		{if isset($nbr_desktops)}data-desktop="[1200,{$nbr_desktops|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_tablets)}data-desktopsmall="[992,{$nbr_tablets|escape:'html':'UTF-8'}]"{/if}
		{if isset($nbr_mobile)}data-tablet="[768,{$nbr_mobile|escape:'html':'UTF-8'}]"{/if}
		data-mobile="[480,1]">

	{if $rows > 1}	
		
		{for $foo=1 to $count}
			<div class="item ajax_block_product product">		
			{foreach from=$items item=item name=item_name key=key}
				{if $key >= ($rows*($foo - 1)) && $key <= ($foo*$rows - 1 ) }
					{include file="{$list_mode_tpl}" product=$item}
				{/if}	
			{/foreach}
			</div>
		{/for}
	{else}
		{foreach from=$items item=item name=item_name key=key}
			<div class="item ajax_block_product product">		
				{include file="{$list_mode_tpl}" product=$item}
			</div>
		{/foreach}	
	{/if}
	</div>
</div>
{if $rows > 1}
    <script type="text/javascript">
    {literal}
        function mobile() {
            if($( window ).width() <= 768) {
                $('.{/literal}{$class_widget}{literal} .carousel-controls .carousel-control').click(function() {
                    $('.{/literal}{$class_widget}{literal} .active .item.ajax_block_product').each(function() {
                          var rows ={/literal}{$rows}{literal};
                           console.log(rows);
                        if($(this).children('div').length > 1) {
                            var x = 1 + Math.floor(Math.random() * rows);
                            $(this).children('div').css('display','none');
                            $(this).children('div:nth-child('+x+')').css('display','block');
                        }
                    });
                });
            }
        }
        $(document).ready(function() {
            mobile(); 
        });
        $(window).resize(function() {
            mobile(); 
        });
    {/literal}    
    </script>
    <style type="text/css">
        @media screen and (max-width: 768px) {
            .item .ajax_block_product:nth-child(1) {
                display: block;
            }
            .item .ajax_block_product {
                display: none;
            }
        }
    </style>
{/if}