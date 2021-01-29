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
{if $categories_info}
{if file_exists("$THEME_SKIN_DIR./modules/pspagebuilder/views/templates/front/widgets/widget_categoriesinfo.tpl")}
	{include file="$THEME_SKIN_DIR./modules/pspagebuilder/views/templates/front/widgets/widget_categoriesinfo.tpl"}
{else}
<div id="categories_block_left" class="block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h3 class="title_block">
		{$widget_heading|escape:'html':'UTF-8'}
	</h3>
	{/if}
	{$itemsperpage=3}
	{$scolumn=4}
	{$tabname="idcategory_info"}
	<div class="block_content">
		<div class="pts-carousel slide boxcarousel" id="{$tabname}">
			{if count($categories_info)>$itemsperpage}	 
				<div class="carousel-controls">
				 	<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
					<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
				</div>
			{/if}
			{$mcategories=array_chunk($categories_info, $itemsperpage)}
			<div class="carousel-inner"> 
			{foreach from=$mcategories item=category name=mcategory_name}
				<div class="category_list item {if $smarty.foreach.mcategory_name.first}active{/if}">
					<div class="row">
					{foreach from=$category item=cat name=category_name}
						<div class="ajax_block_product col-xs-1 col-sm-4 col-md-{$scolumn|escape:'html':'UTF-8'} col-lg-{$scolumn|escape:'html':'UTF-8'}">
							<div class="category-item">
								{if $show_image && $cat.id_image}
									<div class="category-img">
										<a href="{$link->getCategoryLink({$cat.id_category|escape:'htmlall':'UTF-8'})|escape:'htmlall':'UTF-8'}" title="{$cat.name|escape:'htmlall':'UTF-8'}">
						               		<img src="{$link->getCatImageLink($cat.link_rewrite, $cat.id_image, 'category_default')|escape:'html':'UTF-8'}" alt="{$cat.name|escape:'html':'UTF-8'}" />
			               		     	</a>
										<a class="link-image" href="{$link->getCategoryLink({$cat.id_category})|escape:html:'UTF-8'}" title="{$cat.name|escape:html:'UTF-8'}">  </a>
				               		</div>
				                {/if}
				                <div class="category-meta">
					                {if $show_cat_title}
					                	<h3><a href="{$link->getCategoryLink({$cat.id_category|escape:'htmlall':'UTF-8'})|escape:'htmlall':'UTF-8'}" title="{$cat.name|escape:'htmlall':'UTF-8'}">{$cat.name|escape:'html':'UTF-8'}</a></h3>
					                {/if}
					                {if $show_nb_product}
										<div class="number-item">{l s='-' mod='pspagebuilder'}{$cat.nb_products} {l s='Items -' mod='pspagebuilder'}</div>
					                {/if}
					        	</div>
				                {if $show_description}
				                    <p>{$cat.description|strip_tags:'UTF-8'|truncate:{$limit_description|escape:'htmlall':'UTF-8'}|escape:'htmlall':'UTF-8'}</p>
				                {/if}
				                {if $show_sub_category && $cat.subcategories}
				                    <ul>
				                    {foreach from=$cat.subcategories item=subcategory name=subcategory_name}
				                        <li><a href="{$link->getCategoryLink({$subcategory.id_category|escape:'htmlall':'UTF-8'})|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}">{$subcategory.name|escape:'htmlall':'UTF-8'}</a></li>
				                    {/foreach}
				                    </ul>
				                {/if}
							</div>
						</div>
					{/foreach}
					</div>
				</div>
			{/foreach}
			</div>
		</div>
	</div>
</div>
{/if}
{/if}
