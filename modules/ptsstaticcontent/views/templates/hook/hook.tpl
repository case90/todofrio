{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   ptsstaticcontent
* @version   2.1
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($htmlitems) && $htmlitems}

{if (int)$hookcols>0}
{assign var="hcol" value=12/$hookcols}
{else}
{assign var="hcol" value=4}
{/if}

<div id="ptsstaticontent_{$hook|escape:'htmlall':'UTF-8'}">
    <ul class="staticontent-home clearfix row">
        {foreach name=items from=$htmlitems item=hItem}
            {if $hItem.col_lg<=0}
            {$hItem.col_lg=floor(12/count($htmlitems))}
            {/if}

            {if $hItem.col_sm<=0}
            {$hItem.col_sm=12}
            {/if}


        	<li class="staticontent-item-{$smarty.foreach.items.iteration|escape:'htmlall':'UTF-8'} col-lg-{$hItem.col_lg|escape:'htmlall':'UTF-8'} col-xs-{$hItem.col_sm|escape:'htmlall':'UTF-8'} {$hItem.class|escape:'htmlall':'UTF-8'}">
            	{if $hItem.url}
                	<a href="{$hItem.url|escape:'html':'UTF-8'}" class="item-link"{if $hItem.target == 1} target="_blank"{/if}>
                {/if}
	            	{if $hItem.image}
	                	<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/{$hItem.image|escape:'htmlall':'UTF-8'}" class="item-img" alt="" />
	                {/if}
	            	{if $hItem.title && $hItem.title_use == 1}
                        <h3 class="item-title">{$hItem.title|escape:'htmlall':'UTF-8'}</h3>
	                {/if}
	            	{if $hItem.html}
	                	<div class="item-html">
                        	{$hItem.html}{* HTML, can not escape *} <i class="icon-double-angle-right"></i>                            
                        </div>
	                {/if}
            	{if $hItem.url}
                	</a>
                {/if}
            </li>
        {/foreach}
    </ul>
</div>
{/if}

