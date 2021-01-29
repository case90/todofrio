<!-- blocksocial -->
<div id="SocialNavIcons" class="pull-left">
	<ul>
		{if isset($facebook_url) && $facebook_url != ''}
			<li><a class="_blank" href="{$facebook_url|escape:html:'UTF-8'}"><i class="fa fa-facebook"></i></a></li>
		{/if}
		{if isset($youtube_url) && $youtube_url != ''}
			<li><a class="_blank" href="{$youtube_url|escape:html:'UTF-8'}"><i class="fa fa-youtube"></i></a></li>
	    {/if}
		{if isset($instagram_url) && $instagram_url != ''}
			<li><a class="_blank" href="{$instagram_url|escape:html:'UTF-8'}"><i class="fa fa-instagram"></i></a></li>
	    {/if}
	    {if isset($twitter_url) && $twitter_url != ''}
			<li><a class="_blank" href="{$twitter_url|escape:html:'UTF-8'}"><i class="fa fa-twitter"></i></a></li>
	    {/if}
	</ul>
</div>
<!-- /blocksocial -->