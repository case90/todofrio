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
<div class="form-group" style="display: none;">
	<div class="col-lg-12" id="{$id|escape:'htmlall':'UTF-8'}-images-thumbnails">
		{if isset($files) && $files|count > 0}
		{foreach $files as $file}
		{if isset($file.image) && $file.type == 'image'}
		<div class="img-thumbnail text-center">
			<p>{$file.image}{* HTML, can not escape *}</p>
			{if isset($file.size)}<p>{l s='File size' mod='pssliderlayer' mod='pssliderlayer'} {$file.size|escape:'htmlall':'UTF-8'}kb</p>{/if}
			{if isset($file.delete_url)}
			<p>
				<a class="btn btn-default" href="{$file.delete_url|escape:'htmlall':'UTF-8'}">
				<i class="icon-trash"></i> {l s='Delete' mod='pssliderlayer'}
				</a>
			</p>
			{/if}
		</div>
		{/if}
		{/foreach}
		{/if}
	</div>
</div>
{if isset($max_files) && $files|count >= $max_files}
<div class="row">
	<div class="alert alert-warning">{l s='You have reached the limit (%s) of files to upload, please remove files to continue uploading' mod='pssliderlayer' sprintf=$max_files}</div>
</div>
<script type="text/javascript">
	$( document ).ready(function() {
		{if isset($files) && $files}
		$('#{$id|escape:'htmlall':'UTF-8'}-images-thumbnails').parent().show();
		{/if}
	});
</script>
{else}
<div class="form-group">
	<div class="col-lg-12">
		<input id="{$id|escape:'htmlall':'UTF-8'}" type="file" name="{$name|escape:'htmlall':'UTF-8'}[]"{if isset($url)} data-url="{$url|escape:'htmlall':'UTF-8'}"{/if}{if isset($multiple) && $multiple} multiple="multiple"{/if} class="hide" />
		<button class="btn btn-default" data-style="expand-right" data-size="s" type="button" id="{$id|escape:'htmlall':'UTF-8'}-add-button">
			<i class="icon-plus-sign"></i> {if isset($multiple) && $multiple}{l s='Add files' mod='pssliderlayer'}{else}{l s='Add file' mod='pssliderlayer'}{/if}
		</button>
		<button class="ladda-button btn btn-default" data-style="expand-right" type="button" id="{$id|escape:'htmlall':'UTF-8'}-upload-button" style="display:none;">
			<i class="icon-cloud-upload text-success"></i> <span class="ladda-label text-success">{if isset($multiple) && $multiple}{l s='Upload files' mod='pssliderlayer'}{else}{l s='Upload file' mod='pssliderlayer'}{/if}</span>
		</button>
                <!-- Split button -->
                <div class="btn-group">
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                  {l s='Order Image By' mod='pssliderlayer'} <span class="caret"></span>
                </button>
                <ul id="img_order" class="dropdown-menu">
                    <li><a href="#" data-type="name"><span class="text-danger">{l s='Name' mod='pssliderlayer'} <i class="icon-sort-by-alphabet"></i></span></a></li>
                    <li><a href="#" data-type="name_desc"><span>{l s='Name DESC' mod='pssliderlayer'} <i class="icon-sort-by-alphabet-alt"></i></span></a></li>
                    <li class="divider"></li>
                    <li><a href="#" data-type="date"><span>{l s='Date Modified' mod='pssliderlayer'} <i class="icon-sort-by-attributes"></i></span></a></li>
                    <li><a href="#" data-type="date_desc"><span>{l s='Date Modified DESC' mod='pssliderlayer'} <i class="icon-sort-by-attributes-alt"></i></span></a></li>
                  </ul>
                </div>
	</div>
</div>
<div class="row" style="display:none">
	<div class="alert alert-info" id="{$id|escape:'htmlall':'UTF-8'}-files-list"></div>
</div>
<div class="row" style="display:none">
	<div class="alert alert-success" id="{$id|escape:'htmlall':'UTF-8'}-success"></div>
</div>
<div class="row" style="display:none">
	<div class="alert alert-danger" id="{$id|escape:'htmlall':'UTF-8'}-errors"></div>
