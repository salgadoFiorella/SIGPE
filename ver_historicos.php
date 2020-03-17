<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    include("conecta.php");
    $conn=Conectarse();
    page_require_permission('crear_reportes');
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
    <title><?php echo $_POST['nombre'];?></title>
  </head>
  <?php 
  if(isset($_POST['filtros'])) {
    $nombre=$_POST['nombre'];
      $sql="SELECT PlanCd, gradoAcademico, nombrePlan, ";
        $filtros=$_POST["filtros"];
        for ($i=0;$i<count($filtros);$i++){
          $sql= $sql.$filtros[$i].", ";
        }
      $sql1= substr($sql,0,strlen($sql)-2);

      $sql1=$sql1." from plan where HistoricoInd='Y'";

      $rs = mysqli_query($conn,$sql1);
  }
?>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
      <div class="row">
        <div class="col-md-6">
          <?php echo display_msg($msg); ?>
          <h1><?php echo $nombre;?></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-responsive"> 
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                <th>Nombre</th>
                <?php for ($i=0;$i<count($filtros);$i++){
                echo "<th>".$filtros[$i]."</th>";
                }
                if(isset($_POST["titulaciones"])){
                  echo "<th>Titulaciones</th>";
                }
                ?>
                </tr>
              </thead>
              <tbody>
                
                <?php 
                
                while($row = mysqli_fetch_array($rs)){
                echo "<tr onclick='redireccionar(".$row['PlanCd'].")'>";
                echo "<td>".$row['gradoAcademico']." ".$row['nombrePlan']."</td>";
                for ($i=0;$i<count($filtros);$i++){
                echo "<td>".$row[$filtros[$i]]."</td>";
                }
                if(isset($_POST["titulaciones"])){
                  $planId =  $row['PlanCd']; 
                  $sql3 = "SELECT nombre FROM titulaciones WHERE planId like '$planId'";
                  $rs2 = mysqli_query($conn, $sql3);
    
                  while($row2 = mysqli_fetch_array($rs2)){
                      echo "<td>".$row2['nombre']."</td>";
                  }
                }
                echo "</tr>";
                } ?>
              </tbody>
            </table>
          </div>
          <!-- <form action="script/ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
              <p>Exportar a Excel  <img src="public\images\excel.png" class="botonExcel" width="50" height="50" style="cursor: pointer;"/></p>
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
          </form> -->
        </div>
      </div>
    </div><!-- cierra el container-->

  

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>   -->
    <script type="text/javascript" src="libs/js-files/jquery-3.4.1.js"></script>  
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script> <!--siempre necesario-->
   
    <script type="text/javascript" src='libs/js-files/jquery.dataTables.min.js'></script>
   <!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> siempre necesario -->
    
    <script type="text/javascript" src='libs/js-files/dataTables.bootstrap4.min.js'></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
    <script type="text/javascript" src='libs/js-files/dataTables.buttons.min.js'></script>
    <script type="text/javascript" src='libs/js-files/buttons.bootstrap4.min.js'></script>
    <script type="text/javascript" src='libs/js-files/jszip.min.js'></script>
    <script type="text/javascript" src='libs/js-files/pdfmake.min.js'></script>
    <script type="text/javascript" src='libs/js-files/vfs_fonts.js'></script>
    <script type="text/javascript" src='libs/js-files/buttons.html5.min.js'></script>
    <script type="text/javascript" src='libs/js-files/buttons.print.min.js'></script>
    <script type="text/javascript" src='libs/js-files/buttons.colVis.min.js'></script>
    <link rel="stylesheet" type="text/css" href="libs/css-files/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" type="text/css" href="libs/css-files/buttons.bootstrap4.min.css"/>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy','pdf','excel' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
    
function redireccionar(plancd){
  window.open("vista-historico-detalles.php?plan="+plancd);
}
</script>
    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>