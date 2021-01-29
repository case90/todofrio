{*
* Pts Prestashop Theme Framework for Prestashop 1.6.x
*
* @package   ptsbttestimonials
* @version   1.0
* @author    http://www.prestabrain.com
* @copyright Copyright (C) October 2013 prestabrain.com <@emai:prestabrain@gmail.com>
*               <info@prestabrain.com>.All rights reserved.
* @license   GNU General Public License version 2
*}
<div id="ptsbttestimonials{$ptsbttestimonials_modid|escape:'htmlall':'UTF-8'}" class="carousel slide ptsbttestimonials" style="width: {$config_testimonials.test_width|escape:'htmlall':'UTF-8'}px; height: {$config_testimonials.test_height|escape:'htmlall':'UTF-8'}px;">
	{if count($get_testimonials) > 1}
		<div class="carousel-controls">
            <a class="carousel-control left" href="#ptsbttestimonials{$ptsbttestimonials_modid|escape:'htmlall':'UTF-8'}" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#ptsbttestimonials{$ptsbttestimonials_modid|escape:'htmlall':'UTF-8'}" data-slide="next">&rsaquo;</a>
        </div>
	{/if}
	<div class="carousel-inner">
		{foreach from=$get_testimonials item=test name=testimonial}
			<div class="{if isset($active) && $active == 1} active{/if} item {if $smarty.foreach.testimonial.first}active{/if}">

				{if isset($test.avatar) && $test.avatar neq "" }
					<img width="{$config_testimonials.media_width|escape:'htmlall':'UTF-8'}" height="{$config_testimonials.media_height|escape:'htmlall':'UTF-8'}" src="{$config_testimonials.img_link|escape:'htmlall':'UTF-8'}{$test.avatar|escape:'htmlall':'UTF-8'}" alt="{$test.note|escape:'htmlall':'UTF-8'}" />
				{/if}

				{if $test.name  || $test.content}
					<div class="test-info">
						<div class="text">{$test.content}{* HTML, can not escape *}</div>
						<b>{$test.name|escape:'htmlall':'UTF-8'} -- {$test.address|escape:'htmlall':'UTF-8'}</b>
					</div>
				{/if}

				{if isset($test.media_code) && $test.media_code neq "" }
					<div><a  class="fancybox-media" href="{$test.media_code|escape:'html':'UTF-8'}">{l s='Link video' mod='ptsbttestimonials'}</a></div>
				{/if}

			</div>
		{/foreach}
	</div>

	<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox-media').fancybox({
			openEffect  : 'none',
			closeEffect : 'none'
		});
	});
	</script>

</div>