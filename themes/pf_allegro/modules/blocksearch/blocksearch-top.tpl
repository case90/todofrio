{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- block seach mobile -->
{if isset($hook_mobile)}
<div class="input_search" data-role="fieldcontain">
	<form id="searchbox" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" >
		<input type="hidden" name="controller" value="search" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
		<input class="search_query" type="search" id="search_query_top" name="search_query" placeholder="{l s='Search' mod='blocksearch'}" value="{$search_query|escape:'html':'UTF-8'|stripslashes}" />
	</form>
</div>
{else}
	<!-- Block search module TOP -->
	{if !isset($header_cp)}
		{$header_cp = Configuration::get('PTS_CP_HEADER')}
	{/if}
	{if $header_cp && file_exists("$CURRENT_THEMEDIR./sub/headers/{$header_cp}/modules/blocksearch/blocksearch-top.tpl")}
		{include file="$CURRENT_THEMEDIR./sub/headers/{$header_cp}/modules/blocksearch/blocksearch-top.tpl" page_name_skin=$page_name}
	{else}	
		<div id="search_block_top" class="clearfix">
			<form id="searchbox" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" >
				<div class="input-group">
					<input type="hidden" name="controller" value="search" />
					<input type="hidden" name="orderby" value="position" />
					<input type="hidden" name="orderway" value="desc" />
					<input class="search_query form-control" type="text" placeholder="{l s='What do you need...' mod='blocksearch'}" id="search_query_top" name="search_query" value="{$search_query|escape:'html':'UTF-8'|stripslashes}" />
					<div class="input-group-btn">
						<button class="button-search btn" name="submit_search" type="submit">
							<span class="icon-search"></span>
						</button>
					</div>
				</div>
			</form>
		</div>
	{/if}
{/if}
<!-- /Block search module TOP -->
