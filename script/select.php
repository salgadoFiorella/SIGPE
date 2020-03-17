<?php
include("../conecta.php");
$conn = Conectarse();
$consulta = "SELECT nombre ,fcs_codigo FROM unidadacademica ORDER BY nombre";
$rs = mysqli_query($conn,$consulta);
$options="";

while($row = mysqli_fetch_array($rs)){
if($row["fcs_codigo"]===$_POST["elegido"]){
 $options =$options.'<option  value="'.$row['nombre'].'">'.$row['nombre'].'</option>';
}
}
echo $options;
?>
