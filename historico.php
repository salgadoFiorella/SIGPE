<!doctype html>
<html lang="en">
<?php
	//include("conecta.php");
  require_once('includes/load.php');
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	page_require_permission('crear_historico');
?>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="libs/css-files/bootstrap.min.css">
<style>
.bg-red {
    background-color: #CC071E;
}
#line{
	border: 0;
	clear:both;
	display:block;
	width: 96%;                
	/*background-color:#428bca;*/
	height: 1px;
	border-top: 3px double #428bca;
}
</style>
    <title>Agregar Plan</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>

    <!--Queries-->
    <?php
    $plan = $_GET['idPlan'];
    include_once("conecta.php");
    $conn = Conectarse();
    
    $sql = "SELECT p.RowID_Plan, p.PlanCd, p.logo, p.nombrePlan, p.gradoAcademico, p.tipoPlan,p.otras_universidades, p.tipo_carrera, p.ComentariosGenerales, p.oferta ,p.ComentarioOferta, p.aprobacion, p.redisenno,p.declaracion_planTerminal,unidad_Academica unidad,sede.nombre fcs, sede.id cod FROM plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs sede on u.fcs_codigo=sede.id where RowID_Plan ='$plan' AND HistoricoInd='N'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);
    //Codigo de la definicion del plan
    $cdPlan =$row["RowID_Plan"];
	$toggle = $row['PlanCd'];
	$source= $row['logo'];
	
	// $sql5 = "SELECT p.nombrePlan, u.id_unidad as uni, f.nombre as fcs, f.codigo as cod from plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs f on u.fcs_codigo=f.id where p.PlanCd=".$toggle;
	// $res5 = mysqli_query($conn,$sql5);
	// $row5 = mysqli_fetch_array($res5);
	$cod5=$row['cod'];
	
	//echo 'Nombre del plan '. $row["nombrePlan"];
    $sql2 = "SELECT *  FROM enfasis where  planAct='Y' and plan_cd like '$cdPlan' ";
	$resultEnf = mysqli_query($conn,$sql2);

    $sqlAreaD = "SELECT *  FROM areas_disciplinarias where planAct='Y' and planId like '$toggle' ";
	$resultAreaD = mysqli_query($conn,$sqlAreaD);
	
    $sql4 = "SELECT *  FROM etiqueta where  planAct='S' and plan_cd = '$cdPlan' ";
    $resultEtiq = mysqli_query($conn,$sql4);

	$sql5 = "SELECT *  FROM titulaciones where  planAct='S' and plan_cd = '$cdPlan' ";
    $resultTitu = mysqli_query($conn,$sql5);
	
	$sqlAc = "SELECT *  FROM acreditaciones where planAct='Y' and planCd = '$cdPlan' ";
    $resultAc = mysqli_query($conn,$sqlAc);

    $nombre=$row['nombrePlan'];

    $sql3 ="SELECT * FROM salidas where planAct='Y' and plan_cd ='$cdPlan'";
    $resultSalid = mysqli_query($conn,$sql3);

    $sqlcampus ="SELECT c.Campus, p.EstadoPlan from campus as c inner join plan_campus as p on c.Id=p.campus_cd where planAct='Y' and p.plan_cd='$cdPlan'";
    $result4 = mysqli_query($conn,$sqlcampus);
    $campus = mysqli_fetch_array($result4);


    // $source= "uploads/planesdeEstudio/".$estructC['LogoPlan'];

    // $sqlUni ='SELECT unidad_Academica from plan where PlanCd='.$row['PlanCd'];
    // $resUni = mysqli_query($conn,$sqlUni);
    // $uniFCS = mysqli_fetch_array($resUni);
	$un1 = $row['unidad'];

	$fsql = 'SELECT fcs_codigo from unidadacademica where nombre="'.$un1.'"';
    $fsql1 = mysqli_query($conn,$fsql);
    $fsql2 = mysqli_fetch_array($fsql1);

    $unsql = 'SELECT * from fcs where id="'.$fsql2['fcs_codigo'].'"';
    $unsql1 = mysqli_query($conn,$unsql);
    $unsql2 = mysqli_fetch_array($unsql1);

    //Extraigo los datos de cada campus del plan a modificar
    $sqlcamp = 'SELECT * FROM plan_campus where planAct="Y" and plan_cd="'.$plan.'"';
    $resultcamp = mysqli_query($conn,$sqlcamp);
    if($resultcamp->num_rows >= 0){
    $resultcamp->data_seek(0);
    $campusCD = array(); //array de campus
    $EstadosPlanes = array(); //array de estados de plan
    $aux =" ";
    while($fila=$resultcamp->fetch_assoc()){
        if($fila['EstadoPlan']=="Virtual"){
        $aux="Vi";
        }
        if($fila['EstadoPlan']=="Presencial"){
        $aux="Pre";
        }
        if($fila['EstadoPlan']=="Bimodal"){
        $aux="Bim";
        }
        switch ($fila['campus_cd']) {
        case 1: array_push($campusCD,"omar"); $aux=$aux."1";
                break;
        case 2: array_push($campusCD,"Liberia"); $aux=$aux."2";
                break;
        case 3: array_push($campusCD,"Nicoya"); $aux=$aux."3";
                break;
        case 4: array_push($campusCD,"Pérez"); $aux=$aux."4";
                break;
        case 5: array_push($campusCD,"Coto"); $aux=$aux."5";
                break;
        case 6: array_push($campusCD,"Benjamin"); $aux=$aux."6";
                break;
        case 7: array_push($campusCD,"Sarapiqui"); $aux=$aux."7";
                break;
        case 8: array_push($campusCD,"Interuniversitaria"); $aux=$aux."8";
                break;
        } 
        array_push($EstadosPlanes,$aux);
    }}

    ?>
    <!--Queries--> 
  <body>
  <div class="container">
 <br>
 <?php echo display_msg($msg); ?>
