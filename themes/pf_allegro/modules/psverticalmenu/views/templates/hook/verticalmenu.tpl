{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   psverticalmenu
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}

<div id="pts-verticalmenu" class="dropdown block block-highlighted">
    <h4 class="title_block dropdown-toggle" data-target=".navbar-ex2-collapse" data-toggle="collapse"> 
    {l s='shop by categories' mod='psverticalmenu'}</h4>
    <div class="pts-verticalmenu navbar-collapse navbar-ex2-collapse block_content collapse">
        <div class="navbar">
            <div id="mainmenutop" class="verticalmenu" role="navigation">
                <div class="navbar-header">
                    <div class="tree-menu ">
                        {$psverticalmenu}{* HTML, cannot escape *}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    if($(window).width() >= 992){
        $('#pts-verticalmenu a.dropdown-toggle').click(function(){
            var redirect_url = $(this).attr('href');
            window.location = redirect_url;
        });
    }
</script>