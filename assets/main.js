/*==================================================
=            SERIALIZAR DATOS EN OBJETO            =
==================================================*/
$.fn.serializeObject = function()
{
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name] !== undefined) {
				if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
};
/*=====  End of SERIALIZAR DATOS EN OBJETO  ======*/

/*========================================
=            REDONDEAR NUMERO            =
========================================*/
function round(num, decimales = 2) {
	var signo = (num >= 0 ? 1 : -1);
	num = num * signo;
	if (decimales === 0) //con 0 decimales
			return signo * Math.round(num);
	// round(x * 10 ^ decimales)
	num = num.toString().split('e');
	num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
	// x * 10 ^ (-decimales)
	num = num.toString().split('e');
	signo = signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
	return signo.toFixed(2);
}

/*=====  End of REDONDEAR NUMERO  ======*/


$("[id^=Modal]").appendTo("body"); //ENVIAR MODAL AL FINAL DEL BODY


/*===========================================
=            SETEAR VALIDACIONES            =
===========================================*/
$.validator.setDefaults({
	errorPlacement: function ( error, element ) {
		// Add the `help-block` class to the error element
		error.addClass( "help-block" );
		if ( element.prop( "type" ) === "checkbox" ) {
			error.insertAfter( element.parent( "label" ) );
		} else {
			error.insertAfter( element );
		}
	},
	highlight: function ( element, errorClass, validClass ) {
		$( element ).parent().addClass( "has-error" ).removeClass( "has-success" );
	},
	unhighlight: function (element, errorClass, validClass) {
		$( element ).parent().addClass( "has-success" ).removeClass( "has-error" );
	}
});
/*=====  End of SETEAR VALIDACIONES  ======*/


/*==================================
=            DATEPICKER            =
==================================*/
$('.datepicker').datepicker({
	autoclose: true,
	language: "es",
	format: "yyyy-mm-dd",
	todayHighlight: true
});

$('.timepicker').timepicker({
	showInputs: false,
	stepping:15,
	showMeridian:false
});
/*=====  End of DATEPICKER  ======*/


/*===============================
=            SELECT2            =
===============================*/
$(".select2").select2();
/*=====  End of SELECT2  ======*/


/*===================================
=            HORA ACTUAL            =
===================================*/
function hora(){
	var f=new Date();
	cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
	return window.status =cad;
}
/*=====  End of HORA ACTUAL  ======*/


/*===================================================
=            ENVIAR FORMULIARIO POR AJAX            =
===================================================*/
function enviarFormulario($form,callback){
	var htmlSubmit = $($form).find('button:submit').html()
	$($form).ajaxSubmit({
		beforeSend: function() {
			$($form).find('button:submit').prop('disabled',true).html('<i class="fa fa-refresh fa-spin"></i> Procesando');
		},
		success : function(data){
			if (data.success) {
				if (typeof data.redirect != "undefined") {
					window.location.href = base_url+data.redirect;
				}else{
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success",
						timer: 2500
					});
					$($form).removeClass('has-success');
					$($form).find('.form-group').removeClass('has-success');
				}
				callback(data);
			}else{
				Swal.fire({
					title: "Error",
					text: "Ha ocurrido un error.",
					type: "error",
				});
			}
		},
		error : function(err){
			Swal.fire({
				title: "Error",
				text: "Ha ocurrido un error.",
				type: "error",
			});
		},
		dataType:'JSON',
		complete: function() {
			$($form).find('button:submit').prop('disabled',false).html(htmlSubmit);
		}
	});

}
/*=====  End of ENVIAR FORMULIARIO POR AJAX  ======*/


/*===================================================================
=            CONFIRMAR IR A METODO QUE ELIMINAR REGISTRO            =
===================================================================*/
$('tbody').on('click','a.confirm',function(e){
	 e.preventDefault(); // Prevent the href from redirecting directly
		var linkURL = $(this).attr("href");
		warnBeforeRedirect(linkURL);
});

function warnBeforeRedirect(linkURL) {
	Swal.fire({
		title: "Confirmar Eliminar",
		type: "warning",
		cancelButtonText:'Cancelar',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		html: "Si confirmas eliminar el registro has click en el boton OK. <br /> <span style='font-size:12px' class='text-warning'> <i class='fa fa-asterisk'></i>Los registros que están relacionados también se eliminarán.</span>"
	}).then((result) => {
		if (result.value) {
			window.location.href = linkURL;
		}
	})
}
/*=====  End of CONFIRMAR IR A METODO QUE ELIMINAR REGISTRO  ======*/


$(function(){
/*=======================================
=            CITAS REGISTRAR            =
=======================================*/

$('.filtrarMedicos').change(function(event) {
	let especialidad = $(this).val();
	$.ajax({
		url: base_url+'citas/registrar/getMedicos',
		type: 'POST',
		dataType: 'JSON',
		data: {'especialidad':especialidad}
	})
	.done(function(response) {
		let option = '';
		$.each(response, function(index, val) {
			 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
		});
		$('select[name=medico]').empty().html(option);
	});
});



$('#FormCitas').validate({
	rules: {
		especialidad:{required:true},
		medico:{required:true},
		fecha:{required:true}
	},
	submitHandler:function() {
		buscarCitas()
	}
});

$('#FormCitas input[name=fecha]').dateDropper();




function buscarCitas(){
	$.getJSON(base_url+'citas/registrar/getCitaDia', $('#FormCitas').serializeObject() , function(json, textStatus) {
		let encabezadoResultadoBusqueda = `
			<strong>Especialidad: </strong>${ $('#FormCitas select[name=especialidad] option:selected').text() } /
			<strong>Médico: </strong>${ $('#FormCitas select[name=medico] option:selected').text() } /
			<strong>Fecha </strong>${ $('#FormCitas input[name=fecha]').val() }
		`;
		$('.titulosBusqueda').removeClass('hidden').html(encabezadoResultadoBusqueda);
		$('input[name=busquedaEspecialidad]').val(json.especialidad);
		$('input[name=busquedaMedico]').val(json.medico);
		$('input[name=busquedaMedicoNombre]').val(json.medico_nombre);
		$('input[name=busquedaFecha]').val(json.fecha);
		$('#total-ocupados').html(json.ocupados);
		$('#total-disponibles').html(json.disponibles);
		$('#totales').removeClass('hidden');

		let tr = '';
		$.each(json.horas, function(index, val) {
			if (typeof val['id_paciente'] == "undefined") {
				tr += `
					<tr class="disponible" data-hora="${val['hora']}">
						<td>${val['hora']}</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>`;
			}else{
				tr += `
					<tr class="success ${val['fila']}">
						<td>${val['hora']}</td>
						<td>${val['id_paciente']}</td>
						<td>${val['paciente']}</td>
						<td>${val['id_cita']}</td>
						<td>${val['observacion']}</td>
						<td>${val['estado']}</td>
						<td>${val['btn-editar']}</td>
					</tr>`;
			}
		});
		$('#HorariosCita tbody').empty().html(tr);
	});
}

$('#HorariosCita tbody').on('dblclick', 'tr.disponible', function(event) {
	$('#FormAgendarCita')[0].reset();
	$('select[name=paciente]').select2('val','')
	$('#ModalAgendarCita').modal();	
	let fecha = $('input[name=busquedaFecha]').val();
	let hora = $(this).attr('data-hora');
	let especialidad = $('input[name=busquedaEspecialidad]').val();
	let medico = $('input[name=busquedaMedico]').val();
	let nombreMedico = $('input[name=busquedaMedicoNombre]').val();
	
	$('#AgendarNombreMedico').html(nombreMedico);
	$('#AgendarFecha').html(fecha);
	$('#AgendarHora').html(hora);
	$('#FormAgendarCita input[name=fecha]').val(fecha);
	$('#FormAgendarCita input[name=hora]').val(hora);
	$('#FormAgendarCita input[name=medico]').val(medico);
	$('#FormAgendarCita input[name=especialidad]').val(especialidad);

});

$('#ModalAgendarCita select[name=paciente]').select2({
	ajax: {
		delay: 500,
		url: base_url+'citas/registrar/getPacientes',
		dataType: 'json',
		data: function (params) {
			var queryParameters = {
				q: params.term
			}
			return queryParameters;
		},
		processResults: function (data) {
			return {
				results: data
			}
		},
		transport: function (params, success, failure) {
			if (typeof params['data']['q']  != "undefined") {
				if (params['data']['q'].length > 3) {
					var $request = $.ajax(params);
					$request.then(success);
					$request.fail(failure);
					return $request;
				}
			}
		}
	}
});

$('#FormAgendarCita').validate({
	rules: {
		paciente:{
			required:true,
			remote:{
				url: base_url+"citas/registrar/validaPacienteUnico",
				type: "POST",
				data: {
					paciente: function() {
						return $("#FormAgendarCita select[name=paciente]").val();
					},
					medico: function(){
						return $("#FormAgendarCita input[name=medico]").val();
					},
					fecha: function(){
						return $("#FormAgendarCita input[name=fecha]").val();
					}
				}
			}
		},
		motivo:{required:true},
		sede:{required:true}
	},
	messages:{
		paciente:{
			remote:'Este paciente ya tiene una cita agendada.'
		}
	},
	submitHandler:function() {
		let datos = enviarFormulario('#FormAgendarCita',function(r){
			$('#ModalAgendarCita').modal('hide');
			buscarCitas();
		});
		
	}
});

$('#HorariosCita tbody').on('click', 'button.editar', function(event) {
	let id = $(this).attr('data-id');
	$('#ModalEditarCita').modal();
	$.getJSON(base_url+'citas/registrar/getCita', {'id': id}, function(json, textStatus) {
		$('#FormEditarCita input[name=id]').val(json.codi_cit);
		$('#FormEditarCita input[name=fecha]').val(json.fech_cit.split(' ')[0]);
		$('#FormEditarCita input[name=hora]').val(json.fech_cit.split(' ')[1].substr(0,5));
		$('#FormEditarCita #NombrePaciente').html(json.nomb_pac+' '+json.apel_pac);
		$('#FormEditarCita select[name=sede]').val(json.cod_sede);
		$('#FormEditarCita select[name=codigo]').val(json.cod_citado);
		$('#FormEditarCita input[name=motivo]').val(json.motivo_consult);
		$('#FormEditarCita textarea[name=observacion]').val(json.obsv_cit);
		$('#FormEditarCita select[name=especialidadEditar]').val(json.cod_especialidad);
		$.ajax({
			url: base_url+'citas/registrar/getMedicos',
			type: 'POST',
			dataType: 'JSON',
			data: {'especialidad': json.cod_especialidad},
			success: function(resp){
				let option = '<option value="">Seleccione</option>';
				$.each(resp, function(index, val) {
					 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
				});
				$('select[name=medicoEditar]').empty().html(option);
				$('select[name=medicoEditar]').val(json.codi_med);
			}
		});
		
	});
});

$('#FormEditarCita').validate({
	ignore: [],
	rules: {
		id:{required:true},
		fecha:{required:true},
		hora:{required:true},
		especialidadEditar:{required:true},
		medicoEditar:{required:true},
		sede:{required:true},
		estado:{required:true},
		motivo:{required:true}
	},
	submitHandler:function() {
		let datos = enviarFormulario('#FormEditarCita',function(r){
			$('#ModalEditarCita').modal('hide');
			buscarCitas();
		});
	}
});

$('#FormEditarCita select[name=especialidadEditar]').change(function(event) {
	let especialidad = $(this).val();
	$.ajax({
		url: base_url+'citas/registrar/getMedicos',
		type: 'POST',
		dataType: 'JSON',
		data: {'especialidad': especialidad},
		success: function(resp){
			let option = '<option value="">Seleccione</option>';
			$.each(resp, function(index, val) {
				 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
			});
			$('select[name=medicoEditar]').empty().html(option);
		}
	});
});


/*=====  End of CITAS REGISTRAR  ======*/



/*===============================
=            AGENDA            =
===============================*/

function loadCalendario()
{
	var options = {
		events_source: base_url+"citas/agenda/calendario",
		tmpl_path: base_url+'assets/plugins/calendar/tmpls/',
		tmpl_cache: false,
		view: $('input[name=vista]:checked').val(),
		time_start: '00:00',
		time_end: '23:45',
		time_split: '15',
		language:'es-ES',
		weekbox:false,
		day: $('input[name=fecha]').val(),
		medico: $('#FormAgendaFiltro select[name=medico]').val(),
		especialidad: $('#FormAgendaFiltro select[name=especialidad]').val(),
		estado: $('#FormAgendaFiltro select[name=estado]').val(),
		modal: "#events-modal",
		modal_type: "ajax",
		modal_title: function(event) { 
			return event.title 
		},
		onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function(view) {
			$('.botones h4').text(this.getTitle());
			
			$('.checkbox input[data-calendar-view="' + view + '"]').prop('checked', true);
		}/*,
		classes: {
			months: {
				general: 'label'
			}
		}*/

	};

	var calendar = $("#calendar").calendar(options); 

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.checkbox input[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});

	$('#first_day').change(function(){
		var value = $(this).val();
		value = value.length ? parseInt(value) : null;
		calendar.setOptions({first_day: value});
		calendar.view();
	});

	$('#language').change(function(){
		calendar.setLanguage($(this).val());
		calendar.view();
	});

	$('#events-in-modal').change(function(){
		var val = $(this).is(':checked') ? $(this).val() : null;
		calendar.setOptions({modal: val});
	});
	$('#format-12-hours').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({format12: val});
		calendar.view();
	});
	$('#show_wbn').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({display_week_numbers: val});
		calendar.view();
	});
	$('#show_wb').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({weekbox: val});
		calendar.view();
	});
	$('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
		//e.preventDefault();
		//e.stopPropagation();
	});
	
}

