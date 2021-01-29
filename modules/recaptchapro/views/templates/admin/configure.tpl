{*
* 2007-2017 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- Add New IP address to Whitelist Modal -->
<div class="modal fade" id="add_new_ipaddress" tabindex="-1" role="dialog" aria-labelledby="add_new_ipaddress">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{l s='ADD NEW IP ADDRESS TO WHITELIST' mod='recaptchapro'}</h4>
            </div>
            <div class="modal-body">
                <label for="cf_productname">{l s='Enter IP address. (Allowed formats: 151.167.0.2):' mod='recaptchapro'}</label>
                <input type="text" name="add_newip_input" id="add_newip_input" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Close' mod='recaptchapro'}</button>
                <button type="button" id="add_new_ipaddress_button" class="btn btn-primary">{l s='Add' mod='recaptchapro'}</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            // Add new clip arts category to configurator Ajax request
            $(document).on('click', '#add_new_ipaddress_button', function(e) {
                if ($.trim($('#add_newip_input').val()).length) {
                    // Check if IP address have good format
                    var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
                    if ($.trim($('#add_newip_input').val()).match(ipformat)) {
                        $.ajax({
                            url: '{$uri|escape:"htmlall":"UTF-8"}addipaddress.php',
                            type: 'post',
                            data: 'ip_address=' + $.trim($('#add_newip_input').val()) + '&token={$ajax_token|escape:"html":"UTF-8"}',
                            success: function(data) {
                                var url = window.location.href;    
                                if (url.indexOf('?') > -1) {
                                   url += '&re_successfully=1'
                                } else {
                                   url += '?re_successfully=1'
                                }
                                window.location.href = url;
                            }
                        });
                    } else {
                        $('#add_new_ipaddress #newp_undefined_id').remove();
                        $("<p id='newp_undefined_id'>{l s='Invalid IP address.' mod='recaptchapro'}</p>").hide().appendTo('#add_new_ipaddress .modal-body').fadeIn(400);
                    }
                } else {
                    $('#add_new_ipaddress #newp_undefined_id').remove();
                    $("<p id='newp_undefined_id'>{l s='Invalid IP address.' mod='recaptchapro'}</p>").hide().appendTo('#add_new_ipaddress .modal-body').fadeIn(400);
                }
            });
        });
    </script>
</div>
<div class="sidebar navigation" id="nsidebar">
    <nav class="list-group categorieList">
        <a class="list-group-item {if $tab == 'configuration'}active{/if}" href="{$module_link|escape:'htmlall':'UTF-8'}&atab=configuration"><i class="icon-briefcase"></i>{l s='Configuration' mod='recaptchapro'}</a>
        <a class="list-group-item {if $tab == 'whitelist'}active{/if}" href="{$module_link|escape:'htmlall':'UTF-8'}&atab=whitelist"><i class="icon-group"></i>{l s='Whitelist' mod='recaptchapro'}</a>
    </nav>
</div>
