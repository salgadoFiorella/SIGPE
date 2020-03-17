<?php
include("../conecta.php");
$conn = Conectarse();
// $consulta = "SELECT codigoU,nombre ,fcs_codigo FROM unidadacademica ORDER BY nombre";
$consulta ='SELECT * from unidadacademica where fcs_codigo='.$_POST["codigo"];
$rs = mysqli_query($conn,$consulta);
$options="";

while($row = mysqli_fetch_array($rs)){
if($row["nombre"]===$_POST["unidad"]){
 $options =$options.'<option  value="'.$row['nombre'].'" selected="">'.ucwords($row['nombre']).'</option>';
}
else{
    $options =$options.'<option  value="'.$row['nombre'].'">'.ucwords($row['nombre']).'</option>';
}
}
echo $options;
?>
