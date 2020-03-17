<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="libs/css-files/bootstrap.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<!-- <link rel="stylesheet" href="libs/css-files/bootstrapp.min.css"> -->

  <script src="libs/js-files/jquery3.min.js"></script>
  <script src="libs/js-files/bootstrap3.min.js"></script>
  <script src="libs/js-files/jquery.min.js"></script>
<link rel="stylesheet" href="libs/css-files/login.css" />
<link rel="icon" href="public/images/unatransparente.png">
<header id="header">
  <!-- <div class="logo pull-left responsive"> -->
  <div class="text-center">
    <img style="margin:10px 10px" class="rounded" alt="Responsive image" src="public/images/logo-blanco.png" width="130px" height="130px" />
  </div>
<!-- </div> -->
</header>

<div class="login-page">
    <div class="text-center">
       <h3>Bienvenido a SIGPE</h3>
       <h4>Inicie sesión </h4>
       <hr>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="auth.php" class="clearfix">
        <div class="form-group">
        <label for="username" class="control-label">Usuario</label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Usuario">
        </div>
        <div class="form-group">
        <label for="Password" class="control-label">Contraseña</label>
        <span  data-toggle="tooltip" title="Llamar al 2277-3924 " data-placement="right" class="glyphicon glyphicon-info-sign"></span>
        <!-- <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="right">
          <span class="glyphicon glyphicon-info-sign"></span>
        </button> -->
            <input type="password" name= "password" id="Password" class="form-control" placeholder="Contraseña">
        </div>
        <div class="form-group">
                <button type="submit" class="btn btn-primary active pull-right">Entrar</button>
        </div>
    </form>
</div>
<style>
      .bg-red {
        background-color: #CC071E;
      }
    </style>

<?php include_once('layouts/footer.php');?>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
