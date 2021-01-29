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
{if isset($tabs)}
<div class="widget-tab block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget_heading title_block">
		{$widget_heading|escape:'htmlall':'UTF-8'}
	</div>
	{/if}
	<div class="widget-inner block_content">	
		<div id="tabs{$id|escape:'htmlall':'UTF-8'}" class="panel-group">
			

			<ul class="nav nav-tabs" id="myTab">
			  {foreach $tabs as $key => $ac}  
			  <li class="{if $key==0}active{/if}"><a href="#tab{$id|escape:'htmlall':'UTF-8'}{$key|escape:'htmlall':'UTF-8'}" >{$ac.header|escape:'htmlall':'UTF-8'}</a></li>
			  {/foreach}
			</ul>

			<div class="tab-content">
			 	{foreach $tabs as $key => $ac}
				  <div class="tab-pane{if $key==0} active{/if} " id="tab{$id|escape:'htmlall':'UTF-8'}{$key|escape:'htmlall':'UTF-8'}">{$ac.content}{* HTML can not escape *}</div>
			 	{/foreach}
	 		</div>

	</div></div>
</div>
{/if}


