<!doctype html>
<html lang="en">
<?php
  $page_title = 'Agregar usuarios';
  require_once('includes/load.php');
  include("conecta.php");
$conn = Conectarse();
  // Checking What level user has permission to view this page
  page_require_permission('agregar_usuario');
  $groups = find_all('user_groups');
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
</head>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password','level' );
   validate_fields($req_fields);

   //It verifies if the username is taken
  $usern = $_POST['username'];
  $queryUser = 'select * from users where username ="'.$usern.'"';
  $result = mysqli_query($conn,$queryUser);
  $row = mysqli_fetch_array($result);
  if(is_null($row)==false){
     $session->msg('d',"Usuario en uso, por favor elija otra opción");
    redirect('agregar_usuario.php', false);
  }


//It verifies if the password is strong enough
   $password   = $_POST['password'];
   $confPwd = $_POST['confirmPassword'];
   if (!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password) || $password!=$confPwd){
    $session->msg('d'," Contraseña no permitida");
    redirect('agregar_usuario.php', false);}

   if(empty($errors)){
      $name   = remove_junk($db->escape($_POST['full-name']));
      $username   = remove_junk($db->escape($_POST['username']));
      $password   = remove_junk($db->escape($_POST['password']));
      $user_level = (int)$db->escape($_POST['level']);
      $fecha = $_POST['fechaex'];
      $password = sha1($password);
        $query = "INSERT INTO users (";
        $query .="name,username,password,user_level,expiration";
        $query .=") VALUES (";
        $query .=" '{$name}', '{$username}', '{$password}', '{$user_level}','{$fecha}'";
        $query .=")";
        
        if($db->query($query)){
          //sucess
          $session->msg('s'," Cuenta de usuario ha sido creada");
          redirect('agregar_usuario.php', false);
        } else {
          //failed
          $session->msg('d',' No se pudo crear la cuenta.');
          redirect('agregar_usuario.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('agregar_usuario.php',false);
   }
 }
?>
<?php include_once('layouts/theader.php'); ?>
<body>
    <div class="container"><br>
        <div class="row">
            <div class="col-9">
            <h4>Usuario</h4>
            </div>
        </div><!--cierra el row--> 
        <hr>
        <?php echo display_msg($msg); ?>
        <br>
        <div class="col-9">
        <div class="card">
        <div class="card-header text-center">
            <b>Agregar</b>
        </div>
        <div class="card-body">
          <form method="post" action="agregar_usuario.php">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="full-name" placeholder="Nombre completo" required>
            </div>
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" class="form-control" name="username" placeholder="Nombre de usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label><small> (Debe contener mínimo una mayúscula, una minúscula y un número.)</small>
                <input type="password" class="form-control" name ="password" id="password" onkeyup="javaScript:verifyPasswordStrength();"  placeholder="Contraseña" required>
                <span id="strength"></span>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmar contraseña</label> 
                <input type="password" class="form-control" name ="confirmPassword" id="confirmPassword" onkeyup="javascript:conPassword();" placeholder="Confirmar Contraseña" required>
                <span id="passwordMsg"></span>
            </div>
            <div class="form-group">
                <label for="fechaex">Fecha de Expiración</label> 
                <input type="date" class="form-control" name ="fechaex" id="fechaex" required>
            </div>
            <div class="form-group">
              <label for="level">Rol de usuario</label>
                <select class="form-control" name="level" id="grouplevel">
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['id'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            </div>
            <div class="card-footer text-muted">
              <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
              </form>
            </div>
            </div>
        </div>
        </div><br>
        
    </div><!-- cierra el container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
    <script type="text/javascript" src="libs/js-files/jquery.js"></script>
    <script type="text/javascript" src="script/security.js"></script>    
    
    <?php include_once('layouts/footer.php');?>

</body>
</html>
