<?php
// PHP SECURE FILE DOWNLOAD
// Put the Files in a directory that is not publically accessible.. maybe outside document root or set correct permissions
try{
/*  require_once('/../includes/load.php');
$user = current_user();
if(isset($user)){
        // If not authenticated then send back to the login page
        $host = $_SERVER["HTTP_HOST"];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: http://$host$path/index.php");
        exit;
    }*/
    include('ChromePhp.php');
    ChromePhp::log('Hello console1');
    include("../conecta.php");
    $conn = Conectarse();
    $fileCod = $_GET["file"];
    $query = "SELECT estructura_pdf FROM estructuracurricular where plan_id= '$fileCod' and activo_ind='S'";
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($rs);
    $num_rows = mysqli_num_rows($rs);
    if($num_rows >0){
      $server = $_SERVER['DOCUMENT_ROOT']."/SIGPE/";
      $file = $server.$row["estructura_pdf"];
    }else{
      $file="#";
    }
    
    ChromePhp::log($file);
//echo basename($file);
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    //header("Content-type: application/pdf");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
else {
  echo "No hay archivo csv guardado<br>";
  //echo $file;
}
  }
  catch ( Exception $e) {
     ECHO 'ERROR';
  }
?>