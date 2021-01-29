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
<div class="blog_container grid clearfix">	
	{if $item.image && $show_image}
		<div class="blog-image">
			<a href="{$item.link|escape:'html':'UTF-8'}" title="{$item.title|escape:'html':'UTF-8'}" class="link">
				<img src="{$item.preview_url|escape:'html':'UTF-8'}" title="{$item.title|escape:'html':'UTF-8'}" class="img-responsive" alt=""/>
			</a>
		</div>
	{/if}
	<div class="blog_inner">
		{if $show_title}
			<h5 class="clearfix blog-title">
				<a href="{$item.link|escape:'html':'UTF-8'}" title="{$item.title|escape:'html':'UTF-8'}">{$item.title|escape:'html':'UTF-8'}</a>
			</h5>
		{/if}
		<div class="blog-meta">										
			{if $show_category}
				<span class="blog-cat"> <i class="icon icon-list"></i> {l s='In' mod='pspagebuilder'}
					 <a href="{$item.category_link|escape:'html':'UTF-8'}" title="{$item.category_title|escape:'html':'UTF-8'}">{$item.category_title|escape:'html':'UTF-8'}</a>
				</span>
			{/if}
			{if $show_dateadd}
				<span class="blog-created"><i class="icon icon-clock-o"> </i>
					{strtotime($item.date_add)|escape:'html':'UTF-8'|date_format:"%b %e, %Y"}
				</span>
			{/if}
			{if $show_comment}<span class="blog-ctncomment">
				<i class="icon icon-comment"></i> {l s='Comment' mod='pspagebuilder'}: {$item.comment_count|escape:'html':'UTF-8'}</span>
			{/if}
		</div>

		{if $show_description}
			<div class="blog-shortinfo">
				{$item.description|strip_tags|truncate:145|escape:'html':'UTF-8'}
			</div>
		{/if}
		{if $show_readmore}
			<div class="readmore">
				<p>
					<a href="{$item.link|escape:'html':'UTF-8'}" title="{$item.title|escape:'html':'UTF-8'}" class="btn-link">{l s='Read more >' mod='pspagebuilder'}</a>
				</p>
			</div>
		{/if}
	</div>
</div>