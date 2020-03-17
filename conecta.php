<?php
// global $MemberCheck_defined;

// if (!isset ($MemberCheck_defined)) {
  if(!function_exists('Conectarse')) {
function Conectarse(){


        if(!($link=mysqli_connect("localhost","root","pruebas")))
        {


        echo "Error Conectando a la Base de Datos";

        exit();

        }
              //  print_r($link);
        if(!mysqli_select_db($link,"sigpe_test"))
        {
          echo "Error Selecionando BD";
          exit();
        }

        return $link;
}
// $MemberCheck_defined = true;
}
?>
