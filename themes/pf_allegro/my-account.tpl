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

{capture name=path}{l s='My account'}{/capture}

<h1 class="page-heading">{l s='My account'}</h1>
{if isset($account_created)}
    <p class="alert alert-success">
        {l s='Your account has been created.'}
    </p>
{/if}
<div class="box">
    <p class="info-account">{l s='Welcome to your account. Here you can manage all of your personal information and orders. '}</p>
    <div class="row addresses-lists">
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('address', true)|escape:'html':'UTF-8'}" title="{l s='Add my first address'}">
                    <div class="icon_container"><i class="icon-building-o icon-4x"></i></div>
                    <div class="title3">{l s='Add my first address'}</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('history', true)|escape:'html':'UTF-8'}" title="{l s='Orders'}">
                    <div class="icon_container"><i class="icon-list-ol icon-4x"></i></div>
                    <div class="title3">{l s='Order history and details '}</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('order-follow', true)|escape:'html':'UTF-8'}" title="{l s='Merchandise returns'}">
                    <div class="icon_container"><i class="icon-refresh icon-4x"></i></div>
                    <div class="title3">{l s='My merchandise returns'}</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('order-slip', true)|escape:'html':'UTF-8'}" title="{l s='Credit slips'}">
                    <div class="icon_container"><i class="icon-file-o icon-4x"></i></div>
                    <div class="title3">{l s='My credit slips'}</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('addresses', true)|escape:'html':'UTF-8'}" title="{l s='Addresses'}">
                    <div class="icon_container"><i class="icon-building-o icon-4x"></i></div>
                    <div class="title3">{l s='My addresses'}</div>
                </a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="order_option_container">
                <a href="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}" title="{l s='Information'}">
                    <div class="icon_container"><i class="icon-user icon-4x"></i></div>
                    <div class="title3">{l s='My personal information'}</div>
                </a>
            </div>
        </div>
        <!--<div class="col-xs-12 col-sm-6 col-lg-6">
            <ul class="list-unstyled myaccount-link-list ">
                {if $has_customer_an_address}
                <li><a href="{$link->getPageLink('address', true)|escape:'html':'UTF-8'}" title="{l s='Add my first address'}"><i class="icon-building-o"></i><span>{l s='Add my first address'}</span></a></li>
                {/if}
                <li><a href="{$link->getPageLink('history', true)|escape:'html':'UTF-8'}" title="{l s='Orders'}"><i class="icon-list-ol"></i><span>{l s='Order history and details '}</span></a></li>
                {if $returnAllowed}
                <li><a href="{$link->getPageLink('order-follow', true)|escape:'html':'UTF-8'}" title="{l s='Merchandise returns'}"><i class="icon-refresh"></i><span>{l s='My merchandise returns'}</span></a></li>
                {/if}
                <li><a href="{$link->getPageLink('order-slip', true)|escape:'html':'UTF-8'}" title="{l s='Credit slips'}"><i class="icon-file-o"></i><span>{l s='My credit slips'}</span></a></li>
                <li><a href="{$link->getPageLink('addresses', true)|escape:'html':'UTF-8'}" title="{l s='Addresses'}"><i class="icon-building-o"></i><span>{l s='My addresses'}</span></a></li>
                <li><a href="{$link->getPageLink('identity', true)|escape:'html':'UTF-8'}" title="{l s='Information'}"><i class="icon-user"></i><span>{l s='My personal information'}</span></a></li>
            </ul>
        </div>-->
    {if $voucherAllowed || isset($HOOK_CUSTOMER_ACCOUNT) && $HOOK_CUSTOMER_ACCOUNT !=''}
        <div class="col-xs-12 col-sm-6 col-lg-6">
            <ul class="list-unstyled myaccount-link-list">
                {if $voucherAllowed}
                    <li><a href="{$link->getPageLink('discount', true)|escape:'html':'UTF-8'}" title="{l s='Vouchers'}"><i class="icon-barcode"></i><span>{l s='My vouchers'}</span></a></li>
                {/if}
                {$HOOK_CUSTOMER_ACCOUNT}
            </ul>
        </div>
    {/if}
    </div>
    <ul class="footer_links list-unstyled clearfix">
    <li><a class="btn btn-default" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{l s='Home'}"><span><i class="icon-chevron-left left"></i> {l s='Home'}</span></a></li>
    </ul>
</div>