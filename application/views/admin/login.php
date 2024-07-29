<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dental</title>
        <meta content="with=device-width, initial-scale=1, maximun-scale=1, user-scalable=no" name="viewport">
        <!-- CSS -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/template/dist/img/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url();?>assets/template/dist/img/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url();?>assets/template/dist/img/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url();?>assets/template/dist/img/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?php echo base_url();?>assets/template/dist/img/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <!-- <h1><strong>Bootstrap</strong> Login Form</h1> -->
                            <!-- <div class="description">
                                <p>
                                    This is a free responsive login form made with Bootstrap. 
                                    Download it on <a href="http://azmind.com"><strong>AZMIND</strong></a>, customize and use it as you like!
                                </p>
                            </div> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                            <div class="form-top">
                                <div class="form-top-left">
                                    <h3>SISTEMA DENTAL</h3>
                                    <p>Ingrese su nombre de usuario y contraseña</p>

                                </div>

                          
                            </div>

                                  <div class="login-box-msg">
                                 
                                     <?php if($this->session->flashdata("error")):?>
            <div class="alert alert-danger">
              <p><?php echo $this->session->flashdata("error")?></p>
            </div>
          <?php endif; ?>
                                </div>
                            <div class="form-bottom">
                                <form role="form" action="<?php echo base_url();?>auth/login" method="post" class="login-form">
                                    <div class="form-group">
                                        <label class="sr-only" for="form-username">Username</label>
                                        <input type="text" name="username" placeholder="Usuario..." class="form-username form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-password">Password</label>
                                        <input type="password" name="paswoord" placeholder="Contraseña..." class="form-password form-control" >
                                    </div>
                                    <button type="submit" class="btn">Ingresar</button>

                            <a style="color:#2D62FF;" href="<?php echo base_url();?>regpersona">¿No tiene cuenta? Crear Cuenta</a>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                            <div class="social-login-buttons">
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-twitter"></i> Twitter
                                </a>
                                <a class="btn btn-link-2" href="#">
                                    <i class="fa fa-google-plus"></i> Google Plus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="<?php echo base_url();?>assets/template/bootstrap/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url();?>assets/template/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/template/bootstrap/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url();?>assets/template/bootstrap/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>