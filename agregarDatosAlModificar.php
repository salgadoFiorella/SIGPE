<?php
try{
	include("conecta.php");
	require_once('includes/load.php');
	$conn=Conectarse();
	
	if(isset($_POST['mandar'])) {
		$plan = $_POST['planID']; //el id del plan actual
		//echo "Plan actual: ".$plan."<br>";
		// $sql = 'SELECT * FROM definicionplan where DefinicionPlanId="'.$plan.'"';
		// $result = mysqli_query($conn,$sql);
		// $defPlan = mysqli_fetch_array($result);
		
		$sqlGet = 'SELECT PlanCd from plan where RowID_Plan="'.$plan.'" and HistoricoInd="N"';
		$resultget = mysqli_query($conn,$sqlGet);
		$rowGet = mysqli_fetch_array($resultget);
		$plan_idcd=$rowGet['PlanCd'];
		
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
		$banner2= $_POST['codigoBanner2'];
		$aprobacion = date('Y-m-d', strtotime($_POST['aprobacion']));
		$redisenno = date('Y-m-d', strtotime($_POST['redisenno']));
		$comgen = $_POST['comgen'];
		$comentarioOf = $_POST['comment'];
		if(isset($_POST['declaracionTerm'])){
			$terminal=$_POST['declaracionTerm'];
			//
		}else{
			$terminal='N';
		}
		

		//Actualiza la definicion del plan
		$sqldefPlan= 'UPDATE definicionplan set PlanNombre="'.$nom.'" where DefinicionPlanId="'.$plan.'"';
		$sql = 'UPDATE plan set codigoRegistro="'.$codR.'", codigoBanner="'.$codB.'",nombrePlan="'.$nom.'",gradoAcademico="'.$grado.'", tipoPlan="'.$tipo_plan.'", unidad_Academica="'.$unidadA.'",otras_universidades="'.$otrasU.'",
			  tipo_carrera="'.$tipo_carrera.'", oferta="'.$oferta.'",ComentarioOferta="'.$comentarioOf.'",codigoBanner2="'.$banner2.'", aprobacion="'.$aprobacion.'", redisenno="'.$redisenno.'",ComentariosGenerales="'.$comgen.'" 
			  ,declaracion_planTerminal="'.$terminal.'" where PlanCd="'.$plan_idcd.'"';
			 // echo $sql."<br>";
		
		if(mysqli_query($conn,$sqldefPlan)==TRUE){
			if(mysqli_query($conn,$sql)==TRUE){
			// 	 echo "Se modifico definicion de plan"."<br>";
			//  echo "Se modifico plan"."<br>";
			} else{
				$session->msg("d", $msg."No se pudo modificar el plan<br>");
				redirect('actualizar_plan.php?idPlan=.'.$plan, false);
				// echo "No se modifico plan"."<br>";
			} 
		}else {
			$session->msg("d", $msg."No se pudo modificar el plan<br>");
			redirect('actualizar_plan.php?idPlan=.'.$plan, false);
			// echo "No se modifico definicion de plan"."<br>";
		}
		
		/****************************************** */	
		//SALIDAS, modifica en caso de que haya cambiado y sino inserta nueva
		//Para ver si se modificó o se eliminó uno ya existente
		$sql23 = 'SELECT Id FROM salidas where plan_cd="'.$plan.'" and planAct="Y"';
		$rSal = mysqli_query($conn,$sql23);
		if($rSal->num_rows >= 0){
		  $rSal->data_seek(0); //array de salidas de la BD
		  $sals = array(); 
		  while($fila=$rSal->fetch_assoc()){
			array_push($sals,$fila['Id']);
		  }
		}
		if(isset($_POST['salidasAct'])){
		$salidasAct=$_POST["salidasAct"];
		for ($i=0;$i<count($salidasAct);$i++){
			$existe = in_array ($salidasAct[$i],$sals);
		//Si el enfasis sigue activo, lo modifica
		if($existe==true){
			$desc=$_POST['salid-'.$salidasAct[$i]];
			$salCom=$_POST['salCom-'.$salidasAct[$i]];
			$sql ='UPDATE salidas set salidaLateral="'.$desc.'", comentario="'.$salCom.'" where Id='.$salidasAct[$i];
		}
		if(mysqli_query($conn,$sql)){
		//   echo "Se modificaron las salidas<br>";
		}
		else{
		//   echo "fallo la modificacion de salidas<br>";
		}

		}//cierra el for
		//Si no existe una salida se elimina
		for($j=0;$j<count($sals);$j++){
			$existe1= in_array($sals[$j],$salidasAct);
			if($existe1==false){
				$sql='DELETE from salidas where Id='.$sals[$j];
				if(mysqli_query($conn,$sql)){
					// echo "Se eliminaron las salidas<br>";
				}
				else{
					// echo "fallo la eliminacion de salidas<br>";
				}
			}
		}//cierra el for de j
	}
		//Agregar nuevas Salidas
		$aux=1;
        $bandera = true;
        while($bandera){
            if(isset($_POST['sal+'.$aux])){
				$salida = $_POST['sal+'.$aux];
				$com = $_POST['com-'.$aux];
                $sql="INSERT INTO salidas (SalidaLateral, comentario,plan_cd,planId) VALUES ('$salida','$com','$plan',$plan_idcd)";
                if(mysqli_query($conn,$sql)){
                    // echo "Se ingreso salida: ".$salida."<br>";
                } else{
					// echo "error al insertar salida";
                    $session->msg("d", $msg."Error al ingresar los datos de las salidas<br>");
                    redirect('actualizar_plan.php?idPlan='.$plan, false);
                }
            $aux = $aux +1;
            }
            else{
                $bandera = false;
            }
        }
		/****************************************** */
		//CAMPUS
		//Extrae la informacion de la bd y la almacena en arrays
		$sqlcamp = 'SELECT * FROM plan_campus where plan_cd="'.$plan.'" and planAct="Y"';
		$resultcamp = mysqli_query($conn,$sqlcamp);
		if($resultcamp->num_rows >= 0){
		  $resultcamp->data_seek(0);
		  $campusCD = array(); //array de campus, key = campus_cd, value=id
		  $EstadosPlanes = array(); //array de estados de plan key=campus_cd, value=estadoplan
		  $IDs = array();// ids de los plan_campus que existen en la bd
		  while($fila=$resultcamp->fetch_assoc()){
			$campusCD[$fila['campus_cd']]=$fila['Id'];
			$EstadosPlanes[$fila['campus_cd']]=$fila['EstadoPlan'];
			array_push($IDs,$fila['Id']);
		  }
		}
		$campus=$_POST["campus"];

		for ($i=0;$i<count($campus);$i++){

		//Primero buscamos si esta en los de la bd
		$existe = false;
		if(array_key_exists ($campus[$i],$campusCD)){$existe=true;}

		//Extraemos el estado de plan del formulario
		  $vp = $_POST['virtualP'.$campus[$i]];
		  // echo $campus[$i].'---->';
		  // echo $vp;
		//Caso #1: Existe el campus con distinto estado de plan / Comparacion con los campus y estados de la bd con los que trae el form
		if($existe==true){
			if($vp!=$EstadosPlanes[$campus[$i]]){
				// echo "<br>entre<br>";
				$sql ='UPDATE plan_campus set EstadoPlan="'.$vp.'" where Id='.$campusCD[$campus[$i]];
			}
		}//Caso #2: Agregaron un nuevo campus en el formulario. que no esta en la bd
		else{
			$sql="INSERT INTO plan_campus (plan_cd, campus_cd,EstadoPlan,planId) VALUES ('$plan','$campus[$i]','$vp',$plan_idcd)";
		}
		if(mysqli_query($conn,$sql)){
			// echo $sql."<br>";
		  // echo "Se ingresaron los campus"."<br>";
		}
		else{
			$session->msg("d", $msg."Error al ingresar los datos de los campus.<br>");
			redirect('actualizar_plan.php?idPlan='.$plan, false);
		}

		//Despues de actualizar y agregar, revisamos los plan_campus que ya no estan en el form para eliminarlos de la bd
		for($j=0;$j<count($IDs);$j++){
			$clave = array_search($IDs[$j],$campusCD); //me traigo el valor del campus por medio del id
			if(in_array($clave,$campus)==false){//comparo si el campus de la bd esta en los campus del form
				$sql='DELETE from plan_campus where Id="'.$campusCD[$clave].'"';
				if(mysqli_query($conn,$sql)){
					// echo $sql."<br>";
				//    echo "Se elimino el campus".$clave."<br>";
				}
				else{
				//   echo "fallo la eliminacion de campus"."<br>";
				}
			}
		}
		}
		/****************************************** */
		//ENFASIS
		//Para ver si se modificó o se eliminó uno ya existente
		$sqlenfasis = 'SELECT codigoE FROM enfasis where plan_cd="'.$plan.'" and planAct="Y"';
		$resultenf = mysqli_query($conn,$sqlenfasis);
		if($resultenf->num_rows >= 0){
		  $resultenf->data_seek(0); //array de enfasis
		  $enfs = array(); 
		  while($fila=$resultenf->fetch_assoc()){
			array_push($enfs,$fila['codigoE']);
			
		  }
		}
		if(isset($_POST["enfasisAct"])){
			$enfasisAct=$_POST["enfasisAct"];
		for ($i=0;$i<count($enfasisAct);$i++){
			$existe = in_array ($enfasisAct[$i],$enfs);

		//Si el enfasis sigue activo, lo modifica
		if($existe==true){
			$desc=$_POST['enf-'.$enfasisAct[$i]];
			$sql ='UPDATE enfasis set descripcion="'.$desc.'", nombre="'.$desc.'" where codigoE='.$enfasisAct[$i];
		}
		if(mysqli_query($conn,$sql)){

		//    echo "Se modificaron los enfasis"."<br>";
		}
		else{
		//    echo "fallo la modificacion de enfasis"."<br>";
		}

		}//cierra el for
		//Si no existe un enfasis se elimina
		for($j=0;$j<count($enfs);$j++){
			$existe1= in_array($enfs[$j],$enfasisAct);
			if($existe1==false){
				$sql='DELETE from enfasis where codigoE='.$enfs[$j];
				if(mysqli_query($conn,$sql)){
					// echo "Se eliminaron los enfasis"."<br>";
				}
				else{
					//  echo "fallo la eliminacion de enfasis"."<br>";
				}
			}
		}//cierra el for de j
	}
		// AGREGAR NUEVO ENFASIS
		$aux=1;
		$bandera = true;
		while($bandera)
		{
			if(isset($_POST['enfasis'.$aux])){
			
			$enfasis = $_POST['enfasis'.$aux];
			
			$sql="INSERT INTO enfasis (descripcion, nombre, plan_cd,planId) VALUES ('$enfasis','$enfasis','$plan',$plan_idcd)";
			if(mysqli_query($conn,$sql)){
			
			// echo "Se ingreso enfasis: ".$enfasis."<br>";
			}
			else{
			// echo "fallo".$enfasis."<br>";
			$session->msg("d", $msg."Error al ingresar los datos del Enfasis".$aux." Para arreglar debe ir a modificar<br>");
			redirect('actualizar_plan.php?idPlan=.'.$plan, false);	
		}
			$aux = $aux +1;
			}
			else{
			$bandera = false;
			}
		}
		/****************************************** */
		//ACREDITACIONES ACTUALIZAR
		$sqlacr = 'SELECT AcredCod FROM acreditaciones where planCd="'.$plan.'" and planAct="Y"';
		$resultacr = mysqli_query($conn,$sqlacr);
		if($resultacr->num_rows >= 0){
		 $resultacr->data_seek(0); //array de acreditaciones de la bd
		  $acreds = array(); 
		  while($fila=$resultacr->fetch_assoc()){
			array_push($acreds,$fila['AcredCod']);
		  }
		}

		for ($i=0;$i<count($acreds);$i++){
			$fec=$_POST['fec-'.$acreds[$i]];
			$fecF=$_POST['fecHasta-'.$acreds[$i]];
			$det=$_POST['det-'.$acreds[$i]];
			$sql ='UPDATE acreditaciones set Fecha="'.$fec.'",FechaFin="'.$fecF.'", Detalle="'.$det.'" where AcredCod='.$acreds[$i];

		if(mysqli_query($conn,$sql)){
			
		//   echo "Se modifico la acreditacion"."<br>";
		}
		else{
		//   echo "fallo la modificacion de acreditacion"."<br>";
		}
		}//cierra el for

		//ACREDITACIONES agregar nuevas
		$aux=1;
		$bandera = true;
		while($bandera){
			if(isset($_POST['aprobacion+'.$aux])){
				$detalle = $_POST['detalle-'.$aux];
				$fechaFin = date('Y-m-d', strtotime($_POST['hasta+'.$aux]));
				$fecha = date('Y-m-d', strtotime($_POST['aprobacion+'.$aux]));
				$tipoAcred = $_POST['tipoAcred'.$aux];
				$sql="INSERT INTO acreditaciones (Fecha,FechaFin,Detalle,planCd,planId,tipo) VALUES ('$fecha','$fechaFin','$detalle','$plan',$plan_idcd,'$tipoAcred')";
				// echo $sql."<br>";
				if(mysqli_query($conn,$sql)){
				//   echo "Se ingreso acreditacion"."<br>";
				}
				else{
				//   echo "fallo acreditacion"."<br>";
				$session->msg("d", $msg."Error al ingresar los datos de las Acreditaciones".$aux." Para arreglar debe ir a modificar<br>");
				redirect('actualizar_plan.php?idPlan=.'.$plan, false);
				}
				$aux = $aux +1;
			}
			else{
			$bandera = false;
			}
		}
				/****************************************** */
				//ACTUALIZAR TITULACIONES
				$sqltit = 'SELECT id FROM titulaciones where plan_cd="'.$plan.'" and planAct="S"';
				$resulttit = mysqli_query($conn,$sqltit);
				if($resulttit->num_rows >= 0){
				$resulttit->data_seek(0); //array de enfasis
				$tits = array(); 
				while($fila=$resulttit->fetch_assoc()){
					array_push($tits,$fila['id']);
					//echo $fila['codigoE'];
				}
				}
				if(isset($_POST['titulacionAct'])){
				$titulacionAct=$_POST["titulacionAct"];
				for ($i=0;$i<count($titulacionAct);$i++){
					$existe = in_array ($titulacionAct[$i],$tits);
				//Si el enfasis sigue activo, lo modifica
				if($existe==true){
					$desc=$_POST['nombreTitulacion-'.$titulacionAct[$i]];
					$tipo=$_POST['tipoTitulacion-'.$titulacionAct[$i]];
					$sql ='UPDATE titulaciones set nombre="'.$desc.'", tipo="'.$tipo.'" where id='.$titulacionAct[$i];
				}
				if(mysqli_query($conn,$sql)){
					// echo $sql."<br>";
				//    echo "Se modificaron las titulaciones"."<br>";
				}
				else{
				//    echo "fallo la modificacion de titulaciones"."<br>";
				}

				}//cierra el for
				//Si no existe una titulaciones se elimina
				for($j=0;$j<count($tits);$j++){
					$existe1= in_array($tits[$j],$titulacionAct);
					if($existe1==false){
						$sql='DELETE from titulaciones where id='.$tits[$j];
						if(mysqli_query($conn,$sql)){
							// echo "Se eliminaron los titulaciones"."<br>";
						}
						else{
							//  echo "fallo la eliminacion de titulaciones"."<br>";
						}
					}
				}//cierra el for de j
			}

		//Agregar nuevas titulaciones
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
		/****************************************** */
		//ETIQUETAS
		//Para ver si se modificó o se eliminó uno ya existente
		$sqltag = 'SELECT id FROM etiqueta where plan_cd="'.$plan.'" and planAct="S"';
		$resulttag = mysqli_query($conn,$sqltag);
		if($resulttag->num_rows >= 0){
		  $resulttag->data_seek(0); //array de enfasis
		  $tags = array(); 
		  while($fila=$resulttag->fetch_assoc()){
			array_push($tags,$fila['id']);
			//echo $fila['codigoE'];
		  }
		}
		if(isset($_POST['tagsAct'])){
		$tagsAct=$_POST["tagsAct"];
		for ($i=0;$i<count($tagsAct);$i++){
			$existe = in_array ($tagsAct[$i],$tags);
		//Si el enfasis sigue activo, lo modifica
		if($existe==true){
			$desc=$_POST['etiq-'.$tagsAct[$i]];
			$sql ='UPDATE etiqueta set nombre="'.$desc.'" where id='.$tagsAct[$i];
		}
		if(mysqli_query($conn,$sql)){
			// echo $sql."<br>";
		//    echo "Se modificaron las etiquetas"."<br>";
		}
		else{
		//    echo "fallo la modificacion de etiquetas"."<br>";
		}

		}//cierra el for
		//Si no existe una etiqueta se elimina
		for($j=0;$j<count($tags);$j++){
			$existe1= in_array($tags[$j],$tagsAct);
			if($existe1==false){
				$sql='DELETE from etiqueta where id='.$tags[$j];
				if(mysqli_query($conn,$sql)){
					// echo "Se eliminaron los etiquetas"."<br>";
				}
				else{
					//  echo "fallo la eliminacion de etiquetas"."<br>";
				}
			}
		}//cierra el for de j
	}
	$aux=1;
        $bandera = true;
        while($bandera){
            if(isset($_POST['tag'.$aux])){
                $tag = $_POST['tag'.$aux];
                $sql="INSERT INTO etiqueta (nombre, plan_cd,planId) VALUES ('$tag','$plan',$plan_idcd)";
                if(mysqli_query($conn,$sql)){
                    // echo "Se ingreso etiqueta: ".$tag."<br>";
                } else{
					// echo "error al insertar etiqueta";
                    $session->msg("d", $msg."Error al ingresar los datos de las etiquetas<br>");
                    redirect('actualizar_plan.php?idPlan=.'.$plan, false);
                }
            $aux = $aux +1;
            }
            else{
                $bandera = false;
            }
        }
		/****************************************** */
		//Agregar nuevas AREAS DISCIPLINARIAS
		//Para ver si se modificó o se eliminó uno ya existente
		$sqlarea = 'SELECT Id FROM areas_disciplinarias where plan_cd="'.$plan.'" and planAct="Y"';
		$resultarea = mysqli_query($conn,$sqlarea);
		if($resultarea->num_rows >= 0){
			$resultarea->data_seek(0); //array de areas
			$areas = array(); 
			while($fila=$resultarea->fetch_assoc()){
			array_push($areas,$fila['Id']);
			//echo $fila['codigoE'];
			}
		}
		if(isset($_POST['areasAct'])){
		$areasAct=$_POST["areasAct"];
		for ($i=0;$i<count($areasAct);$i++){
			$existe = in_array ($areasAct[$i],$areas);
		//Si el enfasis sigue activo, lo modifica
		if($existe==true){
			$nombre=$_POST['area-'.$areasAct[$i]];
			$sql ='UPDATE areas_disciplinarias set nombre="'.$nombre.'" where Id='.$areasAct[$i];
		}
		if(mysqli_query($conn,$sql)){
			// echo $sql."<br>";
		//    echo "Se modificaron las areas"."<br>";
		}
		else{
		//    echo "fallo la modificacion de areas"."<br>";
		}

		}//cierra el for
		//Si no existe una etiqueta se elimina
		for($j=0;$j<count($areas);$j++){
			$existe1= in_array($areas[$j],$areasAct);
			if($existe1==false){
				$sql='DELETE from areas_disciplinarias where Id='.$areas[$j];
				if(mysqli_query($conn,$sql)){
					// echo "Se eliminaron los areas"."<br>";
				}
				else{
					//  echo "fallo la eliminacion de areas"."<br>";
				}
			}
		}//cierra el for de j
		}
		$aux=1;
		$bandera = true;
		while($bandera){
			if(isset($_POST['areaD-'.$aux])){
				$nom = $_POST['areaD-'.$aux];
				$sql="INSERT INTO areas_disciplinarias (nombre, plan_cd,planId) VALUES ('$nom','$plan',$plan_idcd)";
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
		/****************************************** */
		//ESTRUCTURA CURRICULAR
		$sqlest = 'SELECT * from estructuracurricular where plan_id="'.$plan_idcd.'" and activo_ind="S"';
		$resultest = mysqli_query($conn,$sqlest);
		$rowest = mysqli_fetch_array($resultest);
		$estructura_id = $rowest['estructura_id'];
		$estructura_excel = $rowest['estructura_excel'];
		$estructura_pdf = $rowest['estructura_pdf'];
		$pdf_publico = $rowest['plan_pdf'];
		$sep = 'uploads/estructuras/';
				$array = explode($sep,$estructura_pdf);
				$nombPDF = $array[1];
		//si mandan nuevo csv
		if(file_exists($_FILES['archcsv']['tmp_name']) || is_uploaded_file($_FILES['archcsv']['tmp_name'])){
			$fileNameCSV=$_FILES["archcsv"]["name"];
            $fileSizeCSV=$_FILES["archcsv"]["size"]/1024;
            $fileTypeCSV=$_FILES["archcsv"]["type"];
			$fileTmpNameCSV=$_FILES["archcsv"]["tmp_name"]; 

			if($fileTypeCSV=="application/vnd.ms-excel" || $fileTypeCSV=="text/csv"){
				date_default_timezone_set('America/Costa_Rica');
				$today_date = date('d-m-Y-h-i');
				$newFileNameCSV=$today_date.$fileNameCSV;
				//File csv upload path
                $uploadPathCSV = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/estructuras/'.$newFileNameCSV;
				$path_csv = 'uploads/estructuras/'.$newFileNameCSV;

				if(move_uploaded_file($fileTmpNameCSV,$uploadPathCSV)){
					unlink($_SERVER['DOCUMENT_ROOT']."/SIGPE/".$estructura_excel); //se elimina el pasado
					$sql = "UPDATE estructuracurricular set estructura_excel='".$path_csv."' where estructura_id='".$estructura_id."'";
					if(mysqli_query($conn,$sql)){
						// echo "Se modifico el csv";
                    }
				}
			}
		} //cierra el si mandan nuevo csv
		//si mandan nuevo pdf
		if ((file_exists($_FILES['archpdf']['tmp_name']) || is_uploaded_file($_FILES['archpdf']['tmp_name']))){
            $fileNamePDF=$_FILES["archpdf"]["name"];
            $fileSizePDF=$_FILES["archpdf"]["size"]/1024;
            $fileTypePDF=$_FILES["archpdf"]["type"];
            $fileTmpNamePDF=$_FILES["archpdf"]["tmp_name"];  

            if($fileTypePDF=="application/pdf"){
                date_default_timezone_set('America/Costa_Rica');
				$today_date = date('d-m-Y-h-i');
				$fecha = date('Y-m-d');
                $newFileNamePDF=$today_date.$fileNamePDF;
                
                //File pdf upload path
                $uploadPathPDF = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/estructuras/'.$newFileNamePDF;
				$path_pdf = 'uploads/estructuras/'.$newFileNamePDF;
				
          
                //function for upload file
                if(move_uploaded_file($fileTmpNamePDF,$uploadPathPDF)){
					$sql1="INSERT INTO versiones_pdf (plancd,ruta,nombre,fecha) values ('$plan_idcd','$estructura_pdf','$nombPDF','$fecha')";
                    $sql="UPDATE estructuracurricular SET estructura_pdf ='$path_pdf' where estructura_id=$estructura_id";
                    if(mysqli_query($conn,$sql)){
						// echo "modificacion exitosa del pdf<br>";
						
						if(mysqli_query($conn,$sql1)){
                        	// echo "Subida exitosa del pdf a versiones<br>";
						}
						else{
							$session->msg("d", $msg."Error al cargar el pdf en tabla versiones<br>");
							redirect('actualizar_plan.php?idPlan='.$plan, false);
							// echo "Subida no exitosa del pdf a versiones<br>";
						}
					}else{
						// echo "modificacion no exitosa del pdf<br>";
						$session->msg("d", $msg."Error al modificar el pdf de estructura.<br>");
						redirect('actualizar_plan.php?idPlan='.$plan, false);
					}
                   

                }else{
					// echo "error al guardar pdf de estructura";
                    $session->msg("d", $msg."Error al guardar pdf de estructura curricular, intentelo en modificar plan<br>");
                   redirect('actualizar_plan.php?idPlan='.$plan, false);
                }
            }
            else{
            //   echo "You can only upload a pdf file estructura.";
            }  

		}
		
		//plan publico
        if((file_exists($_FILES['planpdf']['tmp_name']) ||  is_uploaded_file($_FILES['planpdf']['tmp_name']))){
			//Plan de estudios publico
			$fNamePDF=$_FILES["planpdf"]["name"];
			$fSizePDF=$_FILES["planpdf"]["size"]/1024;
			$fTypePDF=$_FILES["planpdf"]["type"];
			$fTmpNamePDF=$_FILES["planpdf"]["tmp_name"];

		   if($fTypePDF=="application/pdf"){

			   $upPathPDF = $_SERVER['DOCUMENT_ROOT']."/SIGPE/".'uploads/pdfs/'.$fNamePDF;
			   $ruta_pdf = 'uploads/pdfs/'.$fNamePDF;
			   if(move_uploaded_file($fTmpNamePDF,$upPathPDF)){
				   $sql="UPDATE estructuracurricular set plan_pdf ='$ruta_pdf' where estructura_id=".$estructura_id;
				   unlink($pdf_publico);
				   //echo "<br>".$sql."<br>";
				   if(mysqli_query($conn,$sql)){
					//    echo "Subida exitosa del pdf";
				   }else{
					//    echo "Error1: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar";
					   $session->msg("d", "Error1: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
					   redirect('actualizar_plan.php?idPlan='.$plan, false);
				   }
				   
			   }else{
				//    echo "Error2: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.";
				   $session->msg("d", "Error2: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
				   redirect('actualizar_plan.php?idPlan='.$plan, false);
			   }
	   
		   }else{
			//    echo "Error3: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.";
			   $session->msg("d", "Error3: no se pudo cargar el pdf publico, inténtelo de nuevo en modificar.");
					   redirect('actualizar_plan.php?idPlan='.$plan, false);
		   }

	   }

		/****************************************** */
		$sqlGetL = 'SELECT logo from plan where PlanCd="'.$plan_idcd.'" and HistoricoInd="N"';
		$resultgetL = mysqli_query($conn,$sqlGetL);
		$rowGetL = mysqli_fetch_array($resultgetL);
		$plan_logo=$rowGetL['logo'];
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
              if(mysqli_query($conn,$sql)){
				  if(unlink($_SERVER['DOCUMENT_ROOT']."/SIGPE/".$plan_logo)){
					//   echo "se elimina el logo pasado<br>";
				  }else{
					//   echo "no se elimina el logo pasado<br>";
				  }
                //   echo "Subida exitosa del logo";
              }else{
                // echo "error1logo";
                  $session->msg("d", "Error: no se pudo cargar el logo, inténtelo de nuevo en modificar.");
				  redirect('actualizar_plan.php?idPlan='.$plan, false);
              }
      
            }else{
            //   echo "error2logo";
              $session->msg("d", "Error al cargar el logo, inténtelo de nuevo al modificar");
			  redirect('actualizar_plan.php?idPlan='.$plan, false);
            }
          }
		/****************************************** */
		//DOCUMENTOS
		//Eliminar documento en caso de que la persona ya lo deselecciono
		$docAct=$_POST["docsAct"];
		$sqldoc = 'SELECT codigoDoc, archivoFisico FROM documento where planAct="Y" and plan_cd="'.$plan.'"';
		$resultadoc = mysqli_query($conn,$sqldoc);
		if($resultadoc->num_rows >= 0){
		  $resultadoc->data_seek(0); //array de enfasis
			$docs = array(); 
			$fisico = array();
		  while($fila=$resultadoc->fetch_assoc()){
			array_push($docs,$fila['codigoDoc']);
			array_push($fisico,$fila['archivoFisico']);
		  }
		}
		for($j=0;$j<count($docs);$j++){
			$existe1= in_array($docs[$j],$docAct);
			if($existe1==false){
				$sql='DELETE from documento where codigoDoc='.$docs[$j];
				if(mysqli_query($conn,$sql)){
					// echo $sql."<br>";
					// echo "Se elimino el documento"."<br>";
					unlink($_SERVER['DOCUMENT_ROOT']."/SIGPE/".$fisico[$j]);
				}
				else{
					//echo "fallo la eliminacion de documento"."<br>";
				}
			}
		}//cierra el for de j
		// //Agregar nuevos docs
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
					// echo "Subida exitosa del doc";
				}else{
					// echo "no se pudo guardar doc en la bd";
					$session->msg("d", $msg."No se pudo guardar doc en la bd");
					redirect('actualizar_plan.php?idPlan=.'.$plan, false);
				}
			}else{
				//echo "no se pudo subir";
				$session->msg("d", $msg."no se pudo subir");
				redirect('actualizar_plan.php?idPlan=.'.$plan, false);
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
			
			guardar_doc($input,$plan_idcd,"Documento Principal de Plan de Estudios",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"OPES",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"CNR",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Acuerdos de Asamblea de Unidad Académica",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Referendos de Facultad",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Visto Bueno de Vicerrectoría de Docencia",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Oficio de Registro",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Solicitudes de Asesoría",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Aprobaciones de SEPUNA-CCP",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Documentación de Convenios",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Currículums de Docentes",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Declaración de Plan Terminal",$carpnombre."/",$plan);
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
			
			guardar_doc($input,$plan_idcd,"Publicación del Plan Terminal",$carpnombre."/",$plan);
				$contcnr = $contcnr +1;
			} else{
				$bandera = false;
			}
		}

	} //cierra el isset
}catch(Exception $e){
	 ECHO 'ERROR '.$e;
}
$session->msg("s", $msg."Plan modificado");
redirect('actualizar_plan.php?idPlan='.$plan, false);
?>
