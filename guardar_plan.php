<?php 
try{
    include("conecta.php");
	require_once('includes/load.php');
	// include("script/GuardarDocumentos.php");
	$conn=Conectarse();
	$usuario = current_user();
    $usuarioID = $usuario['username'];
    $errorName = '';
    if(isset($_POST['mandar'])) {
        //Atributos del plan de estudio y definicion del plan
        
            
        if(isset($_POST['nombrePlan']) && isset($_POST['codigoBanner']) && isset($_POST['aprobacion'])){
            if((file_exists($_FILES['archpdf']['tmp_name'])) && (file_exists($_FILES['archcsv']['tmp_name'] )) && (file_exists($_FILES['planpdf']['tmp_name']))){
            $nom = $_POST['nombrePlan'];
            // $nom = $_POST['nombrePlan'];
            $codB = $_POST['codigoBanner'];
            $grado = $_POST["gradoAcademico"];
            $tipo_carrera = $_POST["tipo_carrera"];
            $tipo_plan = $_POST["grado"];
            $unidadA= $_POST['unidad'];
            $otrasU= $_POST['otrasU'];
            $oferta = $_POST["oferta"];
            $banner2= $_POST['codigoBanner2'];
            $aprobacion = date('Y-m-d', strtotime($_POST['aprobacion']));
            $redisenno = date('Y-m-d', strtotime($_POST['redisenno']));
            $comgen = $_POST['comgen'];
            $comOferta = $_POST['comment'];
            if(isset($_POST['declaracionTerm'])){
                $terminal=$_POST['declaracionTerm'];
                //
            }else{
                $terminal='N';
            }
            
            if(isset($_POST['codigoRegistro'])){
                $codR = $_POST['codigoRegistro'];
            }else{
                $codR = 'N/A';
            }
            
            if($nom == ''){ $feedback = 'Fill out all the fields'; }
            

            $RowID_Plan = $condB.strftime( "%Y-%m-%d-%H-%M-%S", time());

            
            //Queries insert definicion plan y plan
            $sqldefPlan= "INSERT INTO definicionplan (DefinicionPlanId, PlanNombre, Ind) VALUES ('$RowID_Plan', '$nom', 'Y')";
            

            
            $sql = "INSERT INTO plan (RowID_Plan,codigoRegistro,DefinicionPlanId, codigoBanner,
            nombrePlan,gradoAcademico, tipoPlan, unidad_Academica,otras_universidades,
            tipo_carrera, oferta,ComentarioOferta,codigoBanner2, aprobacion, redisenno,
            ComentariosGenerales,Usuario,declaracion_planTerminal)"
            ."VALUES ('$RowID_Plan','$codR','$RowID_Plan', '$codB',
            '$nom','$grado', '$tipo_plan', '$unidadA','$otrasU',
            '$tipo_carrera','$oferta','$comOferta','$banner2', '$aprobacion', '$redisenno',
            '$comgen','$usuarioID','$terminal')";
                // echo $sql;
            if(mysqli_query($conn,$sqldefPlan)==TRUE){
                if(mysqli_query($conn,$sql)==TRUE){
                    echo "Se ingreso definicion de plan"."<br>";
                    echo "Se ingreso plan"."<br>";
                } else{
                $session->msg("d", $msg."Error al ingresar plan<br>");
                    redirect('ingresar_plan.php', false);
                } 
            }else {
                $session->msg("d", $msg."Error al ingresar definicion<br>");
                redirect('ingresar_plan.php', false);
            }
        
        // }else{
        //     echo'<script type="text/javascript">
        //     alert("Debe agregar un nombre de plan");
        //     window.location.href="ingresar_plan.php";
        //     </script>';}
            /**************************************************************** */

            //Queries select plan
            $sqlGet = 'SELECT PlanCd from plan where HistoricoInd="N" AND RowID_Plan="'.$RowID_Plan.'"';
            $resultget = mysqli_query($conn,$sqlGet);
            $rowGet = mysqli_fetch_array($resultget);
            $plan_idcd=$rowGet['PlanCd'];

            /**************************************************************** */

            //insert CAMPUS
            $campus=$_POST["campus"];

            for ($i=0;$i<count($campus);$i++){
                $vp = $_POST['virtualP'.$campus[$i]] ;
                $sql="INSERT INTO plan_campus (plan_cd, campus_cd,EstadoPlan,planId) VALUES ('$RowID_Plan','$campus[$i]','$vp',$plan_idcd)";
            if(mysqli_query($conn,$sql)){
                //echo "Se ingresaron los campus"."<br>";
            }
            else{
                echo "fallaron los campus"."<br>";
                $session->msg("d", $msg."Error al ingresar los datos de campus<br>");
                redirect('ingresar_plan.php', false);

            }}
            // /**************************************************************** */

            // //ENFASIS
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['enfasis'.$aux])){
                    $enfasis = $_POST['enfasis'.$aux];
                    $sql="INSERT INTO enfasis (descripcion, nombre, plan_cd,planId) VALUES ('$enfasis','$enfasis','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                    // echo "Se ingreso enfasis: ".$enfasis."<br>";
                    }else{
                        $session->msg("d", $msg."Error al ingresar los datos de enfasis<br>");
                        redirect('ingresar_plan.php', false);
                    }
                    $aux = $aux +1;
                }
                else{
                    $bandera = false;
                }
            }
            //  /**************************************************************** */
            // //ACREDITACIONES
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['aprobacion+'.$aux])){
                    $fecha = date('Y-m-d', strtotime($_POST['aprobacion+'.$aux]));
                    $fechaFin = date('Y-m-d', strtotime($_POST['hasta+'.$aux]));
                    $detalle = $_POST['detalle-'.$aux];
                    $tipoAcred = $_POST['tipoAcred'.$aux];
                    $sql="INSERT INTO acreditaciones (Fecha,FechaFin,Detalle,planCd,planId,tipo) VALUES ('$fecha','$fechaFin','$detalle','$RowID_Plan',$plan_idcd,'$tipoAcred')";
                    if(mysqli_query($conn,$sql)){
                        // echo "Se ingreso acreditacion"."<br>";
                    } else{
                        // echo "No se ingreso acreditacion"."<br>";
                        $session->msg("d", $msg."Error al ingresar los datos de las Acreditaciones".$aux." Para arreglar debe ir a modificar<br>");
                        redirect('ingresar_plan.php', false);
                    }
                    $aux = $aux +1;
                } else{
                    $bandera = false;
                }
            }

            /**************************************************************** */

            //SALIDAS
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['sal+'.$aux])){
                    $salida = $_POST['sal+'.$aux];
                    $comentario = $_POST['com-'.$aux];
                    $sql="INSERT INTO Salidas (SalidaLateral,comentario,plan_cd,planId) VALUES ('$salida','$comentario','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                    // echo "Se ingreso salida: ".$salida."<br>"; 
                    } else{
                        $session->msg("d", $msg."Error al ingresar los datos de las salidas<br>");
                        redirect('ingresar_plan.php', false);
                    }
                    $aux = $aux +1;
                } else{
                    $bandera = false;
                }
            }
            /**************************************************************** */
            // //Titulaciones
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['tit-'.$aux])){
                    $titulacion = $_POST['tit-'.$aux];
                    $tipo = $_POST['tipoTit'.$aux];
                    $sql="INSERT INTO titulaciones (nombre,tipo,plan_cd,planId) VALUES ('$titulacion','$tipo','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                        // echo "Se ingreso titulaciones"."<br>";
                    } else{
                        // echo "No se ingreso titulaciones"."<br>";
                        $session->msg("d", $msg."Error al ingresar los datos de las titulaciones".$aux." Para arreglar debe ir a modificar<br>");
                        redirect('ingresar_plan.php', false);
                    }
                    $aux = $aux +1;
                } else{
                    $bandera = false;
                }
            }

            /**************************************************************** */
            //ETIQUETAS
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['tag'.$aux])){
                    $tag = $_POST['tag'.$aux];
                    $sql="INSERT INTO etiqueta (nombre, plan_cd,planId) VALUES ('$tag','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                    // echo "Se ingreso etiqueta: ".$enfasis."<br>";
                    } else{
                        $session->msg("d", $msg."Error al ingresar los datos de las etiquetas<br>");
                        redirect('ingresar_plan.php', false);
                    }
                $aux = $aux +1;
                }
                else{
                    $bandera = false;
                }
            }
            /**************************************************************** */

            //AREAS DISCIPLINARIAS
            $aux=1;
            $bandera = true;
            while($bandera){
                if(isset($_POST['areaD-'.$aux])){
                    $nom = $_POST['areaD-'.$aux];
                    $sql="INSERT INTO areas_disciplinarias (nombre, plan_cd,planId) VALUES ('$nom','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                    //    echo "Se ingreso area: ".$nom."<br>";
                    } else{
                        // echo "Error al ingresar los datos de las areas<br>";
                        $session->msg("d", $msg."Error al ingresar los datos de las areas<br>");
                        redirect('ingresar_plan.php', false);
                    }
                $aux = $aux +1;
                }
                else{
                    $bandera = false;
                }
            }
            /**************************************************************** */

            //Estructura curricular
            /**************************************************************** */
            if ((file_exists($_FILES['archpdf']['tmp_name']) || is_uploaded_file($_FILES['archpdf']['tmp_name'])) && ( file_exists($_FILES['archcsv']['tmp_name']) || is_uploaded_file($_FILES['archcsv']['tmp_name']))){
                $fileNamePDF=$_FILES["archpdf"]["name"];
                $fileSizePDF=$_FILES["archpdf"]["size"]/1024;
                $fileTypePDF=$_FILES["archpdf"]["type"];
                $fileTmpNamePDF=$_FILES["archpdf"]["tmp_name"];  //planpdf

                $fileNameCSV=$_FILES["archcsv"]["name"];
                $fileSizeCSV=$_FILES["archcsv"]["size"]/1024;
                $fileTypeCSV=$_FILES["archcsv"]["type"];
                $fileTmpNameCSV=$_FILES["archcsv"]["tmp_name"];             
            
                if($fileTypePDF=="application/pdf" && ($fileTypeCSV=="application/vnd.ms-excel" || $fileTypeCSV=="application/msword" || $fileTypeCSV=="application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $fileTypeCSV=="text/csv" || $fileTypeCSV =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")){
            
                    //New file name
                    date_default_timezone_set('America/Costa_Rica');
                    $today_date = date('d-m-Y-h-i');
                    $newFileNamePDF=$today_date.$fileNamePDF;
                    $newFileNameCSV=$today_date.$fileNameCSV;
            
                    //File csv upload path
                    $uploadPathCSV = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/estructuras/'.$newFileNameCSV;
                    $path_csv = 'uploads/estructuras/'.$newFileNameCSV;
            
                    //File pdf upload path
                    $uploadPathPDF = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/estructuras/'.$newFileNamePDF;
                    $path_pdf = 'uploads/estructuras/'.$newFileNamePDF;

            
                    //function for upload file
                    if(move_uploaded_file($fileTmpNamePDF,$uploadPathPDF) && move_uploaded_file($fileTmpNameCSV,$uploadPathCSV)){
                        $sql="INSERT INTO estructuracurricular (estructura_excel, estructura_pdf,plan_id) VALUES ('$path_csv','$path_pdf',$plan_idcd)";
                        // echo $sql."<br";
                        if(mysqli_query($conn,$sql)){
                            // echo "Subida exitosa de los archvios";
                        }else{
                            // echo "error1";
                        $session->msg("d", $msg."Error al guardar estructura curricular!!<br>");
                        redirect('ingresar_plan.php', false);
                        }
                    

                    }else{
                        // echo "error2";
                    $session->msg("d", $msg. ' El pdf es: ' . $fileNamePDF/*"Error al guardar pdf de estructura curricular, intentelo en modificar plan<br>"*/);
                        redirect('ingresar_plan.php', false);
                    }
                }
                else{
                    $session->msg("d", $msg."Error al guardar estructura curricular!!<br>");
                    redirect('ingresar_plan.php', false);
                    // echo "error3";
                //   echo "You can only upload a pdf and .csv/.xls file.";
                }  

            }
            //Traer el id de la estructura que acabamos de ingresar
            $sqlest = 'SELECT estructura_id from estructuracurricular where activo_ind="S" AND plan_id="'.$plan_idcd.'"';
            // echo "<br>".$sqlest."<br>";
            $resultest = mysqli_query($conn,$sqlest);
            $rowest = mysqli_fetch_array($resultest);
            $idest=$rowest['estructura_id'];

            //plan publico
            if((file_exists($_FILES['planpdf']['tmp_name']) ||  is_uploaded_file($_FILES['planpdf']['tmp_name']))){
                //Plan de estudios publico
                $fNamePDF=$_FILES["planpdf"]["name"];
                $fSizePDF=$_FILES["planpdf"]["size"]/1024;
                $fTypePDF=$_FILES["planpdf"]["type"];
                $fTmpNamePDF=$_FILES["planpdf"]["tmp_name"];

                if($fileTypePDF=="application/pdf"){

                    $upPathPDF = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/pdfs/'.$fNamePDF;
                    $ruta_pdf = 'uploads/pdfs/'.$fNamePDF;
                    if(move_uploaded_file($fTmpNamePDF,$upPathPDF)){
                        $sql="UPDATE estructuracurricular set plan_pdf ='$ruta_pdf' where estructura_id=".$idest;
                        echo "<br>".$sql."<br>";
                        if(mysqli_query($conn,$sql)){
                            // echo "Subida exitosa del pdf";
                        }else{
                            $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
                            redirect('ingresar_plan.php', false);
                        }
                        
                    }else{
                        $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
                        redirect('ingresar_plan.php', false);
                    }
            
                }else{
                    $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
                            redirect('ingresar_plan.php', false);
                }

            }
            //Logo del plan
            if(file_exists($_FILES["logo"]['tmp_name']) ||  is_uploaded_file($_FILES["logo"]['tmp_name'])){
                $ruta =$_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/planesdeEstudio/';
                $fileName=$_FILES["logo"]["name"];
                $fileSize=$_FILES["logo"]["size"]/1024;
                $fileType=$_FILES["logo"]["type"];
                $fileTmpName=$_FILES["logo"]["tmp_name"];
                date_default_timezone_set('America/Costa_Rica');
                $today_date = date('d-m-Y-h-i');
                $newFileName=$today_date.$fileName;
                $arch = $ruta.$newFileName;
                $archivofisico = 'uploads/planesdeEstudio/'.$newFileName;
        
                if(move_uploaded_file($fileTmpName,$arch)){
                $sql="UPDATE plan set logo ='$archivofisico' where PlanCd=".$plan_idcd;
                echo "<br>".$sql."<br>";
                if(mysqli_query($conn,$sql)){
                    //echo "Subida exitosa del doc";
                }else{
                    echo "error1logo";
                    $session->msg("d", "Error: no se pudo cargar el logo, inténtelo de nuevo en modificar.");
                    redirect('ingresar_plan.php', false);
                }
        
                }else{
                //   echo "error2logo";
                $session->msg("d", "Error al cargar el logo, inténtelo de nuevo al modificar");
                redirect('ingresar_plan.php',false);
                }
            }
            /**************************************************************** */
            function crear_carpetas($origen){
                $carpetaorigen=$_SERVER['DOCUMENT_ROOT']."/SIGPE/".'public/uploads/'.$origen;
                if(!file_exists($carpetaorigen)){
                    mkdir($carpetaorigen, 0777,true);
                }
            }
            function guardar_doc($input,$idplan,$tipo,$path,$plancd){
                include("conecta.php");
                require_once('includes/load.php');
                $conn = Conectarse();
                //variables
                $ruta =$_SERVER['DOCUMENT_ROOT']."/SIGPE/".'public/uploads/'.$path;
                date_default_timezone_set('America/Costa_Rica');
                $today_date = date('Y/m/d');
                $fileName=$_FILES[$input]["name"];
                $fileSize=$_FILES[$input]["size"]/1024;
                $fileType=$_FILES[$input]["type"];
                $fileTmpName=$_FILES[$input]["tmp_name"];
                $arch = $ruta.$fileName;
                $archivofisico = 'public/uploads/'.$path.$fileName;

                if(move_uploaded_file($fileTmpName,$arch)){
                    $sql="INSERT INTO documento (nombre, fecha,detalle,archivoFisico,tipoDoc,plan_cd,planId) VALUES ('$fileName','$today_date','$fileName','$archivofisico','$tipo','$plancd',$idplan)";
                    if(mysqli_query($conn,$sql)){
                        //echo "Subida exitosa del doc";
                    }else{
                        $session->msg("d", $msg."No se pudo guardar doc en la bd");
                        redirect('ingresar_plan.php', false);
                    }
                }else{
                    $session->msg("d", $msg."no se pudo subir");
                    redirect('ingresar_plan.php', false);
                }
            }
            /**************************************************************** */
            //Documento Principal de Plan de Estudios
            $cont=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Documento Principal de Plan de Estudios";
            while($bandera){
                $input = 'principal+'.$cont;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Documento Principal de Plan de Estudios",$carpnombre."/",$RowID_Plan);
                    $cont = $cont +1;
                } else{
                    $bandera = false;
                }
            }
            //OPES
            $contOpes=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/OPES";
            while($bandera){
                $input = 'opes+'.$contOpes;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"OPES",$carpnombre."/",$RowID_Plan);
                    $contOpes = $contOpes +1;
                } else{
                    $bandera = false;
                }
            }
            //CNR
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/CNR";
            while($bandera){
                $input = 'cnr+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"CNR",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }

            //Acuerdos de asamblea
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Acuerdos de Asamblea de Unidad Académica";
            while($bandera){
                $input = 'acuerdos+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Acuerdos de Asamblea de Unidad Académica",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Referendos
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Referendos de Facultad";
            while($bandera){
                $input = 'referendos+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Referendos de Facultad",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Visto Bueno de Vicerrectoría de Docencia 
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Visto Bueno de Vicerrectoría de Docencia";
            while($bandera){
                $input = 'visto+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Visto Bueno de Vicerrectoría de Docencia",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Oficio de Registro
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Oficio de Registro";
            while($bandera){
                $input = 'oficio+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Oficio de Registro",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Solicitudes de Asesoría
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Solicitudes de Asesoría";
            while($bandera){
                $input = 'soli+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Solicitudes de Asesoría",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Aprobaciones de SEPUNA/CCP
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Aprobaciones de SEPUNA-CCP";
            while($bandera){
                $input = 'sep+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Aprobaciones de SEPUNA-CCP",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //>Documentación de Convenios
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Documentación de Convenios";
            while($bandera){
                $input = 'conv+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Documentación de Convenios",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Currículums de Docentes
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Currículums de Docentes";
            while($bandera){
                $input = 'curri+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Currículums de Docentes",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Declaración de Plan Terminal
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Declaración de Plan Terminal";
            while($bandera){
                $input = 'dec+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Declaración de Plan Terminal",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
            //Publicación del Plan Terminal
            $contcnr=1;
            $bandera = true;
            $carpnombre = $plan_idcd."/Publicación del Plan Terminal";
            while($bandera){
                $input = 'publi+'.$contcnr;
                if(file_exists($_FILES[$input]['tmp_name']) ||  is_uploaded_file($_FILES[$input]['tmp_name'])){
                crear_carpetas($carpnombre);
                
                guardar_doc($input,$plan_idcd,"Publicación del Plan Terminal",$carpnombre."/",$RowID_Plan);
                    $contcnr = $contcnr +1;
                } else{
                    $bandera = false;
                }
            }
        }//isset archivos requeridos
        else{
            $session->msg("d","ERROR: No se registro plan. 1 o más archivos de la estructura curricular no fueron agregados. Vuelva a ingresar todos los datos.<br> Asegurese de que todos los espacios con se hayan agregado");
            redirect('ingresar_plan.php', false);
        }
    }//isset datos requeridos
        else{
            $session->msg("d","ERROR: No se registro plan. 1 o más datos requeridos no fueron ingresados. Vuelva a ingresar todos los datos.<br> Asegurese de que todos los espacios con * se hayan agregado");
            redirect('ingresar_plan.php', false);
        }
    } // isset mandar}
}catch(Exception $e){
	ECHO 'ERROR '.$e;
	
}

$session->msg("s","Se registró el plan.");
redirect('ingresar_plan.php', false);

?>