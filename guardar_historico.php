<?php 
try{
	include("conecta.php");
	require_once('includes/load.php');
	//include("script/GuardarDocumentos.php");
    $conn=Conectarse();
    date_default_timezone_set('America/Costa_Rica');
    $today_date = date('Y/m/d');

    if(isset($_POST['mandar'])) {
        $RowID_Plan=$_POST['planID'];
        //Atributos del plan de estudio y definicion del plan
		$nom = $_POST['nombrePlan'];
		$codR = $_POST['codigoRegistro'];
		$codB = $_POST['codigoBanner'];
		$grado = $_POST["gradoAcademico"];
		$tipo_carrera = $_POST["tipo_carrera"];
		$tipo_plan = $_POST["grado"];
		$unidadA= $_POST['unidad'];
		$otrasU= $_POST['otrasU'];
		$oferta = $_POST["oferta"];
		$codigoBanner2= $_POST['codigoBanner2'];
		$aprobacion = date('Y-m-d', strtotime($_POST['aprobacion']));
		$redisenno = date('Y-m-d', strtotime($_POST['redisenno']));
		$comgen = $_POST['comgen'];
		$ofex = $_POST["comment"];
		if(isset($_POST['declaracionTerm'])){
			$terminal=$_POST['declaracionTerm'];
		}else{
			$terminal='N';
        }
        
        //Extraer codigo unico del plan que sera sustituido
		$sqlGet = 'SELECT PlanCd from plan where RowID_Plan="'.$RowID_Plan.'" and HistoricoInd="N"';
		$resultget = mysqli_query($conn,$sqlGet);
		$rowGet = mysqli_fetch_array($resultget);
		$codPlan= $rowGet['PlanCd'];

        //Modificamos dicho plan para pasar al nuevo
		$sqlPlanb="UPDATE plan set HistoricoInd='Y', fecha_historico='".$today_date."' where PlanCd=".$codPlan;
        $sqldefPlan='UPDATE definicionplan set PlanNombre="'.$nom.'" where DefinicionPlanId="'.$RowID_Plan.'"';
        
        //Insertamos nuevo plan
		$usuario = current_user();
		$usuarioID= $usuario['username'];
		$sql = "INSERT INTO plan (RowID_Plan,codigoRegistro,DefinicionPlanId, codigoBanner,
			nombrePlan,gradoAcademico, tipoPlan, unidad_Academica,otras_universidades,
			tipo_carrera, oferta,ComentarioOferta,codigoBanner2, aprobacion, redisenno,
			ComentariosGenerales,Usuario,declaracion_planTerminal)"
			."VALUES ('$RowID_Plan','$codR','$RowID_Plan', '$codB',
			'$nom','$grado', '$tipo_plan', '$unidadA','$otrasU',
			'$tipo_carrera','$oferta','$ofex','$codigoBanner2', '$aprobacion', '$redisenno',
			'$comgen','$usuarioID','$terminal')";
		// echo $sqlPlanb."<br>";
		// echo $sqldefPlan."<br>";
		// echo $sql."<br>";
		if(mysqli_query($conn,$sqlPlanb)==TRUE){
			if(mysqli_query($conn,$sqldefPlan)==TRUE){
				if(mysqli_query($conn,$sql)==TRUE){
					// echo "Se ingreso definicion de plan"."<br>";
					// echo "Se ingreso plan"."<br>";
				}
				else{
					$session->msg("d", $msg."1Error al ingresar los datos del plan. Intente de nuevo<br>");
					redirect('historico.php?idPlan='.$RowID_Plan, false);
					// echo "No se ingreso plan historico"."<br>";
				} 
			}else {
				$session->msg("d", $msg."2Error al ingresar los datos del plan. Intente de nuevo<br>");
				redirect('historico.php?idPlan='.$RowID_Plan, false);
				// echo "No se pudo modificar definicion de plan"."<br>";
			}
		}else{
			$session->msg("d", $msg."3Error al ingresar los datos del plan. Intente de nuevo<br>");
			redirect('historico.php?idPlan='.$RowID_Plan, false);
			// echo"NO SE PUDO modificar el ind en el plan viejo<br>";
		}

		//Nuevo codigo de plan
		$sqlGet1 = 'SELECT PlanCd from plan where RowID_Plan="'.$RowID_Plan.'" AND HistoricoInd="N"';
		$resultget1 = mysqli_query($conn,$sqlGet1);
		$rowGet1 = mysqli_fetch_array($resultget1);
        $plan_idcd=$rowGet1['PlanCd'];
        // echo $plan_idcd;
        
        /************************************* */
		//CAMPUS
		//Modificar cuando existen campus del plan anterior
		$sqlcamp1 = 'SELECT * from plan_campus where plan_cd="'.$RowID_Plan.'" and planAct="Y"';
		$resultcamp1 = mysqli_query($conn,$sqlcamp1);
		if($resultcamp1->num_rows > 0){
			$resultcamp1->data_seek(0);
			while($fila=$resultcamp1->fetch_assoc()){
				$sqlcamp='UPDATE plan_campus set planAct="N" where Id="'.$fila["Id"].'"';
				if(mysqli_query($conn,$sqlcamp)==TRUE){
					// echo "campusModificado<br>";
				}
			}
		}

		//Agregar los nuevos campus
            $campus=$_POST["campus"];
            for ($i=0;$i<count($campus);$i++){

                $vp = $_POST['virtualP'.$campus[$i]] ;
                $sql="INSERT INTO plan_campus (plan_cd, campus_cd,EstadoPlan,planId) VALUES ('$RowID_Plan','$campus[$i]','$vp',$plan_idcd)";
                if(mysqli_query($conn,$sql)){
                    // echo "Se ingresaron los campus"."<br>";
                }
                else{
                    // echo "fallaron los campus"."<br>";
                // $session->msg("d", $msg."Error al ingresar los datos del Campus".$i." Para arreglar debe ir a modificar<br>");
                // redirect('crear_historico.php?idPlan='.$RowID_Plan, false);	
                }
            }

			/************************************* */
			//ENFASIS
			$senf1 = 'SELECT * from enfasis where plan_cd="'.$RowID_Plan.'" and planAct="Y"';
			$renf1 = mysqli_query($conn,$senf1);
			//$rcamp1 = mysqli_fetch_array($resultcamp1);
			if($renf1->num_rows > 0){
				$renf1->data_seek(0);
				while($fila=$renf1->fetch_assoc()){
					$sqlenf='UPDATE enfasis set planAct="N" where codigoE="'.$fila["codigoE"].'"';
					if(mysqli_query($conn,$sqlenf)==TRUE){
						// echo "enfasisModificado<br>";
					}
				}
            }
            if(isset($_POST["enfasisAct"])){
                $enfasisAct=$_POST["enfasisAct"];
                for ($i=0;$i<count($enfasisAct);$i++){                
                    $desc=$_POST['enf-'.$enfasisAct[$i]];
                    $sql ="INSERT INTO enfasis (descripcion, nombre, plan_cd,planId) VALUES ('$desc','$desc','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                    //    echo "Se agregaron los enfasis pasados"."<br>";
                    }
                    else{
                    //    echo "fallo agregar enfasis pasados"."<br>";
                    }
                }
            }
			//Agregar nuevos enfasis
			$aux=1;
			$bandera = true;
			while($bandera)
			{
				if(isset($_POST['enfasis'.$aux])){
				// echo 'Enfasis2'.'<br>';
				$enfasis = $_POST['enfasis'.$aux];
				// echo $enfasis;
				$sql="INSERT INTO enfasis (descripcion, nombre, plan_cd,planId) VALUES ('$enfasis','$enfasis','$RowID_Plan',$plan_idcd)";
				if(mysqli_query($conn,$sql)){
					//echo "Se ingreso enfasis: ".$enfasis."<br>";
				}
				else{
					//echo "No se ingreso enfasis: ".$enfasis."<br>";
				// $session->msg("d", $msg."Error al ingresar los datos del Enfasis".$aux." Para arreglar debe ir a modificar<br>");
				// redirect('crear_historico.php?idPlan='.$RowID_Plan, false);	
			}
				$aux = $aux +1;
				}
				else{
				$bandera = false;
				}
			}
			/************************************* */		
			//ACREDITACIONES
			//Modificar las viejas
			$sac1 = 'SELECT * from acreditaciones where planCd="'.$RowID_Plan.'" and planAct="Y"';
			$rsac1 = mysqli_query($conn,$sac1);
			//$rcamp1 = mysqli_fetch_array($resultcamp1);
			if($rsac1->num_rows > 0){
				$rsac1->data_seek(0);
				while($fila=$rsac1->fetch_assoc()){
					$sqlsac='UPDATE acreditaciones set planAct="N" where AcredCod="'.$fila["AcredCod"].'"';
					if(mysqli_query($conn,$sqlsac)==TRUE){
						//echo "acreditacionModificada<br>";
					}else{
						//echo "acreditacion no Modificada<br>";
					}
				}
            }
            //Acreditaciones que estaban en el plan anterior se agregan a este nuevo
            if(isset($_POST['AcredAct'])){
                $acredAct=$_POST["AcredAct"];
                for ($i=0;$i<count($acredAct);$i++){
                    $fec=$_POST['fec-'.$acredAct[$i]];
                    $fecF=$_POST['fecHasta-'.$acredAct[$i]];
                    $det=$_POST['det-'.$acredAct[$i]];
                    $tipoAcred = $_POST['AcreditacionTipo'.$acredAct[$i]];
                    $sql ="INSERT INTO acreditaciones (Fecha,FechaFin,Detalle,planCd,planId,tipo) values ('$fec','$fecF','$det','$RowID_Plan',$plan_idcd,'$tipoAcred')";
                    if(mysqli_query($conn,$sql)){
                    //   echo "Se agregaron las Acreditaciones<br>";
                    }
                    else{
                    //   echo "fallo insertar Acreditaciones anteriores<br>";
                    }
                }
            }
			//Agregar nuevas acreditaciones
			$aux=1;
			$bandera = true;
			while($bandera){
			if(isset($_POST['aprobacion+'.$aux])){
				$fecha = date('Y-m-d', strtotime($_POST['aprobacion+'.$aux]));
                $detalle = $_POST['detalle-'.$aux];
                $fechaFin = date('Y-m-d', strtotime($_POST['hasta+'.$aux]));
                $tipoAcred = $_POST['tipoAcred'.$aux];
				print_r($fecha);
				$sql="INSERT INTO acreditaciones (Fecha,FechaFin,Detalle,planCd,planId,tipo) VALUES ('$fecha','$fechaFin','$detalle','$RowID_Plan',$plan_idcd,'$tipoAcred')";
				if(mysqli_query($conn,$sql)){
					//echo "Se ingreso acreditacion"."<br>";
				}
				else{
					//echo "fallo acreditacion"."<br>";
				// $session->msg("d", $msg."Error al ingresar los datos de las Acreditaciones".$aux." Para arreglar debe ir a modificar<br>");
				// redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
				}
				$aux = $aux +1;
			}
			else{

			$bandera = false;
			}
			}

			/**************************************************************** */
			//SALIDAS
			$sal1 = 'SELECT * from salidas where plan_cd="'.$RowID_Plan.'" and planAct="Y"';
			$rsal1 = mysqli_query($conn,$sal1);
			if($rsal1->num_rows > 0){
				$rsal1->data_seek(0);
				while($fila=$rsal1->fetch_assoc()){
					$sqlcamp='UPDATE salidas set planAct="N" where Id="'.$fila["Id"].'"';
					if(mysqli_query($conn,$sqlcamp)==TRUE){
						//echo "salida Modificada<br>";
					}
				}
            }
            
            //SALIDAS que estaban en el plan anterior se agregan a este nuevo
            if(isset($_POST['salidasAct'])){
                $salidasAct=$_POST["salidasAct"];
                for ($i=0;$i<count($salidasAct);$i++){
                        $desc=$_POST['salid-'.$salidasAct[$i]];
                        $salCom=$_POST['salCom-'.$salidasAct[$i]];
                        $sql ="INSERT INTO Salidas (SalidaLateral,comentario,plan_cd,planId) VALUES ('$desc','$salCom','$RowID_Plan',$plan_idcd)";

                    if(mysqli_query($conn,$sql)){
                    //   echo "Se agregaron las salidas<br>";
                    }
                    else{
                    //   echo "fallo insertar salidas anteriores<br>";
                    }
                }//cierra el for
            }

			//Agregar nuevas Salidas
			$aux=1;
			$bandera = true;
			while($bandera){
				if(isset($_POST['sal+'.$aux])){
					$salida = $_POST['sal+'.$aux];
					$comentario = $_POST['com-'.$aux];
					$sql="INSERT INTO Salidas (SalidaLateral,comentario,plan_cd,planId) VALUES ('$salida','$comentario','$RowID_Plan',$plan_idcd)";
					if(mysqli_query($conn,$sql)){
						//echo "salida ingresada<br>";
					}
					else{
						//echo "salida no ingresada<br>";
						// $session->msg("d", $msg."Error al ingresar los datos de las salidas<br>");
						// redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
					}
					$aux = $aux +1;
				} 
				else{ 
					$bandera = false; 
				} 
			}
            /**************************************************************** */
            //Titulaciones
            //editar las viejas para que no esten activas
			$sal1 = 'SELECT * from titulaciones where plan_cd="'.$RowID_Plan.'" and planAct="S"';
			$rsal1 = mysqli_query($conn,$sal1);
			if($rsal1->num_rows > 0){
				$rsal1->data_seek(0);
				while($fila=$rsal1->fetch_assoc()){
					$sqlcamp='UPDATE titulaciones set planAct="N" where id="'.$fila["id"].'"';
					if(mysqli_query($conn,$sqlcamp)==TRUE){
						//echo "titulaciones Modificada<br>";
					}
				}
            }
            //titulaciones que estaban en el plan anterior se agregan a este nuevo
            if(isset($_POST['titulacionAct'])){
                $titulacionAct=$_POST["titulacionAct"];
                for ($i=0;$i<count($titulacionAct);$i++){
                        $nom=$_POST['nombreTitulacion-'.$titulacionAct[$i]];
                        $tipo=$_POST['tipoTitulacion-'.$titulacionAct[$i]];
                        $sql ="INSERT INTO titulaciones (nombre,tipo,plan_cd,planId) VALUES ('$nom','$tipo','$RowID_Plan',$plan_idcd)";

                    if(mysqli_query($conn,$sql)){
                    //   echo "Se agregaron las titulaciones<br>";
                    }
                    else{
                    //   echo "fallo insertar titulaciones anteriores<br>";
                    }
                }//cierra el for
            }

            //Nuevas que agreguen
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
            //Etiquetas
            //Se modifican todas las anteriores para que no esten activas
			$sal1 = 'SELECT id from etiqueta where plan_cd="'.$RowID_Plan.'" and planAct="S"';
			$rsal1 = mysqli_query($conn,$sal1);
			if($rsal1->num_rows > 0){
				$rsal1->data_seek(0);
				while($fila=$rsal1->fetch_assoc()){
					$sqlcamp='UPDATE etiqueta set planAct="N" where id="'.$fila["id"].'"';
					if(mysqli_query($conn,$sqlcamp)==TRUE){
						//echo "etiqueta Modificada<br>";
					}else{
						//echo "etiqueta no modificada<br>";
					}
				}
            }
            //Se agregan las etiquetas del plan anterior
            if(isset($_POST['tagsAct'])){
                $tagsAct=$_POST["tagsAct"];
                for ($i=0;$i<count($tagsAct);$i++){
                    $desc=$_POST['etiq-'.$tagsAct[$i]];
                    $sql ="INSERT INTO etiqueta (nombre, plan_cd,planId) VALUES ('$desc','$RowID_Plan',$plan_idcd)";
                    if(mysqli_query($conn,$sql)){
                        // echo $sql."<br>";
                    //    echo "Se agregaron etiquetas del plan anterior"."<br>";
                    }
                    else{
                    //    echo "fallo agregar etiquetas del plan anterior"."<br>";
                    }
                }
            }
			//Agregar nuevas etiquetas
			$aux=1;
			$bandera = true;
			while($bandera){
				if(isset($_POST['tag'.$aux])){
					$tag = $_POST['tag'.$aux];
					$sql="INSERT INTO etiqueta (nombre, plan_cd,planId) VALUES ('$tag','$RowID_Plan',$plan_idcd)";
					if(mysqli_query($conn,$sql)){
					 //echo "Se ingreso etiqueta<br>";
					} else{
						//echo "no se ingreso etiqueta<br>";
						// $session->msg("d", $msg."Error al ingresar los datos de las etiquetas<br>");
						// redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
					}
				$aux = $aux +1;
				}
				else{
					$bandera = false;
				}
            }
            /****************************************** */
		//Agregar nuevas AREAS DISCIPLINARIAS
		//Se modifican las areas del plan viejo
		$sqlarea = 'SELECT Id FROM areas_disciplinarias where plan_cd="'.$RowID_Plan.'" and planAct="Y"';
		$resultarea = mysqli_query($conn,$sqlarea);
		if($resultarea->num_rows >= 0){
			$resultarea->data_seek(0); //array de areas 
			while($fila=$resultarea->fetch_assoc()){
                $sqlcamp='UPDATE areas_disciplinarias set planAct="N" where Id="'.$fila["Id"].'"';
                if(mysqli_query($conn,$sqlcamp)==TRUE){
                    //echo "etiqueta Modificada<br>";
                }else{
                    //echo "etiqueta no modificada<br>";
                }
			}
        }
        //Se agregan las areas del plan anterior
		if(isset($_POST['areasAct'])){
            $areasAct=$_POST["areasAct"];
            for ($i=0;$i<count($areasAct);$i++){
                $nombre=$_POST['area-'.$areasAct[$i]];
                $sql ="INSERT INTO areas_disciplinarias (nombre, plan_cd,planId) VALUES ('$nombre','$RowID_Plan',$plan_idcd)";
                if(mysqli_query($conn,$sql)){
                //    echo "Se agregaron las areas pasadas"."<br>";
                }
                else{
                //    echo "fallo agregar areas pasadas"."<br>";
                }

            }//cierra el for
        }
        //Agregar nuevas areas disciplinarias
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
                    redirect('actualizar_plan.php?idPlan='.$plan, false);
				}
			$aux = $aux +1;
			}
			else{
				$bandera = false;
			}
		}
        /**************************************************************** */
        //Estructura curricular
        $sql = 'SELECT estructura_id, estructura_pdf from estructuracurricular where plan_id="'.$codPlan.'"';
        $res = mysqli_query($conn,$sql);
        $rowGet = mysqli_fetch_array($res);
        $data =$rowGet['estructura_pdf'];
        $sep = 'uploads/estructuras/';
        $array = explode($sep,$data);
        $nombPDF = $array[1];
        date_default_timezone_set('America/Costa_Rica');
        $today_date = date('Y-m-d');
        $sqlPlanb="UPDATE estructuracurricular set activo_ind='N' where estructura_id='".$rowGet['estructura_id']."'";
        if(mysqli_query($conn,$sqlPlanb)){
            //echo "se modifico la estructura vieja<br>";
        }

        //Insertamos esta version en la tabla versiones pdf
        $sql="INSERT INTO versiones_pdf (plancd, ruta,nombre,fecha) VALUES ('$codPlan','$data','$nombPDF','$today_date')";
        if(mysqli_query($conn,$sql)){
            //echo "Subida exitosa de la estructura";
        }
        //Nueva estructura curricular
        if ((file_exists($_FILES['archpdf']['tmp_name']) || is_uploaded_file($_FILES['archpdf']['tmp_name'])) && ( file_exists($_FILES['archcsv']['tmp_name']) || is_uploaded_file($_FILES['archcsv']['tmp_name']))){
            $fileNamePDF=$_FILES["archpdf"]["name"];
            $fileSizePDF=$_FILES["archpdf"]["size"]/1024;
            $fileTypePDF=$_FILES["archpdf"]["type"];
            $fileTmpNamePDF=$_FILES["archpdf"]["tmp_name"];  

            $fileNameCSV=$_FILES["archcsv"]["name"];
            $fileSizeCSV=$_FILES["archcsv"]["size"]/1024;
            $fileTypeCSV=$_FILES["archcsv"]["type"];
            $fileTmpNameCSV=$_FILES["archcsv"]["tmp_name"]; 
            
        
            if($fileTypePDF=="application/pdf" && ($fileTypeCSV=="application/vnd.ms-excel" || $fileTypeCSV=="text/csv")){      
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
                    if(mysqli_query($conn,$sql)){
                        //echo "Subida exitosa de la estructura";
                    }
                

                }else{
                    //echo "Subida no exitosa de la estructura";
                    // $session->msg("d", $msg."Error al guardar pdf de estructura curricular, intentelo en modificar plan<br>");
                }
            }
            else{
            //echo "You can only upload a pdf and .csv/.xls file.";
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
                //    echo "<br>".$sql."<br>";
                   if(mysqli_query($conn,$sql)){
                       // echo "Subida exitosa del pdf";
                   }else{
                       $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
                       redirect('historico.php?idPlan='.$RowID_Plan, false);
                   }
                   
               }else{
                   $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
                   redirect('historico.php?idPlan='.$RowID_Plan, false);
               }
       
           }else{
               $session->msg("d", "Error: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
               redirect('historico.php?idPlan='.$RowID_Plan, false);
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
        // echo "<br>".$sql."<br>";
        if(mysqli_query($conn,$sql)){
            //echo "Subida exitosa del doc";
        }else{
        // echo "error1logo";
            $session->msg("d", "Error: no se pudo cargar el logo, inténtelo de nuevo en modificar.");
            redirect('historico.php?idPlan='.$RowID_Plan, false);
        }

        }else{
        //   echo "error2logo";
            $session->msg("d", "Error al cargar el logo, inténtelo de nuevo al modificar");
            redirect('historico.php?idPlan='.$RowID_Plan, false);
        }
        }
        /************************************************************** */
        //DOCUMENTOS
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
                    //echo "No se pudo guardar doc en la bd";
                    // $session->msg("d", $msg."No se pudo guardar doc en la bd");
                    // redirect('ingresar_plan.php', false);
                }
            }else{
                // $session->msg("d", $msg."no se pudo subir");
                // redirect('ingresar_plan.php', false);
            }
        }
        /**************************************************************** */
        //Modificar documentos viejos
        $sal1 = 'SELECT codigoDoc from documento where planId="'.$codPlan.'" and planAct="Y"';
        $rsal1 = mysqli_query($conn,$sal1);
        //$rcamp1 = mysqli_fetch_array($resultcamp1);
        if($rsal1->num_rows > 0){
            $rsal1->data_seek(0);
            while($fila=$rsal1->fetch_assoc()){
                $sqlcamp='UPDATE documento set planAct="N" where codigoDoc="'.$fila["codigoDoc"].'"';
                if(mysqli_query($conn,$sqlcamp)==TRUE){
                    //echo "salidaModificada<br>";
                }
            }
        }
        //Agregar documentos nuevos
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
    }//isset mandar

}catch(Exception $e){

}
$session->msg("s", "Plan agregado");
redirect('busqueda_planes.php', false);

?>