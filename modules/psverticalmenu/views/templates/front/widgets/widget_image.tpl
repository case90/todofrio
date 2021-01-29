{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psverticalmenu
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($images)}
<div class="widget-images block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading title_block">
		{$widget_heading|escape:'htmlall':'UTF-8'}
	</div>
	{/if}
	<div class="widget-inner block_content clearfix">
			<div class="images-list clearfix">	
		 	{foreach from=$images item=image name=images}
		 	<div class="image-item grid-{$columns|escape:'htmlall':'UTF-8'}"><div><img src="{$image|escape:'htmlall':'UTF-8'}"/></div></div>
		 {/foreach}</div>
	</div>
</div>
{/if} 