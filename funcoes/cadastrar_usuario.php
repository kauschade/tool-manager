<?php
    include('config.php');

    $nome = $_POST['nome'];
    $usuario = $_POST['usuario'];
    $senha = '123456';
    $tipo = $_POST['tipo'];

    $sql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario'";

    $res = $conn->query($sql) or die($conn->error);
    $row = $res->fetch_object();
    $qtd = $res->num_rows;

    if($qtd > 0) {
        print "<script>alert('Usuário já cadastrada!');</script>";
    } else {
        print "<script>alert('Usuário cadastrado: Usuário: " . $ususario . " | Senha: " .  $senha . "' !');</script>";
        
        $sql = "INSERT INTO `usuarios`
        (`nome`, `usuario`, `senha`, `tipo`, `lido_att`) 
        VALUES ('$nome','$usuario','$senha','$tipo', '')";

        mysqli_query($conn, $sql);
    }

    //LOGS
    date_default_timezone_set('America/Sao_Paulo');
    $acao = "Cadastrou o usuário: " . $usuario . " / Tipo: " . $tipo;
    $datahora = date('d/m/Y H:i');
    session_start();
    $user = $_SESSION["usuario"];

    $log = "INSERT INTO `logs`
    (`usuario`, `acao`, `data_e_hora`) 
    VALUES ('$user','$acao','$datahora')";

    $log2 = "INSERT INTO `logs_totais`
    (`usuario`, `acao`, `data_e_hora`) 
    VALUES ('$user','$acao','$datahora')";

    mysqli_query($conn, $log);
    mysqli_query($conn, $log2);

    echo ("
        <script>
            window.location.href = '../index.php';
        </script>
    ");