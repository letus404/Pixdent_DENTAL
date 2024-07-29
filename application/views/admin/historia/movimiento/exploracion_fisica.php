<div id="HistoriaContenidoExploracionFisica" class="panel panel-primary" style="display: none">
  <div class="panel-heading">Exploración física paciente</div>
  <div class="panel-body">
    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px">
      <li class="active" role="presentation"><a href="#enfermedad" aria-controls="enfermedad" role="tab" data-toggle="tab">Enfermadad actual</a></li>
      <li role="presentation"><a href="#consulta" aria-controls="consulta" role="tab" data-toggle="tab">Consulta de salud</a></li>
      <li role="presentation"><a href="#exploracion" aria-controls="exploracion" role="tab" data-toggle="tab">Exploración Física</a></li>
      <li role="presentation"><a href="#alergias" aria-controls="alergias" role="tab" data-toggle="tab">Alergias</a></li>
    </ul>

    <div class="tab-content">
      <div role="tabpanel" class="tab-pane active" id="enfermedad">
        <form id="FormHistoriaMovimientoPacienteEnfermedad" action="<?= base_url('historia/movimiento/guardarPacienteEnfermedad') ?>" method="post">
          <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
         
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Tiempo de enfermedad:</label>
                <input type="text" name="tiempoEnfermedad" class="form-control input-sm" value="<?= $enfermedad->tiempo_enfact ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Motivo de la consulta:</label>
                <textarea name="motivoConsulta" class="form-control input-sm" rows="3"><?= $enfermedad->motivo_enfact ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Signos y sintomas principales:</label>
                <textarea name="signosSintomas" class="form-control input-sm" rows="3"><?= $enfermedad->signo_enfact ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Antecedentes personales:</label>
                <textarea name="antecedentesPersonales" class="form-control input-sm" rows="3"><?= $enfermedad->antecper_enfact ?></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Antecedentes Familiares:</label>
                <textarea name="antecedentesFamiliares" class="form-control input-sm" rows="3"><?= $enfermedad->antecfam_enfact ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Esta tomando algun medicamento:</label>
                <div>
                  <label class="radio-inline">
                    <input type="radio" name="tomandoMedicamento" value="1" <?= ($enfermedad->medicam_enfact=='1')?'checked':'' ?>> Si
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="tomandoMedicamento" value="0" <?= ($enfermedad->medicam_enfact=='0')?'checked':'' ?>> No
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Nombre del medicamento:</label>
                <input type="text" name="nombreMedicamento" class="form-control input-sm" value="<?= $enfermedad->nommedicam_enfact ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Motivo de uso:</label>
                <input type="text" name="motivoUso" class="form-control input-sm" value="<?= $enfermedad->motivomedi_enfact ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Dosis:</label>
                <input type="text" name="dosis" class="form-control input-sm" value="<?= $enfermedad->dosis_enfact ?>">
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-12">
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-info">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div role="tabpanel" class="tab-pane" id="consulta">
        <form id="FormHistoriaMovimientoPacienteConsulta" action="<?= base_url('historia/movimiento/guardarPacienteConsulta') ?>" method="post">
          <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
        
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Ha tenido alguna vez tratamiento de ortodoncia?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="algunaVezMedicamento" value="1" <?= ($consulta->ortod_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="algunaVezMedicamento" value="0" <?= ($consulta->ortod_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="algunaVezMedicamentoTexto" class="form-control" rows="2" <?= ($consulta->ortod_paccon=='0' OR $consulta->ortod_paccon=='')?'disabled':'' ?>><?= $consulta->ortodtexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Esta tomando algun medicamento?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="tomandoMedicamentoConsulta" value="1" <?= ($consulta->medic_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tomandoMedicamentoConsulta" value="0" <?= ($consulta->medic_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="tomandoMedicamentoTexto" class="form-control" rows="2" <?= ($consulta->medic_paccon=='0' OR $consulta->medic_paccon=='')?'disabled':'' ?>><?= $consulta->medictexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Es alegico a algun medicamento o anestesico?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="alergicoAnestesico" value="1" <?= ($consulta->alergico_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="alergicoAnestesico" value="0" <?= ($consulta->alergico_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="alergicoAnestesicoTexto" class="form-control" rows="2"
                   <?= ($consulta->alergico_paccon=='0' OR $consulta->alergico_paccon=='')?'disabled':'' ?>
                ><?= $consulta->alergicotexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Has estado hospitalizado o tenido una cirugia?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="hospitalizadoCirugia" value="1" <?= ($consulta->hosp_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="hospitalizadoCirugia" value="0" <?= ($consulta->hosp_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="hospitalizadoCirugiaTexto" class="form-control" rows="2"
                 <?= ($consulta->hosp_paccon=='0' OR $consulta->hosp_paccon=='')?'disabled':'' ?>
                ><?= $consulta->hosptexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Ha tenido algun transtorno nervioso o emocional?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="transtornoNerviosoEmocional" value="1" <?= ($consulta->trans_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="transtornoNerviosoEmocional" value="0" <?= ($consulta->trans_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="transtornoNerviosoEmocionalTexto" class="form-control" rows="2"
                  <?= ($consulta->trans_paccon=='0' OR $consulta->trans_paccon=='')?'disabled':'' ?>
                ><?= $consulta->transtexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">¿Padece o a padecido alguna de las siguientes enfermedades?</label>
                <div>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Asma" <?= ($consulta->padece_paccon=='Asma')?'checked':'' ?>>Asma
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Hepatitis" <?= ($consulta->padece_paccon=='Hepatitis')?'checked':'' ?>>Hepatitis
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Epilepsia" <?= ($consulta->padece_paccon=='Epilepsia')?'checked':'' ?>>Epilepsia
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Enf. renal" <?= ($consulta->padece_paccon=='Enf. renal')?'checked':'' ?>>Enf. renal
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Sarampion" <?= ($consulta->padece_paccon=='Sarampion')?'checked':'' ?>>Sarampion
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Varicela" <?= ($consulta->padece_paccon=='Varicela')?'checked':'' ?>>Varicela
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Tuberculosis" <?= ($consulta->padece_paccon=='Tuberculosis')?'checked':'' ?>>Tuberculosis
                  </label>
                      </div>


                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Diabetes" <?= ($consulta->padece_paccon=='Diabetes')?'checked':'' ?>>Diabetes
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="padeceEnfermedad" value="Otras" <?= ($consulta->padece_paccon=='Otras')?'checked':'' ?>>Otras
                  </label>
            
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Cepilla los dientes diariamente?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="cepillaDientes" value="1" <?= ($consulta->cepilla_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="cepillaDientes" value="0" <?= ($consulta->cepilla_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>
            <div class="col-md-9">
              <div class="form-group">
                <textarea name="cepillaDientesTexto" class="form-control" rows="2" 
                  <?= ($consulta->cepilla_paccon=='0' OR $consulta->cepilla_paccon=='')?'disabled':'' ?>
                ><?= $consulta->cepillatexto_paccon ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label class="control-label">¿Sufre de presión arterial alta?</label>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="radio-inline">
                  <input type="radio" name="presionArterial" value="1" <?= ($consulta->presion_paccon=='1')?'checked':'' ?>> Si
                </label>
                <label class="radio-inline">
                  <input type="radio" name="presionArterial" value="0" <?= ($consulta->presion_paccon=='0')?'checked':'' ?>> No
                </label>
              </div>
            </div>


            <div class="col-md-9">
              <div class="form-group">
                <textarea name="presionArterialTexto" class="form-control" rows="2"
                <?= ($consulta->presion_paccon=='0' OR $consulta->presion_paccon=='')?'disabled':'' ?>
                ><?= $consulta->presiontexto_paccon ?></textarea>
              </div>
            </div>
          </div>
            <div class="row">
            <div class="col-md-12">
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-info">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div role="tabpanel" class="tab-pane" id="exploracion">
        <form id="FormHistoriaMovimientoPacienteExploracion" action="<?= base_url('historia/movimiento/guardarPacienteExploracion') ?>" method="post">
          <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
          
               <div class="col-md-14">
          <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h6 class="box-title">Funciones Vitales</h6>

              <div class="box-tools pull-right">
               
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <div class="form-horizontal form-valid">
<div class="form-group">
  
                <div class="col-sm-3 val-smk">
                   <label class="control-label">Presion arterial:</label>
                    <div class="input-group">
                     <input type="text" name="PA" class="form-control input-sm" value="<?= $exploracion->pa_exp ?>">
                 <div class="input-group-addon">
                   mn Hg
                 </div>
                  </div>
                </div>  
            <div class="col-sm-3 val-smk">
                <label class="control-label">Pulso:</label>
              <div class="input-group">
                <input type="text" name="pulso" class="form-control input-sm" value="<?= $exploracion->pulso_exp ?>">
                 <div class="input-group-addon">
                 / min
                 </div>
              </div>
            </div>
            <div class="col-sm-3 val-smk">
             
                <label class="control-label">Temperatura:</label>
                 <div class="input-group">
                <input type="text" name="temperatura" class="form-control input-sm" value="<?= $exploracion->temperat_exp ?>">
                <div class="input-group-addon">
                  º C
                 </div>
              </div>
            </div>
            <div class="col-sm-3 val-smk">
                <label class="control-label">Frecuencia cardiaca:</label>
              <div class="input-group">
              
                <input type="text" name="FC" class="form-control input-sm" value="<?= $exploracion->fc_exp ?>">
                <div class="input-group-addon">
                  x min.
                 </div>
              </div>
            </div>
            <div class="col-sm-3 val-smk">
                      <label class="control-label">Frec. Respiratoria:</label>
              <div class="input-group">
        
                <input type="text" name="frecRep" class="form-control input-sm" value="<?= $exploracion->frec_exp ?>">
                 <div class="input-group-addon">
                  / min
                 </div>
              </div>
            </div>
          </div>
        </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


                  <div class="col-md-14">
          <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h6 class="box-title">Peso - Talla</h6>

              <div class="box-tools pull-right">
               
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <div class="form-horizontal form-valid">
                    <div class="form-group">
  
            <div class="col-sm-3 val-smk">
               <label class="control-label">Peso:</label>
              <div class="input-group">
               
                <input type="text" name="peso" class="form-control input-sm" value="<?= $exploracion->peso_exp ?>">
                <div class="input-group-addon">
                   Kg.
                 </div>
              </div>
            </div>
            <div class="col-sm-3 val-smk">
              <label class="control-label">Talla:</label>
              <div class="input-group">
                
                <input type="text" name="talla" class="form-control input-sm" value="<?= $exploracion->talla_exp ?>">
                 <div class="input-group-addon">
                   m.
                 </div>
              </div>
            </div>
            <div class="col-sm-3 val-smk">
               <label class="control-label">IMC:</label>
              <div class="input-group">
               
                <input type="text" name="masa" class="form-control input-sm" value="<?= $exploracion->masa_exp ?>">
                <div class="input-group-addon">
                   Kg/m.
                 </div>
              </div>
            </div>
           
          </div>
          </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Examen clínico general</label>
                <textarea name="examenClinicoGeneral" class="form-control input-sm" rows="3"><?= $exploracion->clinico_exp ?></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Examen complementario</label>
                <textarea name="examenComplementario" class="form-control input-sm" rows="3"><?= $exploracion->complement_exp ?></textarea>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Odontoestomatologico</label>
                <textarea name="odontoestomatologico" class="form-control input-sm" rows="3"><?= $exploracion->odontoesto_exp ?></textarea>
              </div>
            </div>
          </div>

             <div class="row">
            <div class="col-md-12">
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-info">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div role="tabpanel" class="tab-pane" id="alergias">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#ModalAgregarAlergia"><i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <table id="TableHistoriaMovimientoAlergias" class="table table-bordered table-striped table-sm">
              <thead>
                <tr class="btn-primary btn-xs">
                  <th style="text-align: center;" width="10">Secuencia</th>
                  <th style="text-align: center;">Nombre</th>
                  <th style="text-align: center;">Observación</th>
                  <th style="text-align: center;">Opciones</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="ModalAgregarAlergia" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content ">
      <form id="FormHistoriaMovimientoAgregarAlergia" action="<?= base_url('historia/movimiento/agregarAlergia') ?>" method="post" autocomplete="off">
        <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Agregar Alergia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Alergia:</label>
                <select name="alergia" class="form-control">
                  <option value="">--Selecciona--</option>
                  <?php foreach ($alergias as $a): ?>
                  <option value="<?= $a->cod_ale ?>"><?= $a->nombre_ale ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Observación:</label>
                <textarea name="observacion" class="form-control input-sm" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
          <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="ModalEditarAlergia" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content ">
      <form id="FormHistoriaMovimientoEditarAlergia" action="<?= base_url('historia/movimiento/editarAlergia') ?>" method="post" autocomplete="off">
        <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
        <input type="hidden" name="id">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Editar Alergia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Alergia</label>
                <select name="alergia" class="form-control input-sm">
                  <option value=""></option>
                  <?php foreach ($alergias as $a): ?>
                  <option value="<?= $a->cod_ale ?>"><?= $a->nombre_ale ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Observación</label>
                <textarea name="observacion" class="form-control input-sm" rows="4"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
          <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Guardar</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->