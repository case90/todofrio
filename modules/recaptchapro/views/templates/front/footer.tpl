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

{if $is_https}
    {assign var="base_dir" value="`$base_dir_ssl`"}
{/if}
{if $version == '1.7'}
    {assign var="base_dir" value=$urls.base_url}
{/if}

{if $site_key}
    <script src='https://www.google.com/recaptcha/api.js?hl={$re_language|escape:"htmlall":"UTF-8"}'></script>
    {if $captcha_contact && !$whitelisted}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var submit_button = $('#contact .contact-form .form-footer .btn-primary');
                        var captcha_form = $('#contact .contact-form .form-fields .form-group:last-child .col-md-9');
                        var error_header = '#contact .contact-form .form';
                    {else}
                        var submit_button = $('#contact .contact-form-box #submitMessage');
                        var captcha_form = $('#contact .contact-form-box .clearfix > div:first-child');
                        var error_header = '#center_column .page-heading';
                    {/if}
                    
                    captcha_form.append('<div class="g-recaptcha" style="{if $version == "1.7"}margin-top: 20px;{/if}" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                    submit_button.attr('type', 'button');
                    var clicked_first = true;
                    
                    submit_button.on('click', function() {
                        // Anti-hack verification
                        if (clicked_first == true) {
                            if (submit_button.attr('type') == 'submit'){
                                submit_button.attr('type', 'button');
                            }
                        }
                        
                        if (clicked_first == true) {
                            if (grecaptcha.getResponse()) {
                                $.ajax({
                                    url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                    type: 'post',
                                    data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                    success: function(data) {
                                        if (data == 'OK') {
                                            submit_button.attr('type', 'submit');
                                            clicked_first = false;
                                            submit_button.click();
                                        } else {
                                            $('.alert').remove();
                                            {if $version == '1.7'}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                            {else}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                            {/if}
                                        }
                                    }
                                });
                            } else {
                                $('.alert').remove();
                                {if $version == '1.7'}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                {else}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                {/if}
                            }
                        }
                    });
                });
            </script>
        {else if $re_version == 2}
            <script>
                function onreCSubmitREG(token) {
                    if (token) {
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    {if $version == '1.7'}
                                        $('#contact .contact-form > form').submit();
                                    {else}
                                        $('#contact .contact-form-box').submit();
                                    {/if}
                                } else {
                                    $('.alert').remove();
                                    {if $version == '1.7'}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#contact .contact-form .form').fadeIn(600);
                                    {else}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                    {/if}
                                }
                            }
                        });
                    }
                }
            </script>
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var captcha_form = $('#contact .contact-form > form');
                    {else}
                        var captcha_form = $('#contact .contact-form-box');
                    {/if}
                    
                    $(captcha_form).submit(function(event) {
                        if (! grecaptcha.getResponse()) {
                            event.preventDefault();
                            grecaptcha.execute();
                        }
                    });
                
                    $(captcha_form).append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitREG" data-size="invisible"></div>');
                    $(captcha_form).append('<input type="hidden" value="" name="submitMessage" />');
                });    
            </script>
        {/if}
    {else}
        {if $whitelist_m && $captcha_contact}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        $('#contact .contact-form .form-fields .form-group:last-child .col-md-9').append('<p style="margin-top: 10px;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {else}
                        $('#contact .contact-form-box .clearfix > div:first-child').append('<p style="margin-top: 10px;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {/if}
                });
            </script>
        {/if}
    {/if}
    
    {if $captcha_frontend && !$whitelisted}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var submit_button = $('#authentication #login-form .form-footer .btn-primary');
                        var captcha_form = $('#authentication #login-form > section');
                        var error_header = '#authentication .login-form';
                    {else}
                        var submit_button = $('#authentication #login_form #SubmitLogin');
                        var captcha_form = $('#authentication #login_form .clearfix > div:nth-child(2)');
                        var error_header = '#center_column .page-heading';
                    {/if}
                    
                    captcha_form.append('<div style="margin-top: 20px;" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                    submit_button.attr('type', 'button');
                    var clicked_first = true;
                    
                    submit_button.on('click', function() {
                        // Anti-hack verification
                        if (clicked_first == true) {
                            if (submit_button.attr('type') == 'submit'){
                                submit_button.attr('type', 'button');
                            }
                        }
                        
                        if (clicked_first == true) {
                            if (grecaptcha.getResponse()) {
                                $.ajax({
                                    url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                    type: 'post',
                                    data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                    success: function(data) {
                                        if (data == 'OK') {
                                            submit_button.attr('type', 'submit');
                                            clicked_first = false;
                                            submit_button.click();
                                        } else {
                                            $('.alert').remove();
                                            {if $version == '1.7'}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                            {else}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                            {/if}
                                        }
                                    }
                                });
                            } else {
                                $('.alert').remove();
                                {if $version == '1.7'}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                {else}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                {/if}
                            }
                        }
                    });
                });
            </script>
            {if $version == '1.7'}
                <style>
                    .g-recaptcha > div {
                        margin-left: auto;
                        margin-right: auto;
                        margin-bottom: 20px;
                    }
                </style>
            {/if}
        {else if $re_version == 2}
            <script>
                function onreCSubmitL(token) {
                    if (token) {
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    {if $version == '1.7'}
                                        $('#authentication #login-form').submit();
                                    {else}
                                        $('#authentication #login_form').submit();
                                    {/if}
                                } else {
                                    $('.alert').remove();
                                    {if $version == '1.7'}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#authentication .login-form').fadeIn(600);
                                    {else}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                    {/if}
                                }
                            }
                        });
                    }
                }
            </script>
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var captcha_form = $('#authentication #login-form');
                    {else}
                        var captcha_form = $('#authentication #login_form');
                    {/if}
                    
                    captcha_form.submit(function(event) {
                        if (! grecaptcha.getResponse()) {
                            event.preventDefault();
                            grecaptcha.execute();
                        }
                    });
                
                    captcha_form.append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitL" data-size="invisible"></div>');
                    captcha_form.append('<input type="hidden" value="" name="SubmitLogin" />');
                });    
            </script>
        {/if}
    {else}
        {if $whitelist_m && $captcha_frontend}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        $('#authentication #login-form > section').append('<p style="margin-top: 10px; text-align: center;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {else}
                        $('#authentication #login_form .clearfix > div:nth-child(2)').append('<p style="margin-top: 10px;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {/if}
                });
            </script>
        {/if}
    {/if}
    
    {if $captcha_registration}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        $('#authentication #customer-form > section').append('<div style="margin-top: 10px;" id="g-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                        $('#authentication #customer-form .form-footer .btn-primary').attr('type', 'button');
                        var clicked_first = true;
                        
                        $('#authentication #customer-form .form-footer .btn-primary').on('click', function() {
                            // Anti-hack verification
                            if (clicked_first == true) {
                                if ($('#authentication #customer-form .form-footer .btn-primary').attr('type') == 'submit'){
                                    $('#authentication #customer-form .form-footer .btn-primary').attr('type', 'button');
                                }
                            }
                            
                            if (clicked_first == true) {
                                if (grecaptcha.getResponse()) {
                                    $.ajax({
                                        url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                        type: 'post',
                                        data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                        success: function(data) {
                                            if (data == 'OK') {
                                                $('#authentication #customer-form .form-footer .btn-primary').attr('type', 'submit');
                                                clicked_first = false;
                                                $('#authentication #customer-form .form-footer .btn-primary').click();
                                            } else {
                                                $('.alert').remove();
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#authentication .register-form').fadeIn(600);
                                            }
                                        }
                                    });
                                } else {
                                    $('.alert').remove();
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#authentication .register-form').fadeIn(600);
                                }
                            }
                        });
                    {else}
                        $('#authentication #SubmitCreate').click(function() {
                            if (typeof(interval) != 'undefined' && interval !== null) {
                                clearInterval(interval);
                            }
                            
                            interval = setInterval(function() {
                                if ($('#authentication #account-creation_form .account_creation').length) {
                                    $('#authentication #login_form .g-recaptcha').remove();
                                    $('#authentication #account-creation_form .account_creation').children(':eq(7)').after('<div style="margin-top: 10px;" id="g-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');                            
                                    var re_grecaptcha = grecaptcha.render('g-recaptcha-re', {
                                        'sitekey' : '{$site_key|escape:"htmlall":"UTF-8"}',
                                        'theme' : '{$re_theme|escape:"htmlall":"UTF-8"}',
                                        'size'  : '{$re_size|escape:"htmlall":"UTF-8"}'
                                    });
                                    $('#authentication #account-creation_form #submitAccount').attr('type', 'button');
                                    var clicked_first = true;
                                    
                                    $('#authentication #account-creation_form #submitAccount').on('click', function() {
                                        // Anti-hack verification
                                        if (clicked_first == true) {
                                            if ($('#authentication #account-creation_form #submitAccount').attr('type') == 'submit'){
                                                $('#authentication #account-creation_form #submitAccount').attr('type', 'button');
                                            }
                                        }
                                        
                                        if (clicked_first == true) {
                                            if (grecaptcha.getResponse(re_grecaptcha)) {
                                                $.ajax({
                                                    url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                                    type: 'post',
                                                    data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse(re_grecaptcha) + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                                    success: function(data) {
                                                        if (data == 'OK') {
                                                            $('#authentication #account-creation_form #submitAccount').attr('type', 'submit');
                                                            clicked_first = false;
                                                            $('#authentication #account-creation_form #submitAccount').click();
                                                        } else {
                                                            $('.alert').remove();
                                                            $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                                        }
                                                    }
                                                });
                                            } else {
                                                $('.alert').remove();
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                            }
                                        }
                                    });
                                    
                                    clearInterval(interval);
                                }
                            }, '1000');
                        });
                    
                        // When the form is submited, load again the reCaptcha
                        if ($('#authentication #account-creation_form .account_creation').length) {
                            $('#authentication #login_form .g-recaptcha').remove();
                            $('#authentication #account-creation_form .account_creation').children(':eq(7)').after('<div style="margin-top: 10px;" id="g-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                            $('#authentication #account-creation_form #submitAccount').attr('type', 'button');
                            var clicked_first = true;
                            
                            $('#authentication #account-creation_form #submitAccount').on('click', function() {
                                // Anti-hack verification
                                if (clicked_first == true) {
                                    if ($('#authentication #account-creation_form #submitAccount').attr('type') == 'submit'){
                                        $('#authentication #account-creation_form #submitAccount').attr('type', 'button');
                                    }
                                }
                                
                                if (clicked_first == true) {
                                    if (grecaptcha.getResponse()) {
                                        $.ajax({
                                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                            type: 'post',
                                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                            success: function(data) {
                                                if (data == 'OK') {
                                                    $('#authentication #account-creation_form #submitAccount').attr('type', 'submit');
                                                    clicked_first = false;
                                                    $('#authentication #account-creation_form #submitAccount').click();
                                                } else {
                                                    $('.alert').remove();
                                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                                }
                                            }
                                        });
                                    } else {
                                        $('.alert').remove();
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                    }
                                }
                            });
                        }
                    {/if}
                });
            </script>
        {else if $re_version == 2}
            <script>
                function onreCSubmitR(token) {
                    if (token) {
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    {if $version == '1.7'}
                                        $('#authentication #customer-form').submit();
                                    {else}
                                        $('#authentication #account-creation_form').submit();
                                    {/if}
                                } else {
                                    $('.alert').remove();
                                    {if $version == '1.7'}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#authentication .register-form').fadeIn(600);
                                    {else}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-heading').fadeIn(600);
                                    {/if}
                                }
                            }
                        });
                    }
                }
            </script>
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var captcha_form = $('#authentication #customer-form');
                        captcha_form.submit(function(event) {
                            if (! grecaptcha.getResponse()) {
                                event.preventDefault();
                                grecaptcha.execute();
                            }
                        });
                    
                        captcha_form.append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitR" data-size="invisible"></div>');
                        captcha_form.append('<input type="hidden" value="" name="submitAccount" />');
                    {else}
                        var re_grecaptcha = null;
                        
                        $(document).on('click', '#authentication #account-creation_form #submitAccount', function() {
                            if (typeof(re_grecaptcha) != 'undefined' && re_grecaptcha !== null) {
                                if (! grecaptcha.getResponse(re_grecaptcha)) {
                                    event.preventDefault();
                                    grecaptcha.execute(re_grecaptcha);
                                }
                            } else {
                                if (! grecaptcha.getResponse()) {
                                    event.preventDefault();
                                    grecaptcha.execute();
                                }
                            }
                        });
                        
                        $('#authentication #SubmitCreate').click(function() {
                            if (typeof(interval) != 'undefined' && interval !== null) {
                                clearInterval(interval);
                            }
                            
                            interval = setInterval(function() {
                                if ($('#authentication #account-creation_form .account_creation').length) {
                                    $('#authentication #login_form .g-recaptcha').remove();
                                    $('#authentication #account-creation_form').append('<div id="g-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitR" data-size="invisible"></div>');
                                    
                                    re_grecaptcha = grecaptcha.render('g-recaptcha-re', {
                                        'sitekey' : '{$site_key|escape:"htmlall":"UTF-8"}',
                                        'size'  : 'invisible',
                                        'callback' : 'onreCSubmitR'
                                    });
                                    
                                    $('#authentication #account-creation_form').append('<input type="hidden" value="" name="submitAccount" />');
                                    clearInterval(interval);
                                }
                            }, '1000');
                        });
                        
                        if ($('#authentication #account-creation_form .account_creation').length) {
                            $('#authentication #login_form .g-recaptcha').remove();
                            $('#authentication #account-creation_form').append('<div class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitR" data-size="invisible"></div>');
                            
                            $('#authentication #account-creation_form').append('<input type="hidden" value="" name="submitAccount" />');
                        }
                    {/if}
                });
            </script>
        {/if}
    {/if}
    
    {if $captcha_resetp && !$whitelisted}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var submit_button = $('#password .forgotten-password .btn-primary');
                        var captcha_form = $('#password .forgotten-password');
                        var error_header = '#password #content';
                    {else}
                        var submit_button = $('#password #form_forgotpassword .submit > button');
                        var captcha_form = $('#password #form_forgotpassword fieldset > div:first-child');
                        var error_header = '#center_column .page-subheading';
                    {/if}
                    
                    captcha_form.after('<div style="margin-bottom: 10px;" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                    submit_button.attr('type', 'button');
                    var clicked_first = true;
                    
                    submit_button.on('click', function() {
                        // Anti-hack verification
                        if (clicked_first == true) {
                            if (submit_button.attr('type') == 'submit'){
                                submit_button.attr('type', 'button');
                            }
                        }
                        
                        if (clicked_first == true) {
                            if (grecaptcha.getResponse()) {
                                $.ajax({
                                    url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                    type: 'post',
                                    data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                    success: function(data) {
                                        if (data == 'OK') {
                                            submit_button.attr('type', 'submit');
                                            clicked_first = false;
                                            submit_button.click();
                                        } else {
                                            $('.alert').remove();
                                            {if $version == '1.7'}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                            {else}
                                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                            {/if}
                                        }
                                    }
                                });
                            } else {
                                $('.alert').remove();
                                {if $version == '1.7'}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertBefore(error_header).fadeIn(600);
                                {else}
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter(error_header).fadeIn(600);
                                {/if}
                            }
                        }
                    });
                });
            </script>
        {else if $re_version == 2}
            <script>
                function onreCSubmitRP(token) {
                    if (token) {
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    {if $version == '1.7'}
                                        $('#password .forgotten-password .btn-primary').click();
                                    {else}
                                        $('#password #form_forgotpassword').submit();
                                    {/if}
                                } else {
                                    $('.alert').remove();
                                    {if $version == '1.7'}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertBefore('#password #content').fadeIn(600);
                                    {else}
                                        $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#center_column .page-subheading').fadeIn(600);
                                    {/if}
                                }
                            }
                        });
                    }
                }
            </script>
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        var captcha_form = $('#password .forgotten-password');
                    {else}
                        var captcha_form = $('#password #form_forgotpassword');
                    {/if}
                    
                    captcha_form.submit(function(event) {
                        if (! grecaptcha.getResponse()) {
                            event.preventDefault();
                            grecaptcha.execute();
                        }
                    });
                
                    captcha_form.append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitRP" data-size="invisible"></div>');
                });    
            </script>
        {/if}
    {else}
        {if $whitelist_m && $captcha_resetp}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    {if $version == '1.7'}
                        $('#password .forgotten-password').after('<p style="text-align: center;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {else}
                        $('#password #form_forgotpassword fieldset > div:first-child').after('<p>{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                    {/if}
                });
            </script>
        {/if}
    {/if}
    
    {if $captcha_comments && !$whitelisted}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    $('#product #id_new_comment_form .new_comment_form_content #commentCustomerName').after('<div style="margin-top: 20px;" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                    $('#product #id_new_comment_form button[name="submitMessage"]').attr('type', 'button');
                    var clicked_first = true;
                    
                    // Disable ajax until everything is ok
                    $('#product #id_new_comment_form button[name="submitMessage"]').attr('id', 'submitNewMessage_disabled');
                    
                    $('#product #id_new_comment_form button[name="submitMessage"]').on('click', function() {
                        // Anti-hack verification
                        if (clicked_first == true) {
                            if ($('#product #id_new_comment_form button[name="submitMessage"]').attr('type') == 'submit'){
                                $('#product #id_new_comment_form button[name="submitMessage"]').attr('type', 'button');
                            }
                        }
                        
                        if (clicked_first == true) {
                            if (grecaptcha.getResponse()) {
                                $.ajax({
                                    url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                    type: 'post',
                                    data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse() + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                    success: function(data) {
                                        if (data == 'OK') {
                                            $('.alert').remove();
                                            $('#product #id_new_comment_form button[name="submitMessage"]').attr('type', 'submit');
                                            $('#product #id_new_comment_form button[name="submitMessage"]').attr('id', 'submitNewMessage');
                                            clicked_first = false;
                                            $('#product #id_new_comment_form button[name="submitMessage"]').click();
                                        } else {
                                            $('.alert').remove();
                                            $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#product #id_new_comment_form .page-subheading').fadeIn(600);
                                        }
                                    }
                                });
                            } else {
                                $('.alert').remove();
                                $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#product #id_new_comment_form .page-subheading').fadeIn(600);
                            }
                        }
                    });
                });
            </script>
        {else if $re_version == 2}
            <script>
                function onreCSubmitC(token) {
                    if (token) {
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    $('#product #id_new_comment_form button[name="submitMessage"]').attr('id', 'submitNewMessage');
                                    $('#product #id_new_comment_form button[name="submitMessage"]').click();
                                } else {
                                    $('.alert').remove();
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter('#product #id_new_comment_form .page-subheading').fadeIn(600);
                                }
                            }
                        });
                    }
                }
            </script>
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    $('#product #id_new_comment_form button[name="submitMessage"]').click(function(event) {
                        if (! grecaptcha.getResponse()) {
                            event.preventDefault();
                            grecaptcha.execute();
                        }
                    });
                
                    $('#product #id_new_comment_form').append('<div id="recaptcha" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitC" data-size="invisible"></div>');
                    
                    // Disable ajax until everything is ok
                    $('#product #id_new_comment_form button[name="submitMessage"]').attr('id', 'submitNewMessage_disabled');
                });    
            </script>
        {/if}
    {else}
        {if $whitelist_m && $captcha_comments}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    $('#product #id_new_comment_form .new_comment_form_content #commentCustomerName').after('<p style="margin-top: 10px;">{$whitelist_m|escape:"htmlall":"UTF-8"}</p>');
                });
            </script>
        {/if}
    {/if}
    
    {if $captcha_newsletter && !$whitelisted}
        {if $re_version == 1}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    var clicked_first = false;
                    var news_grecaptcha = false;
                    var news_validated = false;
                    {if $version == '1.7'}
                        var newsletter_form = $('.block_newsletter form');
                    {else}
                        var newsletter_form = $('#newsletter_block_left form');
                    {/if}
                    
                    newsletter_form.submit(function(event) {
                        if (clicked_first == false) {
                            // Remove all others reCaptchas
                            $('.g-recaptcha').remove();
                            
                            newsletter_form.after('<div style="margin-top: 10px;" id="news-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-theme="{$re_theme|escape:"htmlall":"UTF-8"}" data-size="{$re_size|escape:"htmlall":"UTF-8"}"></div>');
                            news_grecaptcha = grecaptcha.render('news-recaptcha-re', {
                                'sitekey' : '{$site_key|escape:"htmlall":"UTF-8"}',
                                'theme' : '{$re_theme|escape:"htmlall":"UTF-8"}',
                                'size'  : '{$re_size|escape:"htmlall":"UTF-8"}'
                            });
                            
                            clicked_first = true;
                        }
                        
                        if (grecaptcha.getResponse(news_grecaptcha)) {
                            $.ajax({
                                url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                                type: 'post',
                                data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + grecaptcha.getResponse(news_grecaptcha) + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                                async: false,
                                success: function(data) {
                                    if (data == 'OK') {
                                        news_validated = true;
                                    } else {
                                        $('.alert').remove();
                                        $("<div style='margin-top: 20px;' class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter(newsletter_form).fadeIn(600);
                                    }
                                }
                            });
                        } else {
                            $('.alert').remove();
                            $("<div style='margin-top: 20px;' class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong captcha.' mod='recaptchapro'}</ol></div>").hide().insertAfter(newsletter_form).fadeIn(600);
                        }
                        
                        // Prevent default submition
                        if (news_validated == false) {
                            event.preventDefault();
                        }
                    });
                });
            </script>
        {else if $re_version == 2}
            <script>
                // Vanilla document ready
                document.addEventListener("DOMContentLoaded", function() {
                    var clickedd_first = false;
                    var news_grecaptcha = false;
                    {if $version == '1.7'}
                        var newsletter_form = $('.block_newsletter form');
                    {else}
                        var newsletter_form = $('#newsletter_block_left form');
                    {/if}
                    
                    newsletter_form.submit(function(event) {
                        if (clickedd_first == false) {
                            newsletter_form.append('<input type="hidden" id="news-letter-validated" value="" />');
                        }
                        
                        // Prevent default submition
                        if (! $('#news-letter-validated').val()) {
                            event.preventDefault();
                        }
                        
                        if (clickedd_first == false) {
                            // Remove all others reCaptchas
                            $('.g-recaptcha').remove();
                            
                            newsletter_form.append('<div id="news-recaptcha-re" class="g-recaptcha" data-sitekey="{$site_key|escape:"htmlall":"UTF-8"}" data-callback="onreCSubmitN" data-size="invisible"></div>');
                            newsletter_form.append('<input type="hidden" name="submitNewsletter" />');
                            
                            news_grecaptcha = grecaptcha.render('news-recaptcha-re', {
                                'sitekey' : '{$site_key|escape:"htmlall":"UTF-8"}',
                                'size'  : 'invisible',
                                'callback' : 'onreCSubmitN'
                            });
                            
                            clickedd_first = true;
                        }
                        
                        if (! grecaptcha.getResponse(news_grecaptcha)) {
                            grecaptcha.execute(news_grecaptcha);
                        }
                    });
                });
                
                function onreCSubmitN(token) {
                    if (token) {
                        {if $version == '1.7'}
                            var newsletter_form = $('.block_newsletter form');
                        {else}
                            var newsletter_form = $('#newsletter_block_left form');
                        {/if}
                        
                        $.ajax({
                            url: '{$base_dir|escape:"htmlall":"UTF-8"}modules/recaptchapro/verifyrecaptcha.php?token={$ajax_token|escape:"htmlall":"UTF-8"}',
                            type: 'post',
                            data: 'secret={$secret_key|escape:"htmlall":"UTF-8"}&response=' + token + '&remoteip={$remote_ip|escape:"htmlall":"UTF-8"}',
                            success: function(data) {
                                if (data == 'OK') {
                                    $('#news-letter-validated').val('true');
                                    newsletter_form.submit();
                                } else {
                                    $('.alert').remove();
                                    $("<div class='alert alert-danger'><p>{l s='There is 1 error' mod='recaptchapro'}</p><ol><li>{l s='Wrong Captcha secret key or Duplicate submit detected.' mod='recaptchapro'}</ol></div>").hide().insertAfter(newsletter_form).fadeIn(600);
                                }
                            }
                        });
                    }
                } 
            </script>
        {/if}
    {/if}
{else}
    <script>
        alert("{l s='Please fill the reCaptcha site key.' mod='recaptchapro'}");
    </script>
{/if}