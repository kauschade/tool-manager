<?php
    include("config.php");

    $id = $_POST["id"]; 
    $acao = $_POST["acao"];
    $ferramenta = $_POST["ferramenta"];
    $estoque_min = $_POST["estoque_min"];

    if ($acao == 'editar') {
        $sql = "UPDATE ferramentas
        SET ferramenta='$ferramenta',
        estoque_min='$estoque_min'
        WHERE id = '$id'";

        mysqli_query($conn, $sql);

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acaolog = "Atualizou a ferramenta: " . $ferramenta . " / Fornecedor: " . $fornecedor . " / estoque min: " . $estoque_min;
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
        $sql = "DELETE FROM ferramentas
        WHERE id = '$id'";

        mysqli_query($conn, $sql);

        //LOGS
        date_default_timezone_set('America/Sao_Paulo');
        $acaolog = "Deletou a ferramenta: " . $ferramenta;
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