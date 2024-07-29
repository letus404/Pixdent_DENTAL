<!DOCTYPE html>
<html>

<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



  <title></title>

</head>

<body>
<div class="content-wrapper">
   <section class="content-header">
               
            </section>
   <section class="content">
    
      <div class="box-body">
        <div  class="col-md-12">
    <div class="row">
    <div class="col-md-10 col-md-offset-1">

       <div class="panel panel-primary">
      <div class="panel-heading"> 
             <h3 style="text-align: center;">REGISTRAR OCURRENCIAS</h3> </div>
         <div class="panel-body">
             <form  action="<?php echo base_url();?>mantenimiento/Ocurrencias/addOcurrencias" method="POST" autocomplete="off" class="form-horizontal"  >
                 <div class="form-group">
                      <label class="col-md-4 control-label">Usuario :</label>
                       <div class="col-md-6">
                    <select name="id_usuario" id="id_usuario" class="form-control">
                      <option value="No">--Seleccionar usuario--</option>
                      <?php foreach ($user as $users):?>
                      <option value="<?php echo $users->id_usuario?>">
                        <?php echo $users->apellidos;?>
                        
                      </option>
                    <?php endforeach;?>
                    </select>
                <!-- <input name="id_area" placeholder="area" class="form-control" type="text"> -->
              </div>
                      
                </div>
                <div class="form-group">
              <label class="col-md-4 control-label" for="area">Area :</label>
              <div class="col-md-6">
                    <select name="id_area" id="id_area" class="form-control">
                         <option value="No">--Seleccionar area--</option>
                      <?php foreach ($area as $areas):?>
                      <option value="<?php echo $areas->id_area?>">
                        <?php echo $areas->nombre_area;?>
                        
                      </option>
                    <?php endforeach;?>
                    </select>
                <!-- <input name="id_area" placeholder="area" class="form-control" type="text"> -->
              </div>
            </div>

             <div class="form-group">
              <label class="col-md-4 control-label" for="problema">Tipo problema :</label>
              <div class="col-md-6">
                    <select name="id_tipo_problema" id="id_tipo_problema" class="form-control">
                      <option value="No">Seleccione un problema</option>
                      <?php foreach ($problema as $problemas):?>
                      <option value="<?php echo $problemas->id_tipo_problema?>">
                        <?php echo $problemas->tipo_nombre;?>
                        
                      </option>
                    <?php endforeach;?>
                    </select>
                <!-- <input name="id_area" placeholder="area" class="form-control" type="text"> -->
              </div>
            </div>

             <div class="form-group">
              <label class="col-md-4 control-label" for="tipodocumento">Tipo documento :</label>
              <div class="col-md-6">
                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control">
                        <option value="No">Seleccione tipo documento</option>
                      <?php foreach ($tipodocumento as $tipodocumentos):?>
                      <option value="<?php echo $tipodocumentos->id_tipo_documento?>">
                        <?php echo $tipodocumentos->nom_documento;?>
                        
                      </option>
                    <?php endforeach;?>
                    </select>
                <!-- <input name="id_area" placeholder="area" class="form-control" type="text"> -->
              </div>
            </div>
              
                 <div class="form-group">
                      <label class="col-md-4 control-label">Mensaje :</label>
                         <div class="col-md-6">
                          <textarea id="mensaje" name="mensaje" class="form-control" rows="5" placeholder="Escriba su mensaje"  required="Ingresar contenido"></textarea>
                             <!--  <input type="text" name="nombre" class="form-control" row="5" required=""> -->
                          </div>
                </div>
                

             <div class="form-group">
            <label  class="col-md-4 control-label">
              Fecha problema
                        </label>
            <div class="col-md-6">  
            <input type="date" name="fecha_problema" id="datetimepicker" 
                          class="form-control" required="">
              </div>
            </div>

               <div class="form-group">
            <label  class="col-md-4 control-label" style = "visibility:hidden">
              Fecha problema
            </label>
            <div class="col-md-6">  
            <input type="date" name="fecha_finalizado" id="datepicker" 
                          class="form-control"  style = "visibility:hidden">
              </div>
            </div>
           
             <div class="col-md-6 col-md-offset-4">
            <button type="submit"   class="btn btn-primary"> Enviar 
                        </button> 
            <a type="button" class="btn btn-default" 
                          href="<?php echo base_url();?>mantenimiento/Ocurrencias"> Cancelar </a>
             </div>
            </form>
           </div>
              </div>
        </div>
    </div>
  </div>
      </div>
  
                    
    
   </section>
  
  
</div>



</body>


</html>