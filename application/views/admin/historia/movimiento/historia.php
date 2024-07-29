<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Historia clinica</h1>
    <ol class="breadcrumb">
       <div style="float:right;">
        <div class="dropdown">
            <div class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" style="padding:0px 8px;">
                <i class="fa fa-cog fa-2" aria-hidden="true" style="font-size: 22px;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a target="_blank" href="<?php echo base_url()?>historia/movimiento/imprimirHistoria/<?php echo $paciente->codi_pac;?>"  ><i class="fa fa-print fa-1" aria-hidden="true"></i> Imprimir Historia</a></li>
               <!--  <li><a href="#" onclick="openModal_ImprimirPDF_OdonInicial();" data-original-title="" title=""><i class="fa fa-print fa-1" aria-hidden="true"></i>  Imprimir Odontograma - Inicial</a></li>
                <li><a href="#" onclick="openModal_ImprimirPDF_OdonEvolucion();" data-original-title="" title=""><i class="fa fa-print fa-1" aria-hidden="true"></i>  Imprimir Odontograma - Evolucion</a></li> -->

            </ul>
        </div>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <!-- <div class="box-header">
            <h3 class="box-title"><?= $paciente->nomb_pac.' '.$paciente->apel_pac ?></h3>
          </div> -->
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-9">
                <div id="HistoriaContenido" data-paciente="<?= $this->uri->segment(4) ?>">
                  <?php
                    $this->load->view('admin/historia/movimiento/datos_paciente');
                    $this->load->view('admin/historia/movimiento/exploracion_fisica');
                    $this->load->view('admin/historia/movimiento/receta');
                    $this->load->view('admin/historia/movimiento/placas');
                    $this->load->view('admin/historia/movimiento/odontograma/odontograma');
                    $this->load->view('admin/historia/movimiento/evolucion');
                    $this->load->view('admin/historia/movimiento/cita');
                    $this->load->view('admin/historia/movimiento/histratamiento');
                    $this->load->view('admin/historia/movimiento/diagnostico');
                  ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="text-center">
                  <?php if (!is_null($paciente->foto_paciente)): ?>
                  <img src="<?= base_url('assets/uploads/pacientes/'.$paciente->foto_paciente) ?>" alt="<?= $paciente->nomb_paciente.' '.$paciente->apel_pac ?>" class="img img-responsive" style="max-width: 200px; padding-left: 80px">
                  <?php else: ?>
                  <img class="profile-user-img img-responsive img-circle" src="<?= base_url() ?>assets/img/usuario_inicio.png" alt="User profile picture" class="img img-responsive" style="max-width: 100px">
                  <?php endif ?>
                  
                  <h4>H.C: <?= $paciente->codi_pac ?></h4>
                  <h5><?= $paciente->nomb_pac.' '.$paciente->apel_pac ?></h5>
                </div>
                <div id="HistoriaMenu" class="list-group">
                  <a href="#" data-id="HistoriaContenidoDatosPaciente" class="list-group-item active"><i class="fa fa-user" aria-hidden="true"></i> Datos del Paciente</a>
                  <a href="#" data-id="HistoriaContenidoExploracionFisica" class="list-group-item"><i class="fa fa-file-text-o" aria-hidden="true"></i>   Exploración Física</a>
                  <a href="#" data-id="HistoriaContenidoOdontograma" class="list-group-item"><i class="fa fa-life-ring" aria-hidden="true"></i>  Odontograma</a>
                  <a href="#" data-id="HistoriaContenidoDiagnostico" class="list-group-item"><i class="fa fa-heart" aria-hidden="true"></i>  Diagnostico</a>
                  <a href="#" data-id="HistoriaContenidoEvolucion" class="list-group-item"><i class="fa fa-user-md" aria-hidden="true"></i> Evolución</a>
                  <a href="#" data-id="HistoriaContenidoPlacas" class="list-group-item"><i class="fa fa-files-o" data-id="HistoriaContenidoReceta" aria-hidden="true"></i> Exam. Auxiliares Placas</a>
                  <a href="#" data-id="HistoriaContenidoTratamientos" class="list-group-item"><i class="fa fa-credit-card" aria-hidden="true"></i> Tratamientos realizados</a>
            
                  <a href="#" data-id="HistoriaContenidoCita" class="list-group-item"><i class="fa fa-calendar-plus-o"></i> Citas</a>
                </div>
                
              </div>
            </div>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

