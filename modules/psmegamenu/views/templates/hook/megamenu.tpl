{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psmegamenu
* @version   2.5
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<nav id="cavas_menu" class="pts-megamenu col-lg-12 clearfix">
    <div class="navbar navbar-default " role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">{l s='Toggle navigation' mod='psmegamenu'}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div id="pts-top-menu" class="collapse navbar-collapse navbar-ex1-collapse">
            {$psmegamenu}{* HTML, can not escape *}
        </div>
    </div>  
</nav>
<script type="text/javascript">
    if($(window).width() >= 992){
        $('#pts-top-menu a.dropdown-toggle').click(function(){
            var redirect_url = $(this).attr('href');
            window.location = redirect_url;
        });
    }
</script>