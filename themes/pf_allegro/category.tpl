{*
* 2007-2016 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{include file="$tpl_dir./errors.tpl"}
{if isset($category)}
    {if $category->id AND $category->active}
        {if isset($subcategories)}
            <div class="categories-wrap clearfix">
                <h1 class="hide page-heading{if (isset($subcategories) && !$products) || (isset($subcategories) && $products) || !isset($subcategories) && $products} product-listing{/if}">{$category->name|escape:'html':'UTF-8'}{if isset($categoryNameComplement)}&nbsp;{$categoryNameComplement|escape:'html':'UTF-8'}{/if}
                        {include file="$tpl_dir./category-count.tpl"}
                </h1>
                {if $scenes || $category->description || $category->id_image}
                    <div class="content_scene_cat">
                        {if $scenes}
                            <div class="content_scene">
                                <!-- Scenes -->
                                {include file="$tpl_dir./scenes.tpl" scenes=$scenes}
                                {if $category->description}
                                    <div class="cat_desc rte">
                                        {if Tools::strlen($category->description) > 350}
                                            <div id="category_description_short">{$description_short}</div>
                                            <div id="category_description_full" class="unvisible">{$category->description}</div>
                                            <a href="{$link->getCategoryLink($category->id_category, $category->link_rewrite)|escape:'html':'UTF-8'}" class="lnk_more">{l s='More'}</a>
                                        {else}
                                            <div>{$category->description}</div>
                                        {/if}
                                    </div>
                                {/if}
                            </div>
                        {else}
                            <!-- Category image -->
                            <div class="content_scene_cat_bg" {if $category->id_image} style="background:url({$link->getCatImageLink($category->link_rewrite, $category->id_image, 'scene_default')|escape:'html':'UTF-8'}) right bottom no-repeat; min-height:{$categorySize.height}px;"{/if}>
                                {if $category->description}
                                    <div class="category-info">
                                           <div class="cat_desc">
                                               {if strlen($category->description) > 350}
                                                   <div id="category_description_short">{$description_short}</div>
                                                    <div id="category_description_full" class="unvisible rte">{$category->description}</div>                         
                                                  
                                               {else}
                                                   <div class="rte">{$category->description}</div>
                                               {/if}
                                           </div>
                                    </div>
                                {/if}
                            </div>                   
                        {/if}
                    </div>
                {/if}
                {if isset($subcategories)}
                    {if (isset($display_subcategories) && $display_subcategories eq 1) || !isset($display_subcategories) }
                        <!-- Subcategories -->
                        <div id="subcategories" class="hide">
                            <h4 class="subcategory-heading">{l s='subcategories'}</h4>
                            <!-- <div class="subcategory-heading">{l s='Subcategories :'}</div> -->
                            <ul class="subcategories-list row">
                                {foreach from=$subcategories item=subcategory name=subcategory_item}
                                    <li class="subcategories-item col-xs-cus-12 col-xs-6 col-sm-4 col-md-4 {if $smarty.foreach.subcategory_item.iteration%3 == 1} first-item {/if}">
                                        <div class="subcategory-container" {if $subcategory.id_image} style="background:url({$link->getCatImageLink($subcategory.link_rewrite, $subcategory.id_image, 'category_default')|escape:'html':'UTF-8'}) center center no-repeat;  min-height:{$categorySize.height -40}px;"{/if}>
                                            <h5 class="subcategory-name"><a  href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'html':'UTF-8'}">{$subcategory.name|truncate:25:'...'|escape:'html':'UTF-8'|truncate:350}</a></h5>
                                            {if $subcategory.description}
                                                <div class="cat_desc">{$subcategory.description}</div>
                                            {/if}
                                        </div>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}
                {/if}
            </div>
        {/if}
        {if $products}
            <div class="content_sortPagiBar product-filter clearfix">
                <div class="row">
                    <div class="sortPagiBar col-lg-4 col-md-4 col-sm-6 col-xs-8">
                        {include file="./product-sort.tpl"}
                    </div>
                    <div class="hidden-xs hidden-sm col-md-3 col-lg-4">{include file="./nbr-product-page.tpl"}</div><!-- error pagination -->
                    <div class="top-pagination-content col-lg-2 col-md-3 col-sm-3 col-xs-4">
                            {include file="./product-compare.tpl"}
                    </div>
                    <div class="sortPagiBar col-lg-2 col-md-2 col-sm-3 col-xs-8">
                        <ul class="list-unstyled display hidden-xs">
                            <li>{l s='View:'}</li>
                            <li id="grid"><a class="btn-tooltip" rel="nofollow" href="#" title="{l s='Grid'}"><i class="icon-th"></i><span>{{l s='Grid'}}</span></a></li>
                            <li id="list"><a class="btn-tooltip" rel="nofollow" href="#" title="{l s='List'}"><i class="icon-th-list"></i><span>{{l s='List'}}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            {include file="./product-list.tpl" products=$products}
            <div class="bottom-pagination-content content_sortPagiBar clearfix">
                 {include file="./pagination.tpl" paginationId='bottom'}
            </div>
        {/if}
    {elseif $category->id}
        <p class="alert alert-warning">{l s='This category is currently unavailable.'}</p>
    {/if}
{/if}