<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    include("conecta.php");
    page_require_permission('ofertar_plan');
    $conn = Conectarse();
  $usuarioActual =current_user();
  $consulta = "SELECT RowID_Plan, PlanCd,codigoRegistro, nombrePlan,oferta,gradoAcademico FROM plan WHERE oferta in(2,3,4)  ORDER BY nombrePlan";
  $rs = mysqli_query($conn,$consulta);
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
    <title>Ofertar Plan</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Planes que no se ofertan</h4>
            </div>
        </div><!--cierra el row--> 
        <?php echo display_msg($msg); ?>
        <hr>
        <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Cod Registro</th>
            <th class="text-center" style="width: 10%;">Estado</th>
            <th class="text-center" style="width: 100px;">Ofertar</th>
            </tr>
        </thead>
        <?php while($row = mysqli_fetch_array($rs)){ ?>
          <tr>
           <td class="text-center"><?php echo $row['gradoAcademico']." ".$row['nombrePlan']?></td>
           <td class="text-center"><?php echo $row['codigoRegistro']?></td>
           <td class="text-center">
           <?php if($row['oferta'] == 2){ ?>
            <?php echo "No se oferta"; ?>
          <?php }if($row['oferta'] == 3){  ?>
            <?php echo "Inactivo"; ?>
          <?php }if($row['oferta'] == 4) {?>
            <?php echo "Cerrado"; ?>
          <?php } ?>
           </td>
           <td style="display:none;"><?php echo $row['RowID_Plan']; ?></td>
           <td style="display:none;"><?php echo $row['PlanCd']; ?></td>
           <td class="text-center">
             <div class="btn-group">
             <a href="activar_plan.php?planCd=<?php echo $row["PlanCd"];?>" title="ofertar" class="btn btn-primary btn-sm">Ofertar</a>
             <!-- <button type="button" onclick='javascript:ofertar(<?php //echo $row["PlanCd"];?>);' class="btn btn-primary btn-sm">Ofertar</button> -->
              </div>
           </td>

          </tr>
        <?php }?>
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