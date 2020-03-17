<!doctype html>
<html lang="en">
<?php
require_once('includes/load.php');
page_require_permission('crear_reportes');
    $tipo=$_POST["tipo"];
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
    <title>Filtro para Reporte</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">Información que desea incluir en el reporte
					</div>
					<div class="card-body">
						<form method="post" action="seleccionarFiltro.php" class="clearfix">
						<input type="hidden" name="tipo" value=<?php echo '"'.$tipo.'"'?>>
						<input type="text" class="form-control" name="nombre" placeholder="Titulo del Reporte" required><br>
						<table class="table table-bordered">
							<thead>
							<tr>
							<th class="text-center">Información</th>
							<th class="text-center" >Seleccionar</th>
							</tr>
							</thead>
							<tbody>
							<tr>
							<td>Código de Registro</td>
							<td><input type="checkbox" id="codigoRegistro" name="filtros[]" value="codigoRegistro"></td>
							</tr>
							<tr>
							<td>Código Banner</td>
							<td><input type="checkbox" id="codigoBanner" name="filtros[]" value="CodigoBanner"></td>
							</tr>
							<!-- <tr>
							<td>Campus</td>
							<td><input type="checkbox" id="campus" name="filtros[]" value="campus"></td>
							</tr> -->
							<tr>
							<td>Tipo de Plan</td>
							<td><input type="radio" id="tipoPlan" name="tipoPlan" value="Grado">&nbsp;Grado<br>
							<input type="radio" id="tipoPlan" name="tipoPlan" value="PosGrado">&nbsp;PosGrado<br>
							<input type="radio" name="tipoPlan" value="Grado, PosGrado">&nbsp;Todos<br></td>
							</tr>
							<tr>
							<td>Unidad Académica</td>
							<td><input type="checkbox" id="unidad_Academica" name="filtros[]" value="unidad_Academica"></td>
							</tr>
							<tr>
							<td>Tipo de Carrera (UNA o CONARE)</td>
							<td><input type="radio" name="tipo_carrera" value="UNA">&nbsp;UNA<br>
							<input type="radio" name="tipo_carrera" value="CONARE">&nbsp;CONARE<br>
							<input type="radio" name="tipo_carrera" value="UNA, CONARE">&nbsp;Todas<br></td>
							</tr>
							<tr>
							<td>Se Oferta</td>
							<td><input type="checkbox" name="oferta[]" value="Se oferta">&nbsp;Se oferta<br>
							<input type="checkbox" name="oferta[]" value="Vigente">&nbsp;Vigente<br>
							<input type="checkbox" name="oferta[]" value="Inactiva">&nbsp;Inactiva<br>
							<input type="checkbox" name="oferta[]" value="Cerrada">&nbsp;Cerrada<br>
							<input type="checkbox" name="oferta[]" value="Se oferta,Vigente,Inactiva,Cerrada">&nbsp;Todas<br></td>
							</tr>
							<tr>
							<td>Aprobación</td>
							<td><input type="checkbox" id="aprobacion" name="filtros[]" value="aprobacion"></td>
							</tr>
							<tr>
							<td>Titulaciones</td>
							<td><input type="checkbox" id="titulaciones" name="filtros[]" value="titulaciones"></td>
							</tr>
							<!-- <tr>
							<td>Salidas Laterales</td>
							<td><input type="checkbox" id="salidas" name="filtros[]" value="salidas"></td>
							</tr> -->
							</tbody>
						</table>
            <input type="submit" name="generar" class="btn btn-success" id="Generar" value="Generar">
					</div><!--cierra el card body-->
				</div><!--cierra el primer card-->
			</div><!--cierra el col -6-->
			<!--card invisible-->
			<div class="col-md-6" id="ap" >
				<div class="card">
					<div class="card-header">Aprobadas por periodo<b style="color: red;">*</b></div>
					<div class="card-body" id="cardB">
						<label for="desde">Desde</label>
						<input id='desde' type='date' name='desde'>
						<label for="hasta">Hasta</label>
						<input id='hasta' type='date' name='hasta'>
					</div> <!-- cierra el card-body-->
				</div>
			</div>
			<!--card invisible-->
      </form>
		</div>
	</div><!-- cierra el container-->
	
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>


<script>
$(document).ready(function(){
  
});

$("#tipo_carrera").click(function (){
	alert("hola");
});


</script>
    <?php include_once('layouts/footer.php');?>

</body>
</html>