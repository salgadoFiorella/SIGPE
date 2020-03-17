<?php


function mostrarDocs($planId){
  $conn = Conectarse();
  $query= "SELECT DISTINCT tipoDoc FROM documento WHERE planId =".$planId;
  $rs = mysqli_query($conn,$query);
  // $num_filas =$rs->num_rows;
  // if($num_filas > 0){
  if($rs != FALSE){
  $tiposDocs = array();
    while($row = mysqli_fetch_array($rs)){
      $tiposDocs[]=$row["tipoDoc"];
    }
  echo crearVista($tiposDocs,$planId);
  }
  else{
    echo "<h4>No hay documentos asociados a este plan</h4>";
  }
}

function crearVista($tiposDocs,$planId){
  $server = $_SERVER['DOCUMENT_ROOT']."/SIGPE/";
  $divIni = '';
  $divCent = '';
  $divFin =
       '</div>
      </div>
    </div>
  </div>';
  $div='';
//echo '<br>'.$server.'<br>';
//echo '<br>'.$server.$row["archivoFisico"].'<br>';
//echo '<br>'.basename($server.$row["archivoFisico"]);
$longitud = count($tiposDocs);
 $conn = Conectarse();
 if($longitud > 0){
  //Recorro todos los elementos
  for($i=0; $i<$longitud; $i++){
    $divIni = '';
    $divCent = '';
      $query = "SELECT codigoDoc, nombre, fecha, detalle, archivoFisico, tipoDoc, plan_cd
      FROM documento where planId =".$planId." AND  tipoDoc= '$tiposDocs[$i]'";
      $rs = mysqli_query($conn,$query);
      $divIni = '<div class="container col-md-12">
      <div class="panel-group">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a data-toggle="collapse" href="#collapse'.$i.'" style="color: black;">'.$tiposDocs[$i].'</a>
            </h4>
          </div>
          <div id="collapse'.$i.'" class="panel-collapse collapse">';
      while($row = mysqli_fetch_array($rs)){
  $divCent =$divCent.'

          <div class="panel-body"><a target="_blank" href=script/downloadFile.php?file='.$row["codigoDoc"].'>
            '.$row["nombre"].'
          </a></div>';
  }
  //juntamos todo aqui
  $div=$div.$divIni.$divCent.$divFin;
  }
 }else{ $div = "<h4>No hay documentos asociados a este plan</h4>";}
return $div;
}
function listar_archivos($carpeta){
    if(is_dir($carpeta)){
        if($dir = opendir($carpeta)){
            while(($archivo = readdir($dir)) !== false){
                if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){
                    echo '<li><a target="_blank" href='.$carpeta.'/'.$archivo.'>'.$archivo.'</a></li>';
                }
            }
            closedir($dir);
        }
    }
}
?>
