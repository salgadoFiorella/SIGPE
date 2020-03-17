<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    page_require_permission('editar_usuarios');
    include("conecta.php");
    $usuarioActual =current_user();
    $conn = Conectarse();
    $e_user = find_by_id('users',(int)$_GET['id']);
    $groups  = find_all('user_groups');
    $idUser=(int)$_GET['id'];
    if(!$e_user){
      $session->msg("d","Missing user id.");
      redirect('ver_usuarios.php');
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
    <script type="text/javascript" src="script/security.js"></script>
<script type="text/javascript" src="libs/js-files/jquery.js"></script>
    <title>Editar usuario</title>
  </head>
  <?php
//Update User basic info
  if(isset($_POST['update'])) {
    $req_fields = array('name','username','level');
    validate_fields($req_fields);
    //It verifies if the username is taken
    $usern = $_POST['username'];
    $queryUser = 'select * from users where username ="'.$usern.'"';
    $result = mysqli_query($conn,$queryUser);
    $row = mysqli_fetch_array($result);
    if($e_user['username']==$usern){
      //
    }
    else{
      $session->msg('d',"Error al actualizar, intente de nuevo.");
      redirect('ver_usuarios.php', false);
    }
    if(empty($errors)){
      $id = $idUser;
      $name = $_POST['name'];
      $level = $_POST['level'];
      $fec = $_POST['fechaex'];
      $fecha=date("Y-m-d", strtotime($fec));
      $sql = "UPDATE users SET name ='".$name."', user_level='".$level."', expiration='".$fecha."' WHERE id=".$id;
      if(mysqli_query($conn,$sql)){
        $session->msg('s',"Cuenta actualizada con éxito");
        redirect('edit_usuario.php?id='.$idUser, false);
      }else{
        $session->msg('d',' Lo siento no se actualizó los datos.');
        redirect('edit_usuario.php?id='.$idUser, false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('edit_usuario.php?id='.$idUser,false);
    }
  }
?>
<?php
// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('password','confirmPassword');
  validate_fields($req_fields);

  $password   = $_POST['password'];
  $confPwd = $_POST['confirmPassword'];
  if (!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password) || $password!=$confPwd){
    $session->msg('s'," Contraseña no permitida");
    redirect('edit_usuario.php?id='.(int)$e_user['id'], false);}

  if(empty($errors)){
           $id = (int)$e_user['id'];
     $password = remove_junk($db->escape($_POST['password']));
     $h_pass   = sha1($password);
          $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
       $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
          $session->msg('s',"Se ha actualizado la contraseña del usuario. ");
          redirect('edit_usuario.php?id='.(int)$e_user['id'], false);
        } else {
          $session->msg('d','No se pudo actualizar la contraseña de usuario..');
          redirect('edit_usuario.php?id='.(int)$e_user['id'], false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('edit_usuario.php?id='.(int)$e_user['id'],false);
  }
}

?>
<?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Usuario <b><?php echo remove_junk(ucwords($e_user['name'])); ?></b></h4>
            </div>
        </div><!--cierra el row--> 
        <hr>
        <?php echo display_msg($msg); ?>
        <br>

        <div class="row">

		<?php if(!in_array('cambiar_contrasena',$permisos)){?>
        <div class="col-9">
		<?php } if(in_array('cambiar_contrasena',$permisos)){?>
		<div class="col-6"><?php } ?>

        <div class="card">
        <div class="card-header text-center">
            <b>Editar</b>
        </div>
        <div class="card-body">
        <form method="post" action="edit_usuario.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Nombres</label>
                  <input type="name" class="form-control" name="name" value="<?php echo remove_junk($e_user['name']); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Usuario</label>
                  <input type="text" class="form-control" value="<?php echo $e_user['username']; ?>" disabled>
                  <input type="hidden" class="form-control" name="username" value="<?php echo $e_user['username']; ?>">
            </div>
            <div class="form-group">
                <label for="fechaex">Fecha de Expiración</label> 
                <input type="date" class="form-control" name ="fechaex" value="<?php echo date("Y-m-d", strtotime($e_user['expiration']));?>" id="fechaex" required>
            </div>
            <div class="form-group">
              <label for="level">Rol de usuario</label>
                <select class="form-control" name="level" id="grouplevel">
                  <?php foreach ($groups as $group ):?>
                   <option <?php if($group['id'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['id'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
           
        </div>
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="update" class="btn btn-primary">Editar</button>
            </form>
        </div>
        </div>
        </div><br>
        <?php if(in_array('cambiar_contrasena',$permisos)){?>
		<div class="col-6">
        <div class="card">
        <div class="card-header text-center">
        <b> Cambiar contraseña</b>
        </div>
        <div class="card-body">
        <form action="edit_usuario.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Contraseña</label><small> (Debe contener mínimo una mayúscula, una minúscula y un número.)</small>
                <input type="password" class="form-control" name="password" id="password" placeholder="Ingresa la nueva contraseña" required onkeyup="javaScript:verifyPasswordStrength();">
                <span id="strength"></span>
          </div>
          <div class="form-group">
                <label for="confirmPassword" class="control-label">Confirme contraseña</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirme la nueva contraseña" required onkeyup="javascript:conPassword();">
                <span id="passwordMsg"></span>
          </div>
        </div>
        <!-- </div> -->
        <div class="card-footer text-muted">
            <button type="submit" name="update-pass" class="btn btn-danger">Cambiar</button>
            </form>
        </div>
		
        </div><!--cierra el card-->
        </div><!--cierra el col-6-->
        
        <?php } ?>
        

        </div><!--cierra el row-->
    </div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>