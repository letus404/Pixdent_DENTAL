$(function(){

var piezas = {
	18:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	17:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	16:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	15:{
		'img':'pieza_uno.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	14:{
		'img':'pieza_dos.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	13:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	12:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	11:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},

	21:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	22:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	23:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	24:{
		'img':'pieza_dos.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false,
	},
	25:{
		'img':'pieza_uno.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	26:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	27:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	28:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},

	55:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	54:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	53:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	52:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	51:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},

	61:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	62:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	63:{
		'img':'pieza_cero.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
	},
	64:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},
	65:{
		'img':'pieza_tres.png',
		'giro':false,
		'Vestibular':'arriba',
		'Palatino':'abajo',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':false
	},


	85:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	84:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	83:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	82:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	81:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},

	71:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	72:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	73:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	74:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	75:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},

	48:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	47:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	46:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	45:{
		'img':'pieza_uno.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	44:{
		'img':'pieza_uno.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	43:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	42:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	41:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'izquierda',
		'Mesial':'derecha',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},

	31:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	32:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	33:{
		'img':'pieza_cero.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':false,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	34:{
		'img':'pieza_uno.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	35:{
		'img':'pieza_uno.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	36:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	37:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},
	38:{
		'img':'pieza_dos.png',
		'giro':true,
		'Vestibular':'abajo',
		'Lingual':'arriba',
		'Distal':'derecha',
		'Mesial':'izquierda',
		'OclusalStatus':true,
		'Oclusal':'centro',
		'LingualStatus':true
	},


};

var seleccionado = '';
$('.odontograma-navegacion a').click(function(event) {
	event.preventDefault();
});

/*=================================================
=            SELECCIONANDO EL HALLAZGO            =
=================================================*/
$('.odontograma-item').click(function(event) {
	var t = $(this);
	if (t.hasClass('nombreHallazgo')) {
		var seleccionado = t[0];
	}else{
		var seleccionado = t.parent().parent().parent().find('a.nombreHallazgo')[0];
		if (t.hasClass('siglas')) {
			var sigla = $(t).data('sigla');
		}else{
			var sigla = $(seleccionado).data('sigla');
		}
	}
	var hallazgo = $(seleccionado).data('hallazgo');
	
	var estado = $(this).data('estado');
	var categoria = $(this).data('categoria');


	$('#FormHistoriaMovimientoAgregarHallazgo input[name=hallazgo], #FormHistoriaMovimientoAgregarHallazgo input[name=estado], #FormHistoriaMovimientoAgregarHallazgo input[name=sigla], #FormHistoriaMovimientoAgregarHallazgo input[name=diente], #FormHistoriaMovimientoAgregarHallazgo input[name=dienteFinal], #FormHistoriaMovimientoAgregarHallazgo input[name=categoria]').val('');

	$('#colDienteFinal').hide();
	$('#FormMarcarPieza').hide();

	$('.cursor').removeClass('inicioSelec');
	$('#FormHistoriaMovimientoAgregarHallazgo input[name="marcas"]').val(0);

	$('#BotonNombreSeleccionado').show().html(seleccionado.innerText);

	$('#odontograma-contenido').removeClass('detalle unico inicio fin MarcarPieza');
	$('#FormMarcarPieza').removeClass('estadoMarcarPieza');
	if ($(seleccionado).hasClass('rango')) {
		$('#odontograma-contenido').addClass('inicio');
	}else{
		$('#odontograma-contenido').addClass('unico');

		if ($(seleccionado).hasClass('hallazgoMarcar')) {
			$('#odontograma-contenido').addClass('MarcarPieza');
			$('#odontograma-contenido').data('marcaclass',$(seleccionado).data('marcaclass'));
			$('#FormHistoriaMovimientoAgregarHallazgo input[name="marcas"]').val(1);
			if ($(seleccionado).hasClass('hallazgoMarcarEstado')) {
				$('#FormMarcarPieza').addClass('estadoMarcarPieza');
			}
		}
	}

	$('#modalHallazgo').val(seleccionado.innerText);

	$('#colEstado').show();
	$('#colSigla').show();
	$('#colCategoria').show();
	$('#dibujar').hide();
	$('#BotonNombreSeleccionado').removeClass('btn-default btn-success btn-danger');
	if (estado=='bueno') {
		$('#modalEstado').val('Buen Estado');
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="estado"]').val('bueno');
    $('#BotonNombreSeleccionado').addClass('btn-success');
	}
	if (estado=='malo') {
		$('#modalEstado').val('Mal Estado');
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="estado"]').val('malo');
		$('#BotonNombreSeleccionado').addClass('btn-danger');	
	}
	if (typeof estado === "undefined") {
		$('#colEstado').hide();
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="estado"]').val('');
	  $('#BotonNombreSeleccionado').addClass('btn-default');	
	}

	if (typeof sigla === "undefined") {
		$('#colSigla').hide();
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="sigla"]').val('');
	}else{
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="sigla"]').val(sigla);
	}
	$('#BotonSeleccion').removeClass('btn-default').addClass('btn-info').html('Quitar Selección');

	if (typeof categoria === "undefined") {
		$('#colCategoria').hide();
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="categoria"]').val('');
	  $('#BotonNombreSeleccionado').addClass('btn-default');	
	}else{
		$('#FormHistoriaMovimientoAgregarHallazgo input[name="categoria"]').val(categoria);
	}
	
	$('#FormHistoriaMovimientoAgregarHallazgo input[name=hallazgo]').val(hallazgo);


});


