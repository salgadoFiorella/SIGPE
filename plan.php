<!doctype html>
<html lang="en">
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
        .bg-blue{
            background-color: #034991;
        }
        .circle {
            width: 30%;
            margin-left: auto;
            margin-right: auto;
            display: block;
            border-radius: 50%;
        }
        </style>
        <title>Detalle de Plan de Estudio</title>
    </head>
        <?php
        require_once('includes/load.php');
        if ($session->isUserLoggedIn(true)) { 
            include_once('layouts/theader.php'); 
            $user = current_user();
            $permisos = find_permissions($user['username']);
        } else{
            include_once('layouts/pheader.php'); 
        }
        $user = current_user();
        $plan = $_GET['cod'];
        include("conecta.php");
        $conn = Conectarse();

        $sql= "SELECT * from plan where RowID_Plan='".$plan."' and HistoricoInd='N'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $cdPlan = $row['PlanCd'];

        $sqlTitulac = "SELECT t.nombre, t.tipo FROM titulaciones t inner join plan p on t.planId=p.PlanCd where p.PlanCd=".$cdPlan;
        $resTitulac = mysqli_query($conn,$sqlTitulac);
        $num_filasTitulaciones =$resTitulac->num_rows;
        $titulaciones = "";
        while($row1 = mysqli_fetch_array($resTitulac)){
            if(strcmp('No tiene',$row1['tipo'])==0){
                $titulaciones=$titulaciones.$row1['nombre']."<br>";
            }else{
                $titulaciones=$titulaciones.$row1['tipo'].", ".$row1['nombre']."<br>";
            }
        }

        $unidadAcademica = $row['unidad_Academica'];
        $sql1= "select f.nombre fcs, u.telefono1, u.telefono2, u.pag_web, u.email, u.imagen, u.subunidad from unidadacademica as u inner join fcs as f on u.fcs_codigo=f.id where u.nombre='".$unidadAcademica."'";
        $result1 = mysqli_query($conn,$sql1);
        $row2 = mysqli_fetch_array($result1);

        $sql3 = "SELECT c.Campus, pc.EstadoPlan from plan_campus pc inner join campus c on pc.campus_cd=c.Id where pc.planAct='Y' AND pc.planId=".$cdPlan;
        $modalidades = " ";
        $table = " ";
        $result3 = mysqli_query($conn,$sql3);
        $num_filas =$result3->num_rows;
        $table = "<table width='50%' border='2' align='center' cellspacing='0'>
        <tr class='table-primary text-center'>
        <th>Campus</th><th>Modalidad</th>
        </tr>";
        $tableEnd = "</table><br><br>";
        while($row3 = mysqli_fetch_array($result3)){
            $table =  $table."<tr><td>".$row3["Campus"]."</td><td>".$row3["EstadoPlan"]."</td></tr>";
        }
        $table = $table.$tableEnd;

        $sqlEnfasis = "SELECT e.nombre FROM enfasis e inner join plan p on e.planId=p.PlanCd where p.PlanCd=".$cdPlan;
        $resEnfasis = mysqli_query($conn,$sqlEnfasis);
        $num_filasEnfasis =$resEnfasis->num_rows;
        $enfasis = "";
        while($row4 = mysqli_fetch_array($resEnfasis)){
            $enfasis=$enfasis.$row4['nombre'].",<br>";
        }
        $enfasis = substr($enfasis,0,-5);

        $sqlSalidas = "SELECT s.SalidaLateral FROM salidas s inner join plan p on s.planId=p.PlanCd where p.PlanCd=".$cdPlan;
        $resSalidas = mysqli_query($conn,$sqlSalidas);
        $num_filasSalidas =$resSalidas->num_rows;
        $salidas="";
        while($row5= mysqli_fetch_array($resSalidas)){
            $salidas=$salidas.$row5['SalidaLateral'].",<br>";
        }
        $salidas = substr($salidas,0,-5);
        ?>
    <body>
        <div class="container"><br>
            <div class="row">
                <div class="col-md-8">
                <div class="card">
                <div class="card-body">
                <img src="<?php echo $row['logo'];?>" class="circle" alt="...">
                <h5 class="card-title text-center"><b><?php echo $row['gradoAcademico']." ".$row['nombrePlan'];?></b></h5><br>
                <p class="card-text">
                <!-- <strong>Código de Registro: </strong><?php //echo $row["codigoRegistro"];?><br> -->
                <strong>Código BANNER: </strong><?php echo $row["codigoBanner"];?><br>
                <?php if (!empty($row["codigoBanner2"])){ ?>
                    <strong>Código BANNER #2: </strong><?php echo $row["codigoBanner2"];?><br>
                <?php } ?>
                <strong>Año de Aprobación: </strong><?php echo $row["aprobacion"];?><br>
                <strong>Carrera UNA o CONARE: </strong><?php echo $row["tipo_carrera"];?><br>
                <strong>Estado de la oferta: </strong><?php echo $row["oferta"];?><br>

                <?php if (!empty($row["otras_universidades"])){ ?>
                    <strong>Programas Conjuntos con Otros: </strong><?php echo $row["otras_universidades"];?><br>
                <?php } ?>                
                <?php if ($num_filasTitulaciones > 0){ ?>
                    <strong>Titulaciones: </strong><?php echo $titulaciones;?>
                <?php } ?>
                <?php if ($num_filasEnfasis > 0){ ?>
                    <strong>Énfasis: </strong><?php echo $enfasis.".";?>
                    <br>
                <?php } ?>
                <?php if ($num_filasSalidas > 0){ ?>
                    <strong>Salidas: </strong><?php echo $salidas.".";?>
                <?php } ?>
                </p>
                <?php if($num_filas > 0){ ?>
                    <!-- <br> -->
                    <p class="card-text"><strong>Modalidades:</strong></p>
                    <?php echo $table;?>
                <?php } ?>
                <center>
                    <?php
                    echo '<a target="_blank" class="btn btn-primary" role="button" href=script/descargarEstructura.php?file='.$row["PlanCd"].'>Plan de Estudios</a>';
                    ?><br><br>
                    <?php if (isset($user) && in_array('modificar_plan',$permisos)){ 
                    echo "<a href='actualizar_plan.php?idPlan=".$plan."' class='btn btn-primary' role='button'>Modificar Plan Actual</a>&nbsp;";
                     } ?>
                    <?php if (isset($user) && in_array('crear_historico',$permisos)){
                    echo "<a href='historico.php?idPlan=".$plan."' class='btn btn-primary' role='button'>Crear nuevo plan</a>";
                     } ?>
                </center>
                </div>
                </div>
                </div>

                <div class="col-md-4"><br>
                    <div class="card" >
                    <div class="card-header text-white text-center bg-primary mb-3">
                        Unidad Acádemica
                    </div>
                    <img src="<?php echo $row2['imagen'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <?php if(!empty($row2['subunidad'])){?>
                        <h5 class="card-title"><?php echo $row2['subunidad']; ?></h5>
                        <?php }?>
                        <h5 class="card-title"><?php echo $unidadAcademica; ?></h5>
                        <p class="card-text">
                        <?php echo $row2['fcs']; ?><br>
                        Teléfonos: <?php echo $row2['telefono1']; ?><?php if($row2['telefono2'] != null) {echo " / ".$row2['telefono2']; }?><br>
                        <?php echo $row2['pag_web'];?><br>
                        <a href="<?php echo "mailto:".$row2['email'];?>"><?php echo $row2['email'];?></a>
                        </p>
                    </div>
                    </div>
                </div>
            </div><!--cierra el row-->
            <?php if (isset($user)  && in_array('ver_documentos',$permisos)){ ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header text-white text-center bg-primary mb-3">Documentos Asociados</h5>
                        <div class="card-body">
                            <div class="container col-md-12">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse15" style="color: black;">Estructura Curricular</a>
                                        </h4>
                                        </div>
                                        <div id="collapse15" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <a target="_blank" href="script/descargarExcel.php?file=<?php echo $cdPlan;?>">
                                                Estructura Curricular (Excel/Doc)
                                                </a>
                                            </div>
                                            <div class="panel-body">
                                                <a target="_blank" href="script/descargarPdf.php?file=<?php echo $cdPlan;?>">
                                                Estructura Curricular (PDF)
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            include("script/download.php");
                            try{
                                //funcion incluida en la carpeta script en el archivo download.php
                                mostrarDocs($row['PlanCd']);
                            }catch( Exception $e){
                                echo "Ocurrio un error al cargar los archivos";
                            } ?>

                        </div>
                    </div>
                </div>
            </div><!--cierra el row-->
            <?php } ?>
            
        </div><!--cierra el container-->
        <?php include("layouts/footer.php");?>
        <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
        <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
        <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
    </body>
</html>