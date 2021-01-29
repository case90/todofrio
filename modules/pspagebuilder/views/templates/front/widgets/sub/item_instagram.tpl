{*
* Pts Prestashop Theme Framework for Prestashop 1.7.x
*
* @package   pspagebuilder
* @version   5.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2016 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
	


	<a class="instagram {if $img_click_type == "i_link"}pts-btnlink img-animation{else}pts-popup fancybox{/if}" href="{if $img_click_type == "i_link"}{$item.link}{else}{$item.images.standard_resolution.url}{/if}" title="">
		<img href="{$item.images.low_resolution.url}"  class="img-responsive" src="{$item.images.standard_resolution.url}" alt="">
	</a>
							