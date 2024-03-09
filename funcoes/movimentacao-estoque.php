<?php
    include("config.php");

    $tipo = $_POST["tipo-mov"];
    $ferramenta = $_POST["ferramenta"];
    $quantidade = $_POST["quantidade"];
    $usuario = $_POST["usuario"];

    if ($tipo == "baixa") {
        $sql = "UPDATE ferramentas 
        SET estoque_atual = estoque_atual - '$quantidade'
        WHERE ferramenta = '$ferramenta'";

        mysqli_query($conn, $sql);

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acao = "Removeu " . $quantidade . " de " . $ferramenta;
        $datahora = date('d/m/Y H:i');

        $log = "INSERT INTO `logs`
        (`usuario`, `acao`, `data_e_hora`) 
        VALUES ('$usuario','$acao','$datahora')";

        mysqli_query($conn, $log);

        $log2 = "INSERT INTO `logs_totais`
        (`usuario`, `acao`, `data_e_hora`) 
        VALUES ('$usuario','$acao','$datahora')";

        mysqli_query($conn, $log2);
    } else {
        $sql = "UPDATE ferramentas 
        SET estoque_atual = estoque_atual + '$quantidade'
        WHERE ferramenta = '$ferramenta'";

        mysqli_query($conn, $sql);
        
        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acao = "Adicionou " . $quantidade . " à " . $ferramenta;
        $datahora = date('d/m/Y H:i');

        $log = "INSERT INTO `logs`
        (`usuario`, `acao`, `data_e_hora`) 
        VALUES ('$usuario','$acao','$datahora')";

        mysqli_query($conn, $log);

        $log2 = "INSERT INTO `logs_totais`
        (`usuario`, `acao`, `data_e_hora`) 
        VALUES ('$usuario','$acao','$datahora')";

        mysqli_query($conn, $log2);
    }

    echo ("
        <script>
            window.location.href = '../index.php';
        </script>
    ");