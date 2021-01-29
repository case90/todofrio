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
{capture name=path}
	<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
		{l s='My account'}
	</a>
	<span class="navigation-pipe">{$navigationPipe}</span>
	<span class="navigation_page">{l s='Order history'}</span>
{/capture}
{include file="$tpl_dir./errors.tpl"}
<h1 class="page-heading bottom-indent">{l s='Order history'}</h1>
<div class="box">
	<p class="info-title">{l s='Here are the orders you\'ve placed since your account was created.'}</p>
	{if $slowValidation}
		<p class="alert alert-warning">{l s='If you have just placed an order, it may take a few minutes for it to be validated. Please refresh this page if your order is missing.'}</p>
	{/if}
	<div class="block-center" id="block-history">
		{if $orders && count($orders)}
			<table id="order-list" class="table table-bordered footab">
				<thead>
					<tr>
						<th class="first_item" data-sort-ignore="true">{l s='Order reference'}</th>
						<th class="item">{l s='Date'}</th>
						<th data-hide="phone" class="item">{l s='Total price'}</th>
						<th data-sort-ignore="true" data-hide="phone,tablet" class="item">{l s='Payment'}</th>
						<th class="item">{l s='Status'}</th>
						<th data-sort-ignore="true" data-hide="phone,tablet" class="item">{l s='Invoice'}</th>
						<th data-sort-ignore="true" data-hide="phone,tablet" class="last_item">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$orders item=order name=myLoop}
						<tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
							<td class="history_link bold">
								{if isset($order.invoice) && $order.invoice && isset($order.virtual) && $order.virtual}
									<img class="icon" src="{$img_dir}icon/download_product.gif"	alt="{l s='Products to download'}" title="{l s='Products to download'}" />
								{/if}
								<a class="color-myaccount" href="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getPageLink('order-detail', true, NULL, "id_order={$order.id_order|intval}")|escape:'html':'UTF-8'}');">
									{Order::getUniqReferenceOf($order.id_order)}
								</a>
							</td>
							<td data-value="{$order.date_add|regex_replace:"/[\-\:\ ]/":""}" class="history_date bold">
								{dateFormat date=$order.date_add full=0}
							</td>
							<td class="history_price" data-value="{$order.total_paid}">
								<span class="price">
									{displayPrice price=$order.total_paid currency=$order.id_currency no_utf8=false convert=false}
								</span>
							</td>
							<td class="history_method">{$order.payment|escape:'html':'UTF-8'}</td>
							<td{if isset($order.order_state)} data-value="{$order.id_order_state}"{/if} class="history_state">
								{if isset($order.order_state)}
									<span class="label {if isset($order.order_state_color) && Tools::getBrightness($order.order_state_color) > 128} dark{/if}"{if isset($order.order_state_color) && $order.order_state_color} style="background-color:{$order.order_state_color|escape:'html':'UTF-8'}; border-color:{$order.order_state_color|escape:'html':'UTF-8'};"{/if}>
										{$order.order_state|escape:'html':'UTF-8'}
									</span>
								{/if}
							</td>
							<td class="history_invoice">
								{if (isset($order.invoice) && $order.invoice && isset($order.invoice_number) && $order.invoice_number) && isset($invoiceAllowed) && $invoiceAllowed == true}
									<a class="link-button" href="{$link->getPageLink('pdf-invoice', true, NULL, "id_order={$order.id_order}")|escape:'html':'UTF-8'}" title="{l s='Invoice'}" target="_blank">
										<i class="icon-file-text large"></i>{l s='PDF'}
									</a>
								{else}
									-
								{/if}
							</td>
							<td class="history_detail">
								<a class="btn-default button btn" href="javascript:showOrder(1, {$order.id_order|intval}, '{$link->getPageLink('order-detail',true, NULL, "id_order={$order.id_order|intval}")|escape:'html':'UTF-8'}');">
									<span>
										{l s='Details'}<i class="icon-chevron-right right"></i>
									</span>
								</a>
								{if isset($opc) && $opc}
									<a class="link-button" href="{$link->getPageLink('order-opc', true, NULL, "submitReorder&id_order={$order.id_order|intval}")|escape:'html':'UTF-8'}" title="{l s='Reorder'}">
								{else}
									<a class="link-button" href="{$link->getPageLink('order', true, NULL, "submitReorder&id_order={$order.id_order|intval}")|escape:'html':'UTF-8'}" title="{l s='Reorder'}">
								{/if}
									{if isset($reorderingAllowed) && $reorderingAllowed}
										<i class="icon-refresh"></i>{l s='Reorder'}
									{/if}
								</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			<div class="anchorDiv"></div>
			<!--PAGINATION-->
			{if $start!=$stop}
			    <ul class="pagination history-pagination">
			        {if $p != 1 && $p}
			            {assign var='p_previous' value=$p-1}
			            <li id="pagination_previous{if isset($paginationId)}_{$paginationId}{/if}" class="pagination_previous">
			                <a rel="nofollow" href="{$requestPage}?p={$prev_p}">
			                    <i class="icon-chevron-left"></i> <b>{l s='Previous'}</b>
			                </a>
			            </li>
			        {else}
			            <li id="pagination_previous{if isset($paginationId)}_{$paginationId}{/if}" class="disabled pagination_previous">
			                <span>
			                    <i class="icon-chevron-left"></i> <b>{l s='Previous'}</b>
			                </span>
			            </li>
			        {/if}
			        {if $start==3}
			            <li>
			                <a rel="nofollow"  href="{$link->goPage($requestPage, 1)}">
			                    <span>1</span>
			                </a>
			            </li>
			            <li>
			                <a rel="nofollow"  href="{$link->goPage($requestPage, 2)}">
			                    <span>2</span>
			                </a>
			            </li>
			        {/if}
			        {if $start==2}
			            <li>
			                <a rel="nofollow"  href="{$link->goPage($requestPage, 1)}">
			                    <span>1</span>
			                </a>
			            </li>
			        {/if}
			        {if $start>3}
			            <li>
			                <a rel="nofollow"  href="{$link->goPage($requestPage, 1)}">
			                    <span>1</span>
			                </a>
			            </li>
			            <li class="truncate">
			                <span>
			                    <span>...</span>
			                </span>
			            </li>
			        {/if}
			        {section name=pagination start=$start loop=$stop+1 step=1}
			            {if $p == $smarty.section.pagination.index}
			                <li class="active current">
			                    <span>
			                        <span>{$p|escape:'html':'UTF-8'}</span>
			                    </span>
			                </li>
			            {else}
			                <li>
			                    <a rel="nofollow" href="{$link->goPage($requestPage, $smarty.section.pagination.index)}">
			                        <span>{$smarty.section.pagination.index|escape:'html':'UTF-8'}</span>
			                    </a>
			                </li>
			            {/if}
			        {/section}
			        {if $pages_nb>$stop+2}
			            <li class="truncate">
			                <span>
			                    <span>...</span>
			                </span>
			            </li>
			            <li>
			                <a href="{$link->goPage($requestPage, $pages_nb)}">
			                    <span>{$pages_nb|intval}</span>
			                </a>
			            </li>
			        {/if}
			        {if $pages_nb==$stop+1}
			            <li>
			                <a href="{$link->goPage($requestPage, $pages_nb)}">
			                    <span>{$pages_nb|intval}</span>
			                </a>
			            </li>
			        {/if}
			        {if $pages_nb==$stop+2}
			            <li>
			                <a href="{$link->goPage($requestPage, $pages_nb-1)}">
			                    <span>{$pages_nb-1|intval}</span>
			                </a>
			            </li>
			            <li>
			                <a href="{$link->goPage($requestPage, $pages_nb)}">
			                    <span>{$pages_nb|intval}</span>
			                </a>
			            </li>
			        {/if}
			        {if $pages_nb > 1 AND $p != $pages_nb}
			            {assign var='p_next' value=$p+1}
			            <li id="pagination_next{if isset($paginationId)}_{$paginationId}{/if}" class="pagination_next">
			                <a rel="nofollow" href="{$requestPage}?p={$next_p}">
			                    <b>{l s='Next'}</b> <i class="icon-chevron-right"></i>
			                </a>
			            </li>
			        {else}
			            <li id="pagination_next{if isset($paginationId)}_{$paginationId}{/if}" class="disabled pagination_next">
			                <span>
			                    <b>{l s='Next'}</b> <i class="icon-chevron-right"></i>
			                </span>
			            </li>
			        {/if}
			    </ul>
			{/if}
			<!--/PAGINATION-->

			<div id="block-order-detail" class="unvisible">&nbsp;</div>
		{else}
			<p class="alert alert-warning">{l s='You have not placed any orders.'}</p>
		{/if}
	</div>
	<ul class="footer_links list-unstyled clearfix">
		<li class="pull-left">
			<a class="btn-default button btn" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
				<span>
					<i class="icon-chevron-left left"></i> {l s='Back to Your Account'}
				</span>
			</a>
		</li>
		<li class="pull-right">
			<a class="btn-default button btn" href="{$base_dir}">
				<span><i class="icon-chevron-left left"></i> {l s='Home'}</span>
			</a>
		</li>
	</ul>
</div>