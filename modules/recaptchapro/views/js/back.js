/**
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
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/

// Vanilla document ready
document.addEventListener("DOMContentLoaded", function() {
    // Change the reCaptcha theme according to the reCaptcha version
    $('#RECAPTCHAPRO_RECAPTCHAV').on('change', function (e) {
        var optionSelected = $('option:selected', this);
        var valueSelected = this.value;
        switch (valueSelected) {
            case '1':
                $('#RECAPTCHAPRO_RETHEME').parent('div').parent('.form-group').fadeIn(100);
                $('#RECAPTCHAPRO_RETHEME').html('<option value="light" selected="selected">' + l_light + '</option><option value="dark">' + l_dark + '</option>');
                $('#RECAPTCHAPRO_RESIZE').parent('div').parent('.form-group').fadeIn(100);
                $('#RECAPTCHAPRO_RESIZE').html('<option value="normal" selected="selected">' + l_normal + '</option><option value="compact">' + l_compact + '</option>');
                break;
            case '2':
                $('#RECAPTCHAPRO_RETHEME').parent('div').parent('.form-group').fadeOut(100);
                $('#RECAPTCHAPRO_RESIZE').parent('div').parent('.form-group').fadeOut(100);
                break;
        }
    });
    
    // Check if version is V2 and display the theme
    if ($('#RECAPTCHAPRO_RECAPTCHAV').val() == '1') {
        $('#RECAPTCHAPRO_RETHEME').parent('div').parent('.form-group').fadeIn(0);
    }
    
    // Check if version is V2 and display the size
    if ($('#RECAPTCHAPRO_RECAPTCHAV').val() == '1') {
        $('#RECAPTCHAPRO_RESIZE').parent('div').parent('.form-group').fadeIn(0);
    }
    
    // Check if language is custom and display the list
    if ($('#RECAPTCHAPRO_RELANGUAGE').val() == '2') {
        $('#RECAPTCHAPRO_CUSTOMLANGUAGE').parent('div').parent('.form-group').fadeIn(0);
    }
    
    // Change the reCaptcha custom language according to the reCaptcha language selection
    $('#RECAPTCHAPRO_RELANGUAGE').on('change', function (e) {
        var optionSelected = $('option:selected', this);
        var valueSelected = this.value;
        
        switch (valueSelected) {
            case '1':
                $('#RECAPTCHAPRO_CUSTOMLANGUAGE').parent('div').parent('.form-group').fadeOut(75);
                break;
            case '2':
                $('#RECAPTCHAPRO_CUSTOMLANGUAGE').parent('div').parent('.form-group').fadeIn(75);
                break;
        }
    });
    
    // Add new IP adress button trigger
    $(document).on('click', '.rec-add-ip-whitelist', function(e) {
        $('#add_new_ipaddress').modal('toggle');
    });
});