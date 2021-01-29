<script>
	var latitude 	= '{$event->lat}';
	var longitude 	= '{$event->lang}';
</script>

<div id="EventsManager">
	<div class="messages">
		{if $success !== null}  
			<div class="alert alert-success">
				{l s='¡Gracias! por tu interés en asistir a nuestor evento, tu registro ha sido enviado correctamente.'}
  			</div>
		{/if}
	</div>
	<div class="col-xs-12 infoEventArea" >
		<div class="innerEventInfo">
			<div><h2>{$event->title}</h2></div>
			<div><strong>{l s="Lugar del evento: " mod="eventsmanager"}</strong>{$event->event_place}</div>
			<div><strong>{l s="Dirección: " mod="eventsmanager"}</strong>{$event->address}</div>
			<div class="headerEventsManagerButtonArea" style="margin-top: 25px; margin-bottom: 10px;">			
			<button type="submit" class="exclusive btn btn-danger">
				<a href="index.php?fc=module&module=eventsmanager&controller=event&id_event_manager={$event->id_event_manager}&action=showform">
					{l s="Registrarse" mod="eventsmanager"}
				</a>
			</button>
			
			</div>
		</div>
	</div>
	<div class="col-xs-12 descriptionArea">
		<div class="contentDescriptionEvent">
			{$event->description}
		</div>
		<div id="map" style="width: 100%; height: 400px;"></div>
	</div>
	<div class="col-xs-12 descriptionFooter">
		
	</div>
</div>

{literal}
<script>

	
	if(latitude !== '' && longitude !== '' ){
		function initMap() {
			var uluru = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
			//var uluru = {lat: -25.363, lng: 131.044};
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 14,
				center: uluru
			});
			var marker = new google.maps.Marker({
				position: uluru,
				map: map
			});
		}

		initMap();
	}

</script>

{/literal}