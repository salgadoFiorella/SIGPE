<!doctype html>
<html lang="en">
<?php 
include("conecta.php");
require_once('includes/load.php');
page_require_permission('crear_reportes');
$nombre=$_POST['nombre'];

$conn=Conectarse();
$tipo= $_POST['tipo'];
if(isset($_POST['filtros'])) {
$sql="SELECT PlanCd,gradoAcademico, nombrePlan,tipoPlan, tipo_carrera, oferta, ";
  $filtros=$_POST["filtros"];
  for ($i=0;$i<count($filtros);$i++){
    $sql= $sql.$filtros[$i].", ";
  }
 $sql1= substr($sql,0,strlen($sql)-2);
  
  if($tipo==="aprobadas"){
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
  }

  if($tipo==="OfertadoVigente"){
    $sql1=$sql1." from plan where HistoricoInd='N'";
    if(isset($_POST['oferta'])){
      $sql1=$sql1." and oferta in (";
      $oferta=$_POST["oferta"];
      for ($i=0;$i<count($oferta);$i++){
        $string = "".$oferta[$i].", ";
        
      }
     $string= substr($string,0,strlen($string)-2);
     $arrayOferta = explode(",", $string);
     $sql2 = "'".implode("','",$arrayOferta)."'";
     $sql1 = $sql1 . $sql2;

     $sql1=$sql1.")";
    }
    
    if(isset($_POST['tipoPlan'])){
      $sql1= $sql1." and tipoPlan in (";
      $tipoPlanP = $_POST["tipoPlan"];
      $tipoPlanP = str_replace(' ', '', $tipoPlanP);
      $array = explode(",", $tipoPlanP);
      $nuevoString = "'".implode("','",$array)."'";
      $sql1 = $sql1 . $nuevoString;
      $sql1=$sql1.")";
    }
    if(isset($_POST['tipo_carrera'])){
      $sql1 = $sql1 . "and tipo_carrera in (";
      $tipoCarrera = $_POST['tipo_carrera'];
      $tipoCarrera = str_replace(' ', '', $tipoCarrera);
      $arrayTipoC = explode(",",$tipoCarrera);
      $stringTipoC = "'".implode("','",$arrayTipoC) . "'";
      $sql1 = $sql1 . $stringTipoC.")";
    }
  }
  
  if($tipo==="PlanTerminal"){
    $sql1=$sql1." from plan where declaracion_planTerminal='S' and HistoricoInd='N'";
    if(isset($_POST['oferta'])){
      $sql1=$sql1." and oferta in (";
      $oferta=$_POST["oferta"];
      for ($i=0;$i<count($oferta);$i++){
        $sql1= $sql1."'".$oferta[$i]."', ";
      }
     $sql1= substr($sql1,0,strlen($sql1)-2);
     $sql1=$sql1.")";
    }
    if(isset($_POST['tipoPlan'])){
      $sql1= $sql1." and tipoPlan in (";
      $tipoPlanP = $_POST["tipoPlan"];
      $tipoPlanP = str_replace(' ', '', $tipoPlanP);
      $array = explode(",", $tipoPlanP);
      $nuevoString = "'".implode("','",$array)."'";
      $sql1 = $sql1 . $nuevoString;
      $sql1=$sql1.")";
    }
    if(isset($_POST['tipo_carrera'])){
      $sql1 = $sql1 . "and tipo_carrera in (";
      $tipoCarrera = $_POST['tipo_carrera'];
      $tipoCarrera = str_replace(' ', '', $tipoCarrera);
      $arrayTipoC = explode(",",$tipoCarrera);
      $stringTipoC = "'".implode("','",$arrayTipoC) . "'";
      $sql1 = $sql1 . $stringTipoC.")";
    }
    
    
  }
  if($tipo==="aprobadas"){
    $desde=$_POST['desde'];
    $hasta=$_POST['hasta'];
    $sql1=$sql1." from plan where aprobacion between '".$desde."' AND '".$hasta."' and HistoricoInd='N'";
    if(isset($_POST['oferta'])){
      $sql1=$sql1." and oferta in (";
      $oferta=$_POST["oferta"];
      for ($i=0;$i<count($oferta);$i++){
        $sql1= $sql1."'".$oferta[$i]."' ".", ";
      }
     $sql1= substr($sql1,0,strlen($sql1)-2);
     $sql1=$sql1.")";
    }

    if(isset($_POST['tipoPlan'])){
      $sql1= $sql1." and tipoPlan in (";
      $tipoPlanP = $_POST["tipoPlan"];
      $tipoPlanP = str_replace(' ', '', $tipoPlanP);
      $array = explode(",", $tipoPlanP);
      $nuevoString = "'".implode("','",$array)."'";
      $sql1 = $sql1 . $nuevoString;
      $sql1=$sql1.")";
    }
    if(isset($_POST['tipo_carrera'])){
      $sql1 = $sql1 . "and tipo_carrera in (";
      $tipoCarrera = $_POST['tipo_carrera'];
      $tipoCarrera = str_replace(' ', '', $tipoCarrera);
      $arrayTipoC = explode(",",$tipoCarrera);
      $stringTipoC = "'".implode("','",$arrayTipoC)."'";
      $sql1 = $sql1 . $stringTipoC.")";
    }
 
    
  }

$rs = mysqli_query($conn, $sql1);
}
else{}
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
    <title><?php echo $nombre;?></title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
		<div class="row">
			<h4><?php echo $nombre;?></h4>
			<hr>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive"> 
					<table id="example" class="table table-striped table-bordered"  style="width:100%">
						<thead>
						<tr>
						<th>Nombre</th>
						<th>Oferta</th>
						<th>Tipo Plan</th>
						<th>Tipo Carrera</th>
						<?php for ($i=0;$i<count($filtros);$i++){
						echo "<th>".$filtros[$i]."</th>";
            }
            if(isset($_POST["titulaciones"])){
              echo "<th> Titulaciones </th>";
            }
						?>
						</tr>
						</thead>
						<tbody>
            <?php 

            while($row = mysqli_fetch_array($rs)){
						echo "<tr>";
						echo "<td>".$row['gradoAcademico']." ".$row['nombrePlan']."</td>";
						echo "<td>".$row['oferta']."</td>";
						echo "<td>".$row['tipoPlan']."</td>";
						echo "<td>".$row['tipo_carrera']."</td>";
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
			</div>
		</div><!--row-->
	</div><!--cierra el container-->
	
  <script type="text/javascript" src="libs/js-files/jquery-3.4.1.js"></script>

    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script> <!--siempre necesario-->
    <script type="text/javascript" src='libs/js-files/jquery.dataTables.min.js'></script>
    <script type="text/javascript" src='libs/js-files/dataTables.bootstrap4.min.js'></script>
   
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
        buttons: [ 'copyHtml5','pdf','excel' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>

