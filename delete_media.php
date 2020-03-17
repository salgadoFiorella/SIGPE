<?php
  require_once('includes/load.php');
  if(!$session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php
  $find_media = find_by_id('media',(int)$_GET['id']);
  $photo = new Media();
  if($photo->media_destroy($find_media['id'],$find_media['file_name'])){
      $session->msg("s","Se ha eliminado la foto.");
      redirect('media.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación de fotografías.");
      redirect('media.php');
  }
?>
