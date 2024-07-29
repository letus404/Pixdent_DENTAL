<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes
        <small>Trat. cobrados</small>
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $cantpacientes; ?></h3>

              <p>Pacientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-man"></i>
            </div>
            <a href="<?php echo base_url();?>mantenimiento/paciente" class="small-box-footer">Ver pacientes <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $cantratamientopag; ?></h3>

              <p>Tratamientos cobrados</p>
            </div>
            <div class="icon">
              <i class="fa  fa-usd"></i>
            </div>
            <a href="#" class="small-box-footer">ver tratamientos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $cantratamientocob; ?></h3>

              <p>Tratamientos por cobrar</p>
            </div>
            <div class="icon">
              <i class="fa fa-credit-card"></i>
            </div>
            <a href="#" class="small-box-footer">ver tratamientos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $cantmedicos; ?></h3>

              <p>Odontologos Habilitados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">ver odontologos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
   
          <!-- /.nav-tabs-custom -->
    <!-- Calendar -->
          <div class="box box-solid bg-light-blue-gradient">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title">Calendario</h3>


              <!-- tools box -->
              <div class="pull-right box-tools">
           
                <button type="button" class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
         
              </div>




              <!-- /. tools -->
            </div>


        
            <!-- /.box-body -->
            <div class="box-footer text-black">
                     <div class="box-tools pull-right">
                        <label>Año:</label>
                            <select name="year" id="year" class="form-control">
                                <?php foreach ($years as $year):?> 
                                   <option value="<?php echo $year->year;?>">
                                       <?php echo $year->year;?>
                                   </option>
                                   <?php endforeach;?>
                               
                            </select>
                        </div>
              <div class="row">
                <div class="col-sm-12">
                    <!-- button with a dropdown -->
         
                     <div class="col-md-12">
                       
                                    <div>
                                        <div id="grafico" style=" margin: 0 auto"></div>

                                    </div>
                
                            </div>

                </div>
        
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>



        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->

        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>


</div>
<!-- ./wrapper -->


</body>
</html>
