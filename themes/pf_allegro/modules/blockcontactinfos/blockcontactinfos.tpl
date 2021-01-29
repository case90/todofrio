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

<!-- MODULE Block contact infos -->
{if file_exists("$THEME_SKIN_DIR./modules/blockcontactinfos/blockcontactinfos.tpl")}
    {include file="$THEME_SKIN_DIR./modules/blockcontactinfos/blockcontactinfos.tpl"}
{else}
    <div  class="footer-block pts-contact col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <h4 class="title_block">{l s='Contact info' mod='blockcontactinfos'}</h4>
            <p class="desc hidden-xs-hidden-sm">
                {if $blockcontactinfos_company != ''}
                    {$blockcontactinfos_company|escape:'html':'UTF-8'}
                {/if}
                
            </p>
            <ul class="toggle-footer list-unstyled list">
                
                {if $blockcontactinfos_address != ''}
                	<li>
                		<p>{$blockcontactinfos_address|escape:'html':'UTF-8'}</p>
                	</li>
                {/if}
                {if $blockcontactinfos_phone != ''}
                	<li>
                		<span>{$blockcontactinfos_phone|escape:'html':'UTF-8'}</span>
                	</li>
                {/if}
                {if $blockcontactinfos_email != ''}
                	<li>
                		<span style="display: inline-block;">{mailto address=$blockcontactinfos_email|escape:'html':'UTF-8' encode="hex"}</span>
                	</li>
                {/if}
            </ul> 
            {if class_exists('PtsthemePanel')}
                {plugin module='blocksocial' hook='footer'}
            {/if}
    </div>
{/if}
<!-- /MODULE Block contact infos -->