$('#BotonSeleccion').click(function(event) {
	$(this).html('Seleccione');
	$('#odontograma-contenido').removeClass('unico inicio fin').addClass('detalle');
	$('.cursor').removeClass('inicioSelec');
	$('#BotonNombreSeleccionado').hide();
});
/*=====  End of SELECCIONANDO EL HALLAZGO  ======*/

/*===============================================
=            SELECCIONANDO EL DIENTE            =
===============================================*/
$('#odontograma').on('click', '#odontograma-contenido.unico .cursor', function(event) {
	event.preventDefault();
	$('#dibujar img').removeClass('rotar');
	$('#pieza').removeClass('categoria-centro categoria-nocentro');
	$('.direccionPieza').hide().removeClass('giro');
	$('#FormMarcarPieza input[type=checkbox], #FormMarcarPieza input[type=radio]').each(function() { 
		this.checked = false;
	});

	$('#FormMarcarPieza .radio-inline').hide();

	var diente = $(this).data('diente');
	if ($('#odontograma-contenido').hasClass('MarcarPieza')) {
		$('#dibujar').show();
		$('.direccionPieza ').attr('class','direccionPieza ');
		$('#FormMarcarPieza').show();
		var propiedades = piezas[diente];
		if (propiedades.LingualStatus) {
			$('#ContentCheckBoxPalatino').hide();
			$('#CheckBoxPalatino').prop('disabled',true);
			$('#ContentCheckBoxLingual').show();
			$('#CheckBoxLingual').prop('disabled',false);
		}else{
			$('#ContentCheckBoxLingual').hide();
			$('#CheckBoxLingual').prop('disabled',true);
			$('#ContentCheckBoxPalatino').show();
			$('#CheckBoxPalatino').prop('disabled',false);
		}

		if (propiedades.OclusalStatus) {
			$('#ContentCheckBoxOclusal').show();
			$('#CheckBoxOclusal').prop('disabled',false);
			$('#pieza').addClass('categoria-centro');
		}else{
			$('#ContentCheckBoxOclusal').hide();
			$('#CheckBoxOclusal').prop('disabled',true);
			$('#pieza').addClass('categoria-nocentro');
		}

		if (propiedades.girar) {
			$('#pieza img').addClass('rotar');
		}else{
			$('#pieza img').removeClass('rotar');		
		}

		$('#dibujar img').attr('src',path+'assets/odontograma/images/'+propiedades.img);
		if (propiedades.giro) {
			$('#dibujar img').addClass('rotar');
		}


	}
	$('#ModalAgregarHallazgo').modal();
	$('#FormHistoriaMovimientoAgregarHallazgo input[name=diente]').val(diente);
});

$('#FormMarcarPieza input[type=checkbox]').click(function(event) {
	var num_diente = $('#FormHistoriaMovimientoAgregarHallazgo input[name=diente]').val();
	var propiedades = piezas[num_diente];
	var check = $(this);
	var direcccion = propiedades[check.val()];
	if ($('#FormMarcarPieza').hasClass('estadoMarcarPieza')) {
		if (check.prop("checked")) {
			$('input[name='+check.val()+'Estado]').parent().show();
		}else{
			$('input[name='+check.val()+'Estado]').parent().hide();
			$('#direccionPieza-'+direcccion).hide().removeClass($('#odontograma-contenido').data('marcaclass'));
		}
	}else{
		if (check.prop("checked")) {
			$('#direccionPieza-'+direcccion).show().addClass($('#odontograma-contenido').data('marcaclass'));
			if (propiedades.giro) {
				$('#direccionPieza-'+direcccion).addClass('giro')
			}
		}else{
			$('#direccionPieza-'+direcccion).hide().removeClass($('#odontograma-contenido').data('marcaclass'));
		}
	}

});

