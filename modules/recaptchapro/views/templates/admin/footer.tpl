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

{if $site_key}
    {if $re_version == 1}
        <script src='https://www.google.com/recaptcha/api.js?hl={$re_language|escape:"htmlall":"UTF-8"}'></script>
        <script>
            // Vanilla document ready
            document.addEventListener("DOMContentLoaded", function() {
                $('#login-panel #login_form .form-group:nth-child(3)').after('<div class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                $('#login-panel #login_form button[name="submitLogin"]').attr('type', 'button');
                var clicked_first = true;
                
                $('#login-panel #login_form button[name="submitLogin"]').on('click', function() {
                    // Anti-hack verification
                    if (clicked_first == true) {
                        if ($('#login-panel #login_form button[name="submitLogin"]').attr('type') == 'submit'){
                            $('#login-panel #login_form button[name="submitLogin"]').attr('type', 'button');
                        }
                    }
                    
                    if (clicked_first == true) {
                        if (grecaptcha.getResponse()) {
                            $.ajax({
                                url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}&re_admin',
                                type: 'post',
                                data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                success: function(data) {
                                    if (data == 'OK') {
                                        $('#login-panel #login_form button[name="submitLogin"]').attr('type', 'submit');
                                        clicked_first = false;
                                        $('#login-panel #login_form button[name="submitLogin"]').click();
                                    } else {
                                        $('.alert').remove();
                                        $('<div class="alert alert-danger" id="error"><p>{$there_is1|escape:"htmlall":"UTF-8"}</p><ol><li>{$wrong_captcha_s_o_d|escape:"htmlall":"UTF-8"}</ol></div>').hide().insertAfter('#login #login-header div.text-center').fadeIn(600);
                                    }
                                }
                            });
                        } else {
                            $('.alert').remove();
                            $('<div class="alert alert-danger" id="error"><p>{$there_is1|escape:"htmlall":"UTF-8"}</p><ol><li>{$wrong_captcha|escape:"htmlall":"UTF-8"}</ol></div>').hide().insertAfter('#login #login-header div.text-center').fadeIn(600);
                        }
                    }
                });
            });
        </script>
    {else if $re_version == 2}
        <script src='https://www.google.com/recaptcha/api.js?hl={$re_language|escape:"htmlall":"UTF-8"}'></script>
        <script>
            function onreCSubmit(token) {
                if (token) {
                    $.ajax({
                        url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}&re_admin',
                        type: 'post',
                        data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                        success: function(data) {
                            if (data == 'OK') {
                                $('#login-panel #login_form button[name="submitLogin"]').attr('type', 'submit');
                                $('#login-panel #login_form').submit();
                                
                            } else {
                                $('.alert').remove();
                                $('<div class="alert alert-danger" id="error"><p>{$there_is1|escape:"htmlall":"UTF-8"}</p><ol><li>{$wrong_captcha_s_o_d|escape:"htmlall":"UTF-8"}</ol></div>').hide().insertAfter('#login #login-header div.text-center').fadeIn(600);
                            }
                        }
                    });
                }
            }
        </script>
        <script>
            // Vanilla document ready
            document.addEventListener("DOMContentLoaded", function() {
                $('#login-panel #login_form button[name="submitLogin"]').click(function(event) {
                    if (! grecaptcha.getResponse()) {
                        event.preventDefault();
                        grecaptcha.execute();
                    }
                });
            
                $('#login-panel').append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmit" data-size="invisible"></div>');
                $('#login-panel #login_form button[name="submitLogin"]').attr('type', 'button');
            });    
        </script>
    {/if}
{else}
    <script>
        alert('{$please_fill_captcha|escape:"htmlall":"UTF-8"}');
    </script>
{/if}