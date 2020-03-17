<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('editar_grupo');
    $id = $_GET['id'];
    $e_group = find_by_id('user_groups',$id);
    include("conecta.php");
    $conn = Conectarse();
    $user = current_user();
  if(!$e_group){
    $session->msg("d","Missing Group id.");
    redirect('ver_grupos.php');
  }
  $sql= "SELECT * from permisos";
  $res = mysqli_query($conn,$sql);

  $sql1= "SELECT id,id_permiso from grupo_permisos where id_grupo=".$id;
  $res1 = mysqli_query($conn,$sql1);
  $permisos1 = array();
  $array = array();
  if($res1->num_rows > 0){
    $res1->data_seek(0);
    while($fila=$res1->fetch_assoc()){
        array_push($permisos1,$fila['id_permiso']);
        $array[$fila['id_permiso']]=$fila['id'];
    }
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
    <title>Editar grupo</title>
  </head>
  <?php
  if(isset($_POST['update'])){

   $req_fields = array('group-name');
   validate_fields($req_fields);
   if(empty($errors)){
        $name = remove_junk($db->escape($_POST['group-name']));
        // $level = remove_junk($db->escape($_POST['group-level']));
        $status = remove_junk($db->escape($_POST['status']));
        $query = "UPDATE user_groups set group_name='".$name."', group_status='".$status."' WHERE id=".$id;
        // $result = $db->query($query);
        if(mysqli_query($conn,$query)){
          //array de permisos seleccionados
          $permisosSelec=$_POST["permisos"];

          for ($i=0;$i<count($permisosSelec);$i++){
            //Caso de que hayan agregado mas permisos al grupo
            if(!in_array($permisosSelec[$i],$permisos1)){
              $sql="INSERT INTO grupo_permisos (id_grupo,id_permiso) VALUES ('$id','$permisosSelec[$i]')";
              if(mysqli_query($conn,$sql)){
                // echo "se agrego<br>";
              }
              else{
              // echo "fallo el agregar un permiso"."<br>";
             $session->msg("d", $msg."Error al ingresar los datos de permisos<br>");
              redirect('edit_grupo.php?id='.$id, false);
              }
            }
          }

          foreach ($array as $i => $value) {
            //echo $i;
            if(!in_array($i,$permisosSelec)){
              $sql='DELETE from grupo_permisos where id="'.$value.'"';
              if(mysqli_query($conn,$sql)){
                // echo $sql."<br>";
                  // echo "Se elimino el permiso<br>";
              }
              else{
                // echo "fallo la eliminacion de permiso"."<br>";
              }
              
            }
          }
          //sucess
          $session->msg('s',"Grupo se ha actualizado! ");
          redirect('ver_grupos.php', false);
        } else {
          //failed
          $session->msg('d','Lamentablemente no se ha actualizado el grupo!');
          redirect('edit_grupo.php?id='.$id, false);
        }
   } else {
     $session->msg("d", "ERROR");
    redirect('edit_grupo.php?id='.$id, false);
   }
 }
?>
<?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Editar grupo</h4>
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
            <b>Editar <?php echo remove_junk(ucwords($e_group['group_name'])); ?></b>
        </div>
        <div class="card-body">
			<div class="row">
				<div class="col-6">
					<form method="post" action="edit_grupo.php?id=<?php echo (int)$e_group['id'];?>" class="clearfix">
					<div class="form-group">
						  <label for="name" class="control-label">Nombre del grupo</label>
						  <input type="name" class="form-control" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
					</div>
					<div class="form-group">
						<label for="status">Estado</label>
						  <select class="form-control" name="status">
							<option <?php if($e_group['group_status'] === '1') echo 'selected="selected"';?> value="1"> Activo </option>
							<option <?php if($e_group['group_status'] === '0') echo 'selected="selected"';?> value="0">Inactivo</option>
						  </select>
					</div>
				</div><!--cierra el col-6-->
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
				</div><!--cierra el col-6-->
			</div><!--cierra el row-->
        </div><!--cierra el card body-->
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
    <script type="text/javascript" src="script/editargrupo.js"></script>
    <script>
    $(document).ready(function(){
		  ponerPermisos(<?php echo json_encode($permisos1); ?>);
    });
    </script>
    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>