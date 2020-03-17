<!doctype html>
<html lang="en">

<?php
  $page_title = 'Cambiar contraseña';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
  $user = current_user(); ?>
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
</head>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('password','old-password','id','confirmPassword' );
    validate_fields($req_fields);

    if(empty($errors)){

             if(sha1($_POST['old-password']) !== current_user()['password'] ){
               $session->msg('d', "Tu antigua contraseña no coincide");
               redirect('cambiar_contrasena.php',false);
             }
             $password   = $_POST['password'];
             $confPwd = $_POST['confirmPassword'];
             if (!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password) || $password!=$confPwd){
              $session->msg('s'," Contraseña no permitida");
              redirect('cambiar_contrasena.php', false);}

            $id = (int)$_POST['id'];
            $new = remove_junk($db->escape(sha1($_POST['password'])));
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Inicia sesión con tu nueva contraseña.");
                  redirect('index.php', false);
                else:
                  $session->msg('d',' Lo siento, actualización falló.');
                  redirect('cambiar_contrasena.php', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect('cambiar_contrasena.php',false);
    }
  }
?>
<?php include_once('layouts/theader.php'); ?> 
<body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Cambiar contraseña de <?php echo $user['name'];?></h4>
            </div>
        </div><!--cierra el row--> 
        <hr>
        <?php echo display_msg($msg); ?>
        <br>


 <div class="col-9">
        <!-- <div class="d-flex justify-content-center"> -->
        <div class="card">
        <div class="card-header text-center">
            <b>Cambiar</b>
        </div>
        <div class="card-body">
		<form method="post" action="cambiar_contrasena.php" class="clearfix">
      <div class="form-group">
              <label for="password" class="control-label">Nueva contraseña</label><small> (Debe contener mínimo una mayúscula, una minúscula y un número.)</small>
              <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña"  onkeyup="javaScript:verifyPasswordStrength();" >
              <span id="strength"></span>
        </div>
        <div class="form-group">
              <label for="confirmPassword" class="control-label">Confirmar nueva contraseña</label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nueva contraseña"  onkeyup="javascript:conPassword();">
              <span id="passwordMsg"></span>
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Antigua contraseña</label>
              <input type="password" class="form-control" name="old-password" placeholder="Antigua contraseña" >
        </div>
              <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
		</div>
		<div class="card-footer text-muted">
            <button type="submit" name="update" class="btn btn-info active">Cambiar</button>
            </form>
        </div>
        </div>
        </div>
<!--
<div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <span class="glyphicon glyphicon-lock"></span>
        <span>Cambiar contraseña</span>
      </div>
      <div class="panel-body">
      <form method="post" action="cambiar_contrasena.php" class="clearfix">
      <div class="form-group">
              <label for="password" class="control-label">Nueva contraseña</label><small> (Debe contener mínimo una mayúscula, una minúscula y un número.)</small>
              <input type="password" class="form-control" name="password" id="password" placeholder="Nueva contraseña"  onkeyup="javaScript:verifyPasswordStrength();" >
              <span id="strength"></span>
        </div>
        <div class="form-group">
              <label for="confirmPassword" class="control-label">Confirmar nueva contraseña</label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nueva contraseña"  onkeyup="javascript:conPassword();">
              <span id="passwordMsg"></span>
        </div>
        <div class="form-group">
              <label for="oldPassword" class="control-label">Antigua contraseña</label>
              <input type="password" class="form-control" name="old-password" placeholder="Antigua contraseña" >
        </div>
        <div class="form-group clearfix">
              <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
              <button type="submit" name="update" class="btn btn-info active">Cambiar</button>
        </div>
        </form>
      </div>
    </div>
  </div>-->

</div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>
