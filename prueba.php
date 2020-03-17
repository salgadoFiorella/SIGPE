<?php 
// 	include("conecta.php");
// require_once('includes/load.php');
// include("script/GuardarDocumentos.php");


//  //rename($_SERVER['DOCUMENT_ROOT']."/SIGPE/"."public/uploads/tmp/historia.jpg",$_SERVER['DOCUMENT_ROOT']."/SIGPE/"."public/uploads/9/OPES/historia.jpg");


// 	$files = scandir($_SERVER['DOCUMENT_ROOT']."/SIGPE/"."public/uploads/tmp");
// 	// Identify directories
// 	$source = $_SERVER['DOCUMENT_ROOT']."/SIGPE/"."public/uploads/tmp"."/";
// 	$destination = $_SERVER['DOCUMENT_ROOT']."/SIGPE/"."public/uploads/9/OPES"."/";
// 	// Cycle through all source files
// 	foreach ($files as $file) {
// 		if (in_array($file, array(".",".."))) continue;
// 		// If we copied this successfully, mark it for deletion
// 		if (copy($source.$file, $destination.$file)) {
// 			$delete[] = $source.$file;
// 			echo $source.$file."<br>";
// 		}
// 	}
// 	// Delete all successfully-copied files
// 	foreach ($delete as $file) {
// 		unlink($file);
// 	}
$r = "hola,<br>";
$r1 = substr($r,0,-5);
echo $r1."<br>";
// echo $r;

?>


