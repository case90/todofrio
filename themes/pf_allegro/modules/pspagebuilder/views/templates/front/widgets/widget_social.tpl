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

<div class="block {$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}
{/if}">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="widget-heading title_block aaaaa">
		<span>{$widget_heading|escape:'html':'UTF-8'}</span>
	</h4>
	
{/if}
	<div class="block_content">
		<ul class="bo-social-icons list-inline">
			{if $facebook_url != ''}
				<li class="facebook ">
					<a class="" target="_blank"  href="{$facebook_url|escape:html:'UTF-8'}" title="{l s='Facebook' mod='pspagebuilder'}"><i class="icon icon-facebook"></i></a>
				</li>
			{/if}
			{if $twitter_url != ''}
				<li class="twitter">
					<a class="" target="_blank"   href="{$twitter_url|escape:html:'UTF-8'}" title="{l s='Twitter' mod='pspagebuilder'}"><i class="icon icon-twitter"></i></a>
				</li>{/if}
			{if $rss_url != ''}
				<li class="rss">
					<a class="" target="_blank"   href="{$rss_url|escape:html:'UTF-8'}" title="{l s='RSS' mod='pspagebuilder'}"><i class="icon icon-rss"></i></a>
				</li>
			{/if}
			{if $youtube_url != ''}
				<li class="youtube">
					<a class="" target="_blank"   href="{$youtube_url|escape:html:'UTF-8'}" title="{l s='YouTube' mod='pspagebuilder'}"><i class="icon icon-youtube"></i></a>
				</li>
			{/if}
			{if $google_plus_url != ''}
				<li class="google_plus">
					<a class="" target="_blank"   href="{$google_plus_url|escape:html:'UTF-8'}" title="{l s='Google+' mod='pspagebuilder'}"><i class="icon icon-google-plus"></i></a>
				</li>
			{/if}
			{if $pinterest_url != ''}
				<li class="pinterest">
					<a class="" target="_blank"   href="{$pinterest_url|escape:html:'UTF-8'}" title="{l s='Pinterest' mod='pspagebuilder'}"><i class="icon icon-pinterest"></i></a>
				</li>
			{/if}
			{if $vimeo_url != ''}
				<li class="vimeo">
					<a class="" target="_blank" href="{$vimeo_url|escape:html:'UTF-8'}" title="{l s='Vimeo' mod='pspagebuilder'}"><i class="icon icon-vimeo-square"></i></a>
				</li>
			{/if}
			{if $instagram_url != ''}
				<li class="instagram">
					<a class="" target="_blank"   href="{$instagram_url|escape:html:'UTF-8'}" title="{l s='Instagram' mod='pspagebuilder'}"><i class="icon icon-instagram"></i></a>
				</li>
			{/if}
		</ul>
	</div>
</div>