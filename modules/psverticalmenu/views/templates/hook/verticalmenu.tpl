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
<div id="pts-verticalmenu" class="block">
    <h3 class="title_block">{l s='Vertical Megamenu' mod='psverticalmenu'}</h3>
    <div class="pts-verticalmenu">
        <div class="navbar navbar-default">
            <div id="mainmenutop" class="verticalmenu" role="navigation">
                <div class="navbar-header">
                    <a href="javascript:;" data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        {$psverticalmenu}{* HTML, can not escape *}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>