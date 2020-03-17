<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('agregar_unidad');
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
    </style>
    <title>Agregar Unidad Academica</title>
  </head>
  <?php
$groups  = find_all('fcs');
  if(isset($_POST['add_UnidadAcademica'])){
    include("conecta.php");
    $conn=Conectarse();

    /******************************************** */
   $req_fields = array('nombre','codigo','tel1','web','email','desc');
   validate_fields($req_fields);

   if(empty($errors)){
       $name   = remove_junk($db->escape($_POST['nombre']));
       $codigoFCSR = remove_junk($db->escape($_POST['codigoFCSR']));
       $codigo = remove_junk($db->escape($_POST['codigo']));
       $tel1 = remove_junk($db->escape($_POST['tel1']));
       if(isset($_POST['tel2'])){
         $tel2 = $_POST['tel2'];
       }else{
         $tel2 = NULL;
       }
       $web = remove_junk($db->escape($_POST['web']));
       $email = remove_junk($db->escape($_POST['email']));
       $desc = remove_junk($db->escape($_POST['desc']));
       //Imagen

        $query = "INSERT INTO unidadacademica (";
        $query .="codigoU,";
        $query .="nombre,fcs_codigo,telefono1,telefono2,pag_web,email,descripcion";
        $query .=") VALUES (";
        $query .="'{$codigo}','{$name}', '{$codigoFCSR}','{$tel1}','{$tel2}','{$web}','{$email}','{$desc}'";
        $query .=");";
        if($db->query($query)){
          //sucess
          $queryu = 'select id_unidad from unidadacademica where codigoU ="'.$codigo.'"';
          $result = mysqli_query($conn,$queryu);
          $row = mysqli_fetch_array($result);
          if(is_null($row)==false){
            //guardar_foto($row['id_unidad']);
            $ruta =$_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/unidadesAcademicas/';
            $fileName=$_FILES["foto"]["name"];
            $fileSize=$_FILES["foto"]["size"]/1024;
            $fileType=$_FILES["foto"]["type"];
            $fileTmpName=$_FILES["foto"]["tmp_name"];
            $arch = $ruta.$fileName;
            $archivofisico = 'uploads/unidadesAcademicas/'.$fileName;

            if(move_uploaded_file($fileTmpName,$arch)){
                $sql="UPDATE unidadacademica set imagen ='$archivofisico' where id_unidad=".$row['id_unidad'];
                if(mysqli_query($conn,$sql)){
                    //echo "Subida exitosa del doc";
                }else{
                    $session->msg("d", $msg."Error: no se pudo cargar el logo, inténtelo al editar.");
                    redirect('ver_unidad_academica.php', false);
                }
            }else{
                $session->msg("d", $msg."No se pudo subir");
                redirect('ver_unidad_academica.php', false);
            }
          }
          $session->msg('s',"Acción Exitosa");
          redirect('ver_unidad_academica.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo crear la unidad academica, intente de nuevo.');
          redirect('agregar_unidad_academica.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('agregar_unidad_academica.php',false);
   }
 }
?>
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
            <b>Agregar</b>
        </div>
        <div class="card-body">
        <form method="post" action="agregar_unidad_academica.php" enctype="multipart/form-data">
        <!-- <div class="col-7"> -->
        <div class="form-group">
                  <label for="nombre" class="control-label">Unidad Academica<b style="color:red;">*</b></label>
                  <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="form-group">
                  <label for="nombre" class="control-label">Código<b style="color:red;">*</b></label>
                  <input type="text" class="form-control" name="codigo" required>
        </div>
            <div class="form-group">
              <label for="level">Facultad Centro Sede Recinto<b style="color:red;">*</b></label>
                <select class="form-control" name="codigoFCSR">
                  <?php foreach ($groups as $group ):?>
                   <option  value="<?php echo $group['id'];?>"><?php echo $group['codigo']."-".$group['nombre'];?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="tel1" class="control-label">Teléfono #1<b style="color:red;">*</b></label>
                  <input type="text" class="form-control" name="tel1" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="tel2" class="control-label">Teléfono #2</label>
                  <input type="text" class="form-control" name="tel2" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="web" class="control-label">Página Web<b style="color:red;">*</b></label>
              <input type="text" class="form-control" name="web" required>
            </div>
            <div class="form-group">
              <label for="email" class="control-label">Email<b style="color:red;">*</b></label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
              <label for="desc" class="control-label">Descripción<b style="color:red;">*</b></label>
              <input type="text" class="form-control" name="desc" required>
            </div>
            <div class="form-group">
              <label for="foto" class="control-label">Logo<small> (No adjunte imagen si no desea modificar el logo actual)</small></label>
              <input type="file" class="form-control" name="foto" required>
            </div>
            </div><!--card body-->
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="add_UnidadAcademica" class="btn btn-primary">Agregar</button>
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