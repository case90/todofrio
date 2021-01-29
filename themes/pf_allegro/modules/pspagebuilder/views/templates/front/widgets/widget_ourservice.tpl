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
<div class="{$addition_cls|escape:'html':'UTF-8'} {if isset($stylecls)&&$stylecls}block-{$stylecls|escape:'html':'UTF-8'}{/if}">
	<div class="ps-ourservice">
		<div class="media">
		{if $icon_position == 'left' || $icon_position == 'right' || $icon_position == 'top' }
			{if $icon || $thumbnailurl}
			<div class="{if $icon_position == 'left'}pull-left {elseif $icon_position == 'right'}pull-right{/if} ">
				{if $icon}
					<i class="icon {$icon|escape:'html':'UTF-8'}"></i>
				{elseif $thumbnailurl}
					<img src="{$thumbnailurl|escape:'html':'UTF-8'}" alt="icon"/>
				{/if}
			</div>
			{/if}
		{/if}
			<div class="media-body">
				{if isset($widget_heading)&&!empty($widget_heading)}
					<h5 class="ourservice-heading">
						{$widget_heading|escape:'html':'UTF-8'}
					</h5>
				{/if}
				<div class="ourservice-content">
					{$content}{* HTML, cannot escape *}
				</div>
			</div>
			{if $icon_position == 'bottom'}
				{if $icon || $thumbnailurl}
				<div class=" ">
					{if $icon}
						<i class="icon {$icon|escape:'html':'UTF-8'}"></i>
					{elseif $thumbnailurl}
						<img src="{$thumbnailurl|escape:'htmlall':'UTF-8'}" alt="icon"/>
					{/if}
				</div>
				{/if}
			{/if}
		</div>
	</div>
</div>	