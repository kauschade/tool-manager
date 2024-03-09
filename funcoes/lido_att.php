<?php
  session_start();
  include("config.php");

  $usuario = $_SESSION["usuario"];

  $sql = "UPDATE usuarios SET lido_att = 'lido' WHERE usuario = '$usuario'";

  mysqli_query($conn, $sql);
  
  //LOGS
  date_default_timezone_set('America/Sao_Paulo');
  $acaolog = "Leu o log da atualização";
  $datahora = date('d/m/Y H:i');
  session_start();
  $user = $_SESSION["usuario"];

  $log = "INSERT INTO `logs`
  (`usuario`, `acao`, `data_e_hora`) 
  VALUES ('$user','$acaolog','$datahora')";

  $log2 = "INSERT INTO `logs_totais`
  (`usuario`, `acao`, `data_e_hora`) 
  VALUES ('$user','$acaolog','$datahora')";

  mysqli_query($conn, $log);
  mysqli_query($conn, $log2);

  echo ("
    <script>
         window.location.href = '../index.php';
    </script>
  ");