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
{if isset($producttabs)}
<div class="widget-producttabs {$addition_cls|escape:'html':'UTF-8'}">
 
	<div class="widget-inner  pts-tab clearfix">
		<ul  class="nav nav-theme clearfix">
		{foreach from=$producttabs item=ptab name=myproducttabs}
			{if !empty($ptab.products)}
			<li{if $smarty.foreach.myproducttabs.index == 0} class="active"{/if}><a data-toggle="tab" href="#tab-{$ptab.key|escape:'html':'UTF-8'}">{$ptab.title|escape:'html':'UTF-8'}</a></li>
			{/if}
		{/foreach}
		</ul>
		<div class="tab-content">
		{foreach from=$producttabs item=ptab name=myproducttabs}
			{if !empty($ptab.products)}
			<div id="tab-{$ptab.key|escape:'html':'UTF-8'}" class="producttab-content tab-pane {if $smarty.foreach.myproducttabs.index == 0}active{/if}">
				{$tabname = $ptab.key}
				{if isset($display_mode) && $display_mode == 'carousel'}
					{include file="{$items_owl_carousel_tpl}" items=$ptab.products}
				{else}
					{include file="{$items_normal_tpl}" items=$ptab.products}
				{/if}
			</div>
			{/if}
		{/foreach}
		</div>
	</div>
</div>
{/if} 