<h1>Ingresar Plan nuevo de <?php echo $nombre;?></h1>
<hr>
<button class="btn btn-success" id="btnabrir">Abrir todos</button><button class="btn btn-primary" id="btncerrar">Cerrar todos</button>
<br>
<form  id="msform" method="post" enctype="multipart/form-data" action="guardar_historico.php" name="datos">
<input type="hidden" name="planID" value="<?php echo $plan;?>">
 <div id="accordion"><br>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <a class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          1. Datos del plan de estudio
        </a>
      </h5>
    </div>

  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-body">
							<h6>Grado Academico<b style="color:red;">*</b></h6>
							<select class="form-control" name="gradoAcademico" id="gradoA" onchange="myFunction();"  required="">
                            <?php if(strcmp($row["gradoAcademico"],"Bachillerato en")==0){?>
                            <option selected="selected" >Bachillerato en</option>
                            <?php }else {  ?>
                            <option>Bachillerato en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Licenciatura en")==0){?>
                              <option selected="selected">Licenciatura en</option>
                              <?php }else {  ?>
							<option>Licenciatura en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Maestria en")==0){?>
                              <option selected="selected">Maestria en</option>
                            <?php }else {  ?>
							<option>Maestria en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Profesorado en")==0){?>
                              <option selected="selected">Profesorado en</option>
                            <?php }else {  ?>
							<option>Profesorado en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Diplomado en")==0){?>
                              <option selected="selected">Diplomado en</option>
                            <?php }else {  ?>
							<option>Diplomado en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Especialidad en")==0){?>
                              <option selected="selected">Especialidad en</option>
                            <?php }else {  ?>
							<option>Especialidad en</option>
                            <?php } if(strcmp($row["gradoAcademico"],"Doctorado en")==0){?> 
                              <option selected="selected">Doctorado en</option>
                            <?php }else {  ?>
							<option>Doctorado en</option>
                            <?php }  ?>
							</select><br>
						  
							<h6>Nivel<b style="color:red;">*</b></h6>
							<select class="form-control" name="grado" id="grado" required="">
							<?php if(strcmp($row["tipoPlan"],"Grado")==0){ ?>
							  <option selected="">Grado</option>
							<?php } else { ?>
							<option>Grado</option>
							<?php } if(strcmp($row["tipoPlan"],"PosGrado")==0){ ?>
							<option selected="">PosGrado</option>
							<?php } else { ?>
							<option>PosGrado</option>
							<?php } ?>
							</select><br>
							
							<h6>Nombre<b style="color:red;">*</b></h6>
							<div class=" form-group input-group input-group-lg">
							<span class="input-group-addon"></span>
							<input type="text" class="form-control" placeholder="Ingrese el nombre del plan" value='<?php echo $row['nombrePlan'];?>' name="nombrePlan" required="">
							</div>
							
							<h6>Declaracion de Plan Terminal</h6>
							<div class="form-check">
                            <?php if($row['declaracion_planTerminal']==='S'){ ?>
							<input type="checkbox" class="form-check-input" value="S" name="declaracionTerm" id="declaracionTerm" checked>
                            <?php } else { ?>
							<input type="checkbox" class="form-check-input" value="S" name="declaracionTerm" id="declaracionTerm">
                            <?php } ?>
							<label class="form-check-label" for="exampleCheck1"><small>Seleccione la casilla si es un plan con Declaracion de Plan Terminal</small></label>
							</div><br>
                            <div class="row">
                            <div class="col-6">
                            <h6>Logo actual</h6><br>
                            <img src="<?php echo $source;?>" id="logoact" alt="logo" width="100" height="100">
							</div> 
                            <div class="col-6">
							<h6>Subir logo del plan<small> (Si no desea cambiar el logo, no cargue ningún archivo)</small></h6>
							<div class="form-group">
								<input type="file" name="logo" multiple="multiple" accept="image/png,image/jpg,image/jpeg" class="btn btn-default btn-file"/>
							</div> 
							</div> 
							</div> <!--cierra el form-group-->
							
						</div> <!-- cierra el panel body-->
                    </div> <!-- cierra el panel panel-primary-->
                </div><!-- cierra el col-md 12 -->
			</div> <!-- cierra el row-->
		</div> <!-- cierra el card body -->
  </div> <!-- cierra el acordion1-->
  </div><!--cierra el card 1-->

	<div class="card">
		<div class="card-header" id="headingTwo">
		  <h5 class="mb-0">
			<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			  2. Salidas Laterales
			</a>
		  </h5>
		</div>
	
	<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
		<div class="card-body">
            <?php
                if($resultSalid->num_rows > 0){
                $resultSalid->data_seek(0);
                echo '<h4>Salidas Registradas</h4>';
                echo '<p><small>Deseleccione la casilla activo si desea eliminar una salida</small></p>';
                echo '<table class="table table-hover"><thead><tr><th scope="col">Activo</th><th scope="col">Salida</th><th scope="col">Comentario salida</th></tr>';
                while($fila=$resultSalid->fetch_assoc()){
                    echo '<tr><td>';
                    echo '<input type="checkbox" id="'.$fila['Id'].'" name="salidasAct[]" value="'.$fila['Id'].'" checked></td><td>';
                    echo '<input type="text" class="form-control" name="salid-'.$fila['Id'].'" value="'.$fila['SalidaLateral'].'"></td><td>';
                    echo '<input type="text" class="form-control" name="salCom-'.$fila['Id'].'" value="'.$fila['comentario'].'">';
                    echo '</td><tr>';
                }
                echo'</tbody></table>';
                }
            ?>
			<h6 class="fs-title">Salidas Laterales, Presione añadir para agregar y eliminar para descartar una salida</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                                    <input type="button" id="btAddS" value="Añadir" class="bt">
									<input type="button" id="btRemoveS" value="Eliminar" class="bt"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="salidasLat"></span>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->


		</div>
	</div>
	</div> <!-- cierra acordion2-->
  
  
  
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          3. Modalidades
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
			<h6 class="fs-title">Modalidad según campus<b style="color:red;">*</b></h6>
				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
							<div class="panel panel-primary">
								<div class="form-group">
									<table id="modalidad">
									<tbody><tr>
										<th><h6>Campus</h6></th>
										<th><h6>Virtual / Presencial</h6> </th>
										</tr>
										<tr>
										<td>
										<label><input type="checkbox" id="omar" name="campus[]" value="1"> Omar Dengo</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP1">
											<option id="Bim1"> Bimodal  </option>
											<option id="Vi1"> Virtual</option>
											<option id="Pre1"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Liberia" name="campus[]" value="2"> Campus Liberia</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP2">
											<option id="Bim2"> Bimodal  </option>
											<option id="Vi2"> Virtual</option>
											<option id="Pre2"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Nicoya" name="campus[]" value="3"> Campus Nicoya</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP3">
											<option id="Bim3"> Bimodal  </option>
											<option id="Vi3"> Virtual</option>
											<option id="Pre3"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Pérez" name="campus[]" value="4"> Campus Pérez Zeledón</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP4">
										<option id="Bim4"> Bimodal  </option>
										<option id="Vi4"> Virtual</option>
										<option id="Pre4"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Coto" name="campus[]" value="5"> Campus Coto</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP5">
											<option id="Bim5"> Bimodal  </option>
											<option id="Vi5"> Virtual</option>
											<option id="Pre5"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Benjamin" name="campus[]" value="6"> Campus Benjamín Núñez</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP6">
											<option id="Bim6"> Bimodal  </option>
											<option id="Vi6"> Virtual</option>
											<option id="Pre6"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Sarapiqui" name="campus[]" value="7"> Sección Regional Sarapiquí</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP7">
											<option id="Bim7"> Bimodal  </option>
											<option id="Vi7"> Virtual</option>
											<option id="Pre7"> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Interuniversitaria" name="campus[]" value="8"> Interuniversitaria de Alajuela</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP8">
											<option id="Bim8"> Bimodal  </option>
											<option id="Vi8"> Virtual</option>
											<option id="Pre8"> Presencial</option>
										</select>
										</td>
										</tr>
									</tbody>
									</table>
								</div> <!-- cierra el form-group-->
							</div> <!-- cierra el panel primary-->
						</div> <!-- cierra el col 12-->
					</div><!-- cierra el row-->
				</div><!-- cierra el panel body-->
		</div>
	</div>
