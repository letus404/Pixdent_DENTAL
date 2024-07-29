<?php foreach ($tratamientos as $t): ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th style="background: #222d32;color:white">Código</th>
			<th style="background: #222d32;color:white">Fecha</th>
			<th style="background: #222d32;color:white">Paciente</th>
			<th style="background: #222d32;color:white">Medico</th>
			<th style="background: #222d32;color:white">Asunto</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $t->codi_tra ?></td>
			<td><?= $t->fecha_tra ?></td>
			<td><?= $t->NombresApellidos ?></td>
			<td><?= $t->nomb_med.' '.$t->apel_med.' - '.$t->nombre_especialidad ?></td>
			<td><?= $t->asunto_tra ?></td>
		</tr>
	</tbody>
		<tr>
			<th style="background: #3c8dbc;color:white">Procedimiento</th>
			<th style="background: #3c8dbc;color:white">Cantidad</th>
			<th style="background: #3c8dbc;color:white">Precio</th>
			<th style="background: #3c8dbc;color:white">Descuento</th>
			<th style="background: #3c8dbc;color:white">Subtotal</th>
		</tr>
		<?php foreach ($t->procedimientos as $p): ?>
		<tr>
			<td><?= $p->nombre ?></td>
			<td><?= $p->cant_tradet ?></td>
			<td><?= $p->preciounit_tradet ?></td>
			<td><?= $p->descuento_tradet ?>%</td>
			<td><?= $p->subtotal_tradet ?></td>
		</tr>
		<?php endforeach ?>
		<tr>
			<th colspan="3"></th>
			<th style="background: #222d32;color:white;text-align:right">Total</th>
			<th><?= $t->total_tra ?></th>
		</tr>
</table>

<?php endforeach ?>