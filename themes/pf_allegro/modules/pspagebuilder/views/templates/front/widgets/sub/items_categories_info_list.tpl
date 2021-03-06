<div class="categories_info_container media clearfix">
    {if $show_image}
        <div class="categories_info_img pull-left">
            <a href="{$link->getCategoryLink({$item.id_category})|escape:'htmlall':'UTF-8'}" title="{$item.name|escape:html:'UTF-8'}">
                {if $item.id_image}
                    <img src="{$link->getCatImageLink($item.link_rewrite, $item.id_image, 'category_default')|escape:'html':'UTF-8'}" alt="{$item.name|escape:html:'UTF-8'}" />
                {else}
                     <img class="replace-2x" src="{$img_cat_dir}{$lang_iso}-default-category_default.jpg" alt="{$item.name|escape:html:'UTF-8'}" />
                {/if}
            </a>
        </div>
    {/if}
    <div class="categories_info_content media-body">
        {if $show_cat_title}
            <h4 class="categories_info_name"><a href="{$link->getCategoryLink({$item.id_category})|escape:'htmlall':'UTF-8'}" title="{$item.name|escape:html:'UTF-8'}">{$item.name|escape:html:'UTF-8'}</a></h4>
        {/if}

        {if $show_nb_product}
            <div class="categories_info_nbproduct">{$item.nb_products} {if $item.nb_products > 1}{l s='items' mod='pspagebuilder'}{else}{l s='item' mod='pspagebuilder'}{/if}</div>
        {/if}

        {if $show_description}
            <div class="categories_info_desc">{$item.description|strip_tags:'UTF-8'|truncate:{$limit_description}}</div>
        {/if}
        {if $show_sub_category && $item.subcategories}
            <div class="categories_info_subcate">
            {foreach from=$item.subcategories item=subcategory name=subcategory_name}
                <a href="{$link->getCategoryLink({$subcategory.id_category})|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}">{$subcategory.name|escape:'htmlall':'UTF-8'}</a>
            {/foreach}
            </div>
        {/if}
    </div>
</div>