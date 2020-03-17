<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ver_versiones');
    $usuarioActual =current_user();
   $all_groups = find_all('plan');
   include_once("conecta.php");
    $conn = Conectarse();
  $sql = "select p.PlanCd, p.gradoAcademico, p.nombrePlan, p.codigoRegistro from plan p inner join versiones_pdf v on p.PlanCd=v.plancd where p.HistoricoInd='Y'";
  $result = mysqli_query($conn,$sql);
  
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
    <title>Ver Estructuras</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Versiones Estructuras Curriculares por plan</h4>
            </div>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th >Cód Registro</th>
            <th >Nombre</th>
            <th>Ver versiones</th>
            </tr>
        </thead>
        <tbody>
        <?php if($result->num_rows > 0){
                $result->data_seek(0);
                while($fila=$result->fetch_assoc()){
          echo "<tr>";
          echo "<td>".$fila['codigoRegistro']."</td>";
          echo "<td>".$fila['gradoAcademico']." ".$fila['nombrePlan']."</td>";
          echo '<td><a href="ver_versiones.php?id='.$fila['PlanCd'].'" class="btn btn-xs btn-success" data-toggle="tooltip" title="Ver">Ver</a></td>';
          echo "</tr>";
         } }?>
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