$('#FormAgendaFiltro input[name=fecha]').dateDropper();

$('#FormAgendaFiltro').validate({
	rules: {
		especialidad:{required:true},
		medico:{required:true}
	},
	submitHandler:function() {
		loadCalendario();		
	}
});

if($('#FormAgendaFiltro')[0])
{
	loadCalendario();
}
/*=====  End of AGENDA  ======*/



/*===========================================
=            TRATAMIENTO - PANEL            =
===========================================*/
var TableTratamientosPanel =  $('#TableTratamientosPanel').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'tratamientos/panel/jsonTratamientos',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.estado = $("select[name=estado]").val();
			d.paciente = $("input[name=paciente]").val();
		}
	},
	"columns": [
		{"orderable":false,"className":'details-control'},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false}
	],
	"columnDefs": [
		{"width": "15%", "targets": 8 }
	]
});

$('#TableTratamientosPanel tbody').on('click', 'td.details-control', function () {
	var tr = $(this).closest('tr');
	var row = TableTratamientosPanel.row(tr);
	if (row.child.isShown()) {
		row.child.hide();
		tr.removeClass('shown');
		$(this).find('span').removeClass('fa-caret-down').addClass('fa-caret-right');
	}else{
		row.child(formatTratamientosDetalle(row.data())).show();
		tr.addClass('shown');
		$(this).find('span').removeClass('fa-caret-right').addClass('fa-caret-down');
	}
});

function formatTratamientosDetalle (d) {
	var folios = jQuery.parseJSON(d[9]);
	var table = `
	<h4><i class="fa fa-list" aria-hidden="true"></i> Detalle</h4>
	<table class="table table-bordered tabla-condensed table-hover">
								<thead>
									<tr class="btn-success">
										<th style="text-align: center">Procedimiento</th>
										<th style="text-align: center">Cant.</th>
										<th style="text-align: center">Precio Unit.</th>
										<th style="text-align: center">Descuento</th>
										<th style="text-align: center">Subtotal</th>
									<tr>
								</thead>`;
	$.each(folios, function(index, val) {
		table += `<tr>
								<td>${val['nombre']}</td>
								<td>${val['cant_tradet']}</td>
								<td>${val['preciounit_tradet']}</td>
								<td>${val['descuento_tradet']}%</td>
								<td>${val['subtotal_tradet']}</td>
								`;
	});
	table += '</table>';

	if (d[11]==1) { //CUOTAS
		var pagos = jQuery.parseJSON(d[10]);
		table += `<h4><i class="fa fa-cc-visa" aria-hidden="true"></i> Pagos cuotas</h4>
								<table class="table table-bordered tabla-condensed table-hover">
									<thead>
										<tr class="btn-danger">
											<th></th>
											<th style="text-align: center">N° Cuota</th>
											<th style="text-align: center">Fecha Registro</th>
											<th style="text-align: center">Fecha Vencimiento</th>
											<th style="text-align: center">Monto</th>
											<th style="text-align: center">Comprobante</th>
											<th></th>
										<tr>
									</thead>`;
		$.each(pagos, function(index, val) {
			table += `<tr>
									<td>${ (val['id_com'] != null)?'<button class="btn btn-xs btn-success"><i class="fa fa-check"></i></button>':'' }</td>
									<td>${ val['num_pago'] }</td>
									<td>${ val['fecharegistro_pago'] }</td>
									<td>${ val['fechavencimiento_pago'] }</td>
									<td>${ val['monto_pago']}</td>
									<td>${ (val['id_com']!=null)?val['abreviatura']+'-'+val['serie_com']+'-'+val['secuencia_com']:'' }</td>
									<td>${ (val['id_com']!=null)?'<a target="_blank" href="'+path+'tratamientos/panel/imprimirComprobante/'+val['id_com']+'" class="btn btn-info btn-xs"><i class="fa fa-print"></i></a>':'' }</td>
									`;
		});
		table += '</table>';
	}

	if (d[11]==2) {
		var pago = jQuery.parseJSON(d[10])[0];
		table += `<h4>Pago Contado</h4>
							<table class="table table-bordered tabla-condensed table-hover">
								<thead>
									<tr class="success">
										<th>Fecha Registro</th>
										<th>Monto</th>
										<th>Comprobante</th>
										<th></th>
									<tr>
								</thead>
								<tbody>
									<tr>
										<td>${pago.fecharegistro_pago}</td>
										<td>${pago.total_comp}</td>
										<td>${ (pago.id_com!=null)?pago.abreviatura+'-'+pago.serie_com+'-'+pago.secuencia_com:'' }</td>
										<td><a target="_blank" href="${path+'tratamientos/panel/imprimirComprobante/'+pago.id_com}" class="btn btn-info btn-xs"><i class="fa fa-print"></i></a></td>
									<tr>
								</tbody>
								`;
	}
	return table;
}

$('#TratamientosFormBusqueda').validate({
	rules:{
		desde:{required:true},
		hasta:{required:true}
	},
	submitHandler:function() {
		$('#TableTratamientosPanel').DataTable().ajax.reload();
	}
});

$('#TableTratamientosPanel tbody').on('click', '.tratamiento-enviar-email', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Esta seguro de enviar el email?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'tratamientos/panel/enviarEmail', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire(
						'Buen trabajo!',
						'Se envió correctamente el email',
						'success'
					);
				}else{
					Swal.fire({
						title: "Error",
						text: "Ha ocurrido un error",
						type: "error",
					});
				}
			});
		}
	})
});

$('#TableTratamientosPanel tbody').on('click', '.tratamiento-anular', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No, Cancelar',
		confirmButtonText:'Si, Anular',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Esta seguro de anular el tratamiento?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'tratamientos/panel/anularTratamiento', {id}, function(json, textStatus) {
			if (json.success) {
				Swal.fire(
					'Buen trabajo!',
					'Se anuló correctamente el tratamiento',
					'success'
				);
				$('#TableTratamientosPanel').DataTable().ajax.reload();
			}else{
				Swal.fire({
					title: "Error",
					text: "Para anular el tratamiento es necesario anular los " + json.numero_comprobantes + " comprobantes.",
					type: "error",
				});
			}
		});
		}
	});
});

$('#TratamientosImprimirLista').click(function(event) {
	let form = $('#TratamientosFormBusqueda').serializeObject();
	let params = $.param(form);
	$(this).attr('href',path+'tratamientos/panel/imprimirListaTratamientos?'+params);
});

$('#TratamientoAgregarProcedimiento').click(function(event) {
	$('#ModalTratamientoProcedimientos').modal();
});

