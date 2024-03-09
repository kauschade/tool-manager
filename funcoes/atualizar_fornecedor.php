<?php
    include("config.php");

    $id = $_POST["id"]; 
    $acao = $_POST["acao"];
    $fornecedor = $_POST["fornecedor"];

    if ($acao == 'editar') {
        $sql = "UPDATE fornecedores
        SET fornecedor='$fornecedor'
        WHERE id = '$id'";

        mysqli_query($conn, $sql);

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acaolog = "Atualizou o fornecedor: " . $fornecedor;
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
        $sql = "DELETE FROM fornecedores
        WHERE id = '$id'";

        mysqli_query($conn, $sql);

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acaolog = "Deletou o fornecedor: " . $fornecedor;
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
    }

    echo ("<script>
            window.location.href = '../index.php';
        </script>");