$('#FormMarcarPieza input[type=radio]').click(function(event) {
	var estado = $(this).val();
	var num_diente = $('#FormHistoriaMovimientoAgregarHallazgo input[name=diente]').val();
	var propiedades = piezas[num_diente];
	
	var marcador = $(this).parent().siblings('.checkbox-inline').find('input').val();
	var direcccion = propiedades[marcador];
	$('#direccionPieza-'+direcccion).removeClass('bueno malo');
	$('#direccionPieza-'+direcccion).show().addClass($('#odontograma-contenido').data('marcaclass')+' '+estado);
	if (propiedades.giro) {
		$('#direccionPieza-'+direcccion).addClass('giro')
	}
});


$('#odontograma').on('click', '#odontograma-contenido.inicio .cursor', function(event) {
	event.preventDefault();
	$('#odontograma-contenido.inicio').removeClass('inicio').addClass('fin');
	$(this).addClass('inicioSelec');
	var diente = $(this).data('diente');

	$('#FormHistoriaMovimientoAgregarHallazgo input[name="diente"]').val(diente);
});

$('#odontograma').on('click', '#odontograma-contenido.fin .cursor', function(event) {
	event.preventDefault();
	var inicio = parseInt($('#odontograma-contenido .inicioSelec').data('orden'));
	var fin = parseInt($(this).data('orden'));

	if (fin<inicio) {
		Swal.fire({
			title: "Error",
			html: "El diente final se debe seleccionar hacia la parte derecha <span class='fa fa-arrow-right'></span>",
			type: "error",
		});
		return;
	}
	var diente = $(this).data('diente');

	$('#FormHistoriaMovimientoAgregarHallazgo input[name="dienteFinal"]').val(diente);
	$('#colDienteFinal').show();
	$('#ModalAgregarHallazgo').modal();
});
/*=====  End of SELECCIONANDO EL DIENTE  ======*/

/*=========================================
=            DETALLE DE DIENTE            =
=========================================*/
$('#odontograma').on('click', '#odontograma-contenido.detalle .cursor', function(event) {
	event.preventDefault();
	$('#ModalOdontogramaDetalle table>tbody').html('');
	var diente = $(this).data('diente');
	var paciente = $('#HistoriaContenido').data('paciente');
	var tipoOdontograma = $('#FormHistoriaMovimientoAgregarHallazgo input[name=tipoOdontograma]').val();
	$('#ModalOdontogramaDetalle').modal();
	$.getJSON(path+'historia/movimiento/getHallazgosDientePaciente', {paciente,diente,tipoOdontograma}, function(json, textStatus) {
			var hallazgos = '';
			$.each(json, function(index, val) {
				var estado = '';
				if (val['estado']!= null) {
					if (val['estado']=='bueno') {
						estado = 'Buen Estado';
					}else{
						estado = 'Mal Estado';
					}
				}

				var marcas = '';
				if (val['marcas']!='') {
					$.each(jQuery.parseJSON(val['marcas']), function(index, val) {
						if (val['Estado']=='malo') {
							var estadoMarca = 'text-danger';
						}else{
							var estadoMarca = 'text-primary';
						}
						marcas += `<span class="${estadoMarca}">${index}</span> `;
					});
				}

				hallazgos += `
					<tr>
						<td>${(val['sigla']!=null)?'<b>'+val['sigla']+':</b>':''} ${val['nombre_hal']}</td>
						<td>${ (val['categoria']!=null)?val['categoria']:'' }</td>
						<td>${ val['dienteInicio'] }</td>
						<td>${ (val['dienteFinal']!=null)?val['dienteFinal']:'' }</td>
						<td>${ estado }</td>
						<td>${ marcas }</td>
						<td>${ val['especificaciones'] }</td>
						<td><button data-id='${ val['pacodo_id'] }'' class="eliminar-hallazgo btn btn-xs btn-danger btn-fill"><i class="fa fa-trash"></i></button></td>
					<tr>
				`;
			});
			$('#ModalOdontogramaDetalle table>tbody').html(hallazgos);
	});
});

