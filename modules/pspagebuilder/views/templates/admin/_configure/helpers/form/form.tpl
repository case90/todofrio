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
{extends file="helpers/form/form.tpl"}

{block name="field"}
    {if $input.type == 'category_tab'}
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                {$input.category_tpl}{* HTML, cannot escape *}
                <div style="clear:both;"></div>
                <div id="category_tab_image">
                    {if $fields_value['categorytab']}
                        {foreach $fields_value['categorytab'] as $key => $val}
                            <div id="categorytab_{$key|escape:'html':'UTF-8'}">
                                <label>Set icon for: <strong>{$key|escape:'html':'UTF-8'}</strong></label>
                                <div class="pts-container" style="padding:10px; border: 1px solid #e6e6e6;">
                                    <label>Icon Class</label>
                                    <input type="text" name="categorytab[{$key|escape:'html':'UTF-8'}][icon_class]" class="icon_class_category" value="{$val['icon_class']|escape:'html':'UTF-8'}">

                                    <label>Icon</label>
                                    <input type="text" name="categorytab[{$key|escape:'html':'UTF-8'}][icon]" class="icon_category" value="{$val['icon']|escape:'html':'UTF-8'}">
                                </div>
                                <br><br>
                            </div>

                            <script type="text/javascript">
                                $('#categorytab_{$key|escape:'html':'UTF-8'} .icon_category').WPO_Gallery();
                            </script>
                        {/foreach}
                    {/if}
                </div>
            </div>
        </div>
    {/if}
    {if $input.type == 'promotions'}
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <div style="clear:both;"></div>
                <div id="promotions_image_mng">
                    {if $fields_value['promotions']}
                        {foreach $fields_value['promotions'] as $key => $val}
                            <div id="promotions_{$key|escape:'html':'UTF-8'}" class="promotion_item">
                                <div class="pts-container" style="padding:10px; border: 1px solid #e6e6e6;">
                                    <label>Title</label>
                                    <input type="text" name="promotions[{$key|escape:'html':'UTF-8'}][title]" class="title_promotion" value="{$val['title']|escape:'html':'UTF-8'}">

                                    <label>Description</label>
                                    <textarea class="rte_promotion rte_promotion_{$key|escape:'html':'UTF-8'}" name="promotions[{$key|escape:'html':'UTF-8'}][description]">
                                    {$val['description']}{* HTML, cannot escape *}
                                    </textarea>

                                    <label>Url</label>
                                    <input type="text" name="promotions[{$key|escape:'html':'UTF-8'}][url]" class="url_promotion" value="{$val['url']|escape:'html':'UTF-8'}">

                                    <label>Image</label>
                                    <input type="text" name="promotions[{$key|escape:'html':'UTF-8'}][image]" class="image_promotion" value="{$val['image']|escape:'html':'UTF-8'}">

                                </div>
                                <br><br>
                            </div>
                        {/foreach}
                    {else}
                        <div id="promotions_0" class="promotion_item">
                            <div class="pts-container" style="padding:10px; border: 1px solid #e6e6e6;">
                                
                                <label>Title</label>
                                <input type="text" name="promotions[0][title]" class="title_promotion" value="">

                                <label>Description (Raw HTML)</label>
                                <textarea class="rte_promotion rte_promotion_0" name="promotions[0][description]">
                                {$val['description']}{* HTML, cannot escape *}
                                </textarea>

                                <label>Url</label>
                                <input type="text" name="promotions[0][url]" class="url_promotion" value="">

                                <label>Image</label>
                                <input type="text" name="promotions[0][image]" class="image_promotion" value="{$val['image']|escape:'html':'UTF-8'}">
                            </div>
                            <br><br>
                        </div>
                    {/if}
                    

                    <script type="text/javascript">
                        $('.image_promotion').WPO_Gallery();
                    </script>
                </div>
                <button class="btn btn-warning removePromotion" type="button">Delete</button>
                <button class="btn btn-primary addNewPromotion showinform" type="button" style="display: inline-block;">Add New Promotion</button>
            </div>
        </div>

    {/if}
    {if $input.type == 'products_slideshow'}
        <div class="form-group">
            <div class="col-lg-9 col-lg-offset-3">
                <div style="clear:both;"></div>
                <div id="pro_slide_image_mng">
                    {if $fields_value['products_slideshow']}
                        {foreach $fields_value['products_slideshow'] as $key => $val}
                            <div id="pro_slide_{$key|escape:'html':'UTF-8'}" class="pro_slide_item">
                                <div class="pts-container" style="padding:10px; border: 1px solid #e6e6e6;">
                                <div>
                                    <label>Background</label>
                                    <input type="text" name="products_slideshow[{$key|escape:'html':'UTF-8'}][background]" class="background_pro_slide" value="{$val['background']|escape:'html':'UTF-8'}">
                                </div>
                                <div>
                                    <label>Image</label>
                                    <input type="text" name="products_slideshow[{$key|escape:'html':'UTF-8'}][image]" class="image_pro_slide" value="{$val['image']|escape:'html':'UTF-8'}">
                                    </div>
                                    <label>Product Id</label>
                                    <input type="text" name="products_slideshow[{$key|escape:'html':'UTF-8'}][id_product]" class="product_pro_slide" value="{$val['id_product']|escape:'html':'UTF-8'}">

                                </div>
                                <br><br>
                            </div>
                        {/foreach}
                    {else}
                        <div id="pro_slide_0" class="promotion_item">
                            <div class="pts-container" style="padding:10px; border: 1px solid #e6e6e6;">
                                <div>
                                <label>Background</label>
                                <input type="text" name="products_slideshow[0][background]" class="background_pro_slide" value="{$val['background']|escape:'html':'UTF-8'}">
                                </div>
                                <div>
                                <label>Image</label>
                                <input type="text" name="products_slideshow[0][image]" class="image_pro_slide" value="{$val['image']|escape:'html':'UTF-8'}">
                                </div>
                                <label>Product Id</label>
                                <input type="text" name="products_slideshow[0][id_product]" class="product_pro_slide" value="{$val['id_product']|escape:'html':'UTF-8'}">
                            </div>
                            <br><br>
                        </div>
                    {/if}
                    
                    <script type="text/javascript">
                        $('.background_pro_slide').WPO_Gallery();
                        $('.image_pro_slide').WPO_Gallery();
                    </script>
                    
                </div>
                <button class="btn btn-warning removeProslide" type="button">Delete</button>
                <button class="btn btn-primary addNewProslide showinform" type="button" style="display: inline-block;">Add New Slide</button>
            </div>
        </div>

    {/if}
    {$smarty.block.parent}
{/block}