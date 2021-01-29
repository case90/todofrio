
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

<!-- Block Newsletter module-->

<div id="newsletter_block_left" class="col-xs-12 col-sm-12 col-md-3 pts-newsletter">
    <div class="wrap">
        <h4 class="title_block">{l s='sign up now' mod='blocknewsletter'}</h4>
        <div class="block_content clearfix">
            <p>{l s='Get the latest promotion updates plus a free US $5 coupon.' mod='blocknewsletter'}</p>
            <form action="{$link->getPageLink('index', null, null, null, false, null, true)|escape:'html':'UTF-8'}" method="post">
                <div class="input-group">
                    <input class="inputNew newsletter-input form-control input-md" id="newsletter-input" type="text" name="email" size="18" value="{if isset($value) && $value}{$value}{else}{l s='your e-mail' mod='blocknewsletter'}{/if}" />
                    <span class="input-group-btn">
                        <button type="submit" name="submitNewsletter">
                            <span class="icon icon-angle-right"></span>
                        </button>
                    </span>
                    <input type="hidden" name="action" value="0" />
                </div>
            </form>
            {if isset($msg) && $msg}
                <p class="{if $nw_error}warning_inline{else}success_inline{/if}">{$msg}</p>
            {/if}
        </div>
    </div>
</div>
<!-- /Block Newsletter module-->

<script type="text/javascript">
    var placeholder_blocknewsletter = "{l s='your e-mail' mod='blocknewsletter' js=1}";
</script>