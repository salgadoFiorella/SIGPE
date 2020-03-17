<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('editar_fcs');
    $facultad = find_by_key('fcs','id',$_GET['id']);
    $groups  = find_all('fcs');
    if(!$facultad){
      $session->msg("d","FCSR No Se Encuentra.");
      redirect('ver_fcsr.php');
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
    <title>Editar FCSR</title>
  </head>
  <?php
//Update User basic info
  if(isset($_POST['update'])) {
    $req_fields = array('nombre','codigo');
    validate_fields($req_fields);
    if(empty($errors)){
             $id = $facultad['id'];
           $name = remove_junk($db->escape($_POST['nombre']));
           $codigo = remove_junk($db->escape($_POST['codigo']));
       $DetalleExtra = remove_junk($db->escape($_POST['DetalleExtra']));
       $status = remove_junk($db->escape($_POST['status']));
            $sql = "UPDATE fcs SET nombre ='{$name}', DetalleExtra ='{$DetalleExtra}', codigo = '{$codigo}' WHERE id='{$db->escape($id)}'";
            //echo $sql;
         $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Datos Actualizados");
            redirect('ver_fcsr.php', false);
          } else {
            $session->msg('d',' Lo siento no se actualizó los datos.');
            redirect('edit_fcsr.php?id='.$facultad['codigo'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_fcsr.php?id='.$facultad['codigo'],false);
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
            <b>Editar <?php echo remove_junk(ucwords($facultad['nombre'])); ?></b>
        </div>
        <div class="card-body">
        <form method="post" action="edit_fcsr.php?id=<?php echo $facultad['id'];?>">
        <!-- <div class="col-7"> -->
            <div class="form-group">
                <label for="name">Nombre de la Facultad Centro Sede o Recinto<b style="color: red;">*</b></label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo $facultad['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="name">Código<b style="color: red;">*</b></label>
                <input type="text" class="form-control" name="codigo" placeholder="Código" value="<?php echo $facultad['codigo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="detalle">Detalle Extra </label>
                <input type="text" class="form-control" name="DetalleExtra" value="<?php echo $facultad['DetalleExtra']; ?>" placeholder="Detalle Extra">
            </div>
        </div>
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="update" class="btn btn-primary">Editar</button>
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