<?php
try{
	include("conecta.php");
	require_once('includes/load.php');
	//include("script/GuardarDocumentos.php");
	$conn=Conectarse();
	
	if(isset($_POST['guardar'])) {
		$RowID_Plan=$_POST['idPlan'];

		//Atributos del plan de estudio y definicion del plan
		$nom = $_POST['nombrePlan'];
		$codR = $_POST['codigoRegistro'];
		$codB = $_POST['codigoBanner'];
		$grado = $_POST["gradoAcademico"];
		$tipo_carrera = $_POST["tipo_carrera"];
		$tipo_plan = $_POST["grado"];
		$unidadA= $_POST['unidadAcademica'];
		$otrasU= $_POST['otrasU'];
		$oferta = $_POST["oferta"];
		$titulaciones= $_POST['titulaciones'];
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
		$sqlPlanb="UPDATE plan set HistoricoInd='Y' where PlanCd=".$codPlan;
		$sqldefPlan='UPDATE definicionplan set PlanNombre="'.$nom.'" where DefinicionPlanId="'.$RowID_Plan.'"';

		//Insertamos nuevo plan
		$usuario = current_user();
		$usuarioID= $usuario['id'];
		$sql = "INSERT INTO plan (RowID_Plan,codigoRegistro,DefinicionPlanId, codigoBanner,
			nombrePlan,gradoAcademico, tipoPlan, unidad_Academica,otras_universidades,
			tipo_carrera, oferta,ComentarioOferta,Titulaciones, aprobacion, redisenno,
			ComentariosGenerales,Usuario,declaracion_planTerminal)"
			."VALUES ('$RowID_Plan','$codR','$RowID_Plan', '$codB',
			'$nom','$grado', '$tipo_plan', '$unidadA','$otrasU',
			'$tipo_carrera','$oferta','$ofex','$titulaciones', '$aprobacion', '$redisenno',
			'$comgen','$usuarioID','$terminal')";
		
		if(mysqli_query($conn,$sqlPlanb)==TRUE){
			if(mysqli_query($conn,$sqldefPlan)==TRUE){
				if(mysqli_query($conn,$sql)==TRUE){
					// echo "Se ingreso definicion de plan"."<br>";
					// echo "Se ingreso plan"."<br>";
				}
				else{
					$session->msg("d", $msg."Error al ingresar los datos del plan. Intente de nuevo<br>");
					redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
					// echo "No se ingreso plan historico"."<br>";
				} 
			}else {
				$session->msg("d", $msg."Error al ingresar los datos del plan. Intente de nuevo<br>");
				redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
				// echo "No se pudo modificar definicion de plan"."<br>";
			}
		}else{
			$session->msg("d", $msg."Error al ingresar los datos del plan. Intente de nuevo<br>");
			redirect('crear_historico.php?idPlan='.$RowID_Plan, false);
			// echo"NO SE PUDO modificar el ind en el plan viejo<br>";
		}

		//Nuevo codigo de plan
		$sqlGet1 = 'SELECT PlanCd from plan where RowID_Plan="'.$RowID_Plan.'" AND HistoricoInd="N"';
		$resultget1 = mysqli_query($conn,$sqlGet1);
		$rowGet1 = mysqli_fetch_array($resultget1);
		$plan_idcd=$rowGet1['PlanCd'];

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
			}}

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
			//Agregar nuevos enfasis
			$aux=1;
			$bandera = true;
			while($bandera)
			{
				if(isset($_POST['enfasis'.$aux])){
				echo 'Enfasis2'.'<br>';
				$enfasis = $_POST['enfasis'.$aux];
				echo $enfasis;
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
			//Agregar nuevas acreditaciones
			$aux=1;
			$bandera = true;
			while($bandera){
			if(isset($_POST['aprobacion+'.$aux])){
				$fecha = date('Y-m-d', strtotime($_POST['aprobacion+'.$aux]));
				$detalle = $_POST['detalle-'.$aux];
				print_r($fecha);
				$sql="INSERT INTO acreditaciones (Fecha,Detalle,planCd,planId) VALUES ('$fecha','$detalle','$RowID_Plan',$plan_idcd)";
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
			//Etiquetas
			$sal1 = 'SELECT * from etiqueta where plan_cd="'.$RowID_Plan.'" and planAct="S"';
			$rsal1 = mysqli_query($conn,$sal1);
			//$rcamp1 = mysqli_fetch_array($resultcamp1);
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
				//if($fileSize<=200){
			
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
						// redirect('ingresar_plan.php', false);
					}
				}
				else{
				//echo "You can only upload a pdf and .csv/.xls file.";
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
	} //isset mandar
	else{
		$session->msg("d", $msg."Error al ingresar los datos del nuevo plan, para arreglar debe ir a modificar<br>");
		redirect('crear_historico.php?idPlan='.$RowID_Plan, false);	
	}
}catch(Exception $e){
	ECHO 'ERROR '.$e;
	
}
$session->msg("s","Se registró el plan.");
redirect('busqueda_planes.php', false);

?>
<!-- <script  language="javascript">
window.self.location="planesEstudio.php";
</script> -->