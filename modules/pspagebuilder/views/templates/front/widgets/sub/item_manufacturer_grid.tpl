{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   pspagebuilder
* @version   5.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div class="manu-logo block_manuf clearfix">
	<a  href="{$link->getmanufacturerLink($item.id_manufacturer, $item.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{l s='view products' mod='pspagebuilder'}">
	<img src="{$img_manu_dir|escape:'htmlall':'UTF-8'}{$item.image|escape:'htmlall':'UTF-8'}-logo_brand.jpg" alt=""> </a>
</div>