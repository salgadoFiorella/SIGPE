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
    $query = "SELECT codigoDoc, archivoFisico FROM documento where codigoDoc = '$fileCod'";
    $rs = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($rs);
    $server = $_SERVER['DOCUMENT_ROOT']."/SIGPE/";
    $file = $server.$row["archivoFisico"];
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
  echo "no se encontro archivo<br>";
  //echo $file;
}
  }
  catch ( Exception $e) {
     ECHO 'ERROR';
  }
?>
