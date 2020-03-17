<!doctype html>
<html lang="en">
  <?php
    require_once('includes/load.php');
    if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
    $user = current_user();
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
      footer{ 
      position:absolute; 
      bottom:0; 
      width:100%; 
      height:90px; 
      }
    </style>
    <title>Pagina de Inicio</title>
  </head>
  <?php include_once('layouts/theader.php'); ?>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <?php echo display_msg($msg); ?>
          <div class="panel"><br>
            <div class="jumbotron text-center">
            <h1>Bienvenida(o) <?php echo remove_junk(ucfirst($user['name'])); ?> al Sistema de Gestión de Planes de Estudio</h1>
            </div><!-- jumbotron-->
          </div><!--panel-->
        </div><!--col md 12-->
      </div><!--row-->
    </div><!--container-->
    <script type="text/javascript" src="libs/js-files/jquery-3.2.1.slim.min.js"></script>
    <script type="text/javascript" src="libs/js-files/popper.min.js"></script>
    <script type="text/javascript" src="libs/js-files/bootstrap.min.js"></script>
    <?php include_once('layouts/footer.php');?>
  </body>
</html>
