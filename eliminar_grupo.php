<?php
  require_once('includes/load.php');
  include("conecta.php");
  $conn = Conectarse();
  // Checkin What level user has permission to view this page
   page_require_permission('eliminar_grupo');
?>
<?php
$id = $_GET['id'];
$sql = "SELECT id from grupo_permisos where id_grupo=".$id;
$res = mysqli_query($conn,$sql);
if($res->num_rows > 0){
  $res->data_seek(0);
  while($fila=$res->fetch_assoc()){
    $sql1 = "DELETE from grupo_permisos where id=".$fila['id'];
    if(mysqli_query($conn,$sql1)){
    }else{
      $session->msg("d","Eliminación falló");
      redirect('ver_grupos.php');
    }
  }
}

  $delete_id = delete_by_id('user_groups',$id);
  if($delete_id){
      $session->msg("s","Grupo eliminado");
      redirect('ver_grupos.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('ver_grupos.php');
  }
?>
