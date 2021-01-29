<div id="RegisterBystander">
	{if $issetEvent}
		<div class="messages">{include file="$tpl_dir./errors.tpl"}</div>
		<form action="index.php?fc=module&module=eventsmanager&controller=event" method="post" id="BystanderForm" class="std box form-horizontal">
			<div class="account_creation">
				<h3 class="page-subheading">{l s='Introduce tu información.' mod='eventsmanager'}</h3>
				<p class="required"><sup>*</sup>{l s='Campos obligatorios.' mod='eventsmanager'}</p>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="name"><strong>{l s='Nombre' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="name" name="name" value="{if isset($values) }{$values['name']}{/if}" maxlength="35">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="paternal_name"><strong>{l s='Apellido Paterno' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="paternal_name" name="paternal_name" value="{if isset($values) }{$values['paternal_name']}{/if}" maxlength="35">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="maternal_name"><strong>{l s='Apellido Materno' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="maternal_name" name="maternal_name" value="{if isset($values) }{$values['maternal_name']}{/if}" maxlength="35">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="business_name"><strong>{l s='Razón Social' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="business_name" name="business_name" value="{if isset($values) }{$values['business_name']}{/if}" maxlength="50">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="phone1"><strong>{l s='Teléfono' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="phone1" name="phone1" value="{if isset($values) }{$values['phone1']}{/if}" maxlength="15">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="phone2"><strong>{l s='Celular' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="validate form-control" id="phone2" name="phone2" value="{if isset($values) }{$values['phone2']}{/if}" maxlength="15">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="email"><strong>{l s='Correo Electrónico' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="email" class="is_required validate form-control" id="email" name="email" value="{if isset($values) }{$values['email']}{/if}" maxlength="50">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="curp"><strong>{l s='CURP' mod='eventsmanager'}</strong> <sup>*</sup></label>
					<div class="col-sm-6 form-error">
						<input type="text" class="is_required validate form-control" id="curp" name="curp" value="{if isset($values) }{$values['curp']}{/if}" maxlength="18">
					</div>
				</div>

				<div class="required form-group">
					<label class="control-label col-sm-3" for="place_origin"><strong>{l s='Lugar de Origen' mod='eventsmanager'}</strong> </label>
					<div class="col-sm-6 form-error">
						<input type="text" class="validate form-control" id="place_origin" name="place_origin" value="{if isset($values) }{$values['place_origin']}{/if}" maxlength="50">
					</div>
				</div>
				
			</div>
			<div class="submit clearfix">
				<input type="hidden" name="action" value="add">
				<input type="hidden" name="id_event_manager" value="{$id_event_manager}">		
				<div class="col-md-2" style="padding: 0">
					<button type="submit" name="submitBystander" id="submitBystander" class="btn btn-default button button-medium">
						<span>{l s='Guardar' mod='eventsmanager'}</span>
					</button>
				</div>
				<div class="col-md-2" style="padding: 0">
					<a href="index.php">
						<button type="button" class="btn btn-default button button-medium">
							<span>{l s='Ir a inicio' mod='eventsmanager'}</span>
						</button>
					</a>
				</div>
				
				<p class="pull-right required"><span><sup>*</sup>{l s='Campos obligatorios.' mod='eventsmanager'}</span></p>
			</div>
		</form>
	{else}
		<script>window.location='index.php';</script> 
	{/if}
</div>