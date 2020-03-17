<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ver_uc');
    $usuarioActual =current_user();
   $all_groups = find_all('unidadacademica');
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
    <title>Unidades Academicas</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Unidades Académicas</h4>
            </div>
            <?php if(in_array('agregar_unidad',$permisos)){ ?>
            <div class="col-3">
            <a href="agregar_unidad_academica.php" class="btn btn-info"> Agregar Unidad Académica</a>
            </div>
            <?php } ?>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th class="text-center" style="width: 50px;">Código</th>
            <th class="text-center">Unidad Academica</th>
            <th class="text-center">Facultad Centro Sede Recinto</th>
            <?php if(in_array('editar_unidad',$permisos) || in_array('eliminar_unidad',$permisos) ){ ?>
            <th class="text-center" style="width: 100px;">Acciones</th>
            <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr>
            <td class="text-center"><?php echo $a_group['codigoU'];?></td>
           <td><?php echo remove_junk(ucwords($a_group['nombre']))?></td>
           <td class="text-center">
             <?php
             $query = find_by_key('fcs','id',$a_group['fcs_codigo']);
             echo remove_junk(ucwords($query['nombre']))?>
           </td>
           <?php if(in_array('editar_unidad',$permisos) || in_array('eliminar_unidad',$permisos) ){ ?>
           <td class="text-center">
             <div class="btn-group">
             <?php if(in_array('editar_unidad',$permisos)){ ?>
                <a href="editar_unidad_academica.php?id=<?php echo $a_group['id_unidad'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                 E
               </a>
               <?php
             }
              if(in_array('eliminar_unidad',$permisos) ){  ?>
                <a href="eliminar_unidadAcademica.php?id=<?php echo $a_group['id_unidad'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                  X
                </a>
              <?php }//}
              ?>
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