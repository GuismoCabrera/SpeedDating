<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=iff, initial-scale=1.0">
    <title>Document</title>
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- STYLE VIDEO CALL -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light " style="background-color: #003b5d;    box-shadow: 0 2px 2px -2px rgba(0,0,0,.2);
">
  <a class="navbar-brand" href="https://w2w.com.mx"><img src="./img/logo_menu.png" alt="Logo App" style="height: 50px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#" style="color: white; font-size: 28px"><b>Match Video</b> <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div> 
</nav>
<?php  
    if(isset($_GET['channel']) && isset($_GET['token']) && isset($_GET['userId']) && isset($_GET['callingTo']) && isset($_GET['calling']) ){
    include './pusher.php';
    ?>
        <div id="me"></div>
            
        <center>
        <hr>
        <h4>Conexiones establecidas:</h4>
        <hr>
        </center>
        <div id="remote-container"></div>
        <script src="./js/AgoraRTCSDK-3.2.1.js"></script>
        <script type="text/javascript" src="./js/Agora.js"></script>
        <?php
    }else{
        echo "Faltan datos para completar la llamada";
    } ?>
</body>
</html>