{if $pickupstore}
	<div><b>{l s='Lugar donde se recogerá la mercancía.' mod='pickupstore'}</b></div>
	<div id="pickupstore" style="margin-bottom: 25px;">
		<table class="table" id="shipping_table">
			<thead>
				<tr>
					<th>
						<span class="title_box ">{l s='Nombre' mod='pickupstore'}</span>
					</th>
					<th>
						<span class="title_box ">{l s='Dirección' mod='pickupstore'}</span>
					</th>
					<th>
						<span class="title_box ">{l s='Fecha de visita' mod='pickupstore'}</span>
					</th>
				</tr>
			</thead>
			<tbody>
				
					<tr>
						<td>{$pickupstore.name}</td>
						<td>{$pickupstore.address1} {$pickupstore.address2}</td>
						<td>{$pickupstore.pickup_date|date_format:"%d/%b/%y"}</td>
					</tr>
			
			</tbody>
		</table>
	</div>
{/if}