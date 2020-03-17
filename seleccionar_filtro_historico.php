<!doctype html>
<html lang="en">
  <?php
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
    <title>Seleccionar filtro para reporte</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
      <div class="row">
        <div class="col-md-9">
          <div class="card ">
            <div class="card-header text-center">
              Información que desea incluir en el reporte de historicos
            </div>
            <div class="card-body">
            <form method="post" action="ver_historicos.php" class="clearfix">
              <input type="text" class="form-control" name="nombre" placeholder="Titulo del Reporte Historico" required><br>
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
                  <td><input type="checkbox" id="tipoPlan" name="filtros[]" value="tipoPlan"></td>
                  </tr>
                  <tr>
                  <td>Unidad Académica</td>
                  <td><input type="checkbox" id="unidad_Academica" name="filtros[]" value="unidad_Academica"></td>
                  </tr>
                  <tr>
                  <td>Tipo de Carrera (UNA o CONARE)</td>
                  <td><input type="checkbox" id="tipo_carrera" name="filtros[]" value="tipo_carrera"></td>
                  </tr>
                  <tr>
                  <td>Estado de oferta</td>
                  <td><input type="checkbox" id="oferta" name="filtros[]" value="oferta"></td>
                  </tr>
                  <tr>
                  <td>Aprobación</td>
                  <td><input type="checkbox" id="aprobacion" name="filtros[]" value="aprobacion"></td>
                  </tr>
                  <tr>
                  <td>Titulaciones</td>
                  <td><input type="checkbox" id="titulaciones" name = "titulaciones" value="titulaciones"></td>
                  </tr>
                  <!-- <tr>
                  <td>Salidas Laterales</td>
                  <td><input type="checkbox" id="salidas" name="filtros[]" value="salidas"></td>
                  </tr> -->
                </tbody>
              </table>
            </div>
            <div class="card-footer text-muted">
              <input type="submit" name="generar" class="btn btn-success" id="Generar" value="Generar">
              </form>
            </div>
          </div>
          </div>
          </div>
          </div><!--cierra el container-->


    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <!-- <script type="text/javascript" src="libs/js-files/popper.min.js"></script> -->
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
        
    <?php include_once('layouts/footer.php');?>

  </body>
</html>