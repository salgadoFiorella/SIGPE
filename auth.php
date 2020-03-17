<?php include_once('includes/load.php'); ?>
<?php
$req_fields = array('username','password' );
validate_fields($req_fields);
$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);
// date_default_timezone_set('America/Costa_Rica');
// 			$today_date = date('Y/m/d');
if(empty($errors)){
  $user_id = authenticate($username, $password);
  if($user_id){
    // if($user_id['expiration'] != NULL && $user_id['expiration'] < $today_date){
    //   $session->msg("d", "Su cuenta ha expirado.");
    //   redirect('index.php',false);
    // }
    //create session with id
     $session->login($user_id['id']);
    //Update Sign in time
     updateLastLogIn($user_id['id']);
     //$session->msg("s", "Bienvenido Al Sistema de Gestion de Planes de Estudio");
     redirect('home.php',false);
  } else {
    $session->msg("d", "Nombre de usuario y/o contraseña incorrecto.");
    redirect('index.php',false);
  }

} else {
   $session->msg("d", $errors);
   redirect('index.php',false);
}

?>
