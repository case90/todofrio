{if isset($htmlitems) && $htmlitems}

{if (int)$hookcols>0}
{assign var="hcol" value=12/$hookcols}
{else}
{assign var="hcol" value=4}
{/if}
   <div class="row">
        {foreach name=items from=$htmlitems item=hItem}
            {if $hItem.col_lg<=0}
                {$hItem.col_lg=floor(12/count($htmlitems))}
            {/if}

            {if $hItem.col_sm<=0}
                {$hItem.col_sm=12}
            {/if}
            <div class="ptsstaticontent_{$hook} staticontent-item-{$smarty.foreach.items.iteration} staticontent-item {$hItem.class} feature-box col-lg-{$hItem.col_lg} col-md-{$hItem.col_lg} col-sm-{$hItem.col_lg} col-xs-12">
                    <div class="pull-left icon">
                    {if $hItem.url}<a href="{$hItem.url|escape:'html':'UTF-8'}" class="item-link"{if $hItem.target == 1} target="_blank"{/if}>{/if}
                        {if $hItem.image}
                            <img src="{$module_dir}views/img/{$hItem.image}" class="item-img img-responsive" alt="" />
                        {/if}
                    {if $hItem.url}</a>{/if}
                    </div>
                    <div class="pull-left">                            
                        {if $hItem.title && $hItem.title_use == 1}
                            <h5 class="ourservice-heading">{$hItem.title}</h5>
                        {/if}
                        {if $hItem.html}
                            {$hItem.html}                        
                        {/if}                         
                    </div>
            </div>
        {/foreach}
        </div>
    {/if}


