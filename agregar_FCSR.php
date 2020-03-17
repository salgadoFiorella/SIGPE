<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
    page_require_permission('agregar_fcs');
    $user = current_user();
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
  if(isset($_POST['add_FCSR'])){
   
    include("conecta.php");
    $conn=Conectarse();

   $req_fields = array('name','codigo');
   validate_fields($req_fields);

   if(empty($errors)){
       $name   = remove_junk($db->escape($_POST['name']));
       $detalle   = remove_junk($db->escape($_POST['detalle']));
       $cod   = remove_junk($db->escape($_POST['codigo']));


        $query = "INSERT INTO fcs (";
        $query .="codigo,";
        $query .="nombre,DetalleExtra";
        $query .=") VALUES (";
        $query .="'{$cod}','{$name}', '{$detalle}'";
        $query .=");";
        if($db->query($query)){
          //sucess
          $session->msg('s',"Se ha agregado con éxito");
          redirect('agregar_FCSR.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo crear.');
          redirect('agregar_FCSR.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('agregar_fcsr.php',false);
   }
 }
?>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Facultad, Sede, Sección, Regional o Centro</h4>
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
            <b>Agregar</b>
        </div>
        <div class="card-body">
        <form method="post" action="agregar_FCSR.php">
        <!-- <div class="col-7"> -->
            <div class="form-group">
                <label for="name">Nombre de la Facultad Centro Sede o Recinto<b style="color: red;">*</b></label>
                <input type="text" class="form-control" name="name" placeholder="Nombre" required>
            </div>
            <div class="form-group">
                <label for="name">Código de la Facultad Centro Sede o Recinto<b style="color: red;">*</b></label>
                <input type="text" class="form-control" name="codigo" placeholder="Código" required>
            </div>
            <div class="form-group">
                <label for="detalle">Digite algún detalle </label>
                <input type="text" class="form-control" name="detalle" placeholder="Detalle Extra">
            </div>
        </div>
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="add_FCSR" class="btn btn-primary">Agregar</button>
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