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
{if isset($images)}
<div class="widget-images block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{/if}">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block ssss">
		<span>{$widget_heading|escape:'html':'UTF-8'}</span>
	</h4>
	{/if}
	<div class="widget-inner gallery-{$type|escape:'html':'UTF-8'} block_content clearfix">
			{if $type=='slider-bt'}
			<div class="carousel slide pts-carousel" id="carousel-{$id|escape:'html':'UTF-8'}" data-ride="carousel">
				  <ol class="carousel-indicators">
				    <li data-target="#carousel-{$id|escape:'html':'UTF-8'}" data-slide-to="0" class="active"></li>
				    <li data-target="#carousel-{$id|escape:'html':'UTF-8'}" data-slide-to="1"></li>
				    <li data-target="#carousel-{$id|escape:'html':'UTF-8'}" data-slide-to="2"></li>
				  </ol>
					<div class="carousel-inner">
				{foreach from=$images item=image name=image}
				
	 				<div class="item"><div>
	 					{if $image.link}
	 					<a href="{$image.link|escape:'html':'UTF-8'}" title="{l s='Image Gallery' mod='pspagebuilder'}"><img src="{$image.thumbnailurl|escape:'html':'UTF-8'}"/></a>
	 					{else}
	 					<img src="{$image.thumbnailurl|escape:'html':'UTF-8'}"/>
	 					{/if}
	 				</div></div>
	 	
				 {/foreach}
				 </div>	
			      <a class="left carousel-control" href="#carousel-{$id|escape:'html':'UTF-8'}" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#carousel-{$id|escape:'html':'UTF-8'}" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				  </a>

			</div>
			{else}
			<div class="images-list clearfix">	
		 		{foreach from=$images item=image name=image}
			 		<div class="image-item grid-{$columns|escape:'html':'UTF-8'}"><div>
			 			<img src="{$image.thumbnailurl|escape:'html':'UTF-8'}"/>
			 			
			 			{if $ispopup}
					 	<a href="{$image.imageurl|escape:'htmlall':'UTF-8'}" class="pts-popup fancybox" title="{l s='Large Image' mod='pspagebuilder'}"><span class="icon icon-expand"></span></a>
					 	{/if}
					 	
					 	{if $image.link}
					 	<a href="{$image.link|escape:'htmlall':'UTF-8'}" class="pts-btnlink" title="{l s='Large Image' mod='pspagebuilder'}"><span class="icon icon-share"></span></a>
					 	{/if}
			 		</div></div>
				 {/foreach}
			</div>	
		 {/if}	
	</div>
</div>
{/if} 