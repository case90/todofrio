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
{if isset($columns)}
	{if $columns == 5}
		{assign var='nbItemsPerLine' value=$columns} 
	{else}
		{assign var='nbItemsPerLine' value=12/$columns}
	{/if}
{else}
	{assign var='columns' value=4}
	{assign var='nbItemsPerLine' value=4}
{/if}
{if isset($nbr_desktops)}
	{if $nbr_desktops == 5}
		{assign var='nbItemsPerLineDesktop' value=$nbr_desktops} 
	{else}
		{assign var='nbItemsPerLineDesktop' value=12/$nbr_desktops}
	{/if}
{else}
	{assign var='nbItemsPerLineDesktop' value=4}
{/if}
{if isset($nbr_tablets)}
	{assign var='nbItemsPerLineTablet' value=12/$nbr_tablets}
{else}
	{assign var='nbItemsPerLineTablet' value=3}
{/if}
{if isset($nbr_mobile)}
	{assign var='nbItemsPerLineMobile' value=12/$nbr_mobile}
{else}
	{assign var='nbItemsPerLineMobile' value=2}
{/if}
<div class="{if isset($list_mode) && $list_mode}{$list_mode|escape:'html':'UTF-8'}{/if} {if isset($class) && $class} {$class}{/if}">
	<div class="row">
		{foreach from=$items item=item name=items_name}
			<div class="owl-wrapper col-lg-{if $nbItemsPerLine==5}cus-{/if}{$nbItemsPerLine|escape:'html':'UTF-8'} col-md-{if $nbItemsPerLineDesktop==5}cus-{/if}{$nbItemsPerLineDesktop|escape:'html':'UTF-8'} col-sm-{$nbItemsPerLineTablet|escape:'html':'UTF-8'} col-xs-{$nbItemsPerLineMobile|escape:'html':'UTF-8'} col-xs-cus-12 {if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLine) == 1} first-in-line{/if}{if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLineTablet) == 1} first-item-of-tablet-line{/if} {if $smarty.foreach.items_name.iteration%(12/$nbItemsPerLineMobile) == 1} first-item-of-mobile-line{/if} ">
				<div class="item">
					{include file="{$list_mode_tpl}" product=$item}
				</div>
			</div>
		{/foreach}
	</div>		
</div>
 