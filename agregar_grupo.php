<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('agregar_grupo');
    include("conecta.php");
    $conn = Conectarse();
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
    <title>Agregar Grupo</title>
  </head>
  <?php
  $sql= "SELECT * from permisos";
  $res = mysqli_query($conn,$sql);


  if(isset($_POST['add'])){

   $req_fields = array('group-name');
   validate_fields($req_fields);

   if(find_by_groupName($_POST['group-name']) === false ){
     $session->msg('d','<b>Error!</b> El nombre de grupo realmente existe en la base de datos');
     redirect('agregar_grupo.php', false);
   }
   if(empty($errors)){
        $name = remove_junk($db->escape($_POST['group-name']));
        // $level = remove_junk($db->escape($_POST['group-level']));
        $status = remove_junk($db->escape($_POST['status']));

        $query  = "INSERT INTO user_groups (";
        $query .="group_name,group_status";
        $query .=") VALUES (";
        $query .=" '{$name}','{$status}'";
        $query .=")";
        if($db->query($query)){
          $sql = "SELECT id from user_groups where group_name='".$name."'";
          $result = mysqli_query($conn,$sql);
          $row = mysqli_fetch_array($result);
          $id=$row['id'];

          $permisos=$_POST["permisos"];

          for ($i=0;$i<count($permisos);$i++){
            $sql="INSERT INTO grupo_permisos (id_grupo,id_permiso) VALUES ('$id','$permisos[$i]')";
            if(mysqli_query($conn,$sql)){
            //echo "Se ingresaron los permisos"."<br>";
            }
            else{
            echo "fallaron los permisos"."<br>";
            $session->msg("d", $msg."Error al ingresar los datos de permisos<br>");
            redirect('ver_grupos.php', false);

            }
          }
          //sucess
          $session->msg('s',"Grupo ha sido creado! ");
          redirect('ver_grupos.php', false);
        } else {
          //failed
          $session->msg('d','Lamentablemente no se pudo crear el grupo!');
          redirect('agregar_grupo.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('agregar_grupo.php',false);
   }
 }
?>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Grupo</h4>
            </div>
        </div><!--cierra el row--> 
        <hr>
        <?php echo display_msg($msg); ?>
        <br>

        <!---->
        <div class="col-12">
        <!-- <div class="d-flex justify-content-center"> -->
        <div class="card">
        <div class="card-header text-center">
            <b>Agregar</b>
        </div>
        <div class="card-body">
        <form method="post" action="agregar_grupo.php" class="clearfix">
		<div class="row">
          <div class="col-6">
            <div class="form-group">
                  <label for="name" class="control-label">Nombre del grupo</label>
                  <input type="name" class="form-control" name="group-name" required>
            </div>
            <!-- <div class="form-group">
                  <label for="level" class="control-label">Nivel del grupo</label>
                  <input type="number" class="form-control" min="1" name="group-level" value="1">
            </div> -->
            <div class="form-group">
              <label for="status">Estado</label>
                <select class="form-control" name="status">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
            </div>
          </div><!--cierra el col-md-6-->
          <div class="col-6">
          <h6>Seleccione los permisos que tiene el grupo</h6>
          <?php if($res->num_rows > 0){
          $res->data_seek(0);
          while($fila=$res->fetch_assoc()){ ?>
            <div class="form-check">
                <input class="form-check-input" name="permisos[]" value="<?php echo $fila['id'];?>" type="checkbox" id="<?php echo $fila['id'];?>">
                <label class="form-check-label" for="<?php echo $fila['id'];?>">
                <?php echo $fila['nombre'];?>
                </label>
            </div>
         <?php }
          }
          ?>
          </div><!--cierra el col-md-6-->
		  </div>
        </div><!--cierra el card body-->
        <div class="card-footer text-muted">
            <button type="submit" name="add" class="btn btn-primary">Agregar</button>
            </form>
        </div><!--cierra card-footer text-muted-->
        </div><!--cierra el card-->
        </div><br><!--cierra el col 12-->

        
        
    </div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>