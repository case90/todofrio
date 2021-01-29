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
{if isset($subcategories)}
<div class="widget-subcategories block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</div>
	{/if}
	<div class="widget-inner block_content">
		<div class="widget-heading">{$title|escape:'htmlall':'UTF-8'}</div>
		<div class="media">
			{if isset($show_image) && $show_image && $ocategory->id_image}
				<div class="image pull-left">
					<a href="{$link->getCategoryLink($ocategory->id_category, $ocategory->link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$title|escape:'htmlall':'UTF-8'}">
						<img src="{$link->getCatImageLink($ocategory->link_rewrite, $ocategory->id_image, 'category_default')|escape:'html':'UTF-8'}" alt="{$title|escape:'htmlall':'UTF-8'}">
					</a>
				</div>
			{/if}
			<div class="media-body">
				<ul class="list-style">
					{foreach from=$subcategories item=subcategory}
						<li class="clearfix">
							<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}" class="img">
								{$subcategory.name|escape:'htmlall':'UTF-8'} 
							</a>
						</li>
					{/foreach}
				</ul>
			</div>
		</div>
	</div>
</div>
{/if} 