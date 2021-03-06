{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   ptsblocksearch
* @version   5.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
{if isset($hook_mobile)}
    <div class="input_search" data-role="fieldcontain">
        <form method="get" action="{$link->getPageLink('search')|escape:'html':'UTF-8'}" id="searchbox">
                <input type="hidden" name="controller" value="search" />
                {$category_html}{* HTML, can not escape *}
                <input type="hidden" name="orderby" value="position" />
                <input type="hidden" name="orderway" value="desc" />
                <input class="search_query" type="search" id="search_query_top" name="search_query" placeholder="{l s='Search' mod='ptsblocksearch'}" value="{$search_query|escape:'html':'UTF-8'|stripslashes}" />
        </form>
    </div>
{else}
    <!-- Block search module TOP -->
    <div id="pts_search_block_top">
        <div class="pts-search">
            <form method="get" action="{$link->getPageLink('search')|escape:'html'}" id="searchbox">
                <input type="hidden" name="controller" value="search" />
                <div class="input-group">
                    <input type="hidden" name="orderby" value="position" />
                    <input type="hidden" name="orderway" value="desc" />
                    <input class="search_query form-control" type="text" placeholder="{l s='Enter key word ...' mod='ptsblocksearch'}" id="pts_search_query_top" name="search_query" value="{$search_query|escape:'html':'UTF-8'|stripslashes}" />
                    <div class="input-group-btn">
                        {$category_html}
                    </div>
                    <button type="submit" name="submit_search" class="button-search">
                        <span class="icon icon-search"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    {include file=$instance_tpl_path}
    {if $tags}
        <div id="search_tags" class="search_tags">
            {foreach $tags as $tag}
                <a href="{$tag.link|escape:'htmlall':'UTF-8'}" title="{$tag.tag|escape:'htmlall':'UTF-8'}">{$tag.tag|escape:'htmlall':'UTF-8'}</a>
            {/foreach}
        </div>
    {/if}
{/if}
<!-- /Block search module TOP -->