var TableTratamientoProcedimientosModal = $('#TableTratamientoProcedimientosModal').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"iDisplayLength": 5,
	"aLengthMenu": [[5,10, 50, 100], [10, 50, 100]],
	"aaSorting": [[0, 'asc']],
	"columns": [
		null,
		null,
		{ "orderable": false },
		{ "orderable": false },
		{ "orderable": false }
	],
	initComplete: function(){
		$('#TableTratamientoProcedimientosModal tfoot th').each( function (key,val) {
			if (key < ($('#TableTratamientoProcedimientosModal tfoot th').length - 2)) {
				var title = $(this).text();
				if (title != ''){	
					$(this).html( '<input type="text" placeholder="Filtrar '+title+'" />' );
				}
				if ($(this).hasClass('hide')) {
					TableTratamientoProcedimientosModal.column($(this).index()).visible( false );
				}
			}
		});

		TableTratamientoProcedimientosModal.columns().every( function () {
			var that = this;
			$('input', this.footer()).on( 'keyup change', function () {

				if (that.search() !== this.value) {
					that
						.search( this.value )
						.draw();
				}
			});
		});
	}
});



$('.addProcedimiento').click(function(event) {
	let id = $(this).data('id');
	let cant = $('#proc-cant-'+id).val();
	$.getJSON(path+'tratamientos/panel/getProcedimiento', {id, cant}, function(json, textStatus) {
		var id_array = [];
		if ($('#TratamientoBodyProcedimiento tr').length > 0) {
			$('#TratamientoBodyProcedimiento tr').each(function(){
				var data_id = parseInt($(this).data('id'));
				id_array.push(data_id);
			});
			if (id_array.includes(parseInt(json.id_procedimiento))){
				$('#proc-'+json.id_procedimiento).remove();
			}
		}

		let tr = `
			<tr id=proc-${json.id_procedimiento} data-id="${json.id_procedimiento}">
				<input class="valores" type="hidden" name="id[]" value="${json.id_procedimiento}"/>
				<td>${json.id_procedimiento}</td>
				<td>${json.nombre}</td>
				<td><input type="number" name="cant[]" class="form-control" value="${json.cant}" value="1" min="1" step="1"/></td>
				<td>${json.prec_procedimiento}</td>
				<td><input type="text" name="desc[]" class="form-control porcentaje" value="0" /></td>
				<td>${ json.total }</td>
				<td><button type="button" data-id="${json.id_procedimiento}" class="removeProcedimiento btn btn-ico btn-xs btn-danger"><i class="fa fa-close"></i></button></td>
			</tr>
		`;

		$('#TratamientoBodyProcedimiento').append(tr);
		$(".porcentaje").inputmask("decimal",{
			placeholder: "0",
			digits: 2,
			digitsOptional: true,
			integerDigits: 2,
			suffix: "%",
			rightAlign: false
		});
		calcularTotalProcedimiento();
	});
});

$('#TratamientoBodyProcedimiento').on('click', '.removeProcedimiento', function(event) {
	event.preventDefault();
	$('#proc-'+$(this).data('id')).remove();
	calcularTotalProcedimiento();
});

function calcularTotalProcedimiento()
{
	var totalProcedimiento = 0;
	$('#TratamientoBodyProcedimiento tr').each(function(){
	 let cant = parseFloat($(this).find('input[name="cant[]"]').val());
	 let desc = parseFloat($(this).find('input[name="desc[]"]').val().replace('%',''));
	 let prec = parseFloat($(this).find('td').eq(3).text());
	 var total = (cant * prec);
	 if (desc>0) {
		total = total - (total * (desc/100));
	 }

	 $(this).find('td').eq(5).text(round(total,2));
	 totalProcedimiento += total;
	});
	
	$('#TableTratamientoProcedimiento tfoot').removeClass('hidden');
	$('#TableTratamientoProcedimiento tfoot tr th').eq(1).text(round(totalProcedimiento,2));
}

$(".porcentaje").inputmask("decimal",{
		placeholder: "0",
		digits: 2,
		digitsOptional: true,
		integerDigits: 2,
		suffix: "%",
		rightAlign: false
});


$('#TratamientoBodyProcedimiento').on('keyup mouseup, focusout', 'input[name="desc[]"]', function(event) {
	event.preventDefault();
	calcularTotalProcedimiento();
});

$("#TratamientoBodyProcedimiento").on('keyup mouseup','input[name="cant[]"]', function () {
	 calcularTotalProcedimiento();
});

$('#TratamientosFormNuevo').validate({
	ignore: [],
	rules: {
		especialidad:{required:true},
		medico:{required:true},
		paciente:{required:true},
		asunto:{required:true}
	},
	submitHandler:function() {
		if ($('#TratamientosFormNuevo input[name^="id"]').length == 0) {
			Swal.fire({
				title: "Error",
				text: "No ha elegido ningun procedimiento.",
				type: "error",
			});
			return;
		}

		let datos = enviarFormulario('#TratamientosFormNuevo',function(r){
			
		});

	}
});

$('#TratamientosFormPagoNuevo select[name=documento]').change(function(event) {
	tratamientoCalcularTotal();
	getSerieSecuenciaDocumento($(this).val());
});

$('#TratamientosFormPagoNuevo select[name=condicionPago]').change(function(event) {
	if ($(this).val()=='Contado') {
		$('#TableCuotas, #Legend-Cuotas, #TratamientoFormPagoCuotas').addClass('hidden');
		$('#TableContado, #Legend-Contado').removeClass('hidden');
	}else{
		$('input[name=subtotal], input[name=IGV], input[name=total]').val('');
		$('#TableCuotas, #Legend-Cuotas, #TratamientoFormPagoCuotas').removeClass('hidden');
		$('#TableContado, #Legend-Contado').addClass('hidden');
	}
	tratamientoCalcularTotal();
});

$('#TratamientoPagosCalcularCuotas').click(function(event) {
	$('input[name=subtotal], input[name=IGV], input[name=total]').val('');
	let tratamiento = $('#TratamientosFormPagoNuevo input[name=tratamiento]').val();
	let peridiocidad = $('#TratamientosFormPagoNuevo select[name=peridiocidad]').val();
	let numCuotas = $('#TratamientosFormPagoNuevo input[name=numCuotas]').val();
	let fechaCuota = $('#TratamientosFormPagoNuevo input[name=fechaCuota]').val();
	$.getJSON(path+'tratamientos/panel/getPagoCuotas', {tratamiento,peridiocidad,numCuotas,fechaCuota}, function(json, textStatus) {
		$('#TratamientosFormPagoNuevo input[name=cuota]').val(json[1].monto);
		var tr = '';
		$.each(json, function(index, val) {
			tr += `
			<tr>
				<td>${val['marcar']}</td>
				<td>${val['num']}</td>
				<td>${val['fecha_registro']}</td>
				<td>${val['fecha_vencimiento']}</td>
				<td>${val['monto']}</td>
			</tr>
			`;
		});
		$('#TratamientosFormPagoNuevo #TableCuotas tbody').html(tr);
	});
});

$('#TratamientosFormPagoNuevo input[name=montoRecibido]').focusout(function(event) {
	let montoRecibido = parseFloat($(this).val());
	let total = parseFloat($('#TratamientosFormPagoNuevo input[name=total]').val());
	if (!isNaN(total)) {
		if (montoRecibido > 0) {
			let vuelto = montoRecibido - total;
			$('#TratamientosFormPagoNuevo input[name=vuelto]').val(round(vuelto,2));
		}
	}
});

$('#TableCuotas').on('click', 'input[name="pago[]"]', function(event) {
	tratamientoCalcularTotal();
});

function tratamientoCalcularTotal()
{
	if ($('#TratamientosFormPagoNuevo select[name=condicionPago]').val()=='Contado') {
		var subtotal = parseFloat($('#TratamientosFormPagoNuevo input[name=pago]').val());
	}else{
		if ($('#TratamientosFormPagoNuevo input[name="pago[]"]:checked').length > 0) {
			var num = parseFloat($('#TratamientosFormPagoNuevo input[name="pago[]"]:checked').length);
			var cuota = parseFloat($('#TratamientosFormPagoNuevo input[name=cuota]').val());
			var subtotal = num *  cuota;
		}else{
			$('input[name=subtotal], input[name=IGV], input[name=total]').val('');
			$('input[name=montoRecibido], input[name=vuelto]').val('');
			return;
		}
	}
	if ($('#TratamientosFormPagoNuevo select[name=documento]').val()=='1') {
		subtotal = (subtotal * 100) / (parseFloat($('input[name=igvValor]').val()) + 100);
		var IGV = subtotal * (parseFloat($('input[name=igvValor]').val()) / 100);
	}else{
		var IGV = 0;
	}
	let total = subtotal + IGV;
	
	$('#TratamientosFormPagoNuevo input[name=IGV]').val(round(IGV,2));
	$('#TratamientosFormPagoNuevo input[name=subtotal]').val(round(subtotal,2));
	$('#TratamientosFormPagoNuevo input[name=total]').val(round(total,2));
}

$.validator.addMethod("montoRecibidoMayorTotal",function (value, element) {
	var montoRecibido = parseFloat(value);
	var total = parseFloat($("#TratamientosFormPagoNuevo input[name=total]").val());
	if (!isNaN(total)) {
		if (montoRecibido >= total) {
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}, 'Debe ser mayor o igual que total');

$('#TratamientosFormPagoNuevo').validate({
	rules: {
		montoRecibido:{required:true, number:true, montoRecibidoMayorTotal:true },
		vuelto:{required:true},
		subtotal:{required:true},
		IGV:{required:true},
		total:{required:true}
	},
	submitHandler:function() {
		if ($('#TratamientosFormPagoNuevo select[name=condicionPago]').val()=='Cuotas') {
			if ($('input[name="pago[]"]:checked').length == 0) {
				Swal.fire({
					title: "Error",
					text: "Debe marcar almenos una cuota",
					type: "error",
				});
				return;
			}
		}

		Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Generar Pago?"
		}).then((result) => {
			if (result.value) {
				enviarFormulario('#TratamientosFormPagoNuevo',function(r){
				});
			}
		})
		
	}
});


$('#TablePagoCuotas input[name="pago[]"]').click(function(event) {
	tratamientoCalcularPagoCuota();
});

$('#TratamientosFormPagosCuotas select[name=documento]').change(function(event) {
	tratamientoCalcularPagoCuota();
	getSerieSecuenciaDocumento($(this).val());
});

