<?php
    session_start();

    include('config.php');

    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios
            WHERE usuario = '{$usuario}'
            AND senha = '{$senha}'";

    //verificação do email e senha
    $res = $conn->query($sql) or die($conn->error);
    $row = $res->fetch_object();
    $qtd = $res->num_rows;

    if($qtd > 0) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["nome"] = $row->nome;
        $_SESSION["tipo"] = $row->tipo;
        print "<script>location.href='../index.php';</script>";

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acaolog = "Logou no sistema";
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
    } else {
        print "<script>alert('usuário e/ou senha icorreto(s)');</script>";
        print "<script>location.href='../login.php';</script>";
    }