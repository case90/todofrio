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
{if isset($thumbnailurl)}
<div class="widget-images block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{/if}">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</h4>
	{/if}
	<div class="widget-inner block_content clearfix">
		 <div>
		 	{if $ispopup}
		 	<a href="{$imageurl|escape:'html':'UTF-8'}" class="pts-popup fancybox" title="{l s='Large Image' mod='pspagebuilder'}"><span class="icon icon-search-plus"></span></a>
		 	{/if}
		 	
		 	{if $link_url}
		 	<a href="{$link_url|escape:'htmlall':'UTF-8'}" class="image-item pts-btnlink img-animation" title="{l s='Large Image' mod='pspagebuilder'}">
		 	<img src="{$thumbnailurl|escape:'html':'UTF-8'}" alt="" /></a>
		 	{else}

		 	<span class="img-animation"><img src="{$thumbnailurl|escape:'html':'UTF-8'}" alt="" /></span>
			{/if}
		 </div>
	</div>
</div>
{/if} 