<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_permission('eliminar_usuarios');
?>
<?php
  $delete_id = delete_by_id('users',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Usuario eliminado");
      redirect('ver_usuarios.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación del usuario");
      redirect('ver_usuarios.php');
  }
?>
