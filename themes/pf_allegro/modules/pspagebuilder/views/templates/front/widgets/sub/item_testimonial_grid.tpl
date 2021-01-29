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
<div class="testimonials-{$testimonial_position|escape:'html':'UTF-8'}">
    <div class="testimonials-wrap clearfix">
        <div class="testimonials-body">
            <div class="testimonials-avatar">
                {if isset($item.avatar) && $item.avatar neq "" }
                    <div class="radius-x">
					   <img class="img-circle" src="{$testimonial_img_link|escape:'html':'UTF-8'}{$item.avatar|escape:'html':'UTF-8'}" alt="{$item.note|escape:'html':'UTF-8'}" />
                    </div>          
				{/if}
            </div>
            <div class="testimonials-profile">
                <div>
                    <div class="testimonials-quote"><i class="space-right-10 icon icon-quote-left"></i>{$item.content|strip_tags}{* HTML, cannot escape *}<i class="space-left-10 icon icon-quote-right"></i></div>
                    <div>
                        <h4 class="name">{$item.name|escape:'html':'UTF-8'}</h4>
                        <div class="job">{{$item.note|strip_tags }|strip_tags}</div>
                    </div>
                </div>
            </div>
        </div>                    
    </div>
</div>