</div><!-- se cierra el card-->
<div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
         4. Información de la Universidad
        </a>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
        <div class="card-body">
		<div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="panel panel-primary">
                    <div class="panel-body">
                    <?php $FCSR  = find_all('fcs');
                           $unidades  = find_all('unidadacademica');
                     ?>
                     <div class="form-group">
                       <h6>Facultad Centro Sede Recinto<b style="color:red;">*</b></h6>
                         <select class="form-control" id = "facese" name="facese">
                           <?php foreach ($FCSR as $group ):?>
                            <option <?php if($group['id']==$cod5){ echo "selected";} ?>  value="<?php echo $group['id'];?>"><?php echo $group['codigo']."-".$group['nombre'];?></option>
                         <?php  endforeach;?>
                         </select>
                     </div>
                     <h6>Unidad Académica<b style="color:red;">*</b></h6>
                      <div class="form-group">
                          <select class="form-control" id = "unidadAcademica" name="unidad">

                          </select>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
         5. Códigos
        </a>
      </h5>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
        <div class="card-body">
					<div class=" form-group input-group input-group-lg">
							<div class="col-md-6"><!-- 1-->
								<h6>Código de Registro<b style="color:red;">*</b></h6>
									<input class="form-control" id="c" type="text" name="codigoRegistro" required="">
							</div> <!-- cierra el col-md-6 1-->
							<div class="col-md-6"> <!--2-->
								<h6>Código Banner<b style="color:red;">*</b></h6>
									<input class="form-control" id="d" type="text" name="codigoBanner" required="" >
							</div> <!-- cierra el col-md-6 2-->
					</div><!-- cierra el form-group input-group-->
					<div class=" form-group input-group input-group-lg">
						<div class="col-md-6">
							<h6>Código Banner #2</h6>
							<input class="form-control" id="d" type="text" name="codigoBanner2">
						</div>
					</div><!-- cierra el form-group input-group-->
				</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->