function tratamientoCalcularPagoCuota()
{
	if ($('input[name="pago[]"]:checked').length > 0) {
		var num = parseFloat($('input[name="pago[]"]:checked').length);
		var cuota = parseFloat($('input[name=cuota]').val());
		var subtotal = num *  cuota;
	}else{
		$('input[name=subtotal], input[name=IGV], input[name=total]').val('');
		$('input[name=montoRecibido], input[name=vuelto]').val('');
		return;
	}
	if ($('select[name=documento]').val()=='1') {
		subtotal = (subtotal * 100) / (parseFloat($('input[name=igvValor]').val()) + 100);
		var IGV = subtotal * (parseFloat($('input[name=igvValor]').val()) / 100);
	}else{
		var IGV = 0;
	}
	let total = subtotal + IGV;
	
	$('#TratamientosFormPagosCuotas input[name=IGV]').val(round(IGV,2));
	$('#TratamientosFormPagosCuotas input[name=subtotal]').val(round(subtotal,2));
	$('#TratamientosFormPagosCuotas input[name=total]').val(round(total,2));
}

$('#TratamientosFormPagosCuotas input[name=montoRecibido]').focusout(function(event) {
	let montoRecibido = parseFloat($(this).val());
	let total = parseFloat($('#TratamientosFormPagosCuotas input[name=total]').val());
	if (!isNaN(total)) {
		if (montoRecibido > 0) {
			let vuelto = montoRecibido - total;
			$('#TratamientosFormPagosCuotas input[name=vuelto]').val(round(vuelto,2));
		}
	}
});

$.validator.addMethod("montoRecibidoMayorTotalCuota",function (value, element) {
	var montoRecibido = parseFloat(value);
	var total = parseFloat($("#TratamientosFormPagosCuotas input[name=total]").val());
	if (!isNaN(total)) {
		if (montoRecibido >= total) {
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}, 'Debe ser mayor o igual que total');


$('#TratamientosFormPagosCuotas').validate({
	rules: {
		montoRecibido:{required:true, number:true, montoRecibidoMayorTotalCuota:true },
		vuelto:{required:true},
		subtotal:{required:true},
		IGV:{required:true},
		total:{required:true}
	},
	submitHandler:function() {
		if ($('#TratamientosFormPagosCuotas select[name=condicionPago]').val()=='Cuotas') {
			if ($('input[name="pago[]"]:checked').length == 0) {
				Swal.fire({
					title: "Error",
					text: "Debe marcar almenos una cuota",
					type: "error",
				});
				return;
			}
		}

		Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Generar Pago?"
		}).then((result) => {
			if (result.value) {
				enviarFormulario('#TratamientosFormPagosCuotas',function(r){})
			}
		})
	}
});

function getSerieSecuenciaDocumento(documento)
{
	$.getJSON(path+'tratamientos/panel/getDocumento', {documento}, function(json, textStatus) {
		$('input[name=serie]').val(json.serie);
		$('input[name=secuencia]').val(json.secuencia);
	});
}
getSerieSecuenciaDocumento($('select[name=documento]').val());

$('select[name=tipoPago]').change(function(event) {
	$('select[name=tipoTarjeta]').val('');
	if ($(this).val()!=4) {
		$('select[name=tipoTarjeta]').prop('disabled',false);
	}else{
		$('select[name=tipoTarjeta]').prop('disabled',true);
	}
});

/*=====  End of TRATAMIENTO - PANEL  ======*/


/*====================================
=            COMPROBANTES            =
====================================*/
var TableTratamientosComprobantes =  $('#TableTratamientosComprobantes').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'tratamientos/comprobantes/jsonComprobantes',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.paciente = $("input[name=paciente]").val();
			d.estado = $("select[name=estado]").val();
		}
	},
	"columns": [
		{"orderable":false,"className":'details-control'},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true,"visible":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false}
	],
	"columnDefs": [
		{"width": "15%", "targets": 9 }
	],
	"initComplete": function(settings, json) {
		totalComprobantes(json.total);
	}
});

$('#TableTratamientosComprobantes tbody').on('click', 'td.details-control', function () {
	var tr = $(this).closest('tr');
	var row = TableTratamientosComprobantes.row(tr);
	if (row.child.isShown()) {
		row.child.hide();
		tr.removeClass('shown');
		$(this).find('span').removeClass('fa-caret-down').addClass('fa-caret-right');
	}else{
		row.child(formatTratamamientoComprobante(row.data())).show();
		tr.addClass('shown');
		$(this).find('span').removeClass('fa-caret-right').addClass('fa-caret-down');
	}
});

function formatTratamamientoComprobante(d){
	var comprobante = jQuery.parseJSON(d[10]);
	var impuesto = parseFloat(comprobante.igvparam_com);
	var table = `
	<h4> <i class="fa fa-list" aria-hidden="true"></i> Procedimientos</h4>
	<table class="table table-bordered tabla-condensed table-hover">
		<thead>
			<tr class="btn-success">
				<th style="text-align: center">Código</th>
				<th style="text-align: center">Procedimiento</th>
				<th style="text-align: center">Prec. Unit.</th>
				<th style="text-align: center">Cant.</th>
				<th style="text-align: center">Dsct.</th>
				<th style="text-align: center">Subtotal</th>
			</tr>
		</thead>
		<tbody>`;
	var subtotalacumulado = 0;
	var tr = '';
	$.each(comprobante.procedimientos, function(index, val) {
		var precio_unitario = (parseFloat(val['preciounit_tradet']) / parseFloat(comprobante.num));
		precio_unitario = (precio_unitario * 100) / (impuesto + 100);
		var subtotal = parseFloat(precio_unitario) * parseFloat(val['cant_tradet']);
		subtotalacumulado += subtotal;
		tr += `
			<tr>
				<td>${ val['id_procedimiento'] }</td>
				<td>${ val['nombre'] }</td>
				<td>${ round(precio_unitario) }</td>
				<td>${ val['cant_tradet'] }</td>
				<td>${ val['descuento_tradet'] }%</td>
				<td>${ round(subtotal,2) }</td>
			</tr>
		`;
	});
	tr += `
		<tr>
			<td colspan="4"></td>
			<td><b>SubTotal :</b></td>
			<td>
				<b>${ round(subtotalacumulado,2) }</b>
			</td>
		</tr>
		<tr>
			<td colspan="4"></td>
			<td><b>IGV :</b></td>
			<td><b>${ (comprobante.igv_com > 0)?round((subtotalacumulado*(impuesto/100)),2):'0.00'  }</b></td>
		</tr>
		<tr>
			<td colspan="4"></td>
			<td><b>Total :</b></td>
			<td><b>${ comprobante['total_comp'] }</b></td>
		</tr>
	`; 
	table += tr;
	table += `
		</tbody>
	</table>`;
	return table;
}

$('#TratamientosFormComprobantesBusqueda').validate({
	rules:{
		desde:{required:true},
		hasta:{required:true},
		estado:{required:true}
	},
	submitHandler:function() {
		$('#TableTratamientosComprobantes').DataTable().ajax.reload(function(json){
			totalComprobantes(json.total);
		});
		if ($("select[name=estado]").val()=='Emitido' || $("select[name=estado]").val()=='Anulado') {
			TableTratamientosComprobantes.column(0).visible(true);
			TableTratamientosComprobantes.column(1).visible(true);
			TableTratamientosComprobantes.column(3).visible(false);
			TableTratamientosComprobantes.column(4).visible(true);
			TableTratamientosComprobantes.column(8).visible(true);
		}else{
			TableTratamientosComprobantes.column(0).visible(false);
			TableTratamientosComprobantes.column(1).visible(false);
			TableTratamientosComprobantes.column(3).visible(true);
			TableTratamientosComprobantes.column(4).visible(false);
			TableTratamientosComprobantes.column(8).visible(false);
		}
	}
});

function totalComprobantes(total){
	$('#TotalComprobante>strong>span').show().html(total);
}

$('#TratamientoImprimirListaComprobantes').click(function(event) {
	let form = $('#TratamientosFormComprobantesBusqueda').serializeObject();
	let params = $.param(form);
	$(this).attr('href',path+'tratamientos/comprobantes/imprimirLista?'+params);
});

$('#TableTratamientosComprobantes tbody').on('click', '.anular-comprobante', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No, Cancelar',
		confirmButtonText:'Si, Anular',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular Comprobante?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'tratamientos/comprobantes/anularcomprobante', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire(
						'Buen trabajo!',
						'Se anuló correctamente el comprobante',
						'success'
					);
					$('#TableTratamientosComprobantes').DataTable().ajax.reload();
				}else{
					Swal.fire({
						type: 'error',
						title: 'Oops...',
						text: 'Ocurrio un error!'
					})
				}
			});
		}
	});
});
/*=====  End of COMPROBANTES  ======*/

/*=============================================
=            HISTORIA - MOVIMIENTO            =
=============================================*/
$('#TableHistoriaMovimiento').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10,25, 50, 100, -1], [10,25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonHistoriaClinica',
		"type": "POST",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.nombresApellidos = $("input[name=nombresApellidos]").val();
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false}
	],
	"columnDefs": [
		{"width": "15%", "targets": 6 }
	]
});

$('#HistoriaMovimientoBusqueda').validate({
	submitHandler:function() {
		$('#TableHistoriaMovimiento').DataTable().ajax.reload();
	}
});

$('#HistoriaMenu a').click(function(event) {
	event.preventDefault();
	$(this).siblings('a').removeClass('active');
	$(this).addClass('active');
	$('#HistoriaContenido .panel').hide();
	var id = $(this).data('id');
	$('#HistoriaContenido #'+id).show();
});

$('#FormHistoriaMovimientoDatosPaciente select[name=departamento]').change(function(event) {
	getProvinciasHistoriaPaciente();
});

$('#FormHistoriaMovimientoDatosPaciente select[name=provincia]').change(function(event) {
	getDistritosHistoriaPaciente();
});

function getProvinciasHistoriaPaciente()
{
	$('#FormHistoriaMovimientoDatosPaciente select[name=provincia]').prop('disabled',true);
	let departamento = $('#FormHistoriaMovimientoDatosPaciente select[name=departamento]').val();
	$.getJSON(path+'mantenimiento/paciente/getProvincias', {'departamento':departamento}, function(json, textStatus) {
		let option = '';
		$.each(json, function(index, val) {
			 option += `<option value="${val['provincia_id']}">${val['provincia_nombre']}</option>`;
		});
		$('#FormHistoriaMovimientoDatosPaciente select[name=provincia]').html(option).prop('disabled',false)
		getDistritosHistoriaPaciente();
	});
}

