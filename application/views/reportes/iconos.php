     <!--Iconos -->

  
   <!-- fin -->   
<body class="hold-transition skin-blue sidebar-mini">

    <div class="content-wrapper">
        <section class="content-header">
            
 <!-- Default box -->
 
  
    <div class="row">
       <div class="col-md-3 col-sm-6 col-xs-12">
       <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Excelente</span>
              <span class="info-box-number"><?php echo $excelente; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: 50%"></div>
              </div>
             <!--  <span class="progress-description">
                    50% Increase in 30 Days
                  </span> -->
            </div>
            <!-- /.info-box-content -->
        </div>
</div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Bueno</span>
                       <span class="info-box-number"><?php echo $bueno; ?></span>

                          <div class="progress">
                               <div class="progress-bar" style="width: 50%"></div>
                        </div>
             <!--  <span class="progress-description">
                    50% Increase in 30 Days
                  </span> -->
                  </div>
            <!-- /.info-box-content -->
               </div>
          </div>


              <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Regular</span>
                       <span class="info-box-number"><?php echo $regular; ?></span>

                          <div class="progress">
                               <div class="progress-bar" style="width: 50%"></div>
                        </div>
             <!--  <span class="progress-description">
                    50% Increase in 30 Days
                  </span> -->
                  </div>
            <!-- /.info-box-content -->
               </div>
          </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Pesimo</span>
                       <span class="info-box-number"><?php echo $pesimo; ?></span>

                          <div class="progress">
                               <div class="progress-bar" style="width: 50%"></div>
                        </div>
             <!--  <span class="progress-description">
                    50% Increase in 30 Days
                  </span> -->
                  </div>
            <!-- /.info-box-content -->
               </div>
          </div>

          <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-user-circle"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Malo</span>
                       <span class="info-box-number"><?php echo $malo; ?></span>

                          <div class="progress">
                               <div class="progress-bar" style="width: 50%"></div>
                        </div>
             <!--  <span class="progress-description">
                    50% Increase in 30 Days
                  </span> -->
                  </div>
            <!-- /.info-box-content -->
               </div>
          </div>
    
</div>
<!-- /.row -->

<div class="row">
      <section class="col-lg-12 connectedSortable">
            <div class="nav-tabs-custom">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico estadistico</h3>

                        <div class="box-tools pull-right">
                            <select name="year" id="year" class="form-control">
                                <?php foreach ($years as $year):?> 
                                   <option value="<?php echo $year->year;?>">
                                       <?php echo $year->year;?>
                                   </option>
                                   <?php endforeach;?>
                               
                            </select>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div id="grafico">
                                    <div>
                                        <div id="grafico" style="margin: 0 auto"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>

       


    <!-- /.col -->
</section>



</div>
<!-- /.row -->




    
        </section>
</div>

  </div>



</body>
