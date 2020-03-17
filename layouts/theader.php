<!-- <!doctype html>
<html lang="en">
<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php $user = current_user();
 $permisos = find_permissions($user['username']);
?>
  <head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="libs/css-files/bootstrap.min.css"> -- -->
    <!-- <title>Hello, world!</title> -->
  <!-- </head> -->
<header>
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-red">
  <!-- <a class="navbar-brand"><img style="margin:10px 10px" class="img-responsive" alt="Bootstrap template" src="public/images/logo-blanco.png" width="70px" height="60px" /> </a> -->
  <a class="navbar-brand"><img style="margin:10px 10px" class="img-responsive" alt="Bootstrap template" src="public/images/LOGO-UNAHorizontal-BLANCO.png" width="160px" height="60px" /> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
    <li class="nav-item active">
        <a class="nav-link"><b>SIGPE</b> <span class="sr-only"></span></a>
      </li>
    <li class="nav-item">
        <a class="nav-link" href="busqueda_planes.php">Inicio <span class="sr-only">(current)</span></a>
      </li>
      <?php if(in_array('ver_usuarios',$permisos) || in_array('ver_grupo',$permisos)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   
      <span>Accesos</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php if(in_array('ver_grupo',$permisos)){ ?>
          <a class="dropdown-item" href="ver_grupos.php">Administrar Grupos</a>
          <?php } ?>
          <?php if(in_array('ver_usuarios',$permisos)){ ?>
          <a class="dropdown-item" href="ver_usuarios.php">Administrar Usuarios</a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
      <?php if(in_array('agregar_plan',$permisos)){ ?>
      <li class="nav-item">
        <a class="nav-link" href="ingresar_plan.php">Agregar Plan</a>
      </li>
      <?php } ?>
      <?php if(in_array('crear_reportes',$permisos)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span>Reportes</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="seleccionar_filtro_historico.php">Reportes Historicos</a>
          <a class="dropdown-item" href="reportes.php">Reportes Generales</a>
        </div>
      </li>
      <?php } ?>
      <?php if(in_array('ver_fcs',$permisos) || in_array('ver_uc',$permisos) || in_array('ofertar_plan',$permisos) || in_array('ver_versiones',$permisos)){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Administración
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <?php if(in_array('ver_fcs',$permisos)){ ?>
          <a class="dropdown-item" href="ver_fcsr.php">Facultades</a>
          <?php } ?>
          <?php if(in_array('ver_uc',$permisos)){ ?>
          <a class="dropdown-item" href="ver_unidad_academica.php">Unidad Academica</a>
          <?php } ?>
          <?php if(in_array('ofertar_plan',$permisos)){ ?>
          <a class="dropdown-item" href="ofertar_planes.php">Ofertar Planes</a>
          <?php } ?>
          <?php if(in_array('ver_versiones',$permisos)){ ?>
          <a class="dropdown-item" href="ver_estructuras.php">Versiones estructuras curriculares</a>
          <?php } ?>
        </div>
      </li>
      <?php } ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo remove_junk(ucfirst($user['name'])); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="editar_cuenta.php">Configurar Perfil</a>
          <a class="dropdown-item" href="logout.php">Cerrar Sesión</a>
        </div>
      </li>
    </ul>
  </div>
 </nav>
</header>
<div style="height: 100px;">
</div>
<!-- <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script> -->