function getDistritosHistoriaPaciente()
{
	$('#FormHistoriaMovimientoDatosPaciente select[name=distrito]').prop('disabled',true);
	let provincia = $('#FormHistoriaMovimientoDatosPaciente select[name=provincia]').val();
	$.getJSON(path+'mantenimiento/paciente/getDistritos', {'provincia':provincia}, function(json, textStatus) {
		let option = '';
		$.each(json, function(index, val) {
			 option += `<option value="${val['distrito_id']}">${val['distrito_nombre']}</option>`;
		});
		$('#FormHistoriaMovimientoDatosPaciente select[name=distrito]').html(option).prop('disabled',false);
	});
}


$('#TableHistoriaMovimientoAlergias').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonAlergias',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		{"orderable":false}
	]
});


$('#FormHistoriaMovimientoAgregarAlergia').validate({
	rules:{
		alergia:{required:true},
	},
	submitHandler:function() {
		$('#ModalAgregarAlergia').modal('hide');
		enviarFormulario('#FormHistoriaMovimientoAgregarAlergia',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoAlergias').DataTable().ajax.reload();
				$('#FormHistoriaMovimientoAgregarAlergia select[name=alergia]').val('');
				$('#FormHistoriaMovimientoAgregarAlergia input[name=observacion]').val('');
			}
		})
	}
});


$('#TableHistoriaMovimientoTratamiento').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonHistratamiento',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false}
	]
});



$('#TableHistoriaMovimientoEvolucion').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonEvolucion',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false}
	]
});


$('#FormHistoriaMovimientoAgregarEvolucion').validate({
	rules:{
		especialidad:{required:true},
		medico:{required:true},
		fecha_registro:{required:true},
		evolucion:{required:true}
	},
	submitHandler:function() {
		$('#ModalAgregarEvolucion').modal('hide');
		enviarFormulario('#FormHistoriaMovimientoAgregarEvolucion',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoEvolucion').DataTable().ajax.reload();
				$('#FormHistoriaMovimientoAgregarEvolucion select[name=especialidad]').select2('val','');
				$('#FormHistoriaMovimientoAgregarEvolucion select[name=medico]').select2('val','');
				$('#FormHistoriaMovimientoAgregarEvolucion datepicker[name=fecha_evolucion]').datepicker('setDate',null);
				$('#FormHistoriaMovimientoAgregarEvolucion textarea[name=evolucion]').val('');
				
			
			}


		})
	}
});

function getMedicosPorEspecialidadSelect2($esp,$selectMedico)
{
	var especialidad = $esp;
	$.ajax({
		url: base_url+'historia/movimiento/getMedicos',
		type: 'POST',
		dataType: 'JSON',
		data: {'especialidad':especialidad}
	})
	.done(function(response) {
		$($selectMedico).select2('val','');
		$($selectMedico).select2({
		    data: response,
		});
	});
}



$('#TableHistoriaMovimientoEvolucion').on('click', '.editar-evolucion', function(event) {
	event.preventDefault();
	console.log('esto aqui');
	var id = $(this).data('id');
	$.getJSON(path+'historia/movimiento/getEvolucion', {id}, function(json, textStatus) {
		
		$('#FormHistoriaMovimientoEditarEvolucion select[name=especialidad]').val(json.cod_especialidad);
		$.ajax({
			url: base_url+'historia/movimiento/getMedicosHistoria',
			type: 'POST',
			dataType: 'JSON',
			data: {'especialidad': json.cod_especialidad},
			success: function(resp){
				let option = '<option value="">Seleccione</option>';
				$.each(resp, function(index, val) {
					 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
				});
				$('#FormHistoriaMovimientoEditarEvolucion select[name=medico]').empty().html(option);
				$('#FormHistoriaMovimientoEditarEvolucion select[name=medico]').val(1);
			}
		});
		
		$('#FormHistoriaMovimientoEditarEvolucion input[name=id]').val(json.pacevol_id);
		$('#FormHistoriaMovimientoEditarEvolucion datepicker[name=fecha_evolucion]').val(json.fecha_evolucion);
		$('#FormHistoriaMovimientoEditarEvolucion textarea[name=evolucion]').val(json.pacevol_descripcion);
		$('#FormHistoriaMovimientoEditarAlergia textarea[name=observacion]').val(json.pacale_observacion);
	});
});

$('#FormHistoriaMovimientoEditarEvolucion').validate({
	ignore: [],
	rules:{
		id:{required:true},
		especialidad:{required:true},
		medico:{required:true},
		fecha_registro:{required:true},
		evolucion:{required:true}
	},
	submitHandler:function() {
		$('#ModalEditarEvolucion').modal('hide');
		enviarFormulario('#FormHistoriaMovimientoEditarEvolucion',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoEvolucion').DataTable().ajax.reload();
				$('#FormHistoriaMovimientoEditarEvolucion select[name=especialidad]').select2('val', '');
				$('#FormHistoriaMovimientoEditarEvolucion select[name=medico]').select2('val', '');
				$('#FormHistoriaMovimientoEditarEvolucion datepicker[name=fecha_evolucion]').datepicker('setDate',null);
				$('#FormHistoriaMovimientoEditarEvolucion textarea[name=evolucion]').val('');
			}
		})
	}
});


$('#TableHistoriaMovimientoEvolucion').on('click', '.anular-evolucion', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular evolucion?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'historia/movimiento/anularEvolucion', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableHistoriaMovimientoEvolucion').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});



$('#FormHistoriaMovimientoDatosPaciente').validate({
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoDatosPaciente',function(json){
		})
	}
});

$('#FormHistoriaMovimientoPacienteEnfermedad').validate({
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoPacienteEnfermedad',function(json){
		})
	}
});

$('#FormHistoriaMovimientoPacienteConsulta').validate({
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoPacienteConsulta',function(json){
		})
	}
});

$('#FormHistoriaMovimientoPacienteExploracion').validate({
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoPacienteExploracion',function(json){
		})
	}
});



$('#FormHistoriaMovimientoPacienteConsulta input[type=radio]').change(function(event) {
	var textarea = $(this).parent().parent().parent().next().find('textarea');
	var valor = $(this).val();
	if (valor == '0') {
		textarea.prop('disabled',true);
	}
	if (valor == '1') {
		textarea.prop('disabled',false);
	}
});

$('#TableHistoriaMovimientoAlergias').on('click', '.editar-alergia', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.getJSON(path+'historia/movimiento/getAlergia', {id}, function(json, textStatus) {
		$('#FormHistoriaMovimientoEditarAlergia input[name=id]').val(json.pacale_id);
		$('#FormHistoriaMovimientoEditarAlergia select[name=alergia]').val(json.cod_ale);
		$('#FormHistoriaMovimientoEditarAlergia textarea[name=observacion]').val(json.pacale_observacion);
	});
});

$('#FormHistoriaMovimientoEditarAlergia').validate({
	rules:{
		alergia:{required:true},
		id:{required:true},
	},
	submitHandler:function() {
		$('#ModalEditarAlergia').modal('hide');
		enviarFormulario('#FormHistoriaMovimientoEditarAlergia',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoAlergias').DataTable().ajax.reload();
				$('#FormHistoriaMovimientoEditarAlergia select[name=alergia]').val('');
				$('#FormHistoriaMovimientoEditarAlergia input[name=observacion]').val('');
			}
		})
	}
});

$('#TableHistoriaMovimientoAlergias').on('click', '.anular-alergia', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular alergia?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'historia/movimiento/anularAlergia', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableHistoriaMovimientoAlergias').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});





$('#TableHistoriaMovimientoDiagnostico').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonDiagnostico',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false}
	]
});



$('#FormHistoriaMovimientoAgregarDiagnostico').validate({
	ignore: [],
	rules:{
		diagnostico01:{required:true},
	},
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoAgregarDiagnostico',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoDiagnostico').DataTable().ajax.reload();
			}
			$('#ModalAgregarDiagnostico').modal('hide');
			$('#FormHistoriaMovimientoAgregarDiagnostico select[name=diagnostico01]').select2('val', '');

		})
	}
});


$('#TableHistoriaMovimientoDiagnostico').on('click', '.editar-diagnostico', function(event) {
	event.preventDefault();
	//$('input[name=hora]').val(hora());
	var id = $(this).data('id');
	$.getJSON(path+'historia/movimiento/getDiagnosticos', {id}, function(json, textStatus) {
		$('#FormHistoriaMovimientoEditarDiagnostico input[name=id]').val(json.pacdiag_id);
		$('#FormHistoriaMovimientoEditarDiagnostico select[name=diagnostico01]').select2('val',json.codi_enf01);

	});
});

$('#FormHistoriaMovimientoEditarDiagnostico').validate({
	ignore: [],
	rules:{

		diagnostico01:{required:true}
	},
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoEditarDiagnostico',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoDiagnostico').DataTable().ajax.reload();
			}
			$('#ModalEditarDiagnostico').modal('hide');
			$('#FormHistoriaMovimientoEditarDiagnostico select[name=diagnostico01]').select2('val', '');
		})
	}
});

$('#TableHistoriaMovimientoDiagnostico').on('click', '.anular-diagnostico', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular receta?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'historia/movimiento/anularDiagnostico', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableHistoriaMovimientoDiagnostico').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});


$('#TableHistoriaMovimientoPlacas').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonPlacas',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		{"orderable":false},
		{"orderable":false}
	]
});

$('#ButtonAgregarPlaca').click(function(event) {
	$('#progress .progress-bar, #files').hide();
});

$('#SubirPlaca').fileupload({
  url: path+'historia/movimiento/subir',
  dataType: 'json',
  done: function (e, data) {
  	var image = `<image src="${ path+'assets/uploads/placas/thumbs/'+data.result.name}">`;
  	$('#files').show().html(image);
  	$('#FormHistoriaMovimientoAgregarPlaca input[name=archivo]').val(data.result.name);
  },
  progressall: function (e, data) {
    var progress = parseInt(data.loaded / data.total * 100, 10);
    $('#progress .progress-bar').show();
    $('#progress .progress-bar').css(
      'width',
      progress + '%'
    );
  }
}).prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled');