<div class="card">
    <div class="card-header" id="headingSix">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
         6. Énfasis
        </a>
      </h5>
    </div>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
        <div class="card-body">
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="panel panel-primary">
                            <div class="panel-body">
                            <div class="form-group">
							<?php
                                  if($resultEnf->num_rows > 0){
                                    $resultEnf->data_seek(0);
                                    echo '<h6>Énfasis Registrados</h6>';
                                    echo '<p style="color: #428bca;">**Deseleccione la casilla activo si desea eliminar un énfasis</p>';
                                    echo '<table class="table table-hover"><thead><tr><th scope="col">Activo</th><th scope="col">Énfasis</th></tr>';
                                    while($fila=$resultEnf->fetch_assoc()){
                                      echo '<tr><td>';
                                      echo '<input type="checkbox" id="'.$fila['codigoE'].'" name="enfasisAct[]" value="'.$fila['codigoE'].'" checked></td><td>';
                                      echo '<input type="text" class="form-control" name="enf-'.$fila['codigoE'].'" value="'.$fila['descripcion'].'">';
                                      echo '</td><tr>';
                                    }
                                    echo'</tbody></table>';
                                  }
                                ?>
								<h6 class="fs-title">Énfasis del Plan, Presione añadir para agregar y eliminar para descartar un Énfasis</h6>
							<input type="button" id="btAddF" value="Añadir" class="bt">
                            <input type="button" id="btRemoveF" value="Eliminar" class="bt">
                                <div class=" form-group input-group input-group-lg">
                                  <span class="input-group-addon" id="Enfasis"></span>
                                  
                                </div> <!-- cierra el form-group input-group-->
                            </div><!-- cierra el form-group-->
                            </div> <!-- cierra el panel body-->
                          </div><!-- cierra el panel panel-primary-->
                        </div><!-- cierra el col-md-12-->
                      </div><!-- cierra el row-->
                    </div><!-- cierra el panel-body-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingSeven">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
         7. Estados
        </a>
      </h5>
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
        <div class="card-body">
			<div class="panel-body">
			    <div class="row">
					<div class="col-md-12">
                        <div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
									<h6>Programas Conjuntos con otras Universidades</h6>
										<div class=" form-group input-group input-group-lg">
											<span class="input-group-addon"></span>
											<input type="text" class="form-control" placeholder="Programas" name="otrasU" value="<?php echo $row['otras_universidades'];?>">
										</div><!-- cierra el form-group input-group-->
										<!-- End panel-body-->
										<div class="row">
											<div class="col-md-6"><!-- 1-->
												<h6>Tipo de Carrera<b style="color:red;">*</b></h6>
												<div class="radio"><!-- 1-->
												<?php
												if($row["tipo_carrera"]=="UNA"){
													echo '<div class="radio"><label><input type="radio" value= "UNA" checked name="tipo_carrera"><span style="font-size:18px">&nbsp;&nbsp;UNA</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "CONARE" name="tipo_carrera"><span style="font-size:18px">&nbsp;&nbsp;CONARE</span></label></div>';

												} else{
													echo '<div class="radio"><label><input type="radio" value= "UNA"  name="tipo_carrera"><span style="font-size:18px">&nbsp;&nbsp;UNA</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "CONARE" checked name="tipo_carrera"><span style="font-size:18px">&nbsp;&nbsp;CONARE</span></label></div>';
												}?>
												</div> <!-- cierra el radio 1-->

												
											</div> <!-- cierra el col-md-6 1-->

											<div class="col-md-6"><!-- 2-->
												<h6>Estado de Oferta<b style="color:red;">*</b></h6>
												<?php $oferta_row = $row['oferta'] ;?>
												<?php if($oferta_row =="Se oferta"){
													echo '<div class="radio"><label><input type="radio" checked value= "Se oferta" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Se oferta</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "Vigente" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Vigente</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "Inactiva" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Inactiva</span></label></div>
													<div class="radio"><label><input type="radio" value= "Cerrada" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Cerrada</span></label></div>';
													} if ($oferta_row =="Vigente"){
													echo '<div class="radio"><label><input type="radio" value= "Se oferta" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Se oferta</span></label></div>';
													echo '<div class="radio"><label><input type="radio" checked value= "Vigente" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Vigente</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "Inactiva" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Inactiva</span></label></div>
													<div class="radio"><label><input type="radio" value= "Cerrada" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Cerrada</span></label></div>';
													}
													if ($oferta_row =="Inactiva"){
													echo '<div class="radio"><label><input type="radio" value= "Se oferta" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Se oferta</span></label></div>';
													echo '<div class="radio"><label><input type="radio"  value= "Vigente" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Vigente</span></label></div>';
													echo '<div class="radio"><label><input type="radio" checked value= "Inactiva" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Inactiva</span></label></div>
													<div class="radio"><label><input type="radio" value= "Cerrada" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Cerrada</span></label></div>';
													}
													if($oferta_row == "Cerrada"){
													echo '<div class="radio"><label><input type="radio" value= "Se oferta" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Se oferta</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "Vigente" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Vigente</span></label></div>';
													echo '<div class="radio"><label><input type="radio" value= "Inactiva" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Inactiva</span></label></div>
													<div class="radio"><label><input type="radio"  checked value= "Cerrada" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Cerrada</span></label></div>';
													
													}
												?>
												
											</div><!-- cierra el col-md-6 2-->
										</div> <!-- row-->
										<h6>Comentarios de estados </h6>
											<textarea id="comment" name="comment"><?php echo $row['ComentarioOferta']; ?></textarea>
								</div><!-- cierra el form-group-->
                            </div><!--cierra el panel body-->
                        </div><!--cierra el panel panel-primary-->
                    </div><!-- cierra el col-md-12-->
                </div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingEight">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
         8. Fechas
        </a>
      </h5>
    </div>
    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion">
        <div class="card-body">
			<div class="form-group">
				<div class="col-8">
					<div class="panel panel-primary">
						<div class="panel-body">
						<?php
							if($resultAc->num_rows > 0){
								$resultAc->data_seek(0);
								echo '<div class="table-responsive">';
								echo '<h6>Acreditaciones Registradas</h6>';
								echo '<h6 style="color: #428bca;">**Puede modificar las acreditaciones existentes en la siguiente tabla.**</h6>';
								echo '<h6 style="color: #428bca;">**Deseleccione en la casilla Activo si no desea incluir una acreditación en este nuevo plan.**</h6>';
								echo '<table class="table"><thead><tr><th>Activo</th><th>Tipo</th><th scope="col">Desde</th><th scope="col">Hasta</th><th scope="col" style="width=100px">Detalle</th></tr></thead><tbody>';
								while($fila=$resultAc->fetch_assoc()){
								echo '<tr><td>';
								echo '<input type="checkbox" id="'.$fila['AcredCod'].'" name="AcredAct[]" value="'.$fila['AcredCod'].'" checked></td><td>';
								echo '<select name="AcreditacionTipo'.$fila['AcredCod'].'">'; 
								if(strcmp($fila['tipo'],"acreditación")==0){
									echo "<option selected>acreditación</option><option>reacreditación</option></select></td><td>";
								}else{
									echo '<option>acreditación</option><option selected>reacreditación</option></select></td><td>';
								}
								 
								echo '<input type="date"  name="fec-'.$fila['AcredCod'].'" value="'.$fila['Fecha'].'"></td><td>';
								echo '<input type="date"  name="fecHasta-'.$fila['AcredCod'].'" value="'.$fila['FechaFin'].'"></td><td>';
								echo '<input type="text" size="500" class="form-control" name="det-'.$fila['AcredCod'].'" value="'.$fila['Detalle'].'">';
								echo '</td><tr>';
								}
								echo'</tbody></table><div id="line"></div>';
								echo '</div><br>';
								
							}
							?>
							<!-- <div id="line"></div> -->
							<div class="row"> <!--1-->

								<div class="col-4"><!-- 1-->
									<h6>Año de Aprobación<b style="color:red;">*</b></h6>
									<input type="date" name="aprobacion" required="" value="<?php echo $row['aprobacion'];?>">
								</div><!-- cierra el col-md-6 1-->
								<div class="col-4"><!-- 2-->
									<h6>Rediseño</h6>
									<input type="date" name="redisenno" value="<?php echo $row['redisenno'];?>">
								</div><!-- cierra el col-md-6 2 -->
							</div><!-- cierra el form group input 1--><br><br>
							<h6>Presione añadir para agregar y eliminar para descartar un fecha de acreditación o reacreditación</h6>
							<input type="button" id="btAdd" value="Añadir" class="bt">
							<input type="button" id="btRemove" value="Eliminar" class="bt"><br><br>
							<div class=" form-group input-group input-group-lg"><!-- 2-->
                                <span id="acreditacion" name="acreditacion">
									
								</span>
							</div><!-- cierra el panel panel-secondary-->
						</div><!-- cierra el panel-body 1-->
					</div><!--cierra el panel panel-primary-->
				</div><!--cierra el col-8-->
			</div><!--cierra el form-group-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingNine">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
         9. Anotaciones
        </a>
      </h5>
    </div>
    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion">
        <div class="card-body">
					<div class="col-md-12">
						<h6 class="fs-title">Puede escribir anotaciones generales del plan de estudios</h6>
						<br>
						<h6>Anotaciones Generales</h6>
						<textarea cols="100" id="Generales" name="comgen"><?php echo $row['ComentariosGenerales'];?></textarea>
					</div> <!-- cierra el col-md-12-->
				</div> <!-- cierra el card-body-->
		</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingTen">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
         10. Titulaciones
        </a>
      </h5>
    </div>
    <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion">
        <div class="card-body">
			<div class="panel-body">
				<div class="row">
					<?php
						if($resultTitu->num_rows > 0){
						$resultTitu->data_seek(0);
						echo '<h4>Titulaciones Registradas</h4>';
						echo '<p style="color: #428bca;">**Deseleccione la casilla activo si desea eliminar una titulacion</p>';
						echo '<div class="table-responsive"><table class="table table-hover"><thead><tr><th scope="col">Activo</th><th scope="col">Etiqueta</th><th scope="col">Tipo</th></tr>';
						while($fila=$resultTitu->fetch_assoc()){
							echo '<tr><td>';
							echo '<input type="checkbox" id="'.$fila['id'].'" name="titulacionAct[]" value="'.$fila['id'].'" checked></td><td>';
							echo '<input type="text" class="form-control" name="nombreTitulacion-'.$fila['id'].'" value="'.$fila['nombre'].'"></td><td>';
							echo '<select class="form-control" name="tipoTitulacion-'.$fila['id'].'">';
							if(strcmp($fila['tipo'],"No tiene")==0){
							echo'<option selected>No tiene</option><option>Maestría profesional</option><option>Maestría Académica</option></select>';
							}
							if(strcmp($fila['tipo'],"Maestría profesional")==0){
							echo'<option>No tiene</option><option selected>Maestría profesional</option><option>Maestría Académica</option></select>';
							}
							if(strcmp($fila['tipo'],"Maestría Académica")==0){
							echo'<option>No tiene</option><option>Maestría profesional</option><option selected>Maestría Académica</option></select>';
							}

							echo '</td><tr>';
						}
						echo'</tbody></table></div>';
						}
					?>
				</div><!-- cierra el row-->
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<h6>Presione Añadir para agregar una nueva titulación y eliminar para desecharla.</h6>
							<div class="panel-body">
								<div class="form-group">
									<input type="button" id="btAddTit" value="Añadir" class="btTitul">
									<input type="button" id="btRemoveTit" value="Eliminar" class="btTitul">
									<div class=" form-group input-group input-group-lg">
										<span class="input-group-addon" id="areaTitulaciones"></span>
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->


