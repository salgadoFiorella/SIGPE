<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_permission('eliminar_unidad');
?>
<?php
  $delete_id = delete_by_key('unidadacademica','id_unidad',$_GET['id']);
  if($delete_id){
      $session->msg("s","Se eliminado correctamente");
      redirect('ver_unidad_academica.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación");
      redirect('ver_unidad_academica.php');
  }
?>
