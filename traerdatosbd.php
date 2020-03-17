<?php 
require_once('includes/load.php');
include("conecta.php");
$conn = Conectarse();

$consulta = "SELECT codigo,nombre FROM fcs ORDER BY nombre";
$rs = mysqli_query($conn,$consulta);
 $options = ""; //array de opciones
 while($row = mysqli_fetch_array($rs)){
     $options =$options.'<option  value="'.$row['codigo'].'">'.ucwords($row['nombre']).'</option>';
    }

    echo $options;


?>