<!doctype html>
<html lang="en">
<?php
$page_title = 'Reportes Generales';
require_once('includes/load.php');
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
    <title>Ver FCSR</title>
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
        <div class="col-md-9">
          <div class="card">
            <div class="card-header text-center">Tipos de Reporte</div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                  <th class="text-center">Reporte</th>
                  <th class="text-center" >Seleccionar</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <td><form method="post" action="filtro_reportes.php" class="clearfix"><label>Carreras con oferta</label><input type="hidden" name="tipo" value="OfertadoVigente"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr>
                  <tr>
                  <td><form method="post" action="filtro-reportes.php" class="clearfix"><label>Carreras Por Campus</label><input type="hidden" name="tipo" value="PorCampus"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr>
                  <tr>
                  <td><form method="post" action="filtro_reportes.php" class="clearfix"><label>Carreras con Declaración de Plan Terminal</label><input type="hidden" name="tipo" value="PlanTerminal"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr>
                  <!-- <tr>
                  <td><form method="post" action="filtro_reportes.php" class="clearfix"><label>Carreras Inactivas</label><input type="hidden" name="tipo" value="Inactivas"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr> -->
                  <!-- <tr>
                  <td><form method="post" action="filtro_reportes.php" class="clearfix"><label>Carreras Ofertadas y No Ofertadas</label><input type="hidden" name="tipo" value="NoOfertadas"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr> -->
                  <tr>
                  <td><form method="post" action="filtro-aprobados.php" class="clearfix"><label>Carreras Aprobadas por Periodo</label><input type="hidden" name="tipo" value="aprobadas"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr>
                  <tr>
                  <td><form method="post" action="reporte-filtros.php" class="clearfix"><label>Carreras con salidas laterales</label><input type="hidden" name="tipo" value="salidasLat"></td>
                  <td><button type="submit" name="selec" class="btn btn-info active">Seleccionar</button></form></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div><!-- cierra el container-->

    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <!-- <script type="text/javascript" src="libs/js-files/popper.min.js"></script> -->
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
    <?php include_once('layouts/footer.php');?>

</body>
</html>