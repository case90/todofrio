<div class="blog-item clearfix">
	<div class="media">
		{if $blog.image && $config->get('listing_show_image',1)}
			<div class="blog-image pull-left">
				<img class="img-responsive" src="{$blog.preview_url}" title="{$blog.title}"/>
			</div>
		{/if}
		<div class="media-body">
			{if $config->get('listing_show_title','1')}
				<h4><a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title}">{$blog.title}</a></h4>
			{/if}
			<div class="blog-meta">
				{if $config->get('listing_show_author','1')&&!empty($blog.author)}
				<span class="blog-author">
					<span class="icon-user"> {l s='Posted By' mod='leoblog'}:</span> 
					<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author}">{$blog.author}</a> 
				</span>
				{/if}
				
				{if $config->get('listing_show_category','1')}
				<span class="blog-cat"> 
					<span class="icon-list"> {l s='In' mod='leoblog'}:</span> 
					<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title}</a>
				</span>
				{/if}
				
				{if $config->get('listing_show_created','1')}
				<span class="blog-created">
					<span class="icon-calendar"> {l s='On' mod='leoblog'}: </span> 
					{strtotime($blog.date_add)|date_format:"%A, %B %e, %Y"}
				</span>
				{/if}
				
				{if isset($blog.comment_count)&&$config->get('listing_show_counter','1')}	
				<span class="blog-ctncomment">
					<span class="icon-comment"> {l s='Comment' mod='leoblog'}:</span> 
					{$blog.comment_count}
				</span>
				{/if}

				{if $config->get('listing_show_hit','1')}	
				<span class="blog-hit">
					<span class="icon-heart"> {l s='Hit' mod='leoblog'}:</span> 
					{$blog.hits}
				</span>
				{/if}
			</div>
			{if $config->get('listing_show_description','1')}
				<div class="blog-shortinfo">
					{$blog.description|strip_tags:'UTF-8'|truncate:360:'...'}
				</div>
			{/if}
			{if $config->get('listing_show_readmore',1)}
				<div class="clearfix">
					<p class="clearfix readmore pull-right">
						<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}"><span>{l s='Read more' mod='leoblog'}</span></a>
					</p>
				</div>
			{/if}
		</div>
	</div>
</div>