<div class="card">
    <div class="card-header" id="headingEleven">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
         11. Etiquetas
        </a>
      </h5>
    </div>
    <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion">
        <div class="card-body">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
                        <div class="panel panel-primary">
							
                            <div class="panel-body">
								<div class="form-group">
								<?php
                                  if($resultEtiq->num_rows > 0){
                                    $resultEtiq->data_seek(0);
                                    echo '<h4>Etiquetas Registradas</h4>';
                                    echo '<p style="color: #428bca;">**Deseleccione la casilla activo si desea eliminar una etiqueta</p>';
                                    echo '<table class="table table-hover"><thead><tr><th scope="col">Activo</th><th scope="col">Etiqueta</th></tr>';
                                    while($fila=$resultEtiq->fetch_assoc()){
                                      echo '<tr><td>';
                                      echo '<input type="checkbox" id="'.$fila['id'].'" name="tagsAct[]" value="'.$fila['id'].'" checked></td><td>';
                                      echo '<input type="text" class="form-control" name="etiq-'.$fila['id'].'" value="'.$fila['nombre'].'">';
                                      echo '</td><tr>';
                                    }
                                    echo'</tbody></table>';
                                  }
                                ?>
								<h6>Presione Añadir para agregar una nueva etiqueta y eliminar para desecharla.</h6>
									<input type="button" id="btAddTag" value="Añadir" class="bt">
									<input type="button" id="btRemoveTag" value="Eliminar" class="bt">
									<div class=" form-group input-group input-group-lg">
										<span class="input-group-addon" id="etiq"></span>
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
                            </div> <!-- cierra el panel body-->
                        </div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingTwelve">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
         12. Áreas Disciplinarias
        </a>
      </h5>
    </div>
    <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordion">
        <div class="card-body">
		<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
                        <div class="panel panel-primary">
						<?php
                                  if($resultAreaD->num_rows > 0){
                                    $resultAreaD->data_seek(0);
                                    echo '<h6>Áreas Disciplinarias Registradas</h6>';
                                    echo '<p style="color: #428bca;">**Deseleccione la casilla activo si desea eliminar una área</p>';
                                    echo '<table class="table table-hover"><thead><tr><th scope="col">Activo</th><th scope="col">Áreas</th></tr>';
                                    while($fila=$resultAreaD->fetch_assoc()){
                                      echo '<tr><td>';
                                      echo '<input type="checkbox" id="'.$fila['Id'].'" name="areasAct[]" value="'.$fila['Id'].'" checked></td><td>';
                                      echo '<input type="text" class="form-control" name="area-'.$fila['Id'].'" value="'.$fila['nombre'].'">';
                                      echo '</td><tr>';
                                    }
                                    echo'</tbody></table>';
                                  }
                                ?>
							<h6>Presione Añadir para agregar una nueva área disciplinaria y eliminar para desecharla.</h6>
                            <div class="panel-body">
								<div class="form-group">
									<input type="button" id="btAddAreaD" value="Añadir" class="btarea">
									<input type="button" id="btRemoveAreaD" value="Eliminar" class="btarea">
									<div class=" col-7">
										<div class="input-group-addon" id="areaDisc"></div>
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
                            </div> <!-- cierra el panel body-->
                        </div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
		</div> <!-- cierra el card-body-->
		</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
	<div class="card-header" id="headingThirteen">
		<h5 class="mb-0">
		<a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
		13. Estructura Curricular
		</a>
		</h5>
	</div>
	<div id="collapseThirteen" class="collapse" aria-labelledby="headingThirteen" data-parent="#accordion">
		<div class="card-body">
		</div> <!-- cierra el card-body-->
		<h6 style="color: #428bca;">**Si no desea modificar los archivos existentes, no cargue ningún otro archivo**</h6>
			<div class="row">
				<div class="col-5">
					<h6 class="fs-title">Puede agregar archivos en formato .csv, .xls, .xlsx (Excel)<b style="color:red;">*</b></h6>
					<input type="file" id="archcsv" name="archcsv" accept=".xlsx, .xls, .csv" required>
				</div><!--col-5-->
				<div class="col-5">
					<h6 class="fs-title">Puede agregar archivos en formato PDF<b style="color:red;">*</b></h6>
					<input type="file" id="archpdf" name="archpdf" accept=".pdf" required >	
				</div><!--col-5-->
			</div><br>
			<div class="row">
				<div class="col-7">
					<br>
					<h6 class="fs-title"><b>Plan de estudios público</b>, puede agregar archivos en formato PDF<b style="color:red;">*</b></h6>
					<input type="file" id="planpdf" name="planpdf" accept=".pdf" required><br><br>
				</div><!--col-7-->	
			</div>
		</div><!-- cierra el div id-->