$('#ModalOdontogramaDetalle table>tbody').on('click', '.eliminar-hallazgo', function(event) {
	event.preventDefault();
	var fila = $(this).parent().parent();
	var id = $(this).data('id');
	var paciente = $('#HistoriaContenido').data('paciente');

	Swal.fire({
		title: "Confirmar Eliminar",
		type: "warning",
		cancelButtonText:'No, Cancelar',
		confirmButtonText:'Si, Eliminar',
		showCancelButton: true,
		confirmButtonColor: "#007AFF",
		cancelButtonColor: "#d43f3a",
		text: '¿Estas seguro de eliminar el hallazgo?'
	}).then((result) => {
		if (result.value) {
			$.getJSON(path+'historia/movimiento/eliminarHallazgo', {id,paciente}, function(json, textStatus) {
					if (json.success) {
						fila.remove();
						$('#odontograma-contenido .hallazgo-'+id).remove();
						Swal.fire({
							title: "Buen trabajo",
							text: "La solicitud ha sido procesada.",
							type: "success"
						});
						$('html, body').animate({scrollTop:1000});
						$('html, body').animate({scrollTop:0});
						setTimeout(function() {
							guardarImagenOdontograma();
						}, 1000);
					}else{
						Swal.fire({
							title: "Error",
							text: "Ha ocurrido un error.",
							type: "error"
						});
					}
			});
			
		}
	})



});
/*=====  End of DETALLE DE DIENTE  ======*/


/*========================================
=            AGREGAR HALLAZGO            =
========================================*/
$('#FormHistoriaMovimientoAgregarHallazgo').validate({
	ignore: [],
	rules: {
		diente:{required:true},
	},
	submitHandler:function() {
		$('html, body').animate({scrollTop:1000});
		$('html, body').animate({scrollTop:0});
		$('#ModalAgregarHallazgo').modal('hide');
		enviarFormulario('#FormHistoriaMovimientoAgregarHallazgo',function(resp){
			if (resp.success) {
				pintarHallazgos(resp.data);
				$('body').css('padding-right:0');
				$('#FormHistoriaMovimientoAgregarHallazgo textarea[name=especificaciones]').val('');
				//$('#BotonSeleccion').trigger('click');
				if ($('#odontograma-contenido').hasClass('fin')) {

					$('#odontograma-contenido').removeClass('fin');
					$('#odontograma-contenido').addClass('inicio');
					$('.cursor').removeClass('inicioSelec');
				}
				setTimeout(function() {
					guardarImagenOdontograma();
				}, 1000);
			}
		});
	}
});

$('#TipoOdontogramaSpan').click(function(event) {
	guardarImagenOdontograma();
});

