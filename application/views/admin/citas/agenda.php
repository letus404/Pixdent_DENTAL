<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <script src="<?= base_url() ?>assets/plugins/calendar/js/calendar.js"></script>
  <script src="<?= base_url() ?>assets/plugins/calendar/js/underscore-min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/calendar/js/language/es-ES.js"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <i class="fa fa-calendar"></i> Agenda
      </h1>
    
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
               <form id="FormAgendaFiltro" autocomplete="off">
               <div class="row">
                    <div class="col-md-12">
                      <div class="form-group grupo">
                        <input type="text" name="fecha" class="form-control hidden" data-lang="es" data-format="Y-m-d" data-inline="true" data-max-year="2030">
                      </div>
                    </div>
               </div>
                    <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Especialidad</label>
                        <select name="especialidad" class="form-control input-sm filtrarMedicos" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          <option value="">Seleccione</option>
                          <?php foreach ($especialidad as $e): ?>
                            <option value="<?= $e->cod_especialidad ?>"><?= $e->nombre_especialidad ?></option>
                          <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>

 
                         <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Médico</label>
                        <select name="medico" class="form-control input-sm" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          
                        </select>
                      </div>
                    </div>
                  </div>
              
   
                         <div class="row">
                    <div class="col-md-12">
                      <label class="control-label">Estado</label>
                      <div class="form-group">
                        <select name="estado" class="form-control input-sm" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="">Todos</option>
                        <?php foreach ($estados as $o): ?>
                        <option value="<?= $o->cod_citado ?>"><?= $o->nomb_citado ?></option>
                        <?php endforeach ?>
                        </select>
                      </div>
                    </div>
                  </div>

             <div class="row">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-block btn-primary"> Buscar</button>
                    </div>
                  </div>
  </form>
              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
           <div class="box box-primary collapsed-box">
             <div class="box-header with-border">
                       <div class="row">
                  <div class="col-md-12">
                    <div class="botones">
                      <div class="btn-group">
                        <button class="btn btn-primary" data-calendar-nav="prev"><i class="fa fa-fw fa-chevron-left"></i></button>
                        <button class="btn btn-default" data-calendar-nav="today">Hoy</button>
                        <button class="btn btn-primary" data-calendar-nav="next"><i class="fa fa-fw fa-chevron-right"></i></button>
                      </div>
                      <h4></h4>
                      <div class="form-group">
                      <div class="radio-inline">
                        <label class="checkbox">
                          <input type="radio" name="vista" value="year" data-calendar-view="year"> Año
                        </label>
                      </div>
                      <div class="radio-inline">
                        <label class="checkbox">
                          <input type="radio" name="vista" value="month" data-calendar-view="month"> Mes
                        </label>
                      </div>
                      <div class="radio-inline">
                        <label class="checkbox">
                          <input type="radio" name="vista" value="week" data-calendar-view="week"> Semana
                        </label>
                      </div>
                      <div class="radio-inline">
                        <label class="checkbox">
                          <input type="radio" name="vista" value="day" data-calendar-view="day" checked> Día
                        </label>
                      </div>
                    </div>
                    </div>
                    
                  </div>
                </div>
                <div id="calendar"></div>
        </div>
      </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
  
    </section>
    <!-- /.content -->
  </div>

<div class="modal fade" id="events-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title"></h3>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
