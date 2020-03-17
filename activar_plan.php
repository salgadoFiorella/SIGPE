<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('ofertar_plan');
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
  <?php
   include("conecta.php"); 
   $conn = Conectarse();
 
   if(isset($_POST['update'])){
     $oferta = $_POST['oferta'];
     $plan =$_POST['id'];
     $sql = 'UPDATE plan set oferta='.$oferta.' where PlanCd='.$plan;
     echo $sql;
     if(mysqli_query($conn,$sql)){
       $session->msg("s","Se modificó el estado de oferta del plan.");
       redirect('ofertar_planes.php', false);
     
     }else{
       $session->msg("d","Error, no se ha podido modificar la oferta de ese plan. Intente de nuevo por favor");
       redirect('ofertar_planes.php', false);
     } 
     }
   $plan = $_GET['planCd'];
   $query ="SELECT nombrePlan, gradoAcademico from plan where PlanCd=".$plan;
   $result = mysqli_query($conn,$query);
   $row = mysqli_fetch_array($result);
?>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4><?php echo $row['gradoAcademico'].' '.$row['nombrePlan']."<br>"; ?></h4>
            </div>
        </div><!--cierra el row--> 
        <hr>
        <?php echo display_msg($msg); ?>
        <br>

        <!---->
        <div class="col-9">
        <!-- <div class="d-flex justify-content-center"> -->
        <div class="card">
        <div class="card-header text-center">
            <b>Cambiar estado de oferta</b>
        </div>
        <div class="card-body">
        <form method="post" action="activar_plan.php" class="clearfix">
      <div class="form-group">
            <div class="radio"> 
                <label><input type="radio" value="Se oferta" name="oferta" checked=""><span style="font-size:18px">Se oferta</span></label>
            </div> 
            <div class="radio"> 
                <label><input type="radio" value="Vigente" name="oferta" ><span style="font-size:18px">Vigente</span></label>
            </div> 
            <div class="radio"> 
                <label><input type="radio" value="Inactiva" name="oferta" ><span style="font-size:18px">Inactiva</span></label>
            </div> 
            <div class="radio"> 
                <label><input type="radio" value="Cerrada" name="oferta"><span style="font-size:18px">Cerrada</span></label>
            </div> 
        </div>
        <div class="form-group clearfix">
              <input type="hidden" name="id" value="<?php echo $plan;?>">
        </div>

        </div>
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="update" class="btn btn-primary">Cambiar</button>
            </form>
        </div>
        </div>
        </div><br>
        
    </div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>