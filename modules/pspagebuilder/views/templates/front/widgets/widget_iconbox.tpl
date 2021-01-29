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
<div class="feature-box {$icon_box_style|escape:'html':'UTF-8'} {$text_align|escape:'html':'UTF-8'} {$background|escape:'html':'UTF-8'}">
    <div class="fbox-icon">
    	{if isset($linkurl) && $linkurl}
        <a href="{$linkurl|escape:'html':'UTF-8'}" title="{if isset($widget_heading)&&!empty($widget_heading)}{$widget_heading|escape:'html':'UTF-8'}{/if}">
        {/if}
        	{if isset($iconurl) && $iconfile}
				<img class="fa" src="{$iconurl|escape:'html':'UTF-8'}" alt="{l s='icon' mod='pspagebuilder'}">
			{elseif $iconclass}
				<i class="fa {$iconclass|escape:'html':'UTF-8'}"></i>
			{/if}
        {if isset($linkurl) && $linkurl}
        </a>
        {/if}
    </div>
    <div class="fbox-body">                          
        {if isset($widget_heading)&&!empty($widget_heading) && $icon_box_style != 'feature-box-v2'}
		<h4 class="fbox-title">
			{$widget_heading|escape:'html':'UTF-8'}
		</h4>
		{/if}

		{if isset($htmlcontent) && $htmlcontent}
        <p>{$htmlcontent}{* HTML, cannot escape *}</p>
        {/if}
    </div>
</div>