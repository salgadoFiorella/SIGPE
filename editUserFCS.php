<?php 
require_once('includes/load.php');
include("conecta.php");
$conn = Conectarse();
$userId=(int)$_POST['user'];
$usuario = 'SELECT fcsr from users where id='.$userId;
$result = mysqli_query($conn,$usuario);
$fila = mysqli_fetch_array($result);
$consulta = "SELECT codigo,nombre FROM fcs ORDER BY nombre";
$rs = mysqli_query($conn,$consulta);
 $options = ""; //array de opciones
 while($row = mysqli_fetch_array($rs)){
     if($fila['fcsr']==$row['codigo']){
        $options =$options.'<option  value="'.$row['codigo'].'" selected>'.ucwords($row['nombre']).'</option>';
     }else{
        $options =$options.'<option  value="'.$row['codigo'].'">'.ucwords($row['nombre']).'</option>';
     }
    }

    echo $options;


?>