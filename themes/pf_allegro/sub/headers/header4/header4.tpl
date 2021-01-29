{**************************************
	     HEADER 1
***************************************}

	<header id="header" class="header4">
		<div id="topbar" class="topbar">
			<div class="container">
				{hook h="displayNav"}
			</div>
		</div>	
		<div  id="header-main" class="header">
			<div class="container">
				<div class="row">
					<div id="header_logo" class="col-xs-12 col-sm-12 col-md-3 col-lg-3 inner">
						<div id="logo-theme" class="{if Configuration::get('PTS_CP_LOGOTYPE') == 'logo-theme'}logo-theme{else}logo-store{/if}">
							<a href="{$base_dir}" title="{$shop_name|escape:'html':'UTF-8'}">
								<img class="logo img-responsive {if Configuration::get('PTS_CP_LOGOTYPE') == 'logo-theme'}hidden{/if}" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"/>
							</a>
						</div>
					</div>
					{if class_exists('PtsthemePanel')}
						<div class="col-xs-12 col-sm-9 col-md-6 col-lg-6">
							{plugin module='ptsblocksearch' hook='displayTop'}
						</div>						   
					{/if}
					{if isset($HOOK_TOP)}
						<div class="header-right col-xs-12 col-sm-3 col-md-3 col-lg-3">
							{$HOOK_TOP}
						</div>
					{/if}							
				</div>
			</div>	
		</div>
	    <div  id="pts-mainnav">
	        <div class="container">
	        	<div class="wrap">
		        	<div class="inner">
		        		<div class="main-menu">
					        {hook h="displayMainmenu"}
					    </div>
					</div>
				</div>
	        </div>
	    </div>
	</header>