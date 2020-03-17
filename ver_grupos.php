<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ver_grupo');
    $all_groups = find_all('user_groups');
    $usuarioActual =current_user();
    $permisos = find_permissions($usuarioActual['username']);
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
    <title>Ver grupos</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Administrar grupos</h4>
            </div>
            <?php if(in_array('agregar_grupo',$permisos)){ ?>
            <div class="col-3">
            <a href="agregar_grupo.php" class="btn btn-info">Agregar grupo</a>
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
            <th class="text-center">Nombre del grupo</th>
            <!-- <th class="text-center">Nivel</th> -->
            <th class="text-center" style="width: 10%;">Estado</th>
            <?php if(in_array('editar_grupo',$permisos) || in_array('eliminar_grupo',$permisos) ){ ?>
            <th class="text-center" style="width: 100px;">Acciones</th>
            <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr>
           <td class="text-center"><?php echo $a_group['id'];//count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_group['group_name']))?></td>
           <td class="text-center">
           <?php if($a_group['group_status'] === '1'): ?>
            <span style="color: green;"><b><?php echo "Activo"; ?></b></span>
          <?php else: ?>
            <span style="color: red;"><b><?php echo "Inactivo"; ?></b></span>
          <?php endif;?>
           </td>
           <?php if(in_array('editar_usuarios',$permisos) || in_array('eliminar_grupo',$permisos) ){ ?>
           <td class="text-center">
             <div class="btn-group">
             <?php if(in_array('editar_grupo',$permisos)){ ?>
                <a href="edit_grupo.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                  E
               </a>
             <?php }
               if(in_array('eliminar_grupo',$permisos)){
                 if($a_group['id'] !=1){ ?>
                <a href="eliminar_grupo.php?id=<?php echo (int)$a_group['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                  X
                </a>
               <?php } }?>
                </div>
           </td>
           <?php }?>
          </tr>
        <?php endforeach;?>
       </tbody>
    </table><br><br>
    </div>
    </div><!-- cierra el container-->


    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    
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