        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    

                

                  
                     <li class="treeview active">
                        <a href="<?php echo base_url();?>dashboard" data-original-title title>
                           <i class="fa fa-tachometer" aria-hidden="true"></i> <span>Inicio</span>
                           <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>dashboard"><i class="fa fa-user-circle-o"></i>Cuenta</a></li>
                            <li><a href="<?php echo base_url();?>regtuto"><i class="fa fa-video-camera"></i>Video Tutorial</a></li>
                             </ul>
                        </a>


                    </li>


                     <li class="treeview">
                                <a>
                                    <i class="fa fa-pencil-square-o"></i> <span class="title">Registro</span>
                                   <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>mantenimiento/paciente"><i class="fa fa fa-male"></i>Paciente</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/medico"><i class="fa fa-user-md"></i>Odontologo</a></li>
                             </ul>     
                       
                                   
                            </a>
                            
                     </li>
               
                    <li class="treeview">
                        <a>
                            <i class="fa fa-calendar"></i> <span>Citas</span>
                        
                       
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url();?>citas/agenda"><i class="fa fa-table"></i> Agenda</a></li>
                                    <li><a href="<?php echo base_url();?>citas/registrar"><i class="fa fa-calendar-plus-o"></i> Registrar</a></li>
                                </ul>

                         </a>
                    </li>

                     <li class="treeview">
                        <a>
                            <i class="fa fa-medkit"></i> <span>Tratamientos</span>
                        <ul class="treeview-menu">
                            <li><a href="<?= base_url('tratamientos/panel') ?>"><i class="fa fa-medkit"></i>Registrar</a>
                            <li><a href="<?= base_url('tratamientos/comprobantes') ?>"><i class="fa fa-line-chart"></i>Comprobantes</a>
                        </ul>

                        </a>
                    </li>


                            

              <li class="treeview">
                        <a>
                            <i class="fa fa-file-text-o"></i> <span>Historia clinica</span>
                       
                        
                            <ul class="treeview-menu">
                                <li><a href="<?= base_url('historia/movimiento')?>"><i class="fa fa-pencil"></i>Movimiento</a></li>
                                <!-- <li><a href="<?php echo base_url();?>historia/movimiento"><i class="fa fa-table"></i>Kardex</a></li> -->
                            </ul>
                        </a>
                    </li>

                    <li class="treeview">
                        <a>
                            <i class="fa fa-bar-chart-o"></i> <span>Reportes</span>
                           
                      
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>reportes/redashboard"><i class="fa fa-money"></i>Tratamientos cobrados</a></li>
                       
                        </ul>

                          </a>
                    </li>


                     <li class="treeview">
                                <a>
                                    <i class="fa fa-suitcase"></i> <span class="title">Procedimiento</span>
                                    
                       
                                   
                            </a>
                             <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>mantenimiento/tarifario"><i class="fa fa fa-usd"></i>Tarifario</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/diagnostico"><i class="fa fa fa-medkit"></i>Diagnostico</a></li>
                             </ul>
                     </li>



                     <li class="treeview">
                                <a>
                                    <i class="fa fa fa-wrench"></i> <span class="title">Mantenimiento</span>
                                    
                       
                                   
                            </a>
                           <ul class="treeview-menu">
                           <!--  <li><a href="<?php echo base_url();?>mantenimiento/paciente"><i class="fa fa-cube"></i>Cajeros</a></li> -->
                            <li><a href="<?php echo base_url();?>mantenimiento/pago"><i class="fa fa-newspaper-o"></i>Tipo pago</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/moneda"><i class="fa fa-dollar"></i>Moneda</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/banco"><i class="fa fa-cubes"></i>Banco</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/tarjeta"><i class="fa fa-cc-visa"></i>Tipo tarjeta</a></li>
                             </ul>
                     </li>


                      <li class="treeview">
                                <a>
                                    <i class="fa fa fa-cube"></i> <span class="title">Catalogo</span>
                                    
                       
                                   
                            </a>
                            <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>mantenimiento/medida"><i class="fa fa-cube"></i>Unidad. Medida</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/concepto"><i class="fa fa-hand-o-right"></i>Tipo concepto</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/categoria"><i class="fa fa fa-diamond"></i>Categoria</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/especialidad"><i class="fa fa-plus-square"></i>Especialidad</a></li>
                                 <li><a href="<?php echo base_url();?>mantenimiento/citado"><i class="fa fa-stethoscope"></i>Tipo citado</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/alergia"><i class="fa fa-stethoscope"></i>Alergia</a></li>
                             </ul>
                     </li>

             
                  

                      <li class="treeview">
                      <a>
                                <i class="fa fa-users"></i><span class="title">Gestión de usuarios</span>
                                
                            </a>
                           <ul class="treeview-menu">
                              <li>
                                 <a href="<?php echo base_url();?>mantenimiento/usuario"> <i class="fa fa-user"></i>       
                                 <span class="title">Usuarios</span>
                                 </a>
                             </li>
                        <li>
                          <a href="<?php echo base_url();?>mantenimiento/rol"> <i class="fa fa-briefcase"></i>
                              <span class="title">Roles</span>
                          </a>
                  
                       </li>
                       <li>
                            <a href="<?php echo base_url();?>administrador/Permisos">
                             <i class="fa fa-unlock-alt"></i> <span class="title">Permisos</span>
                            </a>
                       </li>                       
                  
               
                          </ul>
                   </li>

                    <li class="treeview">
                      <a>
                                <i class="fa fa-gear"></i><span class="title">Configuracion</span>
                                
                     </a>
                           <ul class="treeview-menu">
                              <li>
                                 <a href="<?php echo base_url();?>clinica/regclinica"> <i class="fa fa-hospital-o"></i>       
                                 <span class="title">Mi Clinica</span>
                                 </a>
                             </li>
                        <li>
                          <a href="<?php echo base_url();?>mantenimiento/tipodocumento"> <i class="fa fa-newspaper-o"></i>
                              <span class="title">Tipo Documento</span>
                          </a>
                  
                       </li>
                                      
                  
               
                          </ul>
                   </li>

            
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->
