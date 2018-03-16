<?php
    include_once '../../includes/db.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Food - Automaçao de Restaurantes e Hotéis</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style>
  .card {
      box-shadow: 2px 2px 3px rgba(255,255,255,.4);
      width: 400px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
  }
  body{
      background-image: url('../../img/backgrounds/bg2.jpg');
      background-repeat: repeat-y;
      background-size:100%;
  }


   </style>
</head>
<body>
  <div class="container login">
    <div class="row">
        <div class="col s12 m6">
          <div class="card blue-grey darken-1">
            <form action="loga.php" method="post">
              <div class="card-content white-text">
                <span class="card-title">SISTEMA PARA RESTAURANTE</span>
                <p>Digite sua senha para continuar</p>
                <input type="password" name="senha" placeholder="Digite sua senha...">
              </div>
              <div class="card-action">
                <button type="submit" class="waves-effect waves-light btn">Acessar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
	  <!--  Scripts-->
  <script type="text/javascript" src="../../js/jquery-3.2.1.js"></script>
  <script src="../../js/materialize.js"></script>
  <script src="../../js/init.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      <?php if ($_GET['erro'] == 'true') {?>
       Materialize.toast('Erro ao fazer login, verifique sua senha!', 5000, 'rounded');
      <?php } ?>
    });
  </script>

  </body>
</html>
