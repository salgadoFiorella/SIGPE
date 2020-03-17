<!doctype html>
<html lang="en">
<?php
  $page_title = 'Editar Cuenta';
  require_once('includes/load.php');
  if(!$session->isUserLoggedIn(true)) { redirect('home.php', false);}
   include("conecta.php");
   $conn = Conectarse();
?>

<?php
//update user image
  if(isset($_POST['submit'])) {
  $photo = new Media();
  $user_id = (int)$_POST['user_id'];
  $photo->upload($_FILES['file_upload']);
  if($photo->process_user($user_id)){
    $session->msg('s','La foto fue subida al servidor.');
    redirect('editar_cuenta.php');
    } else{
      $session->msg('d',"error");
      redirect('editar_cuenta.php');
    }
  }
?>
<?php
 //update user other info
  if(isset($_POST['update'])){
    $req_fields = array('name','username' );
    validate_fields($req_fields);

    //It verifies if the username is taken
  $usern = $_POST['username'];
  $queryUser = 'select * from users where username ="'.$usern.'"';
  $result = mysqli_query($conn,$queryUser);
  $row = mysqli_fetch_array($result);
  if(is_null($row)==false){
     $session->msg('d',"Usuario en uso, por favor elija otra opción");
    redirect('editar_cuenta.php', false);
  }

    if(empty($errors)){
             $id = (int)$_SESSION['user_id'];
           $name = remove_junk($db->escape($_POST['name']));
       $username = remove_junk($db->escape($_POST['username']));
            $sql = "UPDATE users SET name ='{$name}', username ='{$username}' WHERE id='{$id}'";
    $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Cuenta actualizada. ");
            redirect('editar_cuenta.php', false);
          } else {
            $session->msg('d',' Lo siento, actualización falló.');
            redirect('editar_cuenta.php', false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('editar_cuenta.php',false);
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
<?php include_once('layouts/theader.php'); ?>
<body>
    <div class="container"><br>
      <div class="row">
        <div class="col-md-12">
          <?php echo display_msg($msg); ?>
        </div>
		<!-- hasta aqui-->
		<div class="col-md-4">
		<div class="card" style="width: 18rem;">
		  <img class="card-img-top" src="uploads/users/<?php echo $user['image'];?>" alt="Foto de perfil">
		  <div class="card-body">
			<h5 class="card-title">Perfil</h5>
      <p class="card-text"><?php echo $user['name'];?></p>
		  </div>
		  <div class="card-body">
      
		  </div>
		</div>
		</div>
		<!-- -->
        <div class="col-md-8">
        <div class="card">
        <div class="card-header text-center">
            <b>Editar cuenta</b>
        </div>
        <div class="card-body">
                <form method="post" action="editar_cuenta.php?id=<?php echo (int)$user['id'];?>" class="clearfix">
                  <div class="form-group">
                        <label for="name" class="control-label">Nombres</label>
                        <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
                  </div>
                  <div class="form-group">
                        <label for="username" class="control-label">Usuario</label>
                        <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
                  </div>
                  </div><!--cierra el card-body-->
                  <div class="card-footer text-muted">
                    <div class="form-group clearfix">
                      <button type="submit" name="update" class="btn btn-info active pull-right">Actualizar</button>
                      <a href="cambiar_contrasena.php" title="change password" class="btn btn-danger ">Cambiar contraseña</a>   
                    </div>
                  </div>
              </form>
          </div><br>

          <div class="card">
            <div class="card-header text-center">
              <b>Editar foto de perfil</b>
            </div>
            <div class="card-body">
              <h5 class="card-title">Seleccione la foto para su perfil</h5>
              <form class="form" action="editar_cuenta.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file" accept="image/*"/>
                </div>
                <div class="form-group">
                  <input type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                </div>
            </div>
            <div class="card-footer text-muted">
              <button type="submit" name="submit" class="btn btn-info active">Cambiar</button>
              </form>
            </div>
          </div>

        </div><!--cierra el col md 8-->
      <!--</div>-->
      </div> <!-- cierra el row-->
      </div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>