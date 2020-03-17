<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ver_fcs');
    $user = current_user();
    $all_groups = find_all('fcs');
    $permisos = find_permissions($user['username']);
  ?>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="public/images/unatransparente.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="libs/css-files/bootstrap.min.css">
    <style>
      .bg-red {
        background-color: #CC071E;
      }

      body{
          /*background-color: #d8d6c3;*/
      }
    </style>
    <title>Ver FCSR</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Facultad, Sede, Centro, Sección Regional</h4>
            </div>
            <?php if(in_array('agregar_fcs',$permisos)){ ?>
            <div class="col-3">
            <a href="agregar_FCSR.php" class="btn btn-info"> Agregar FCSR</a>
            </div>
            <?php } ?>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th class="text-center">Código</th>
            <th class="text-center">Nombre</th>
            <?php if(in_array('editar_fcs',$permisos) || in_array('eliminar_fcs',$permisos) ){ ?>
            <th class="text-center" style="width: 100px;">Acciones</th>
            <?php }?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr>
            <td class="text-center"><?php echo $a_group['id'];?></td>
           <td><?php echo remove_junk(ucwords($a_group['codigo']))?></td>
           <td><?php echo remove_junk(ucwords($a_group['nombre']))?></td>
           <?php if(in_array('editar_fcs',$permisos) || in_array('eliminar_fcs',$permisos) ){ ?>
           <td class="text-center">
             <div class="btn-group">
             <?php if(in_array('editar_fcs',$permisos)){ ?>
                <a href="edit_fcsr.php?id=<?php echo $a_group['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  E
               </a>
               <?php
             }
             if(in_array('eliminar_fcs',$permisos)){ ?>               
                <a href="eliminar_FCSR.php?id=<?php echo $a_group['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                  X
                </a>
               <?php } //}?>
                </div>
           </td>
                <?php } ?>
          </tr>
        <?php endforeach;?>
        </tbody>

    </table><br><br>
    </div>
    </div><!-- cierra el container-->


    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <!-- <script type="text/javascript" src="libs/js-files/popper.min.js"></script> -->
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    <script type="text/javascript" src='libs/js-files/jquery.dataTables.min.js'></script>
    <script type="text/javascript" src='libs/js-files/dataTables.bootstrap4.min.js'></script>


<script>

(function() {
  var table =$('#example').dataTable( {
    responsive: true
  } );
})();

</script>
    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>