function guardarImagenOdontograma()
{	
	html2canvas(document.querySelector("#OdontogramaImprimir")).then(canvas => {
		var imgData = canvas.toDataURL('image/png');
		
		var imagen = imgData.replace('data:image/png:base64,','');
		var img = `<img src="${imagen}" style="width:100%">`;
		
		var paciente = $('#HistoriaContenido').data('paciente');
		var tipo = $('#FormHistoriaMovimientoAgregarHallazgo input[name=tipoOdontograma]').val();
		$.ajax({
			url: path+'historia/movimiento/guardarImagenOdontograma',
			type: 'POST',
			dataType: 'JSON',
			data: {imgData,paciente,tipo},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
}

/*=====  End of AGREGAR HALLAZGO  ======*/


/*=================================================
=            PINTAR ODONTOGRAMA ACTUAL            =
=================================================*/
var paciente = $('#HistoriaContenido').data('paciente');
var tipoOdontograma = $('#FormHistoriaMovimientoAgregarHallazgo input[name=tipoOdontograma]').val();
$.getJSON(path+'historia/movimiento/getOdontograma', {paciente,tipoOdontograma}, function(json, textStatus) {
	$.each(json, function(index, val) {
		pintarHallazgos(val);
	});	
});
/*=====  End of PINTAR ODONTOGRAMA ACTUAL  ======*/

/*========================================
=            PINTAR HALLAZGOS            =
========================================*/
function pintarHallazgos(val){
	if (val['id_hal'] == 1)
		aparatoOrtoFijo(val['id'],val['inicio'],val['fin'],val['estado'])
	if (val['id_hal'] == 2)
		aparatoOrtoRemovible(val['id'],val['inicio'],val['fin'],val['estado'])
	if (val['id_hal'] == 3)
		corona(val['id'],val['inicio'],val['estado'],val['sigla'])
	if (val['id_hal'] == 37)
		coronaTemporal(val['id'],val['inicio'],val['estado'],val['sigla'])
	if (val['id_hal'] == 5)
		defectosDesarrolloEsmalte(val['id'],val['inicio'],val['estado'],val['sigla'])
	if (val['id_hal'] == 17)
		diastema(val['id'],val['inicio'])
	if (val['id_hal'] == 9)
		piezaAusente(val['id'],val['inicio'])
	if (val['id_hal'] == 21)
		piezaEctopica(val['id'],val['inicio'],val['sigla'])
	if (val['id_hal'] == 20)
		piezaClavija(val['id'],val['inicio'])
	if (val['id_hal'] == 10)
		piezaErupcion(val['id'],val['inicio'])
	if (val['id_hal'] == 15)
		piezaExtruida(val['id'],val['inicio'])
	if (val['id_hal'] == 16)
		piezaIntruida(val['id'],val['inicio'])
	if (val['id_hal'] == 14)
		piezaSupernumeraria(val['id'],val['inicio'])
	if (val['id_hal'] == 13)
		edentuloTotal(val['id'],val['inicio'],val['fin'])
	if (val['id_hal'] == 30)
		espigoMunon(val['id'],val['inicio'],val['estado'])
	if (val['id_hal'] == 8)
		fosasFisurasProfundas(val['id'],val['inicio'])
	if (val['id_hal'] == 7)
		fractura(val['id'],val['inicio'],val['categoria'])
	if (val['id_hal'] == 24)
		fusion(val['id'],val['inicio'])
	if (val['id_hal'] == 25)
		geminasion(val['id'],val['inicio'])
	if (val['id_hal'] == 18)
		giroversion(val['id'],val['inicio'],val['categoria'])
	if (val['id_hal'] == 26)
		impactacion(val['id'],val['inicio'])
	if (val['id_hal'] == 31)
		implanteDental(val['id'],val['inicio'],val['estado'])
	if (val['id_hal'] == 22)
		macrodoncia(val['id'],val['inicio'])
	if (val['id_hal'] == 23)
		microdoncia(val['id'],val['inicio'])
	if (val['id_hal'] == 29)
		movilidadPatologica(val['id'],val['inicio'],val['sigla'])
	if (val['id_hal'] == 19)
		posicionDentaria(val['id'],val['inicio'],val['sigla'])
	if (val['id_hal'] == 32)
		protesisFija(val['id'],val['inicio'],val['fin'],val['estado'])
	if (val['id_hal'] == 33)
		protesisRemovible(val['id'],val['inicio'],val['fin'],val['estado'])
	if (val['id_hal'] == 34)
		protesisTotal(val['id'],val['inicio'],val['fin'],val['estado'])
	if (val['id_hal'] == 28)
		remanenteRadicular(val['id'],val['inicio'])
	if (val['id_hal'] == 27)
		superficieDesgastada(val['id'],val['inicio'])
	if (val['id_hal'] == 36)
		transposicion(val['id'],val['inicio'])
	if (val['id_hal'] == 35)
		tratamientoPulpar(val['id'],val['inicio'],val['estado'],val['sigla'])
	if (val['id_hal'] == 4)
		lesionCaries(val['id'],val['inicio'],val['sigla'],val['diente'],val['marcas'])
	if (val['id_hal'] == 12)
		restauracionTemporal(val['id'],val['inicio'],val['diente'],val['marcas'])
	if (val['id_hal'] == 11)
		restauracionDefinitiva(val['id'],val['inicio'],val['diente'],val['marcas'],val['sigla'])
	if (val['id_hal'] == 6)
		sellantes(val['id'],val['inicio'],val['diente'],val['marcas'],'S')

	//console.log(val);
	
}
/*=====  End of PINTAR HALLAZGOS  ======*/



/*============================================
=            PINTAR CADA HALLAZGO            =
============================================*/
function sellantes($id,$inicio,$diente,$marcas,$sigla){
	var sigla = `<span class="hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
	$.each(jQuery.parseJSON($marcas), function(index, val) {
		if (piezas[$diente]['OclusalStatus']) {
			var tipoPieza = 'centro';
		}else{
			var tipoPieza = 'nocentro';
		}
		var direccion = piezas[$diente][String(index)];
		var hallazgo = ` <div class="hallazgos hallazgo-${$id} sellantes ${val['Estado']}  direccion-${ direccion } ${ tipoPieza } direccion-${ direccion+'-'+$inicio }"></div>`;
		$('#odontograma-contenido').append(hallazgo);
	});
}

function restauracionDefinitiva($id,$inicio,$diente,$marcas,$sigla){
	var sigla = `<span class="malo hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
	$.each(jQuery.parseJSON($marcas), function(index, val) {
		if (piezas[$diente]['OclusalStatus']) {
			var tipoPieza = 'centro';
		}else{
			var tipoPieza = 'nocentro';
		}
		var direccion = piezas[$diente][String(index)];
		var hallazgo = ` <div class="hallazgos hallazgo-${$id} restauracionDefinitiva ${val['Estado']} direccion-${ direccion } ${ tipoPieza } direccion-${ direccion+'-'+$inicio }"></div>`;
		$('#odontograma-contenido').append(hallazgo);
	});
}

function restauracionTemporal($id,$inicio,$diente,$marcas){
	$.each(jQuery.parseJSON($marcas), function(index, val) {
		if (piezas[$diente]['OclusalStatus']) {
			var tipoPieza = 'centro';
		}else{
			var tipoPieza = 'nocentro';
		}
		var direccion = piezas[$diente][String(index)];
		var hallazgo = ` <div class="hallazgos hallazgo-${$id} restauracionTemporal direccion-${ direccion } ${ tipoPieza } direccion-${ direccion+'-'+$inicio }"></div>`;
		$('#odontograma-contenido').append(hallazgo);
	});
}

function lesionCaries($id,$inicio,$sigla,$diente,$marcas){
	var sigla = `<span class="malo hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
	$.each(jQuery.parseJSON($marcas), function(index, val) {
		if (piezas[$diente]['OclusalStatus']) {
			var tipoPieza = 'centro';
		}else{
			var tipoPieza = 'nocentro';
		}
		var direccion = piezas[$diente][String(index)];
		var hallazgo = ` <div class="hallazgos hallazgo-${$id} lesionCaries direccion-${ direccion } ${ tipoPieza } direccion-${ direccion+'-'+$inicio }"></div>`;
		$('#odontograma-contenido').append(hallazgo);
	});
}

function tratamientoPulpar($id,$inicio,$estado,$sigla){
	if ($sigla=='TC' || $sigla=='PC') {
		var hallazgo = `<div class="hallazgos hallazgo-${$id} tratamientoPulparTC-PC ${$estado} tratamientoPulparTC-PC-${$inicio}"></div>`;
	}else if($sigla=='PP'){
		var hallazgo = `<div class="hallazgos hallazgo-${$id} tratamientoPulparPP ${$estado} tratamientoPulparPP-${$inicio}"></div>`;
	}
	$('#odontograma-contenido').append(hallazgo);
	var sigla = `<span class="${$estado} hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function transposicion($id,$inicio,){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} transposicion transposicion-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function superficieDesgastada($id,$inicio){
	var sigla = `<span class="malo hallazgo-${$id}">DES,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function remanenteRadicular($id,$inicio){
	var sigla = `<span class="malo hallazgo-${$id}">RR,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function protesisTotal($id,$inicio,$fin,$estado){
	var hallazgo = '';
	for (var i = parseInt($inicio); i <= parseInt($fin); i++) {
		hallazgo += `<div class="hallazgos hallazgo-${$id}  protesisTotal  ${$estado} protesisTotal-${i}"></div>`;
	}
	$('#odontograma-contenido').append(hallazgo);
}

function protesisRemovible($id,$inicio,$fin,$estado){
	console.log('holaa');
	var hallazgo = '';
	for (var i = parseInt($inicio); i <= parseInt($fin); i++) {
		hallazgo += `<div class="hallazgos hallazgo-${$id}  protesisRemovible  ${$estado} protesisRemovible-${i}"></div>`;
	}
	$('#odontograma-contenido').append(hallazgo);
}

function protesisFija($id,$inicio,$fin,$estado){
	var inicio = `<div class="hallazgos hallazgo-${$id} protesisFijaInicio ${$estado} protesisFijaInicio-${$inicio}"></div>`;

	var lineaInicio = parseInt($inicio)+1;
	var lineaFin = parseInt($fin)-1;
	var linea = '';
	for (var i = lineaInicio; i <= lineaFin; i++) {
		linea += `<div class="hallazgos hallazgo-${$id} linea ${$estado} linea-${i}"></div>`;
	}

	var fin = `<div class="hallazgos hallazgo-${$id} protesisFijaFin ${$estado} protesisFijaFin-${$fin}"></div>`;

	$('#odontograma-contenido').append(inicio+linea+fin);
}

function posicionDentaria($id,$inicio,$sigla){
	var sigla = `<span class="bueno hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function movilidadPatologica($id,$inicio,$sigla){
	var sigla = `<span class="malo hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function microdoncia($id,$inicio){
	var sigla = `<span class="bueno hallazgo-${$id}">MIC,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function macrodoncia($id,$inicio){
	var sigla = `<span class="bueno hallazgo-${$id}">MAC,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function implanteDental($id,$inicio,$estado){
	var sigla = `<span class="${ $estado } hallazgo-${$id}">IMP,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function impactacion($id,$inicio){
	var sigla = `<span class="bueno hallazgo-${$id}">I,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function giroversion($id,$inicio,$categoria){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} giroversion giroversion${$categoria} giroversion${$categoria+'-'+$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function geminasion($id,$inicio,){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} geminasion geminasion-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function fusion($id,$inicio,){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} fusion fusion-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function fractura($id,$inicio,$categoria){
	var cate = '';
	if ($categoria=='Coronal') {
		cate = 'fracturaCoronal';
	}else if($categoria=='Incisal'){
		cate = 'fracturaIncisal';
	}else if($categoria=='Raiz y Coronal'){
		cate = 'fracturaRaizCorona';
	}
	var hallazgo = `<div class="hallazgos hallazgo-${$id} ${cate} ${cate+'-'+$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function fosasFisurasProfundas($id,$inicio){
	var sigla = `<span class="bueno hallazgo-${$id}">FFP,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function espigoMunon($id,$inicio,$estado)
{
	var hallazgo = `<div class="hallazgos hallazgo-${$id} munon ${$estado} munon-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function edentuloTotal($id,$inicio,$fin){
	var hallazgo = '';
	for (var i = parseInt($inicio); i <= parseInt($fin); i++) {
		hallazgo += `<div class="hallazgos hallazgo-${$id}  edentulo edentulo-${i}"></div>`;
	}
	$('#odontograma-contenido').append(hallazgo);
}

function piezaSupernumeraria($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} piezaSupernumeraria piezaSupernumeraria-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function piezaIntruida($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} piezaIntruida piezaIntruida-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function piezaExtruida($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} piezaExtruida piezaExtruida-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function piezaErupcion($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} erupcion erupcion-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function piezaClavija($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} piezaClavija piezaClavija-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function piezaEctopica($id,$inicio,$sigla){
	var sigla = `<span class="hallazgo-${$id}">E,</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function piezaAusente($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} piezaAusente piezaAusente-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function diastema($id,$inicio){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} diastema diastema-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
}

function defectosDesarrolloEsmalte($id,$inicio,$estado,$sigla){
	var sigla = `<span class="${$estado} hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function aparatoOrtoFijo($id,$inicio,$fin,$estado){
	var inicio = `<div class="hallazgos hallazgo-${$id} aparatoOrtoFijoInicio ${$estado} aparatoOrtoFijoInicio-${$inicio}"></div>`;

	var lineaInicio = parseInt($inicio)+1;
	var lineaFin = parseInt($fin)-1;
	var linea = '';
	for (var i = lineaInicio; i <= lineaFin; i++) {
		linea += `<div class="hallazgos hallazgo-${$id} linea ${$estado} linea-${i}"></div>`;
	}

	var fin = `<div class="hallazgos hallazgo-${$id} aparatoOrtoFijoFin ${$estado} aparatoOrtoFijoFin-${$fin}"></div>`;

	$('#odontograma-contenido').append(inicio+linea+fin);
}

function aparatoOrtoRemovible($id,$inicio,$fin,$estado){
	var hallazgo = '';
	for (var i = parseInt($inicio); i <= parseInt($fin); i++) {
		hallazgo += `<div class="hallazgos hallazgo-${$id} ${$estado} aparatoOrtoRemovible aparatoOrtoRemovible-${i}"></div>`;
	}
	$('#odontograma-contenido').append(hallazgo);
}

function corona($id,$inicio,$estado,$sigla){
	var hallazgo = `<div class="hallazgos hallazgo-${$id} corona ${$estado} corona-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
	var sigla = `<span class="${$estado} hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}

function coronaTemporal($id,$inicio,$estado,$sigla)
{
	var hallazgo = `<div class="hallazgos hallazgo-${$id} coronaTemporal ${$estado} coronaTemporal-${$inicio}"></div>`;
	$('#odontograma-contenido').append(hallazgo);
	var sigla = `<span class="${$estado} hallazgo-${$id}">${$sigla},</span>`;
	$('.recuadro-'+$inicio).append(sigla);
}
/*=====  End of PINTAR CADA HALLAZGO  ======*/

/*======================================================
=            GUARDAR DETALLE DE ODONTOGRAMA            =
======================================================*/
$('#GuardarDetalle').click(function(event) {
	var paciente = $('#HistoriaContenido').data('paciente');
	var detalle = $('#TextAreaDetalle').val();
	$.ajax({
		url: path+'historia/movimiento/guardarDetalleOdontograma',
		type: 'POST',
		dataType: 'JSON',
		data: {paciente,detalle},
	})
	.done(function(resp) {
		if (resp.success) {
			Swal.fire({
				title: "Buen trabajo",
				text: "La solicitud ha sido procesada.",
				type: "success",
				timer: 2500
			});
		}
	});
	
});
/*=====  End of GUARDAR DETALLE DE ODONTOGRAMA  ======*/

/*====================================================
=            SELECCIONAR TIPO ODONTOGRAMA            =
====================================================*/
$('#tipoOdontograma li').click(function(event) {
	$('#TipoOdontogramaSpan').html($(this).data('tipo'));
	$('#FormHistoriaMovimientoAgregarHallazgo input[name=tipoOdontograma]').val($(this).data('tipo'));
	var paciente = $('#HistoriaContenido').data('paciente');
	var tipoOdontograma = $(this).data('tipo');
	$.ajax({
		url: path+'historia/movimiento/cambiarTipoOdontograma',
		type: 'GET',
		dataType: 'JSON',
		data:{paciente,tipoOdontograma}
	})
	.done(function(resp) {
		$('.hallazgos').remove();
		$('#cursoresRecuadros').empty().html(resp['html']);
		$.each(resp['odontograma'], function(index, val) {
			pintarHallazgos(val);
		});	
	})
	
});
/*=====  End of SELECCIONAR TIPO ODONTOGRAMA  ======*/

/*============================================
=            IMPRIMIR ODONTOGRAMA            =
============================================*/


/*============================================
=            CAPTURAR ODONTOGRAMA            =
============================================*/
$('#CapturarOdontograma').click(function(event) {
	$(this).text('Procesando').prop('disabled',true);
	html2canvas(document.querySelector("#OdontogramaImprimir")).then(canvas => {
		var imgData = canvas.toDataURL('image/png');
		
		var imagen = imgData.replace('data:image/png:base64,','');
		var img = `<img src="${imagen}" style="width:100%">`;

		var paciente = $('#HistoriaContenido').data('paciente');
		var tipo = $('#FormHistoriaMovimientoAgregarHallazgo input[name=tipoOdontograma]').val();
		$('#FormGuardarCapturaOdontograma input[name=paciente]').val(paciente);
		$('#FormGuardarCapturaOdontograma input[name=tipo]').val(tipo);
		$('#FormGuardarCapturaOdontograma input[name=imgData]').val(imgData);

		$('#ImagenOdontogramaCapturado').html(img);
		$('#ModalCapturarOdontograma').modal();
		$(this).text('Capturar Odont.').prop('disabled',false);
	});
});

$('#FormGuardarCapturaOdontograma').validate({
	ignore: [],
	rules: {
		paciente:{required:true},
		tipo:{required:true},
		imgData:{required:true}
	},
	submitHandler:function() {
		enviarFormulario('#FormGuardarCapturaOdontograma',function(resp){
			if (resp.success) {
				$('#ModalCapturarOdontograma').modal('hide');
			}
		})
	}
});
/*=====  End of CAPTURAR ODONTOGRAMA  ======*/

});