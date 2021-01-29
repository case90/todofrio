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
{if isset($products) && !empty($products)}
<div class="widget widget-products pts-flashsale {$addition_cls} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{else}block-borderbox{/if} block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</h4>
	{/if}
	<div class="widget-inner block_content">
		{if isset($products) AND $products}
	 		{$tabname=rand()+count($products)}
			{if isset($display_mode) && $display_mode == 'carousel'}
				{include file="{$items_owl_carousel_tpl}" items=$products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}" carousel_style="boxcarousel"}
			{else}
				{include file="{$items_normal_tpl}" items=$products class="products-block {if isset($list_mode) && $list_mode == 'grid'}{if isset($product_style) && !empty($product_style)}{$product_style}{else}style1{/if}{else}list{/if}"}
			{/if}
		{/if}
		{$key=rand()}
		<div class="flashsale-time">
			<span class="pts-flashsale-time pts-flashsale-{$key|escape:'html':'UTF-8'}"></span>
		</div>
	</div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".pts-flashsale-{$key|escape:'html':'UTF-8'}").lofCountDown({
            TargetDate:"{$dates.month|escape:'html':'UTF-8'}/{$dates.day|escape:'html':'UTF-8'}/{$dates.year|escape:'html':'UTF-8'} {$dates.hour|escape:'html':'UTF-8'}:{$dates.minute|escape:'html':'UTF-8'}:{$dates.seconds|escape:'html':'UTF-8'}",
            DisplayFormat:"<ul><li><div class=\"countdown_num\">%%D%% </div><div>{l s='Days' mod='pspagebuilder'}</div></li><li><div class=\"countdown_num\">%%H%% </div><div>{l s='Hours' mod='pspagebuilder'}</div></li><li><div class=\"countdown_num\">%%M%%</div> <div>{l s='Minutes' mod='pspagebuilder'}</div></li><li><div class=\"countdown_num\">%%S%%</div><div> {l s='Seconds' mod='pspagebuilder'}</div></li></ul>",
            FinishMessage: ""
        });
    });
</script>
{/if}