</div> <!-- cierra el card-->

<div class="card">
    <div class="card-header" id="headingFourteen">
      <h5 class="mb-0">
        <a class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
         14. Documentos Asociados
        </a>
      </h5>
    </div>
    <div id="collapseFourteen" class="collapse" aria-labelledby="headingFourteen" data-parent="#accordion">
        <div class="card-body">
		<h4 style="color: #428bca;">**Se permiten 7 documentos de cada tipo**</h4>
		<h4 style="color: #428bca;">**Los documentos no deben tener espacios en blanco ni caracteres especiales (tildes o ñ ) en sus nombres**</h4><br>
		<h5>Documento Principal de Plan de Estudios</h5>
		<h6 class="fs-title">Puede agregar archivos en formato .docx</h6>
		<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddDoc" value="Añadir" class="btDoc">
									<input type="button" id="btRemoveDoc" value="Eliminar" class="btDoc"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="docPrincipal"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>OPES</h5>
			<h6 class="fs-title">Puede agregar archivos en formato pdf e imágenes</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddOpes" value="Añadir" class="btOpes">
									<input type="button" id="btRemoveOpes" value="Eliminar" class="btOpes"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espacioopes"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>CNR</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddcnr" value="Añadir" class="btcnr">
									<input type="button" id="btRemovecnr" value="Eliminar" class="btcnr"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciocnr"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Acuerdos de Asamblea de Unidad Académica</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddacu" value="Añadir" class="btacu">
									<input type="button" id="btRemoveacu" value="Eliminar" class="btacu"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espacioacu"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Referendos de Facultad</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddref" value="Añadir" class="btref">
									<input type="button" id="btRemoveref" value="Eliminar" class="btref"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espacioref"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Visto Bueno de Vicerrectoría de Docencia </h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddvis" value="Añadir" class="btvis">
									<input type="button" id="btRemovevis" value="Eliminar" class="btvis"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciovis"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Oficio de Registro</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>	
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddof" value="Añadir" class="btof">
									<input type="button" id="btRemoveof" value="Eliminar" class="btof"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espacioof"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Solicitudes de Asesoría </h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddsoli" value="Añadir" class="btsoli">
									<input type="button" id="btRemovesoli" value="Eliminar" class="btsoli"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciosoli"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Aprobaciones de SEPUNA/CCP</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddsep" value="Añadir" class="btsep">
									<input type="button" id="btRemovesep" value="Eliminar" class="btsep"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciosep"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Documentación de Convenios</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddconv" value="Añadir" class="btconv">
									<input type="button" id="btRemoveconv" value="Eliminar" class="btconv"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espacioconv"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Currículums de Docentes</h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato comprimido .zip/.rar/.7z</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddcurri" value="Añadir" class="btcurri">
									<input type="button" id="btRemovecurri" value="Eliminar" class="btcurri"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciocurri"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Declaración de Plan Terminal </h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAdddec" value="Añadir" class="btdec">
									<input type="button" id="btRemovedec" value="Eliminar" class="btdec"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciodec"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<h5>Publicación del Plan Terminal </h5><br>
			<h6 class="fs-title">Puede agregar archivos en formato pdf</h6>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-body">
								<div class="form-group">
                  					<input type="button" id="btAddpubli" value="Añadir" class="btpubli">
									<input type="button" id="btRemovepubli" value="Eliminar" class="btpubli"><br>
									<div class=" form-group input-group input-group-lg">
										
										<span  id="espaciopubli"></span>
										<br><br>
										<div id="line"></div>
										<br><br>
										
									</div> <!-- cierra el form-group input-group-->
								</div><!-- cierra el form-group-->
							</div> <!-- cierra el panel body-->
						</div><!-- cierra el panel panel-primary-->
					</div><!-- cierra el col-md-12-->
				</div><!-- cierra el row-->
			</div><!-- cierra el panel-body-->
			<!--terminan los docs-->
		</div> <!-- cierra el card-body-->
	</div><!-- cierra el div id-->
