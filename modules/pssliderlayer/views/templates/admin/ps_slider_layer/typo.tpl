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
<div class="typos bannercontainer">
    <div class="note"> 
            {l s='NOTE' mod='pssliderlayer'}: <p>{l s='These Below Typos are getting in the file' mod='pssliderlayer'}:<a href="{$typoDir|escape:'htmlall':'UTF-8'}" target="_blank">{$typoDir|escape:'htmlall':'UTF-8'}</a>
            <br>{l s='you can open this file and add yours css style and it will be listed in here!!!' mod='pssliderlayer'}</p>
            <p>{l s='To Select One, You Click The Text Of Each Typo' mod='pssliderlayer'}</p>
    </div>

    <div class="typos-wrap">	
        {foreach $captions as $caption}
            <div class="typo {if $caption=='cus_color'}typo-big{/if}"><div class="tp-caption {$caption|escape:'htmlall':'UTF-8'}" data-class="{$caption|escape:'htmlall':'UTF-8'}">{l s='Use This Caption Typo' mod='pssliderlayer'}</div></div>
        {/foreach}
     </div>
</div>  
<script type="text/javascript">
$('div.typo').live('click', function() {  
        if(parent.$('#{$field|escape:'htmlall':'UTF-8'}').val())
            parent.$('#{$field|escape:'htmlall':'UTF-8'}').val(parent.$('#{$field|escape:'htmlall':'UTF-8'}').val()+" "+$("div", this).attr("data-class") );
        else
            parent.$('#{$field|escape:'htmlall':'UTF-8'}').val($("div", this).attr("data-class") );
        parent.$('#dialog').dialog('close');
        parent.$('#dialog').remove();	
});
</script>