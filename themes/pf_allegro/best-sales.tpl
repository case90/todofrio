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

{capture name=path}{l s='Top sellers'}{/capture}

<h1 class="page-heading product-listing">{l s='Top sellers'}</h1>

{if $products}
       <div class="content_sortPagiBar product-filter clearfix">
            <div class="row">
                <div class="sortPagiBar col-lg-6 col-md-6 col-sm-6">
                    {include file="./product-sort.tpl"}
                </div>
                <div class="hidden-xs hidden-sm col-md-3  col-lg-4">{include file="./nbr-product-page.tpl"}</div><!-- error pagination -->
                <div class="top-pagination-content col-lg-2 col-md-3 col-sm-12">
                        {include file="./product-compare.tpl"}
                </div>
            </div>
        </div>
        {include file="./product-list.tpl" products=$products}
        <div class="bottom-pagination-content content_sortPagiBar clearfix">
             {include file="./pagination.tpl" paginationId='bottom'}
        </div>
	{else}
	<p class="alert alert-warning">{l s='No top sellers for the moment.'}</p>
{/if}
