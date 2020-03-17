<?php

require_once('includes/load.php');
if(isset($_POST['update'])) {
    $id_unidad = $_GET['id'];
    $archivoImagen = $_POST['archivoImagen'];
    include("conecta.php");
    $conn=Conectarse();
    $req_fields = array('nombre','codigo','tel1','web','email','desc');
    validate_fields($req_fields);

    if(file_exists($_FILES["foto"]['tmp_name']) ||  is_uploaded_file($_FILES["foto"]['tmp_name'])){
      $ruta =$_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/unidadesAcademicas/';
      $fileName=$_FILES["foto"]["name"];
      $fileSize=$_FILES["foto"]["size"]/1024;
      $fileType=$_FILES["foto"]["type"];
      $fileTmpName=$_FILES["foto"]["tmp_name"];
      $arch = $ruta.$fileName;
      $archivofisico = 'uploads/unidadesAcademicas/'.$fileName;

      if(move_uploaded_file($fileTmpName,$arch)){
        $sql="UPDATE unidadacademica set imagen ='$archivofisico' where id_unidad=".$id_unidad;
        //echo "<br>"."<br>"."<br>".$sql."<br>";
        if(mysqli_query($conn,$sql)){
          if(strcmp($archivoImagen,"uploads/unidadesAcademicas/curso2.jpg") != 0){
            unlink($archivoImagen);
          }
            //echo "Subida exitosa del doc";
        }else{
        //   echo "error1";
            $session->msg("d", "Error: no se pudo cargar el logo, inténtelo de nuevo.");
            redirect('editar_unidad_academica.php?id='.$id_unidad, false);
        }

      }else{
        // echo "error2";
        $session->msg("d", "Error al cargar el logo, inténtelo de nuevo");
        redirect('editar_unidad_academica.php?id='.$id_unidad,false);
      }
    }
      $name = remove_junk($db->escape($_POST['nombre']));
      $cod = remove_junk($db->escape($_POST['codigo']));
      $codigoFCSR = remove_junk($db->escape($_POST['codigoFCSR']));
      $tel1 = remove_junk($db->escape($_POST['tel1']));
      if(isset($_POST['tel2'])){
        $tel2 = $_POST['tel2'];
      }else{
        $tel2 = NULL;
      }
      $web = remove_junk($db->escape($_POST['web']));
      $email = remove_junk($db->escape($_POST['email']));
      $desc = remove_junk($db->escape($_POST['desc']));
      $sql = "UPDATE unidadacademica SET nombre ='{$name}', fcs_codigo ='{$codigoFCSR}', codigoU = '{$cod}', telefono1='{$tel1}', telefono2='{$tel2}', pag_web='{$web}', email='{$email}', descripcion='{$desc}' WHERE id_unidad='{$db->escape($id_unidad)}'";
      //echo $sql;
      $result = $db->query($sql);
      if($result && $db->affected_rows() === 1){
        $session->msg('s',"Datos Actualizados");
        redirect('ver_unidad_academica.php', false);
      } else {
        $session->msg('d',' Lo siento no se actualizaron los datos.');
        redirect('editar_unidad_academica.php?id='.$id_unidad, false);
      }
  }

?>