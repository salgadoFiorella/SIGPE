<!doctype html>
<html lang="en">
<?php
	//include("conecta.php");
  require_once('includes/load.php');
  include("conecta.php");
  $conn = Conectarse();

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
        .bg-blue{
            background-color: #034991;
        }
        </style>
        <title>Buscar Plan</title>
    </head>
    <?php 
    if ($session->isUserLoggedIn(true)) { 
    include_once('layouts/theader.php'); }else{
        include_once('layouts/pheader.php'); 
    }
    function formato_oferta($of){
        if(strcmp($of,"Ofertados")==0){
            return "Se oferta";
        }else{
            return $of;
        }
    }
    function formato_tipooferta($of){
        $res="";
        switch($of){
            case "Se oferta":
            $res= "ofertados";
            break;
            case "Vigente":
            $res= "vigentes";
            break;
            case "Inactiva":
            $res= "inactivos";
            break;
            case "Cerrada":
            $res= "cerrados";
            break;
        }
        return $res;
    }

    if(isset($_GET['oferta'])){
        $oferta =  formato_tipooferta($_GET['oferta']);
        $tipooferta = $_GET['oferta'];

    }else{
        $oferta = "ofertados";
        $tipooferta="Se oferta";
    }
    ?>
 
    <body>
        <div class="container">
            <br><br>
            <?php echo display_msg($msg); ?>
            <!--letras-->
            <nav class="navbar navbar-expand-lg navbar-light "><span class="navbar-brand">Estado oferta </span>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="busqueda_planes.php?oferta=Se oferta" style="color: #0056b3;">Ofertados</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="busqueda_planes.php?oferta=Vigente" style="color: #0056b3;">Vigentes</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="busqueda_planes.php?oferta=Inactiva" style="color: #0056b3;">Inactivos</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="busqueda_planes.php?oferta=Cerrada" style="color: #0056b3;">Cerrados</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="jumbotron text-center">
            <h1>Búsqueda de Planes de Estudio <?php echo $oferta;?> en el <?php echo date('Y');?></h1><br>
            </div><!-- jumbotron-->
            
            <div class="row justify-content-center">
            <div class="col-6">
            <form id="general-search" method="GET" action="busqueda_planes.php">
                <div class="form-row">
                  <div class="col">
                    <input value="<?php echo $tipooferta;?>" name="oferta" type="hidden">
                    <input type="search" class="form-control search" name="etiqueta" placeholder="Buscar por etiqueta">
                  </div>
                  <div class="col-1">
                    <button class="btn btn-primary" id="general-search-bt" type="submit">Buscar</button>
                  </div>
                </div>
            </form> <br>
            </div>
            </div>
            <div class="row justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm">
                    <li class="page-item"><a class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=A" tabindex="-1">A</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=B">B</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=C">C</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=D">D</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=E">E</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=F">F</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=G">G</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=H">H</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=I">I</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=J">J</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=K">K</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=L">L</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=M">M</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=N">N</a></li>
                       
                        
                    </ul>
                </nav>
            </div>
            <!-- justify-content-center -->
            <div class="row justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm">
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=Ñ">Ñ</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=O">O</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=P">P</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=Q">Q</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=R">R</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=S">S</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=T">T</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=U">U</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=V">V</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=W">W</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=X">X</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=Y">Y</a></li>
                        <li class="page-item"><a  class="page-link" href="busqueda_planes.php?oferta=<?php echo $tipooferta;?>&letra=Z">Z</a></li>
                    </ul>
                </nav>
            </div>
            
            <hr><br>
            <span id="resultado">
            <?php 
            if(isset($_GET['letra']) && isset($_GET['oferta'])){
                $letra = $_GET['letra'];
                $of = $_GET['oferta'];
                $sql = "SELECT  p.RowID_Plan, p.PlanCd, p.gradoAcademico, p.nombrePlan, f.nombre, p.tipo_carrera, p.logo FROM plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs f on u.fcs_codigo=f.id where p.nombrePlan like '".$letra."%' and p.HistoricoInd='N' and p.oferta='".$of."' order by p.nombrePlan asc";
                $result = mysqli_query($conn,$sql);
                $num_total_registros = mysqli_num_rows($result);
                if($num_total_registros > 0){
                    if($result->num_rows >= 0){
                        $result->data_seek(0);
                        while($fila=$result->fetch_assoc()){
                            echo '<div class="row"><div class="col-9"><div class="card">
                            <div class="card-header text-white bg-primary mb-3">
                            '.$fila['gradoAcademico'].' '.$fila['nombrePlan'].'
                            </div>
                            <div class="card-body">
                            <div class="row">
                            <div class="col-9">
                            <p><b>Facultad/Centro/Sede/Recinto/Sección: </b>'.$fila['nombre'].'
                            <br><b>Tipo de Carrera: </b>'.$fila['tipo_carrera'].'</p>
                            <a href=plan.php?cod='.$fila["RowID_Plan"].' class="btn btn-primary btn-sm">Ver detalles</a>
                            </div>
                            <div class="col-3">
                            <img border="1" class="card-img" src="'.$fila['logo'].'" width="80" height="80" >
                            </div>
                            </div></div>';
                            $sql1 = "SELECT nombre from etiqueta where planId=".$fila['PlanCd']." and planAct='S'";
                            $res = mysqli_query($conn,$sql1);
                            if($res->num_rows >= 0){
                                $res->data_seek(0);
                                echo'<div class="card-footer text-muted">';
                                echo '<button type="button" class="btn btn-link btn-sm">';
                                $tag="#";
                                while($row=$res->fetch_assoc()){
                                   $tag = $tag.$row['nombre']." #";
                                }
                                $tag = rtrim($tag, '#');
                                echo $tag.'</button></div>';
                            }
                            
                            echo '</div><br></div></div><br>';
                        }
                    }
                }else{
                    echo "<h4>No hay planes de estudio con la letra '".$letra."'</h4>";
                }

            } else if(isset($_GET['etiqueta']) && isset($_GET['oferta'])){
                $etiqueta = $_GET['etiqueta'];
                $of = $_GET['oferta'];
                $sql = "SELECT planId from etiqueta where nombre like '".$etiqueta."%'";
                $result = mysqli_query($conn,$sql);
                $num_total_registros = mysqli_num_rows($result);
                if($num_total_registros > 0){
                    $ids = array();
                    if($result->num_rows >= 0){
                        $result->data_seek(0);
                        while($fila=$result->fetch_assoc()){
                            array_push($ids,$fila['planId']);
                        }
                    }
                    $query = "SELECT p.RowID_Plan,p.PlanCd, p.gradoAcademico, p.nombrePlan, f.nombre, p.tipo_carrera, p.logo FROM plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs f on u.fcs_codigo=f.id where HistoricoInd='N' and PlanCd in (";
                    foreach ($ids as $cod ):
                        $query = $query.$cod.",";
                    endforeach;
                    $query = rtrim($query, ',');
                    $query = $query.") and p.oferta='".$of."' order by nombrePlan asc";
                    $res = mysqli_query($conn,$query);
                    if($res->num_rows >= 0){
                        $res->data_seek(0);
                        while($fila=$res->fetch_assoc()){
                            echo '<div class="row"><div class="col-9"><div class="card">
                            <div class="card-header text-white bg-primary mb-3">
                              '.$fila['gradoAcademico'].' '.$fila['nombrePlan'].'
                            </div>
                            <div class="card-body"><div class="row">
                            <div class="col-9">
                            <p><b>Facultad/Centro/Sede/Recinto/Sección: </b>'.$fila['nombre'].'
                            <br><b>Tipo de Carrera: </b>'.$fila['tipo_carrera'].'</p>
                            <a href=plan.php?cod='.$fila["RowID_Plan"].' class="btn btn-primary btn-sm">Ver detalles</a>
                            </div>
                            <div class="col-3">
                            <img border="1" class="card-img" src="'.$fila['logo'].'" width="80" height="80" >
                            </div>
                            </div></div>';
                            $sql1 = "SELECT nombre from etiqueta where planId=".$fila['PlanCd']." and planAct='S'";
                            $res1 = mysqli_query($conn,$sql1);
                            if($res1->num_rows >= 0){
                                $res1->data_seek(0);
                                echo'<div class="card-footer text-muted">';
                                echo '<button type="button" class="btn btn-link btn-sm">';
                                $tag="#";
                                while($row=$res1->fetch_assoc()){
                                   $tag = $tag.$row['nombre']." #";
                                }
                                $tag = rtrim($tag, '#');
                                echo $tag.'</button></div>';
                            }

                          echo '</div><br></div></div><br>';
                        }
                    }
                    
                }else{
                    echo "<h4>No hay planes de estudio con la etiqueta '".$etiqueta."'</h4>";
                }

            }else if(isset($_GET['oferta'])){
                $of = $_GET['oferta'];
                $sql = "SELECT  p.PlanCd,p.RowID_Plan,p.gradoAcademico, p.nombrePlan, f.nombre, p.tipo_carrera,p.logo FROM plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs f on u.fcs_codigo=f.id where HistoricoInd='N' and oferta='".$of."' order by nombrePlan asc";
                $result = mysqli_query($conn,$sql);
                if($result->num_rows > 0){
                    $result->data_seek(0);
                    while($fila=$result->fetch_assoc()){
                        echo '<div class="row"><div class="col-9"><div class="card">
                        <div class="card-header text-white bg-primary mb-3">
                          '.$fila['gradoAcademico'].' '.$fila['nombrePlan'].'
                        </div>
                        <div class="card-body"><div class="row">
                        <div class="col-9">
                        <p><b>Facultad/Centro/Sede/Recinto/Sección: </b>'.$fila['nombre'].'
                        <br><b>Tipo de Carrera: </b>'.$fila['tipo_carrera'].'</p>
                        <a href=plan.php?cod='.$fila["RowID_Plan"].' class="btn btn-primary btn-sm">Ver detalles</a>
                        </div>
                        <div class="col-3">
                        <img border="1" class="card-img" src="'.$fila['logo'].'" width="80" height="80" >
                        </div>
                        </div></div>';
                        $sql1 = "SELECT nombre from etiqueta where planId=".$fila['PlanCd']." and planAct='S'";
                        $res1 = mysqli_query($conn,$sql1);
                        if($res1->num_rows >= 0){
                            $res1->data_seek(0);
                            echo'<div class="card-footer text-muted">';
                            echo '<button type="button" class="btn btn-link btn-sm">';
                            $tag="#";
                            while($row=$res1->fetch_assoc()){
                               $tag = $tag.$row['nombre']." #";
                            }
                            $tag = rtrim($tag, '#');
                            echo $tag.'</button></div>';
                        }

                      echo '</div><br></div></div><br>';
                    }
                }else{
                    echo "<h4>No hay planes de estudio ".$oferta.".</h4>";
                }
            

            }else{
                $sql = "SELECT  p.PlanCd,p.RowID_Plan,p.gradoAcademico, p.nombrePlan, f.nombre, p.tipo_carrera,p.logo FROM plan p inner join unidadacademica u on p.unidad_Academica=u.nombre inner join fcs f on u.fcs_codigo=f.id where HistoricoInd='N' and oferta='".$tipooferta."' order by nombrePlan asc";
                $result = mysqli_query($conn,$sql);
                if($result->num_rows > 0){
                    $result->data_seek(0);
                    while($fila=$result->fetch_assoc()){
                        echo '<div class="row"><div class="col-9"><div class="card">
                        <div class="card-header text-white bg-primary mb-3">
                          '.$fila['gradoAcademico'].' '.$fila['nombrePlan'].'
                        </div>
                        <div class="card-body"><div class="row">
                        <div class="col-9">
                        <p><b>Facultad/Centro/Sede/Recinto/Sección: </b>'.$fila['nombre'].'
                        <br><b>Tipo de Carrera: </b>'.$fila['tipo_carrera'].'</p>
                        <a href=plan.php?cod='.$fila["RowID_Plan"].' class="btn btn-primary btn-sm">Ver detalles</a>
                        </div>
                        <div class="col-3">
                        <img border="1" class="card-img" src="'.$fila['logo'].'" width="80" height="80" >
                        </div>
                        </div></div>';
                        $sql1 = "SELECT nombre from etiqueta where planId=".$fila['PlanCd']." and planAct='S'";
                        $res1 = mysqli_query($conn,$sql1);
                        if($res1->num_rows >= 0){
                            $res1->data_seek(0);
                            echo'<div class="card-footer text-muted">';
                            echo '<button type="button" class="btn btn-link btn-sm">';
                            $tag="#";
                            while($row=$res1->fetch_assoc()){
                               $tag = $tag.$row['nombre']." #";
                            }
                            $tag = rtrim($tag, '#');
                            echo $tag.'</button></div>';
                        }

                      echo '</div><br></div></div><br>';
                    }
                }else{
                    echo "<h4>No hay planes de estudio ".$oferta.".</h4>";
                }

            }
            ?>
            </span>
            <br><br><hr><br><br>
        </div><!--cierra el container-->
        <?php include("layouts/footer.php");?>
        <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
        <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
        <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>

        <!-- <script src="script/busquedas.js" type="text/javascript"></script> -->
        <script>
        function ver(){
            console.log("hola");
        }
        </script>
    </body>
</html>