$('#FormHistoriaMovimientoAgregarPlaca').validate({
	rules:{
		nombre:{required:true}
	},
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoAgregarPlaca',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoPlacas').DataTable().ajax.reload();
			}
			$('#ModalAgregarPlaca').modal('hide');
			$('#FormHistoriaMovimientoAgregarPlaca input[name=nombre]').val('');
			$('#FormHistoriaMovimientoAgregarPlaca texarea[name=notas]').val('');
			$('.pekecontainer').empty();
		})
	}
});


$('#SubirPlacaEditar').fileupload({
  url: path+'historia/movimiento/subir',
  dataType: 'json',
  done: function (e, data) {
  	var image = `<image src="${ path+'assets/uploads/placas/thumbs/'+data.result.name}">`;
  	$('#filesEditar').show().html(image);
  	$('#FormHistoriaMovimientoEditarPlaca input[name=archivo]').val(data.result.name);
  },
  progressall: function (e, data) {
    var progress = parseInt(data.loaded / data.total * 100, 10);
    $('#progressEditar .progress-bar').show();
    $('#progressEditar .progress-bar').css(
      'width',
      progress + '%'
    );
  }
}).prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled');

$('#TableHistoriaMovimientoPlacas').on('click', '.editar-placa', function(event) {
	event.preventDefault();
	$("#FormHistoriaMovimientoEditarPlaca #filesEditar img").attr('src','');
	$("#FormHistoriaMovimientoEditarPlaca input[name='archivo']").val('');
	var id = $(this).data('id');
	$.getJSON(path+'historia/movimiento/getPlaca', {id}, function(json, textStatus) {
		$("#FormHistoriaMovimientoEditarPlaca input[name='id']").val(id);
		$("#FormHistoriaMovimientoEditarPlaca input[name='nombre']").val(json.pla_nombre);
		$("#FormHistoriaMovimientoEditarPlaca textarea[name='notas']").val(json.pla_notas);
		$("#FormHistoriaMovimientoEditarPlaca #filesEditar img").attr('src',path+'assets/uploads/placas/thumbs/'+json.pla_archivo);
		$('#ModalEditarPlaca').modal();
	});
});

$('#FormHistoriaMovimientoEditarPlaca').validate({
	rules:{
		nombre:{required:true}
	},
	submitHandler:function() {
		enviarFormulario('#FormHistoriaMovimientoEditarPlaca',function(json){
			if (json.success) {
				$('#TableHistoriaMovimientoPlacas').DataTable().ajax.reload();
			}
			$('#ModalEditarPlaca').modal('hide');
			$('#FormHistoriaMovimientoAgregarPlaca input[name=nombre]').val('');
			$('#FormHistoriaMovimientoAgregarPlaca texarea[name=notas]').val('');
			$('.pekecontainer').empty();
		})
	}
});

$('#TableHistoriaMovimientoPlacas').on('click', '.anular-placa', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular placa?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'historia/movimiento/anularPlaca', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableHistoriaMovimientoPlacas').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});

/*=====  End of HISTORIA - MOVIMIENTO  ======*/




/*===========================================
=            MEDICO - LISTADO            =
===========================================*/
var TableMantenimientoMedico =  $('#TableMantenimientoMedico').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/medico/jsonmedicos',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.medico = $("input[name=medico]").val();
			d.especialidad = $("select[name=especialidad]").val();
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},

	]
});

$('#MedicosFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoMedico').DataTable().ajax.reload();
	}
});


/*========================================
=            MEDICO - REGISTRAR            =
===========================================*/

$('#FormRegistrar').validate({
	ignore: [],
	rules: {
		especialidad:{required:true},
		nombre:{required:true},
		apellidos:{required:true},
		dni:{required:true},
		direccion:{required:true},
		colegiatura:{required:true},
		fechanacimiento:{required:true},
		telefono:{required:true},
		email:{required:true},
		fecha_registro:{required:true},
		usuarioMedico:{required:true},
		passwordMedico:{required:true},

	
	},
	

});

/*========================================
=            MEDICO - ANULAR            =
===========================================*/

$('#TableMantenimientoMedico').on('click', '.anular-medico', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular medico?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'mantenimiento/medico/anularMedico', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableMantenimientoMedico').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});



/*========================================
=            TRATAMIENTO - LISTADO       =
===========================================*/

var TableMantenimientoProcedimiento =  $('#TableMantenimientoProcedimiento').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/tarifario/jsontarifario',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.procedimiento = $("input[name=procedimiento]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#ProcedimientoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoProcedimiento').DataTable().ajax.reload();
	}
});

/*=========================================*/

$('#TableMantenimientoProcedimiento tbody').on('click', '.anularTarifario', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular Procedimiento?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'mantenimiento/tarifario/anularpago', {id}, function(json, textStatus) {
				if (json.success) {
					$('#TableMantenimientoProcedimiento').DataTable().ajax.reload();
				}
			});
		}
	});
});	

// $('#TableMantenimientoProcedimiento tbody').on('click', '.anularTarifario', function(event) {
// 	event.preventDefault();
// 	let id = $(this).data('id');
// 	$.getJSON(path+'mantenimiento/tarifario/anularpago/', {id},
	
// })

// });




/*========================================
=            PROCEDIMIENTO - VALIDAR
===========================================*/

$('#FormRegistrarTarifario').validate({
	ignore: [],
	rules: {
		concepto:{required:true},
		 nombre:{required:true},
		 medida:{required:true},
		categoria:{required:true},
		precio:{required:true},
		// colegiatura:{required:true},
		// fechanacimiento:{required:true},
		// telefono:{required:true},
		// email:{required:true},
		// fecha_registro:{required:true},
		// estado:{required:true},
	
	},


});


/*========================================
=            PACIENTE - LISTADO       =
===========================================*/

var TableMantenimientoPaciente =  $('#TableMantenimientoPaciente').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/paciente/jsonpaciente',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.paciente = $("input[name=paciente]").val();
			
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
	]
});

$('#PacienteFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoPaciente').DataTable().ajax.reload();
	}
});


/*========================================
=            PACIENTE - ANULAR            =
===========================================*/

$('#TableMantenimientoPaciente').on('click', '.anular-paciente', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular paciente?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'mantenimiento/paciente/anularPaciente', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "La solicitud ha sido procesada.",
						type: "success"
					});
					$('#TableMantenimientoPaciente').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});



/*========================================
=            DEPARTAMENTOS Y PROVINCIAS       =
===========================================*/
$('#FormRegistrarPaciente select[name=departamento]').change(function(event) {
	getProvincias();
});

$('#FormRegistrarPaciente select[name=provincia]').change(function(event) {
	getDistritos();
});

function getProvincias()
{
	$('#FormRegistrarPaciente select[name=provincia]').prop('disabled',true);
	let departamento = $('#FormRegistrarPaciente select[name=departamento]').val();
	$.getJSON(path+'mantenimiento/paciente/getProvincias', {'departamento':departamento}, function(json, textStatus) {
		let option = '';
		$.each(json, function(index, val) {
			 option += `<option value="${val['provincia_id']}">${val['provincia_nombre']}</option>`;
		});
		$('#FormRegistrarPaciente select[name=provincia]').html(option).prop('disabled',false)
		getDistritos();
	});
}

function getDistritos()
{
	$('#FormRegistrarPaciente select[name=distrito]').prop('disabled',true);
	let provincia = $('#FormRegistrarPaciente select[name=provincia]').val();
	$.getJSON(path+'mantenimiento/paciente/getDistritos', {'provincia':provincia}, function(json, textStatus) {
		let option = '';
		$.each(json, function(index, val) {
			 option += `<option value="${val['distrito_id']}">${val['distrito_nombre']}</option>`;
		});
		$('#FormRegistrarPaciente select[name=distrito]').html(option).prop('disabled',false);
	});
}


/*========================================
=            PACIENTE - REGISTRAR            =
===========================================*/

$('#FormRegistrarPaciente').validate({
	ignore: [],
	rules: {
		nombre:{required:true},
		apellidos:{required:true},
		edad:{required:true},
		ocupacion:{required:true},
		lugarnacimiento:{required:true},
		informacion:{required:true},
		tipaciente:{required:true},
		direccion:{required:true},
		telefono:{required:true},
		dni:{required:true},
		fechanacimiento:{required:true},
		sexo:{required:true},
		email:{required:true},
		pais:{required:true},
		departamento:{required:true},
	
	},
	submit:function(form){
		form.submit();
	}
	

});





/*========================================
=            DIAGNOSTICO - LISTADO       =
===========================================*/

var TableMantenimientoDiagnostico =  $('#TableMantenimientoDiagnostico').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/diagnostico/jsondiagnostico',
		"type": "GET",
		"data": function (d) {
			d.enfermedad = $("input[name=enfermedad]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#DiagnosticoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoDiagnostico').DataTable().ajax.reload();
	}
});

/*=========================================*/


/*========================================
=            DIAGNOSTICO - REGISTRAR            =
===========================================*/

$('#FormRegistrarDiagnostico').validate({
	ignore: [],
	rules: {
		codigo:{required:true},
		descripcion:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
	

});


/*=========================================*/
/*=====ANULAR CIE10===========*/

$('#TableMantenimientoDiagnostico tbody').on('click', '.anularcie10', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular CIE10?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/diagnostico/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoDiagnostico').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*========================================
=            UNIDAD MEDIDA - LISTADO       =
===========================================*/

var TableMantenimientoMedida =  $('#TableMantenimientoMedida').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/medida/jsonmedida',
		"type": "GET",
		"data": function (d) {
			d.unidad_medida = $("input[name=unidad_medida]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#MedidaFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoMedida').DataTable().ajax.reload();
	}
});

/*=========================================*/	


/*========================================
=            UNIDAD DE MEDIDA - REGISTRAR =
===========================================*/

$('#FormRegistrarMedida').validate({
	ignore: [],
	rules: {
		codigo:{required:true},
		descripcion:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
	

});


/*=========================================*/
/*=====ANULAR MEDIDA===========*/

$('#TableMantenimientoMedida tbody').on('click', '.anularmedida', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Unidad de medida?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/medida/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoMedida').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*========================================
=            TIPO DE CONCEPTO - LISTADO       =
===========================================*/

var TableMantenimientoConcepto =  $('#TableMantenimientoConcepto').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/concepto/jsonconcepto',
		"type": "GET",
		"data": function (d) {
			d.tipo_concepto = $("input[name=tipo_concepto]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#ConceptoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoConcepto').DataTable().ajax.reload();
	}
});

/*=========================================*/	


/*========================================
=            TIPO CONCEPTO - REGISTRAR =
===========================================*/

$('#FormRegistrarConcepto').validate({
	ignore: [],
	rules: {
		concepto:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
	

});


/*=========================================*/
/*=====ANULAR TIPO CONCEPTO===========*/

$('#TableMantenimientoConcepto tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo Concepto?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/concepto/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoConcepto').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*========================================
=            CATEGORIA - LISTADO       =
===========================================*/

var TableMantenimientoCategoria =  $('#TableMantenimientoCategoria').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/categoria/jsoncategoria',
		"type": "GET",
		"data": function (d) {
			d.categoria = $("input[name=categoria]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#CategoriaFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoCategoria').DataTable().ajax.reload();
	}
});

/*=========================================*/	


/*==========================================
		 CATEGORIA - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarCategoria').validate({
	ignore: [],
	rules: {
		categoria:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
	

});

/*=========================================*/
/*=====ANULAR CATEGORIA===========*/

$('#TableMantenimientoCategoria tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular categoria?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/categoria/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoCategoria').DataTable().ajax.reload();
		}
	});
			}
		})

});



