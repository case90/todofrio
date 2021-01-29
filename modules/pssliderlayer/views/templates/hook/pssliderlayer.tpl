{*
 *  Ps Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 PrestaBrain.com <@emai:prestabrain@gmail.com>
 *               <info@prestabrain.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
{if $sliderParams.slider_class == "boxed"}
<div class="layerslider-wrapper{if $sliderParams.group_class} {$sliderParams.group_class|escape:'htmlall':'UTF-8'}{/if}{if $sliderParams.md_width} col-md-{$sliderParams.md_width|escape:'htmlall':'UTF-8'}{/if}{if $sliderParams.sm_width} col-sm-{$sliderParams.sm_width|escape:'htmlall':'UTF-8'}{/if}{if $sliderParams.xs_width} col-xs-{$sliderParams.xs_width|escape:'htmlall':'UTF-8'}{/if}">
    {assign var="sliderParams.group_class" value=""}
{/if}
    <div class="bannercontainer banner-{$sliderParams.slider_class|escape:'htmlall':'UTF-8'}{if $sliderParams.group_class} {$sliderParams.group_class|escape:'htmlall':'UTF-8'}{/if}" style="padding: {$sliderParams.padding|escape:'htmlall':'UTF-8'};margin: {$sliderParams.margin|escape:'htmlall':'UTF-8'};{$sliderParams.background|escape:'htmlall':'UTF-8'}">
        <div id="sliderlayer{$sliderIDRand|escape:'htmlall':'UTF-8'}" class="rev_slider {$sliderParams.slider_class|escape:'htmlall':'UTF-8'}banner" style="width:100%;height:{$sliderParams.height|escape:'htmlall':'UTF-8'}px; " >
            <ul>
                {if $sliders}
                    {assign var="count" value="61"}
                {foreach from=$sliders item=slider}

                <li {$slider.data_link} {$slider.data_delay|escape:'htmlall':'UTF-8'} {$slider.data_target} data-masterspeed="{$slider.params.duration|escape:'htmlall':'UTF-8'}"  data-transition="{$slider.params.transition|escape:'htmlall':'UTF-8'}" data-slotamount="{$slider.params.slot|escape:'htmlall':'UTF-8'}" data-thumb="{$slider.thumbnail|escape:'htmlall':'UTF-8'}"{if $slider.background_color} style="background-color:{$slider.background_color|escape:'htmlall':'UTF-8'}"{/if}>
                    {if $slider.videoURL}
                    <div class="caption fade fullscreenvideo" data-autoplay="true" data-x="0" data-y="0" data-speed="500" data-start="10" data-easing="easeOutBack">
                        <iframe src="{$slider.videoURL|escape:'htmlall':'UTF-8'}?title=0&amp;byline=0&amp;portrait=0;api=1" width="100%" height="100%"></iframe>
                    </div>
                    {else if $slider.main_image}
                    <img src="{$slider.main_image|escape:'htmlall':'UTF-8'}" alt=""/>
                    {/if}
                    {if isset($slider.layersparams)}
                    {foreach from=$slider.layersparams item=layer}
                    <div class="caption{if $layer.layer_class} {$layer.layer_class|escape:'htmlall':'UTF-8'}{/if}{if $layer.layer_animation} {$layer.layer_animation|escape:'htmlall':'UTF-8'}{/if}{if $layer.layer_easing} {$layer.layer_easing|escape:'htmlall':'UTF-8'}{/if}
                        {if $layer.layer_endanimation != "auto" && !$layer.layer_endtime}{$layer.layer_endanimation|escape:'htmlall':'UTF-8'}{/if}"
                         data-x="{$layer.layer_left|escape:'htmlall':'UTF-8'}"
                         data-y="{$layer.layer_top|escape:'htmlall':'UTF-8'}"
                         data-speed="{$layer.layer_speed|escape:'htmlall':'UTF-8'}"
                         data-start="{$layer.time_start|escape:'htmlall':'UTF-8'}"
                         {assign var=count value=$count+1}
                         data-easing="easeOutExpo" {if $layer.layer_endtime}data-end="{$layer.layer_endtime|escape:'htmlall':'UTF-8'}" data-endspeed="{$layer.layer_endspeed|escape:'htmlall':'UTF-8'}" {if $layer.layer_endeasing != "nothing"}data-endeasing="{$layer.layer_endeasing|escape:'htmlall':'UTF-8'}"{/if}{/if}
                         {if $layer.layer_link}onclick="window.open('{$layer.layer_link|escape:'htmlall':'UTF-8'}','{$layer.layer_target|escape:'htmlall':'UTF-8'}');"{/if}
                         {if $layer.css}style="{$layer.css|escape:'htmlall':'UTF-8'};z-index: {$count|escape:'htmlall':'UTF-8'};"{/if}>
                        
                         {if $layer.layer_type == "image"}
                         <img src="{$sliderImgUrl|escape:'htmlall':'UTF-8'}{$layer.layer_content|escape:'htmlall':'UTF-8'}" alt=""/>
                         {elseif $layer.layer_type == "video"}
                            {if $layer.layer_video_type == "vimeo"}
                            <iframe src="http://player.vimeo.com/video/{$layer.layer_video_id|escape:'htmlall':'UTF-8'}?wmode=transparent&amp;title=0&amp;byline=0&amp;portrait=0;api=1" width="{$layer.layer_video_width|escape:'htmlall':'UTF-8'}" height="{$layer.layer_video_height|escape:'htmlall':'UTF-8'}"></iframe>
                            {else}
                            <iframe width="{$layer.layer_video_width|escape:'htmlall':'UTF-8'}" height="{$layer.layer_video_height|escape:'htmlall':'UTF-8'}" src="http://www.youtube.com/embed/{$layer.layer_video_id|escape:'htmlall':'UTF-8'}?wmode=transparent" frameborder="0" allowfullscreen></iframe>
                            {/if}
                         {else}
                             {*<a href="https://www.google.com.vn" target="_blank"></a>*}
                            {$layer.layer_caption|replace:"_ASM_":"&"|html_entity_decode:$smarty.const.ENT_QUOTES:"UTF-8"}{* HTML, can not escape *}
                         {/if}

                    </div>
                    {/foreach}
                    {/if}
                </li>           
                {/foreach}
                {/if}
            </ul>
            {if $sliderParams.show_time_line} 
            <div class="tp-bannertimer tp-{$sliderParams.time_line_position|escape:'htmlall':'UTF-8'}"></div>
            {/if}
        </div>
    </div>
{if $sliderParams.slider_class == "boxed"}
</div>
{/if}

<script type="text/javascript">
             {literal}
                 var tpj=jQuery;
                 
                 if (tpj.fn.cssOriginal!=undefined)
                 tpj.fn.css = tpj.fn.cssOriginal;

                 tpj("#sliderlayer{/literal}{$sliderIDRand|escape:'htmlall':'UTF-8'}{literal}").revolution(
                 {
                     delay:{/literal}{$sliderParams.delay|escape:'htmlall':'UTF-8'}{literal},
                 startheight:{/literal}{$sliderParams.height|escape:'htmlall':'UTF-8'}{literal},
                 startwidth:{/literal}{$sliderParams.width|escape:'htmlall':'UTF-8'}{literal},


                 hideThumbs:{/literal}{$sliderParams.hide_navigator_after|escape:'htmlall':'UTF-8'}{literal},

                 thumbWidth:{/literal}{$sliderParams.thumbnail_width|escape:'htmlall':'UTF-8'}{literal},                     
                 thumbHeight:{/literal}{$sliderParams.thumbnail_height|escape:'htmlall':'UTF-8'}{literal},
                 thumbAmount:{/literal}{$sliderParams.thumbnail_amount|escape:'htmlall':'UTF-8'}{literal},
                 {/literal}{if $sliderParams.navigator_type != "both"}{literal}
                 navigationType:"{/literal}{$sliderParams.navigator_type|escape:'htmlall':'UTF-8'}{literal}",
                 {/literal}{else}{literal}
                 navsecond:"both",
                 {/literal}{/if}{literal}
                 navigationArrows:"{/literal}{$sliderParams.navigator_arrows|escape:'htmlall':'UTF-8'}{literal}",                
                 {/literal}{if $sliderParams.navigation_style != "none"}{literal}
                 navigationStyle:"{/literal}{$sliderParams.navigation_style|escape:'htmlall':'UTF-8'}{literal}",          
                 {/literal}{/if}{literal}

                 navOffsetHorizontal:{/literal}{if $sliderParams.offset_horizontal}{$sliderParams.offset_horizontal|escape:'htmlall':'UTF-8'}{else}0{/if}{literal},
                 {/literal}{if $sliderParams.offset_vertical}{literal}
                 navOffsetVertical:{/literal}{$sliderParams.offset_vertical|escape:'htmlall':'UTF-8'}{literal},  
                {/literal}{/if}{literal}    
                 touchenabled:"{/literal}{if $sliderParams.touch_mobile}on{else}off{/if}{literal}",         
                 onHoverStop:"{/literal}{if $sliderParams.stop_on_hover}on{else}off{/if}{literal}",                     
                 shuffle:"{/literal}{if $sliderParams.shuffle_mode}on{else}off{/if}{literal}",  
                 stopAtSlide: {/literal}{if $sliderParams.auto_play}-1{else}1{/if}{literal},                        
                 stopAfterLoops:{/literal}{if $sliderParams.auto_play}-1{else}0{/if}{literal},                     

                 hideCaptionAtLimit:0,              
                 hideAllCaptionAtLilmit:0,              
                 hideSliderAtLimit:0,           
                 fullWidth:"{/literal}{$sliderFullwidth|escape:'htmlall':'UTF-8'}{literal}",
                 shadow:{/literal}{$sliderParams.shadow_type|escape:'htmlall':'UTF-8'}{literal},
                 startWithSlide:{/literal}{$sliderParams.slider_start_with_slide|escape:'htmlall':'UTF-8'}{literal}
         
                 });
                 $( document ).ready(function() {
                    $('.caption',$('#sliderlayer{/literal}{$sliderIDRand|escape:'htmlall':'UTF-8'}{literal}')).click(function(){
                        if($(this).data('link') != undefined && $(this).data('link') != '') location.href = $(this).data('link');
                    });

                   
                 });
             {/literal}
</script>