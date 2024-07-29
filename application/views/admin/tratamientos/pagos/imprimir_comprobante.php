<div class="w100">
	<div class="w30">
		<img src="<?= base_url('assets/uploads/logo/'.$this->session->userdata('foto')) ?>" style="max-width: 100px; padding-top: -10px">
	</div>
	<div class="w40 text-center">
		<h5><?= $clinicas->nomb_clin ?><br>CLÍNICA DENTAL</h5>
		<p>
			Dirección:<?= $clinicas->direc_clin ?> <br>
			Email: <?= $clinicas->email_clin ?>
		</p>
	</div>
	<div class="w30">
		<div class="Comp-Marco">
			<div class="Com-Marco-RUC">R.U.C: <?= $clinicas->ruc_clin ?></div>
			<div class="Com-Marco-Recibo">RECIBO DE CAJA</div>
			<div class="Com-Marco-Serie"><?= $comprobante->abreviatura ?>-<?= $comprobante->serie_com ?>-<?= $comprobante->secuencia_com ?></div>
		</div>
	</div>
</div>
<br><br>

<div class="Com-Datos">
	Datos Generales
</div>

<br>
<div class="w100">
	<div class="w50">
		<p><b>N° Historia Clínica:</b> <?= $comprobante->codi_pac ?></p>
		<p><b>Sr(a):</b> <?= $comprobante->nomb_pac.' '.$comprobante->apel_pac ?></p>
		<p><b>DNI:</b> <?= $comprobante->dni_pac ?></p>
		<p><b>Asunto:</b> <?= $comprobante->asunto_tra ?></p>
	</div>
	<div class="w50">
		<p><b>Fecha de Tratamiento:</b> <?= $comprobante->fecha_com ?></p>
		<p><b>Médico:</b> <?= $comprobante->nomb_med.' '.$comprobante->apel_med ?></p>
		<p><b>Tipo de Pago:</b> <?= ($comprobante->cod_tipopago==1)?'Pagos':'Contado' ?></p>
	</div>
</div>
<br>
<table class="table table-bordered table-condensed">
	<thead>
		<tr>
			<th>Código</th>
			<th>Procedimiento</th>
			<th>Prec. Unit.</th>
			<th>Cant.</th>
			<th>Dsct.</th>
			<th>Subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php  $subtotalAcumulado = 0; ?>
		<?php foreach ($comprobante->procedimientos as $p): ?>
		<?php $impuesto = $comprobante->igvparam_com ?>
		<tr>
			<td><?= $p->id_procedimiento ?></td>
			<td><?= $p->nombre ?></td>
				<?php 
					$precio_unitario = ($p->precio_unitario / $comprobante->num);
					$precio_unitario = ($precio_unitario * 100) / ($impuesto + 100);
				?>
			
			<td><?= round($precio_unitario,2) ?></td>
			<td><?= $p->cant_tradet ?></td>
			<td><?= $p->descuento_tradet ?>%</td>
			<?php $subtotal =  ($precio_unitario * $p->cant_tradet)?>
			<td><?= round($subtotal,2) ?></td>
			<?php $subtotalAcumulado += $subtotal ?>
		</tr>
		<?php endforeach ?>
		<tr>
			<td colspan="4"></td>
			<td><b>SubTotal</b></td>
			<td>
				<b><?= round($subtotalAcumulado,2) ?></b>
			</td>
		</tr>
		<tr>
			<td colspan="4"></td>
			<td><b>IGV</b></td>
			<td><b><?= ($impuesto!=0)?round($subtotalAcumulado * ($impuesto/100),2):'' ?></b></td>
		</tr>
		<tr>
			<td colspan="4"></td>
			<td><b>Total</b></td>
			<td><b><?= $comprobante->total_comp ?></b></td>
		</tr>
	</tbody>
</table>