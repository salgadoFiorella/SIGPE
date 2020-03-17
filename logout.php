<?php
  require_once('includes/load.php');
  $user = current_user();
  $dirPath = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'public/uploads/tmp'.$user['username'];

function delete_directory($dirname) {
    if (is_dir($dirname))
      $dir_handle = opendir($dirname);
if (!$dir_handle)
     return false;
while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
           if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
           else
                delete_directory($dirname.'/'.$file);
      }
}
closedir($dir_handle);
rmdir($dirname);
return true;
}

delete_directory($dirPath);
  if(!$session->logout()) {redirect("index.php");}
?>