/*========================================
=            ESPECIALIDAD - LISTADO       =
===========================================*/

var TableMantenimientoEspecialidad =  $('#TableMantenimientoEspecialidad').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/especialidad/jsonespecialidad',
		"type": "GET",
		"data": function (d) {
			d.especialidad = $("input[name=especialidad]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#EspecialidadFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoEspecialidad').DataTable().ajax.reload();
	}
});

/*=========================================*/	


/*==========================================
		 ESPECIALIDAD - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarEspecialidad').validate({
	ignore: [],
	rules: {
		codigo:{required:true},
		nombre:{required:true},
		//descripcion:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR ESPECIALIDAD=================*/

$('#TableMantenimientoEspecialidad tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular especialidad?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/especialidad/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoEspecialidad').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*========================================
=            TIPO CITADO - LISTADO       =
===========================================*/

var TableMantenimientoCitado =  $('#TableMantenimientoCitado').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/citado/jsoncitado',
		"type": "GET",
		"data": function (d) {
			d.tipo_citado = $("input[name=tipo_citado]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#CitadoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoCitado').DataTable().ajax.reload();
	}
});

/*=========================================*/


/*==========================================
		 TIPO CITADO - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarCitado').validate({
	ignore: [],
	rules: {
		codigo:{required:true},
		nombre:{required:true},
		//descripcion:{required:true},
		estado:{required:true},
		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR CITADO=======================*/

$('#TableMantenimientoCitado tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular citado?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/citado/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoCitado').DataTable().ajax.reload();
		}
	});
			}
		})

});

/*========================================
=            TIPO DOCUMENTO - LISTADO       =
===========================================*/

var TableMantenimientoDocumento =  $('#TableMantenimientoDocumento').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/tipodocumento/jsondocumento',
		"type": "GET",
		"data": function (d) {
			d.tipo_documento = $("input[name=tipo_documento]").val();
		
		}
	},
	"columns": [
	//	{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		 {"orderable":true},
		 {"orderable":true},
		{"orderable":false},
		
	]
});

$('#DocumentoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoDocumento').DataTable().ajax.reload();
	}
});


/*==========================================
		 TIPO DOCUMENTO - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarDocumento').validate({
	ignore: [],
	rules: {

		nombre:{required:true},
		abreviatura:{required:true},
		serie:{required:true},
		inicio:{required:true},
		fin:{required:true},
		correlativo:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR CITADO=======================*/

$('#TableMantenimientoDocumento tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo Documento?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/tipodocumento/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoDocumento').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*========================================
=            TIPO PAGO - LISTADO       =
===========================================*/

var TableMantenimientoPago =  $('#TableMantenimientoPago').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/pago/jsonpago',
		"type": "GET",
		"data": function (d) {
			d.tipo_pago = $("input[name=tipo_pago]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#PagoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoPago').DataTable().ajax.reload();
	}
});

/*==========================================
		 TIPO DOCUMENTO - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarPago').validate({
	ignore: [],
	rules: {

		descripcion:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR PAGO=======================*/

$('#TableMantenimientoPago tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo Pago?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/pago/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoPago').DataTable().ajax.reload();
		}
	});
			}
		})

});

/*========================================
=            TIPO MONEDA - LISTADO       =
===========================================*/

var TableMantenimientoMoneda =  $('#TableMantenimientoMoneda').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/moneda/jsonmoneda',
		"type": "GET",
		"data": function (d) {
			d.tipo_moneda = $("input[name=tipo_moneda]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#MonedaFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoMoneda').DataTable().ajax.reload();
	}
});

/*==========================================
		 TIPO MONEDA - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarMoneda').validate({
	ignore: [],
	rules: {

		nombre:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR TIPO MONEDA===================*/

$('#TableMantenimientoMoneda tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo Moneda?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/moneda/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoMoneda').DataTable().ajax.reload();
		}
	});
			}
		})

});

/*========================================
=            BANCO - LISTADO       =
===========================================*/

var TableMantenimientoBanco =  $('#TableMantenimientoBanco').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/banco/jsonBanco',
		"type": "GET",
		"data": function (d) {
			d.banco = $("input[name=banco]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#BancoFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoBanco').DataTable().ajax.reload();
	}
});

/*==========================================
		 BANCO - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarBanco').validate({
	ignore: [],
	rules: {

		descripcion:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});

/*=========================================*/
/*=====ANULAR BANCO===================*/

$('#TableMantenimientoBanco tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo Moneda?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/banco/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoBanco').DataTable().ajax.reload();
		}
	});
			}
		})

});

/*========================================
=            TIPO TARJETA - LISTADO       =
===========================================*/

var TableMantenimientoTarjeta =  $('#TableMantenimientoTarjeta').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/tarjeta/jsonTarjeta',
		"type": "GET",
		"data": function (d) {
			d.tipo_tarjeta = $("input[name=tipo_tarjeta]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#TarjetaFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoTarjeta').DataTable().ajax.reload();
	}
});

/*==========================================
		 TIPO DE TARJETA - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarTarjeta').validate({
	ignore: [],
	rules: {

		descripcion:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});


/*=========================================*/
/*=====ANULAR TIPO DE TARJETA==============*/

$('#TableMantenimientoTarjeta tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Tipo de tarjeta?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/tarjeta/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoTarjeta').DataTable().ajax.reload();
		}
	});
			}
		})

});



$('#TableHistoriaMovimientoCita').DataTable({
	"language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[1, 'desc']],
	"ajax": {
		"url": path+'historia/movimiento/jsonCitasHistoria',
		"type": "POST",
		"data": function (d) {
			d.paciente = $("#HistoriaContenido").data('paciente');
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false}
	]
});



$('#TableHistoriaMovimientoCita').on('click', '.editar-citahistoria', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.getJSON(path+'historia/movimiento/getCitaHistoria', {id}, function(json, textStatus) {
		$('#FormEditarCitaHistoria input[name=id]').val(json.codi_cit);
		$('#FormEditarCitaHistoria input[name=fecha]').val(json.fech_cit.split(' ')[0]);
		$('#FormEditarCitaHistoria input[name=hora]').val(json.fech_cit.split(' ')[1].substr(0,5));
		$('#FormEditarCitaHistoria #NombrePaciente').html(json.nomb_pac+' '+json.apel_pac);
		$('#FormEditarCitaHistoria select[name=sede]').val(json.cod_sede);
		$('#FormEditarCitaHistoria select[name=codigo]').val(json.cod_citado);
		$('#FormEditarCitaHistoria input[name=motivo]').val(json.motivo_consult);
		$('#FormEditarCitaHistoria textarea[name=observacion]').val(json.obsv_cit);
		$('#FormEditarCitaHistoria select[name=especialidadEditar]').val(json.cod_especialidad);
		$.ajax({
			url: base_url+'historia/movimiento/getMedicosHistoria',
			type: 'POST',
			dataType: 'JSON',
			data: {'especialidad': json.cod_especialidad},
			success: function(resp){
				let option = '<option value="">Seleccione</option>';
				$.each(resp, function(index, val) {
					 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
				});
				$('select[name=medicoEditar]').empty().html(option);
				$('select[name=medicoEditar]').val(json.codi_med);
			}
		});
		
	});
});

$('#FormEditarCitaHistoria').validate({
	ignore: [],
	rules: {
		id:{required:true},
		fecha:{required:true},
		hora:{required:true},
		especialidadEditar:{required:true},
		medicoEditar:{required:true},
		sede:{required:true},
		estado:{required:true},
		motivo:{required:true}
	},
	submitHandler:function() {
		
		 enviarFormulario('#FormEditarCitaHistoria',function(json){
		 	if(json.success){
	         $('#TableHistoriaMovimientoCita').DataTable().ajax.reload();
	     }
	     	$('#ModalEditarCitaHistoria').modal('hide');
	         $('#FormEditarCitaHistoria input[name=fecha]').val('');
			$('#FormEditarCitaHistoria input[name=motivo]').val('');
	       
		})
	}
});

$('#FormEditarCitaHistoria select[name=especialidadEditar]').change(function(event) {
	let especialidad = $(this).val();
	$.ajax({
		url: base_url+'historia/movimiento/getMedicosHistoria',
		type: 'POST',
		dataType: 'JSON',
		data: {'especialidad': especialidad},
		success: function(resp){
			let option = '<option value="">Seleccione</option>';
			$.each(resp, function(index, val) {
				 option += `<option value="${val['codi_med']}">${val['nomb_med']+' '+val['apel_med']}</option>`;
			});
			$('select[name=medicoEditar]').empty().html(option);
		}
	});
});









/*========================================
=            ALERGIA - LISTADO       =
===========================================*/

var TableMantenimientoAlergia =  $('#TableMantenimientoAlergia').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/alergia/jsonAlergia',
		"type": "GET",
		"data": function (d) {
			d.alergia = $("input[name=alergia]").val();
		
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},
		
	]
});

$('#AlergiaFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoAlergia').DataTable().ajax.reload();
	}
});

/*==========================================
		 ALERGIA - VALIDAR Y REGISTRAR
===========================================*/

