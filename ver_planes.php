<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('');
    $usuarioActual =current_user();
   $all_groups = find_all('plan');
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
    <title>Planes de Estudio</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Planes de Estudio</h4>
            </div>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th class="text-center">Grado Académico</th>
            <th class="text-center">Nombre</th>
            <th class="text-center" style="width: 100px;">Ver estructura</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($all_groups as $a_group): ?>
          <tr>
           <td><?php echo remove_junk(ucwords($a_group['gradoAcademico']))?></td>
           <td>
            <a href="ver_estructura.php?id=<?php echo $a_group['RowID_Plan'];?>" class="btn btn-xs btn-success" data-toggle="tooltip" title="Ver">Ver</a>
           </td>
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