</div>
<script type="text/javascript">
	function humanizeSize(bytes)
	{
		if (typeof bytes !== 'number') {
			return '';
		}

		if (bytes >= 1000000000) {
			return (bytes / 1000000000).toFixed(2) + ' GB';
		}

		if (bytes >= 1000000) {
			return (bytes / 1000000).toFixed(2) + ' MB';
		}

		return (bytes / 1000).toFixed(2) + ' KB';
	}
        
        function reloadImageList(sortBy){
                if(!sortBy) sortBy = "date_add";
                $.ajax({
                    type: 'GET',
                    url: imgManUrl + '&reloadSliderImage=1&sortBy='+sortBy,
                    data: '',
                    dataType: 'json',
                    cache: false, // @todo see a way to use cache and to add a timestamps parameter to refresh cache each 10 minutes for example
                    success: function(data)
                    {
                         $("#list-imgs").html(data);
                         $('.label-tooltip').tooltip();
                         $('.fancybox').fancybox();
                    }
                });
        }
        
	$( document ).ready(function() {
		$("#img_order a").click(function(){
                    reloadImageList($(this).attr("data-type"));
                    $("#img_order a span").removeClass("text-danger");
                    $(this).find("span").addClass("text-danger");
                });
                
                {if isset($multiple) && isset($max_files)}
			var {$id|escape:'htmlall':'UTF-8'}_max_files = {$max_files - $files|count};
		{/if}

		{if isset($files) && $files}
		$('#{$id|escape:'htmlall':'UTF-8'}-images-thumbnails').parent().show();
		{/if}

		var {$id|escape:'htmlall':'UTF-8'}_upload_button = Ladda.create( document.querySelector('#{$id|escape:'htmlall':'UTF-8'}-upload-button' ));
		var {$id|escape:'htmlall':'UTF-8'}_total_files = 0;

		$('#{$id|escape:'htmlall':'UTF-8'}').fileupload({
			dataType: 'json',
			autoUpload: false,
			singleFileUploads: true,
			{if isset($post_max_size)}maxFileSize: {$post_max_size|escape:'htmlall':'UTF-8'},{/if}
			{if isset($drop_zone)}dropZone: {$drop_zone}{* HTML, can not escape *},{/if}
			start: function (e) {
				{$id|escape:'htmlall':'UTF-8'}_upload_button.start();
				$('#{$id|escape:'htmlall':'UTF-8'}-upload-button').unbind('click'); //Important as we bind it for every elements in add function
			},
			fail: function (e, data) {
				$('#{$id|escape:'htmlall':'UTF-8'}-errors').html(data.errorThrown.message).parent().show();
			},
			done: function (e, data) {
                                if (data.result) {
                                        $("#list-imgs").html(data.result);
                                        $('.label-tooltip').tooltip();
                                        $('.fancybox').fancybox();
                                        $("#file").val("");
                                        $("#file-files-list").html("");
                                        $("#file-upload-button").hide();
					$(data.context).find('button').remove();					
				}
			},
		}).on('fileuploadalways', function (e, data) {
				{$id|escape:'htmlall':'UTF-8'}_total_files--;

				if ({$id|escape:'htmlall':'UTF-8'}_total_files == 0)
				{
					{$id|escape:'htmlall':'UTF-8'}_upload_button.stop();
					$('#{$id|escape:'htmlall':'UTF-8'}-upload-button').unbind('click');
					$('#{$id|escape:'htmlall':'UTF-8'}-files-list').parent().hide();
				}
		}).on('fileuploadadd', function(e, data) {
			if (typeof {$id|escape:'htmlall':'UTF-8'}_max_files !== 'undefined') {
				if ({$id|escape:'htmlall':'UTF-8'}_total_files >= {$id|escape:'htmlall':'UTF-8'}_max_files) {
					e.preventDefault();
					alert('{l s='You can upload a maximum of %s files'|sprintf:$max_files mod='pssliderlayer'}');
					return;
				}
			}

			data.context = $('<div/>').addClass('row').appendTo($('#{$id|escape:'htmlall':'UTF-8'}-files-list'));
			var file_name = $('<span/>').append('<strong>'+data.files[0].name+'</strong> ('+humanizeSize(data.files[0].size)+')').appendTo(data.context);

			var button = $('<button/>').addClass('btn btn-default pull-right').prop('type', 'button').html('<i class="icon-trash"></i> {l s='Remove file' mod='pssliderlayer'}').appendTo(data.context).on('click', function() {
				{$id|escape:'htmlall':'UTF-8'}_total_files--;
				data.files = null;
				
				var total_elements = $(this).parent().siblings('div.row').length;
				$(this).parent().remove();

				if (total_elements == 0) {
					$('#{$id|escape:'htmlall':'UTF-8'}-files-list').html('').parent().hide();
				}
			});

			$('#{$id|escape:'htmlall':'UTF-8'}-files-list').parent().show();
			$('#{$id|escape:'htmlall':'UTF-8'}-upload-button').show().bind('click', function () {
				if (data.files != null)
					data.submit();						
			});

			{$id|escape:'htmlall':'UTF-8'}_total_files++;
		}).on('fileuploadprocessalways', function (e, data) {
			var index = data.index,	file = data.files[index];
			
			if (file.error) {
				$('#{$id|escape:'htmlall':'UTF-8'}-errors').append('<div class="row"><strong>'+file.name+'</strong> ('+humanizeSize(file.size)+') : '+file.error+'</div>').parent().show();
				$(data.context).find('button').trigger('click');
			}
		});

		$('#{$id|escape:'htmlall':'UTF-8'}-add-button').on('click', function() {
			$('#{$id|escape:'htmlall':'UTF-8'}-success').html('').parent().hide();
			$('#{$id|escape:'htmlall':'UTF-8'}-errors').html('').parent().hide();
			$('#{$id|escape:'htmlall':'UTF-8'}-files-list').parent().hide();
			{$id|escape:'htmlall':'UTF-8'}_total_files = 0;
			$('#{$id|escape:'htmlall':'UTF-8'}').trigger('click');
		});
	});
</script>
{/if}