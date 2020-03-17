<?php     require_once('includes/load.php');
 $array = find_permissions("117000387");
//$array = find_by_sql("SELECT * from users");
for($i=0;$i<count($array);$i++){
  if(in_array('crear_reportes',$array)){
    echo "SIIII".$i."<br>";
  }else{
    echo "NO:(".$i."<br>";
  }
  
}
//     include("conecta.php");
//     $conn=Conectarse();
//     $plan = "g2019-09-17-15-57-57";
//  $queryu = "SELECT * from plan where RowID_Plan='".$plan."' and HistoricoInd='N'";
//  $result = mysqli_query($conn,$queryu);
//  $row = mysqli_fetch_array($result);
//  if(is_null($row)==false){
//    echo $row['gradoAcademico'];
//  }
?>