<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ver_versiones');
    include_once("conecta.php");
    $conn = Conectarse();
    $id = $_GET['id'];
    $plan = find_by_key('plan','PlanCd',$id);
    $sql = 'SELECT * FROM versiones_pdf where plancd='.$id;
    $all_groups = mysqli_query($conn,$sql);
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
    <title>Ver versiones por plan</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Versiones Estructuras Curriculares de <?php echo $plan['nombrePlan'];?> </h4>
            </div>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th >Nombre</th>
            <th >Fecha que se cambió</th>
            <th>Ver</th>
            </tr>
        </thead>
        <tbody>
        <?php if($all_groups->num_rows > 0){
                    $all_groups->data_seek(0); 
                    while($fila=$all_groups->fetch_assoc()){?>
          <tr>
           <td><?php echo $fila['nombre'];?></td>
           <td><?php echo $fila['fecha'];?></td>
           <td>
           <?php
           echo '<a target="_blank" class="btn btn-primary" role="button" href=script/descargarVersion.php?file='.$fila['id'].'>Ver</a>';
             ?>
           </td>
          </tr>
        <?php }}?>
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