<!doctype html>
<html lang="en">
<?php 
include("conecta.php");
require_once('includes/load.php');
page_require_permission('crear_reportes');
$conn=Conectarse();
$nombre = $_POST['nombre'];
if(isset($_POST['filtros'])){
    $filtros=$_POST["filtros"]; //filtros seleccionados
    $sql = "select p.gradoAcademico, p.nombrePlan, s.SalidaLateral,p.oferta,p.tipoPlan,p.tipo_carrera,";
    for ($i=0;$i<count($filtros);$i++){
      $sql= $sql."p.".$filtros[$i].", ";
    }
    $query1= substr($sql,0,strlen($sql)-2);
    $query2= $query1." from plan p inner join salidas s on p.PlanCd=s.planId where s.planAct='Y' and p.HistoricoInd='N'";
    if(isset($_POST['oferta'])){
      $query2=$query2." and oferta in (";
      $oferta=$_POST["oferta"];
      for ($i=0;$i<count($oferta);$i++){
        $query2= $query2."'".$oferta[$i]."', ";
      }
     $query2= substr($query2,0,strlen($query2)-2);
     $query2=$query2.")";
    }
    $query2=$query2." and tipoPlan in ('".$_POST["tipoPlan"]."') and tipo_carrera in ('".$_POST['tipo_carrera']."')";
    $rs = mysqli_query($conn,$query2);
    //  echo "<br>"."<br>"."<br>"."<br>"."<br>"."<br>"."<br>"."<br>"."<br>".$query2."<br>";
  }
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
			<div class="col-md-6">
			<?php echo display_msg($msg); ?>
			</div>
        </div>
		<div class="row">
		<?php echo "<h4>".$nombre."</h4>";?>
		<hr><br><br>
		</div>
        <div class="row">
			<div class="col-md-12">
				<div class="table-responsive"> <br><br>
					<table id="example" class="table table-striped table-bordered" style="width:100%">
						<thead>
						<tr>
						<th>Nombre</th>
						<th>Salida Lat</th>
            <th>Oferta</th>
						<th>Tipo Plan</th>
						<th>Tipo Carrera</th>
						<?php for ($i=0;$i<count($filtros);$i++){
						echo "<th>".$filtros[$i]."</th>";
						}
						?>
						</tr>
						</thead>
						<tbody>
						<?php while($row = mysqli_fetch_array($rs)){
						echo "<tr>";
						echo "<td>".$row['gradoAcademico']." ".$row['nombrePlan']."</td>";
            echo "<td>".$row['SalidaLateral']."</td>";   
            echo "<td>".$row['oferta']."</td>";
						echo "<td>".$row['tipoPlan']."</td>";
						echo "<td>".$row['tipo_carrera']."</td>";                        
						for ($i=0;$i<count($filtros);$i++){
						echo "<td>".$row[$filtros[$i]]."</td>";
						}
						echo "</tr>";
						} ?>
						</tbody>
					</table>
				</div>
			</div>
        </div>
	</div><!--cierra el container-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>  
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
        buttons: [ 'copy','pdf' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>