$('#FormRegistrarAlergia').validate({
	ignore: [],
	rules: {

		descripcion:{required:true},
		estado:{required:true},

		
	
	},

	submit:function(form){
		form.submit();
	}
	
});


/*=========================================*/
/*=====ANULAR ALERGIA======================*/

$('#TableMantenimientoAlergia tbody').on('click', '.anular', function(event) {
	event.preventDefault();
	let id = $(this).data('id');
	Swal.fire({
			title: "Confirmar",
			type: "warning",
			cancelButtonText:'No',
			confirmButtonText:'Si',
			showCancelButton: true,
			confirmButtonColor: "#007AFF",
			cancelButtonColor: "#d43f3a",
			text: "¿Anular Alergia?"
		}).then((result) => {
			if (result.value) {
				$.getJSON(path+'mantenimiento/alergia/anular', {id}, function(json, textStatus) {
		if (json.success) {
				
		 $('#TableMantenimientoAlergia').DataTable().ajax.reload();
		}
	});
			}
		})

});


/*===========================================
=            USUARIO - LISTADO            =
===========================================*/
var TableMantenimientoUsu =  $('#TableMantenimientoUsu').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/usuario/jsonUsu',
		"type": "GET",
		"data": function (d) {
			d.desde = $("input[name=desde]").val();
			d.hasta = $("input[name=hasta]").val();
			d.usuario = $("input[name=usuario]").val();
			d.rol = $("select[name=rol]").val();
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},

	]
});

$('#UsuariosFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoUsu').DataTable().ajax.reload();
	}
});


/*==========================================
		  USUARIO - EDITAR
===========================================*/

$('#TableMantenimientoUsu').on('click', '.editar-usuario', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.getJSON(path+'mantenimiento/usuario/getUsuario', {id}, function(json, textStatus) {
		$('#FormEditarUsuario input[name=id]').val(json.codi_usu);
		$('#FormEditarUsuario input[name=apellido]').val(json.apellido);
		$('#FormEditarUsuario input[name=nombre]').val(json.nombre);
		$('#FormEditarUsuario input[name=telefono]').val(json.telefono);
		$('#FormEditarUsuario input[name=direccion]').val(json.direccion);
		$('#FormEditarUsuario input[name=email]').val(json.email);
		$('#FormEditarUsuario select[name=tipo_documento]').val(json.tipo_documento);
		$('#FormEditarUsuario input[name=documento]').val(json.documento);
		$('#FormEditarUsuario select[name=codigorol]').val(json.codi_rol);
		$('#FormEditarUsuario input[name=login]').val(json.logi_usu);
		$('#FormEditarUsuario input[name=fecharegistro]').val(json.fecha_registro);
		$('#FormEditarUsuario select[name=estado]').val(json.esta_usu);
	});
});

$('#cambiarPassword').click(function(event) {
	
	if ($(this).is(":checked")) {
		$('#FormEditarUsuario input[name=passwoord]').prop('disabled', false);
	}else{
		$('#FormEditarUsuario input[name=passwoord]').prop('disabled', true);
	}
});

$('#FormEditarUsuario').validate({
	ignore: [],
	rules:{
		apellido:{required:true},
		nombre:{required:true},
		direccion:{required:true},
		telefono:{required:true},
		documento:{required:true},
		email:{required:true},
		login:{required:true},
		passwoord:{required:true},
		fecharegistro:{required:true},
		grupo:{required:true},
		perfil:{required:true},
		estado:{required:true}
		
	},
	submitHandler:function() {
		enviarFormulario('#FormEditarUsuario',function(json){
			if (json.success) {
				$('#TableMantenimientoUsu').DataTable().ajax.reload();
			}
			$('#ModalEditarUsuario').modal('hide');
			$('#FormEditarUsuario input[name=apellido]').val('');
			$('#FormEditarUsuario input[name=nombre]').val('');
			$('#FormEditarUsuario input[name=telefono]').val('');
			$('#FormEditarUsuario input[name=direccion]').val('');
			$('#FormEditarUsuario input[name=email]').val('');
			$('#FormEditarUsuario select[name=tipo_documento]').select('val','');
			$('#FormEditarUsuario input[name=documento]').val('');
			$('#FormEditarUsuario select[name=codigorol]').select('val','');
		    $('#FormEditarUsuario input[name=login]').val('');
		    $('#FormEditarUsuario input[name=passwoord]').val('');
		    $('#FormEditarUsuario input[name=fecharegistro]').datepicker('setDate',null);    
		    $('#FormEditarUsuario select[name=estado]').select('val','');
		})
	}
});


/*==========================================
		 USUARIO - ANULAR
===========================================*/

$('#TableMantenimientoUsu').on('click', '.anular-usuario', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular usuario?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'mantenimiento/usuario/anularUsuario', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "Se anulo correctamente.",
						type: "success"
					});
					$('#TableMantenimientoUsu').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});

/*===========================================
=            ROL - LISTADO            =
===========================================*/
var TableMantenimientoRol =  $('#TableMantenimientoRol').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'mantenimiento/rol/jsonRol',
		"type": "GET",
		"data": function (d) {
			d.rol = $("input[name=rol]").val();
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},

	]
});

$('#RolesFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoRol').DataTable().ajax.reload();
	}
});


/*==========================================
		  ROL - EDITAR
===========================================*/

$('#TableMantenimientoRol').on('click', '.editar-rol', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.getJSON(path+'mantenimiento/rol/getRol', {id}, function(json, textStatus) {
		$('#FormEditarRol input[name=id]').val(json.codi_rol);
		$('#FormEditarRol input[name=nombre]').val(json.nomb_rol);
		$('#FormEditarRol select[name=estado]').val(json.esta_rol);
	});
});


$('#FormEditarRol').validate({
	ignore: [],
	rules:{
		nombre:{required:true},
		estado:{required:true}
		
	},
	submitHandler:function() {
		enviarFormulario('#FormEditarRol',function(json){
			if (json.success) {
				$('#TableMantenimientoRol').DataTable().ajax.reload();
			}
			$('#ModalEditarRol').modal('hide');
			$('#FormEditarRol input[name=nombre]').val('');  
		    $('#FormEditarRol select[name=estado]').select('val','');
		})
	}
});

/*==========================================
		 USUARIO - ANULAR
===========================================*/

$('#TableMantenimientoRol').on('click', '.anular-rol', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	Swal.fire({
		title: "Confirmar",
		type: "warning",
		cancelButtonText:'No',
		confirmButtonText:'Si',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: "¿Anular rol?"
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'mantenimiento/rol/anularRol', {id}, function(json, textStatus) {
				if (json.success) {
					Swal.fire({
						title: "Buen trabajo",
						text: "Se anulo correctamente.",
						type: "success"
					});
					$('#TableMantenimientoRol').DataTable().ajax.reload();
				}else{
					Swal.fire({
						title: "Error",
						text: "Ocurrio un error, vuelva a intentarlo.",
						type: "error"
					});
				}
			});
		}
	});
});



/*===========================================
=            PERMISOS - LISTADO            =
===========================================*/
var TableMantenimientoPermisos =  $('#TableMantenimientoPermisos').DataTable({
	"language": {
		"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
	},
	"searching": false,
	"processing": true,
	"serverSide": true,
	"iDisplayLength": 10,
	"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos']],
	"aaSorting": [[0, 'desc']],
	"ajax": {
		"url": path+'administrador/permisos/jsonPermisos',
		"type": "GET",
		"data": function (d) {
			d.menus = $("select[name=menus]").val();
			d.rol = $("select[name=rol]").val();
		}
	},
	"columns": [
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":true},
		{"orderable":false},

	]
});

$('#PermisosFormBusqueda').validate({
	submitHandler:function() {
		$('#TableMantenimientoPermisos').DataTable().ajax.reload();
	}
});


/*=============================================
=            FORMULARIO DE MENSAJE            =
=============================================*/
if ($('#textareaContenido')[0]) {
	CKEDITOR.replace('textareaContenido');
	$('#FormMensaje').validate({
		ignore: [],
		rules:{
			titulo:{required:true},
			contenido:{required:true}
			
		},
		submitHandler:function() {
			enviarFormulario('#FormMensaje',function(json){
				
			})
		}
	});
}
/*=====  End of FORMULARIO DE MENSAJE  ======*/



$('#TableMantenimientoDocumento').on('click', '.editar-tipodocumento', function(event) {
	event.preventDefault();
	var id = $(this).data('id');
	$.getJSON(path+'mantenimiento/tipodocumento/getTipoDocumento', {id}, function(json, textStatus) {
		$('#FormEditarTipoDocumento input[name=id]').val(json.cod_tipodocumento);
		$('#FormEditarTipoDocumento input[name=nombre]').val(json.descripcion);
		$('#FormEditarTipoDocumento input[name=abreviatura]').val(json.abreviatura);
		$('#FormEditarTipoDocumento input[name=serie]').val(json.serie);
		$('#FormEditarTipoDocumento input[name=inicio]').val(json.inicio);
		$('#FormEditarTipoDocumento input[name=fin]').val(json.fin);
		$('#FormEditarTipoDocumento input[name=correlativo]').val(json.correlativo_actual);
		$('#FormEditarTipoDocumento select[name=estado]').val(json.estado);
	});
});

$('#FormEditarTipoDocumento').validate({
	rules:{
		nombre:{required:true},
		abreviatura:{required:true},
		serie:{required:true},
		inicio:{required:true},
		fin:{required:true},
		correlativo:{required:true},
		estado:{required:true},
	},
	submitHandler:function() {
		$('#ModalEditarTipoDocumento').modal('hide');
		enviarFormulario('#FormEditarTipoDocumento',function(json){
			if (json.success) {
				$('#TableMantenimientoDocumento').DataTable().ajax.reload();
				$('#FormEditarTipoDocumento input[name=nombre]').val('');
				$('#FormEditarTipoDocumento input[name=abreviatura]').val('');
				$('#FormEditarTipoDocumento input[name=serie]').val('');
				$('#FormEditarTipoDocumento input[name=inicio]').val('');
				$('#FormEditarTipoDocumento input[name=fin]').val('');
				$('#FormEditarTipoDocumento input[name=correlativo]').val('');
				$('#FormEditarTipoDocumento select[name=estado]').select('val','');
			}
		})
	}
});



});