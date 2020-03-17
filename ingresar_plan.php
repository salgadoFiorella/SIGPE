<!doctype html>
<html lang="en">
<?php
	//include("conecta.php");
  require_once('includes/load.php');
	if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
	page_require_permission('agregar_plan');
?>
<?php $user = current_user();
// $conn=Conectarse();
// $sql = "SELECT * FROM etiqueta order by nombre";
// $tagres = mysqli_query($conn,$sql);


?>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="public/images/unatransparente.png">
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
 
  <body>
  <div class="container">
 <br>
 <?php echo display_msg($msg); ?>
<h1>Ingresar Plan</h1>
<hr>
<button class="btn btn-success" id="btnabrir">Abrir todos</button><button class="btn btn-primary" id="btncerrar">Cerrar todos</button>
<br>
<form method="POST" enctype="multipart/form-data" action="guardar_plan.php">
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
							<select class="form-control" name="gradoAcademico" id="gradoA"   required="">
							<option>Bachillerato en</option>
							<option>Licenciatura en</option>
							<option>Maestria en</option>
							<option>Profesorado en</option>
							<option>Diplomado en</option>
							<option>Especialidad en</option>
							<option>Doctorado en</option>
							</select><br>
						  
							<h6>Nivel<b style="color:red;">*</b></h6>
							<select class="form-control" name="grado" id="grado"  required="">
							  <option>Grado</option>
							  <option>PosGrado</option>
							</select><br>
							
							<h6>Nombre<b style="color:red;">*</b></h6>
							<div class=" form-group input-group input-group-lg">
							<span class="input-group-addon"></span>
							<input id = "nombrePlan" type="text" class="form-control" placeholder="Ingrese el nombre del plan" name="nombrePlan">
							
							</div>
							
							<h6>Declaracion de Plan Terminal</h6>
							<div class="form-check">
							<input type="checkbox" class="form-check-input" value="S" name="declaracionTerm" id="declaracionTerm">
							<label class="form-check-label" for="exampleCheck1"><small>Seleccione la casilla si es un plan con Declaracion de Plan Terminal</small></label>
							</div><br>
							
							<h6>Subir logo del plan</h6>
							<div class="form-group">
								<input type="file" name="logo" multiple="multiple" accept="image/x-png,image/jpeg,image/jpg" class="btn btn-default btn-file"/>
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
										<label><input type="checkbox" id="omar" name="campus[]" value="1" checked=""> Omar Dengo</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP1">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Liberia" name="campus[]" value="2"> Campus Liberia</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP2">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Nicoya" name="campus[]" value="3"> Campus Nicoya</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP3">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Pérez" name="campus[]" value="4"> Campus Pérez Zeledón</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP4">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Coto" name="campus[]" value="5"> Campus Coto</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP5">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Benjamin" name="campus[]" value="6"> Campus Benjamín Núñez</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP6">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Sarapiqui" name="campus[]" value="7">Sección Regional Sarapiquí</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP7">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
										</select>
										</td>
										</tr>

										<tr>
										<td>
										<label><input type="checkbox" id="Interuniversitaria" name="campus[]" value="8"> Interuniversitaria de Alajuela</label><br>
										</td>
										<td>
										<select class="form-control" name="virtualP8">
											<option> Bimodal  </option>
											<option> Virtual</option>
											<option> Presencial</option>
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
                            <option  value="<?php echo $group['id'];?>"><?php echo $group['codigo']."-".$group['nombre'];?></option>
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
								<h6>Código de Registro</h6>
									<input class="form-control" id="c" type="text" name="codigoRegistro">
							</div> <!-- cierra el col-md-6 1-->
							<div class="col-md-6"> <!--2-->
								<h6>Código Banner<b style="color:red;">*</b></h6>
									<input class="form-control" id="d" type="text" name="codigoBanner">
							</div> <!-- cierra el col-md-6 2-->
					</div><!-- cierra el form-group input-group-->
					<div class=" form-group input-group input-group-lg">
						<div class="col-md-6"> <!--2-->
							<h6>Código Banner #2</h6>
							<input class="form-control" id="banner2" type="text" name="codigoBanner2">
						</div> <!-- cierra el col-md-6 2-->
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
		<h6 class="fs-title">Énfasis del Plan, Presione añadir para agregar y eliminar para descartar un Énfasis</h6>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="panel panel-primary">
                            <div class="panel-body">
                            <div class="form-group">
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
											<input type="text" class="form-control" placeholder="Programas" name="otrasU">
										</div><!-- cierra el form-group input-group-->
										<!-- End panel-body-->
										<div class="row">
											<div class="col-md-6"><!-- 1-->
												<h6>Tipo de Carrera<b style="color:red;">*</b></h6>
												<div class="radio"><!-- 1-->
												  <label><input type="radio" value="UNA" name="tipo_carrera" checked=""><span style="font-size:18px">&nbsp;&nbsp;UNA</span></label>
												</div> <!-- cierra el radio 1-->

												<div class="radio"> <!-- 2-->
												  <label><input type="radio" value="CONARE" name="tipo_carrera"><span style="font-size:18px">&nbsp;&nbsp;CONARE</span></label>
												</div> <!-- cierra el radio 2-->
											</div> <!-- cierra el col-md-6 1-->

											<div class="col-md-6"><!-- 2-->
												<h6>Estado de Oferta<b style="color:red;">*</b></h6>
												<div class="radio"> <!-- 3-->
													<label><input type="radio" value="Se oferta" name="oferta" checked=""><span style="font-size:18px">&nbsp;&nbsp;Se oferta</span></label>
												</div> <!-- cierra el radio 3-->

												<div class="radio"><!-- 4-->
												  <label><input type="radio" value="Vigente" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Vigente</span></label>
												</div><!-- cierra el radio 4-->

												<div class="radio"><!-- 5-->
												  <label><input type="radio" value="Inactiva" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Inactiva</span></label>
												</div><!-- cierra el radio 5-->

												<div class="radio"><!-- 6-->
												  <label><input type="radio" value="Cerrada" name="oferta"><span style="font-size:18px">&nbsp;&nbsp;Cerrada</span></label>
												</div><!-- cierra el radio 6-->
											</div><!-- cierra el col-md-6 2-->
										</div> <!-- row-->
										<h6>Comentarios de estados </h6>
											<textarea id="comment" name="comment"></textarea>
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
							<div class="row"> <!--1-->

								<div class="col-4"><!-- 1-->
									<h6>Año de Aprobación<b style="color:red;">*</b></h6>
									<input type="date" name="aprobacion" >
								</div><!-- cierra el col-md-6 1-->
								<div class="col-4"><!-- 2-->
									<h6>Rediseño</h6>
									<input type="date" name="redisenno" >
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
						<textarea cols="100" id="Generales" name="comgen"></textarea>
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
							<h6>Presione Añadir para agregar una nueva etiqueta y eliminar para desecharla.</h6>
                            <div class="panel-body">
								<div class="form-group">
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
		<div class="row">
				<div class="col-5">
					<h6 class="fs-title">Puede agregar archivos en formato .csv, .xls, .xlsx, .doc, .docx (Excel o Word)<b style="color:red;">*</b></h6>
					<input type="file" id="archcsv" name="archcsv" accept=".xlsx, .xls, .csv,.doc,.docx" >
				</div><!--col-5-->
				<div class="col-5">
					<h6 class="fs-title">Puede agregar archivos en formato PDF<b style="color:red;">*</b></h6>
					<input type="file" id="archpdf" name="archpdf" accept=".pdf" >	
				</div><!--col-5-->
			</div><br>
			<div class="row">
				<div class="col-7">
					<br>
					<h6 class="fs-title"><b>Plan de estudios público</b>, puede agregar archivos en formato PDF<b style="color:red;">*</b></h6>
					<input type="file" id="planpdf" name="planpdf" accept=".pdf" >
				</div><!--col-7-->	
			</div>
		</div> <!-- cierra el card-body-->
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
<button type="submit" name="mandar" onclick = "alertar" class="btn btn-primary">Ingresar</button>
</div>
</div>
 </form>
 <!--</div> se cierra el acordion-->
 </div><!-- se cierra el container--><br>
 
	<?php 
		//include("script/GuardarDocumentos.php");

	?>
	<script type="text/javascript" src="libs/js-files/jquery-3.4.1.js"></script>
    <!-- <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script> -->
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
	<script type="text/javascript" src="script/agregarSalida.js"></script>
	<script type="text/javascript" src="script/agregarEnf.js"></script>
	<script type="text/javascript" src="script/agregarElementos.js"></script>
	<script type="text/javascript" src="script/agregarEtiqueta.js"></script>
	<script type="text/javascript" src="script/agregarDoc.js"></script>
	<script type="text/javascript" src="script/agregarAreaDisciplinaria.js"></script>
	<script type="text/javascript" src="script/agregarTitulacion.js"></script>


	<script>
	
	function alertar(){
		let nombrePlan = document.getElementById("nombrePlan");
		console.log()
	}
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
		$('#collapseThirteen').addClass('collapse');
		$('#collapseFourteen').addClass('collapse');
});

	$(document).ready(function(){

		// $('#mandar').on( "click", function() {
		// 	alert("hola");
		// 	tabToJson();
		// 	$( "#msform" ).submit();
		// });

  $("#facese option:selected").each(function () {
   elegido=$(this).val();
   $.ajax({
			method: "POST",
			url: "script/select.php",
			data: { elegido: elegido}
			})
			.done(function( data ) {
				$("#unidadAcademica").html(data);
			});
});
   $("#facese").change(function () {
           $("#facese option:selected").each(function () {
			elegido=$(this).val();
			$.ajax({
			method: "POST",
			url: "script/select.php",
			data: { elegido: elegido}
			})
			.done(function( data ) {
				$("#unidadAcademica").html(data);
			});
            // $.post("script/select.php", { elegido: elegido }, function(data){
            // $("#unidadAcademica").html(data);
            // });
	 });
	 
});
	 
});
	</script>
	<?php include_once('layouts/footer.php');?>
  </body>
</html>