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

<div id="ptsblockblogstabs{$tabname|escape:'html':'UTF-8'}" class="widget-latestblog block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{else}block-borderbox{/if}">
	{if isset($widget_heading)&&!empty($widget_heading)}
		<h4 class="title_block">
			{$widget_heading|escape:'html':'UTF-8'}
		</h4>
	{/if}
	<div class="block_content">
		{if !empty($blogs)}
			{if isset($display_mode) && $display_mode == 'carousel'}
				{include file="{$items_owl_carousel_tpl}" items=$blogs carousel_style="boxcarousel"}
			{else}
				{include file="{$items_normal_tpl}" items=$blogs}
			{/if}
		{/if}
		{if $config->get('blockpts_blogs_show',1)}
			<div class="link-view">
				<a class="pull-right btn" href="{$view_all_link|escape:'html':'UTF-8'}" title="{l s='View All' mod='pspagebuilder'}">
					<span>{l s='View All' mod='pspagebuilder'}</span>
				</a>
			</div>
		{/if}		
	</div>
</div>
 