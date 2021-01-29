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
{if isset($username)}
<div class="widget-twitter block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading title_block">
		{$widget_heading|escape:'htmlall':'UTF-8'}
	</div>
	{/if}
	<div class="widget-inner block_content">
		<a class="twitter-timeline" data-dnt="true" data-theme="{$theme|escape:'htmlall':'UTF-8'}" data-link-color="#FFFFFF" width="{$width|escape:'htmlall':'UTF-8'}" height="{$height|escape:'htmlall':'UTF-8'}" data-chrome="{$chrome|escape:'htmlall':'UTF-8'}" data-border-color="{$border_color|escape:'htmlall':'UTF-8'}" lang="EN" data-tweet-limit="{$count|escape:'htmlall':'UTF-8'}" data-show-replies="{$show_replies|escape:'htmlall':'UTF-8'}" href="https://twitter.com/{$username|escape:'htmlall':'UTF-8'}"  data-widget-id="{$twidget_id|escape:'htmlall':'UTF-8'}">Tweets by @{$username|escape:'htmlall':'UTF-8'}</a>
		{$js}{* HTML, can not escape *}
	</div>
</div>
{/if} 