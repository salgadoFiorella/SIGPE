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
        } else{
            include_once('layouts/pheader.php'); 
        }
        $user = current_user();
        $plan = $_GET['plan'];
        include("conecta.php");
        $conn = Conectarse();

        $sql= "SELECT * from plan where PlanCd='".$plan."' and HistoricoInd='Y'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $cdPlan = $plan;


        $unidadAcademica = $row['unidad_Academica'];
        $sql1= "select f.nombre fcs, u.telefono1, u.telefono2, u.pag_web, u.email, u.imagen from unidadacademica as u inner join fcs as f on u.fcs_codigo=f.id where u.nombre='".$unidadAcademica."'";
        $result1 = mysqli_query($conn,$sql1);
        $row1 = mysqli_fetch_array($result1);

        $sql3 = "SELECT c.Campus, pc.EstadoPlan from plan_campus pc inner join campus c on pc.campus_cd=c.Id where pc.planAct='N' AND pc.planId=".$cdPlan;
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
        ?>
    <body>
        <div class="container"><br>
            <div class="row">
                <div class="col-md-8">
                <div class="card">
                <div class="card-body">
                <img src="uploads/planesdeEstudio/eco.png" class="circle" alt="...">
                <h5 class="card-title text-center"><?php echo $row['gradoAcademico']." ".$row['nombrePlan'];?></h5>
                <p class="card-text">
                <strong>Código de Registro: </strong><?php echo $row["codigoRegistro"];?><br>
                <strong>Código BANNER: </strong><?php echo $row["codigoBanner"];?><br>
                <strong>Año de Aprobación: </strong><?php echo $row["aprobacion"];?><br>
                <strong>Carrera UNA o CONARE: </strong><?php echo $row["tipo_carrera"];?><br>
                <strong>Estado de la Oferta: </strong><?php echo $row["oferta"];?><br>
                <?php if (!empty($row['Titulaciones'])){ ?>
                    <strong>Titulaciones: </strong><?php echo $row["Titulaciones"];?><br>
                <?php } ?>
                <?php if (!empty($row["otras_universidades"])){ ?>
                    <strong>Programas Conjuntos con Otros: </strong><?php echo $row["otras_universidades"];?><br>
                <?php } ?>
                </p>
                <?php if($num_filas > 0){ ?>
                    <p class="card-text"><strong>Modalidades:</strong></p>
                    <?php echo $table;?>
                <?php } ?>
                <center>
                    <?php
                    echo '<a target="_blank" class="btn btn-primary" role="button" href=script/descargarEstructuraHist.php?file='.$row["PlanCd"].'>Prevista Estructura</a>';
                    ?>
                </center>
                </div>
                </div>
                </div>

                <div class="col-md-4"><br>
                    <div class="card" >
                    <div class="card-header text-white text-center bg-primary mb-3">
                        Unidad Acádemica
                    </div>
                    <img src="<?php echo $row1['imagen'];?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $unidadAcademica; ?></h5>
                        <p class="card-text">
                        <?php echo $row1['fcs']; ?><br>
                        Teléfonos: <?php echo $row1['telefono1']; ?> / <?php echo $row1['telefono2']; ?><br>
                        <?php echo $row1['pag_web'];?><br>
                        <a href="<?php echo "mailto:".$row1['email'];?>"><?php echo $row1['email'];?></a>
                        </p>
                    </div>
                    </div>
                </div>
            </div><!--cierra el row-->
            <?php if (isset($user)){ ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <h5 class="card-header text-white text-center bg-primary mb-3">Documentos Asociados</h5>
                        <div class="card-body">
                            <?php
                            include("script/download.php");
                            try{
                                //metodo incluido en la carpeta script en el archivo download.php
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
