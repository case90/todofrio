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
{if isset($promotions) && $promotions}
<div class="widget-images block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{/if}">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</h4>
	{/if}

	<div class="widget-inner block_content clearfix">
		{if $type_display == 'tab'}
			<ul  class="nav nav-theme clearfix">
			{foreach from=$promotions item=promotion name=name_promotion}
				<li{if $smarty.foreach.name_promotion.index == 0} class="active"{/if}>
					<a data-toggle="tab" href="#tab-{$randId|escape:'html':'UTF-8'}-{$smarty.foreach.name_promotion.index|escape:'html':'UTF-8'}">{if isset($promotion.title) && $promotion.title}{$promotion.title|escape:'html':'UTF-8'}{else}{l s='promotions' mod='pspagebuilder'}{/if}</a>
				</li>
			{/foreach}
			</ul>
			<div class="tab-content">
				{foreach from=$promotions item=promotion name=name_promotion}
					<div id="tab-{$randId|escape:'html':'UTF-8'}-{$smarty.foreach.name_promotion.index|escape:'html':'UTF-8'}" class="promotion-content tab-pane {if $smarty.foreach.name_promotion.index == 0}active{/if}">
						{if isset($promotion.title) && $promotion.title}
			        		<h3>{$promotion.title|escape:'html':'UTF-8'}</h3>
			        	{/if}
			        	{if isset($promotion.imageurl) && $promotion.imageurl}
							<a href="{$promotion.url|escape:'htmlall':'UTF-8'}" class="pts-btnlink img-animation" title="{l s='Large Image' mod='pspagebuilder'}">
								<img src="{$promotion.imageurl|escape:'htmlall':'UTF-8'}" alt="{$promotion.title|escape:'html':'UTF-8'}"/>
							</a>
						{/if}
						{if isset($promotion.description) && $promotion.description}
							<div class="promotion-description">{$promotion.description}{* HTML, cannot escape *}</div>
						{/if}
					</div>
				{/foreach}
			</div>
		{else}
			<div id="promotion-carousel-{$randId|escape:'html':'UTF-8'}" class="carousel slide" data-ride="carousel">
			    <div class="carousel-inner">
			    	{foreach from=$promotions item=promotion name=name_promotion}
				        <div class="item{if $smarty.foreach.name_promotion.index == 0} active{/if}">
				        	{if isset($promotion.title) && $promotion.title}
				        		<h3>{$promotion.title|escape:'html':'UTF-8'}</h3>
				        	{/if}
				        	{if isset($promotion.imageurl) && $promotion.imageurl}
								<a href="{$promotion.url|escape:'htmlall':'UTF-8'}" class="pts-btnlink img-animation" title="{l s='Large Image' mod='pspagebuilder'}">
									<img src="{$promotion.imageurl|escape:'htmlall':'UTF-8'}" alt="{$promotion.title|escape:'html':'UTF-8'}"/>
								</a>
							{/if}
							{if isset($promotion.description) && $promotion.description}
								<div class="promotion-description">{$promotion.description}{* HTML, cannot escape *}</div>
							{/if}
				        </div>
			        {/foreach}
			    </div>
			</div>
		{/if}

	</div>

</div>
{/if} 