</div> <!-- cierra el card-->
</div><!-- cierra el acordion-->

<div class="row">
<div class="col-9"><br>
<button type="submit" name="mandar" class="btn btn-primary">Modificar</button><br>
</div>
</div>
 </form>
 </div><!-- se cierra el container--><br>
 
	<?php 
		include("script/GuardarDocumentos.php");

	?>
    <script type="text/javascript" src="libs/js-files/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/agregarSalida.js"></script>
	<script type="text/javascript" src="script/agregarEnf.js"></script>
	<script type="text/javascript" src="script/agregarElementos.js"></script>
	<script type="text/javascript" src="script/agregarEtiqueta.js"></script>
	<script type="text/javascript" src="script/agregarDoc.js"></script>
	<script type="text/javascript" src="script/agregarAreaDisciplinaria.js"></script>
	<script type="text/javascript" src="script/agregarTitulacion.js"></script>
	<script type="text/javascript" src="script/modificarPlan.js"></script>



	<script>
$("#btnabrir").click(function(){
	$('#collapseOne').addClass('collapse show');
    $('#collapseTwo').addClass('collapse show');
    $('#collapseThree').addClass('collapse show');
    $('#collapseFour').addClass('collapse show');
    $('#collapseFive').addClass('collapse show');
    $('#collapseSix').addClass('collapse show');
	$('#collapseSeven').addClass('collapse show');
	$('#collapseEight').addClass('collapse show');
	$('#collapseNine').addClass('collapse show');
	$('#collapseTen').addClass('collapse show');
	$('#collapseEleven').addClass('collapse show');
	$('#collapseTwelve').addClass('collapse show');
	$('#collapseThirteen').addClass('collapse show');
	$('#collapseFourteen').addClass('collapse show');
});

	$("#btncerrar").click(function() {
	$('#collapseOne').removeClass('collapse show');
    $('#collapseTwo').removeClass('collapse show');
    $('#collapseThree').removeClass('collapse show');
    $('#collapseFour').removeClass('collapse show');
    $('#collapseFive').removeClass('collapse show');
    $('#collapseSix').removeClass('collapse show');
    $('#collapseSeven').removeClass('collapse show');
    $('#collapseEight').removeClass('collapse show');
    $('#collapseNine').removeClass('collapse show');
    $('#collapseTen').removeClass('collapse show');
    $('#collapseEleven').removeClass('collapse show');
    $('#collapseTwelve').removeClass('collapse show');
    $('#collapseThirteen').removeClass('collapse show');
    $('#collapseFourteen').removeClass('collapse show');


    $('#collapseOne').addClass('collapse');
    $('#collapseTwo').addClass('collapse');
    $('#collapseThree').addClass('collapse');
    $('#collapseFour').addClass('collapse');
    $('#collapseFive').addClass('collapse');
    $('#collapseSix').addClass('collapse');
	$('#collapseSeven').addClass('collapse');
	$('#collapseEight').addClass('collapse');
	$('#collapseNine').addClass('collapse');
	$('#collapseTen').addClass('collapse');
	$('#collapseEleven').addClass('collapse');
	$('#collapseTwelve').addClass('collapse');
	$('#collapseFourteen').addClass('collapse');
	$('#collapseThirteen').addClass('collapse');
});

	$(document).ready(function(){
		ponerCampus(<?php echo json_encode($campusCD) ?>);
 
		//Este metodo permite visualizar la modalidad de cada campus que se metieron originalmente al plan
  		ponerModalidad(<?php echo json_encode($EstadosPlanes) ?>);
  		fcs(<?php echo json_encode($unsql2['id']);?>,<?php echo json_encode($un1);?>);

		$("#facese").change(function () {
           $("#facese option:selected").each(function () {
            elegido=$(this).val();
            $.post("script/select.php", { elegido: elegido }, function(data){
            $("#unidadAcademica").html(data);
            });
        });
   });
	 
});
	</script>
	<?php include_once('layouts/footer.php');?>
  </body>
</html>