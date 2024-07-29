<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DentalSac | Cuenta</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Datos de tu cuenta</h3>
                </div><!-- /.box-header -->
            <div class="box-body box-profile">
                  <div class="row">
                    <div class="col-xs-12">
                          <div class="box box-widget widget-user-2">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                          <div class="widget-user-header bg-primary">

                             <img class="profile-user-img img-responsive img-circle" src="<?= base_url() ?>assets/img/usuario_inicio.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?= $this->session->userdata('nombre') ?></h3>
              <h5 class="membership-big-txt emailr" style="text-align: center;"><?= $this->session->userdata('nombrerol') ?></h5>
                        
                      
                          </div>

                                <br>
                          <div class="box-footer no-padding">
                            <ul class="list-group list-group-unbordered">
                             
                              
                              <li class="list-group-item">
                                <b><strong>Direccion:</strong></b>&nbsp; <?php echo $_SESSION["direccion"]?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-taxi"></i></span>
                              </li>
                              <li  class="list-group-item">
                                <b><strong>Clinica:</strong></b>&nbsp; <?php echo $_SESSION["clinica"]?> <span class="pull-right badge bg-yellow"><i class="fa fa-hospital-o"></i></span>
                              </li>
                              <li  class="list-group-item">
                                <b><strong>Telefono:</strong></b>&nbsp; <?php echo $_SESSION["telefono"]?> <span class="pull-right badge bg-blue"><i class="fa fa-fw fa-mobile-phone"></i></span>
                              </li>
                              <li class="list-group-item">
                                <b><strong>Email:</strong></b>&nbsp; <?php echo $_SESSION["email"]?> <span class="pull-right badge bg-green"><i class="fa fa-fw fa-envelope"></i></span>
                              </li>
                              <li class="list-group-item">
                                <b><strong>Usuario sesion:</strong></b>&nbsp; <?php echo $_SESSION["logi_usu"]?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-user"></i></span>
                              </li>
                              <hr>
                               <h4 style="text-align: center;"> <span class="label label-success"><?php echo $_SESSION["plan"]?></span> </h4>
                            </ul>

                          </div>

                        </div><!-- /.widget-user -->

                    </div>
                  </div>
             

         

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
    
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary collapsed-box">
            
               <div class="box-header with-border">
                
             
                  <h3 class="box-title">Anuncios</h3>
                  <div class="box-tools pull-right">
                    <div class="user-block">
                    <a  target="_blank" href="https://www.facebook.com/Dentalsac-293538311576573/?ref=br_rs">
                    <img class="img-circle img-bordered-sm" src="<?= base_url() ?>assets/img/sociales/facebook.png" alt="User Image"></a>
        
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=5192398412"><img class="img-circle img-bordered-sm" src="<?= base_url() ?>assets/img/sociales/whatsapp.png" alt="User Image"></a>
          
                          
                         
                  
                  </div>
                  </div>
              
      
                </div><!-- /.box-header -->
              <div>
              <div class="nav-tabs-custom">
            <hr>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <!-- Post -->
                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="<?= base_url() ?>assets/img/adminsistemas.jpg" alt="user image">
                        <span class="username">
                          <a>Sistema Web Odontologico - DentalSAC</a>
                         
                        </span>
                    <span class="description">Administrador del Sistema - 10:44 PM 11/07/2019</span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    Bienvenido al sistema odontologico Dentalsac  desarrollado para clínicas y consultorios odontológicos con el objetivo de sistematizar sus procesos en registro de citas,pagos de tratamientos, historia clínica y odontograma virtual.
                  </p>
               <!--    <ul class="list-inline">
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                    </li>
                    <li class="pull-right">
                      <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
                  </ul> -->

           
                </div>
                <!-- /.post -->

                <!-- Post -->
                <div class="post clearfix">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="<?= base_url() ?>assets/img/analista.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Buscar agenda de citas  </a> <small class="label bg-yellow">nuevo</small>

              
    
                         
                        </span>


                    <span class="description">Sent you a message - 3 days ago</span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    Aqui dejamos el manual de como registrar  y buscar tu agenda de citas odontologicas por especialidades de manera muy rapida.
                  </p>

                   <form class="form-horizontal">
                    <div class="form-group margin-bottom-none">
                     
                      <div class="col-sm-8">
                       <a href="#" style="font-weight:bold;font-size:15px;color:#00B200;" data-original-title="" title="">Click aqui - ver tutorial completo del sistema</a>
                      </div>
                    </div>
                  </form>

            
                </div>
                <!-- /.post -->

                <!-- Post -->
              
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
        
              <!-- /.tab-pane -->


              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>

    </section>
    <!-- /.content -->
  </div>

</body>
</html>
