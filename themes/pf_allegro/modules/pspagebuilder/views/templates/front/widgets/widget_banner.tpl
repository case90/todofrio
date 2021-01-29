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
<div class="widget-images block {$addition_cls} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{else}block-borderbox{/if}">

	{if $subtitle}
		<small>{$subtitle|escape:'html':'UTF-8'}</small>
	{/if}
	{if isset($widget_heading)&&!empty($widget_heading)}
		<h4 class="title_block">
			{$widget_heading|escape:'html':'UTF-8'}
		</h4>
	{/if}
	<div class="widget-inner block_content clearfix">
		<div class="row">
	    	<div class="col-xs-12 col-sm-7 col-md-8">
		        <a href="{$imageurl|escape:'html':'UTF-8'}" class="pts-popup fancybox" title="{$widget_heading|escape:'html':'UTF-8'}">
					<img src="{$imageurl|escape:'html':'UTF-8'}" alt="{$widget_heading|escape:'html':'UTF-8'}">
				</a>
	        	<a class="mask-link" href="{$link_url}"></a>
			</div>
	        <div class="widget-banner-desc col-xs-12 col-sm-5 col-md-4">
				{if $description}
					{$description}{* HTML, cannot escape *}
				{/if}
	        </div>
	    </div>
	</div>
</div>

