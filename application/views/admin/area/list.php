 <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

<body>
    <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                Areas
                <small>/ Listado</small>
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="box box-solid">
                    <div class="box-body">
                         <div class="row">
                                <div class="col-md-12">
                                  <?php if($this->session->flashdata("error")):?>
                                <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error");?></p>  
                                </div>
                            <?php endif;?>
                                  <?php if($permisos->insert == 1):?>
                                    <button  class="btn btn-success" onclick="add_area()"><span class="glyphicon glyphicon-plus"></span>  Agregar area</button>
                                  <?php endif;?>
                                </div>
                        </div>
                    
                     <hr>
                         <div class="row">
                                <div class="col-md-12">
                                    <table id="table" class="table table-bordered btn-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                 <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($area)):?>
                                                <?php foreach($area as $areas):?>
                                            <tr>
                                                <td><?php echo $areas->id_area;?></td>
                                                <td><?php echo $areas->nombre_area;?></td>
                                                <td><?php echo $areas->descripcion_area;?></td>
                                                <td>
                                                    <div class="btn-group">

                                                        <button class="btn btn-warning" onclick="edit_area(<?php echo $areas->id_area;?>)">
                                                            <i class="glyphicon glyphicon-pencil"></i> </button>
                                                            
                                                        <button class="btn btn-danger btn-remove" onclick="delete_area(<?php echo $areas->id_area;?>)">
                                                         <i class="glyphicon glyphicon-trash"></i> </button>
                                                       
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php endif;?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                         </div>
                     
                  
                     </div>
             </div>
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<script type="text/javascript">
    
    function add_area()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
    //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

     function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }
     function save()
    {
      var url;
      if(save_method == 'add')
      {
          url = "<?php echo site_url('mantenimiento/Area/area_add')?>";
      }
      else
      {
        url = "<?php echo site_url('mantenimiento/Area/area_update')?>";
      }

       // ajax adding data to database
          $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",

            success: function(data)
            {
               //if success close modal and reload ajax table
              //  $('#modal_form').modal('hide');
              // location.reload();// for reload a page
               $('#modal_form').modal('hide');
              

               swal(
                'Good job!',
                'Data has been save!',
                'success',

                )
                location.reload();
               // location.reload();

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

     function edit_area(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('mantenimiento/Area/area_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id_area"]').val(data.id_area);
            $('[name="nombre_area"]').val(data.nombre_area);
            $('[name="descripcion_area"]').val(data.descripcion_area);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Book'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }


    // function delete_area(id)
    // {
    //   if(confirm('Desea desactivar el area?'))
    //   {
    //     // ajax delete data from database
    //       $.ajax({
    //         url : "<?php echo site_url('mantenimiento/Area/delete/')?>/"+id,
    //         type: "POST",
    //         dataType: "JSON",
    //         success: function(data)
    //         {
               
    //            location.reload();
    //         },
    //         error: function (jqXHR, textStatus, errorThrown)
    //         {
    //             alert('Error Desactivación');
    //         }
    //     });

    //   }
    // }

         function delete_area(id)
     {

      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      }).then(function(isConfirm) {
        if (isConfirm) {

     // ajax delete data to database
     $.ajax({
      url : "<?php echo site_url('mantenimiento/Area/delete')?>/"+id,
      type: "POST",
     // data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data)
      {
               //if success reload ajax table
               $('#modal_form').modal('hide');
              reload_table();
               swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                );
             
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

     
   }
 })
      
    }
</script>

<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">AREA DE TRABAJO</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id_area"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Nombre :</label>
              <div class="col-md-9">
                <input name="nombre_area" placeholder="nombre" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Descripcion</label>
              <div class="col-md-9">
                <input name="descripcion_area" placeholder="descripcion" class="form-control" type="text">
              </div>
            </div>

          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
  
</body>
        


<!-- <script type="text/javascript">
function confirma(){
 if (confirm("¿Realmente desea eliminarlo?")){ 
 alert("El registro ha sido eliminado.") }
 else { 
 return false
 }
}
</script> -->