<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('editar_unidad');
    $f_uni = find_by_key('unidadacademica','id_unidad',$_GET['id']);
    $fcss  = find_all('fcs');
    if(!$f_uni){
      $session->msg("d","Unidad Aacademica No Se Encuentra.");
      redirect('ver_unidad_academica.php');
    }
    $id_unidad = $f_uni['id_unidad'];
    $archivoImagen = $f_uni['imagen'];
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
    <title>Editar Unidad Academica</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Unidad Académica</h4>
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
            <b>Editar <?php echo remove_junk(ucwords($f_uni['nombre'])); ?></b>
        </div>
        <div class="card-body">
        <form method="post" action="editarUnidad.php?id=<?php echo $id_unidad;?>" enctype="multipart/form-data">
        <input type="hidden" name="archivoImagen" value="<?php echo $archivoImagen;?>">
        <!-- <div class="col-7"> -->
        <div class="form-group">
          <label for="nombre" class="control-label">Unidad Académica</label>
          <input type="text" class="form-control" name="nombre" value="<?php echo $f_uni['nombre']; ?>" required>
        </div>
        <div class="form-group">
          <label for="codigo" class="control-label">Código</label>
          <input type="text" class="form-control" name="codigo" value="<?php echo $f_uni['codigoU']; ?>" required>
        </div>
        <div class="form-group">
          <label for="level">Facultad Centro Sede Recinto</label>
            <select class="form-control" name="codigoFCSR">
              <?php foreach ($fcss as $fcs ):?>
                <option <?php if($fcs['id'] === $f_uni['fcs_codigo']) echo 'selected="selected"';?> value="<?php echo $fcs['id'];?>"><?php echo $fcs['codigo']."-".$fcs['nombre'];?></option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="tel1" class="control-label">Teléfono #1<b style="color:red;">*</b></label>
                  <input type="text" class="form-control" value="<?php echo $f_uni['telefono1'];?>" name="tel1" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="tel2" class="control-label">Teléfono #2</label>
                  <input type="text" class="form-control" name="tel2" value="<?php echo $f_uni['telefono2'];?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="web" class="control-label">Página Web<b style="color:red;">*</b></label>
              <input type="text" class="form-control" name="web" required value="<?php echo $f_uni['pag_web'];?>">
            </div>
            <div class="form-group">
              <label for="email" class="control-label">Email<b style="color:red;">*</b></label>
              <input type="email" class="form-control" name="email" required value="<?php echo $f_uni['email'];?>">
            </div>
            <div class="form-group">
              <label for="desc" class="control-label">Descripción<b style="color:red;">*</b></label>
              <input type="text" class="form-control" name="desc" required value="<?php echo $f_uni['descripcion'];?>">
            </div>
            <div class="row">
              <div class="col-6">
                <label for="foto" class="control-label">Logo actual</label><br>
                <img src="<?php echo $archivoImagen;?>" height="80px" weight="80px">
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="foto" class="control-label">Logo<small> (No adjunte imagen si no desea modificar el logo actual)</small></label>
                  <input type="file" class="form-control" name="foto">
                </div>
              </div>
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