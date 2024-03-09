<?php
    include('config.php');

    $fornecedor = $_POST['fornecedor'];

    $sql = "SELECT fornecedor FROM fornecedores WHERE fornecedor = '$ferramenta'";

    $res = $conn->query($sql) or die($conn->error);
    $row = $res->fetch_object();
    $qtd = $res->num_rows;

    if($qtd > 0) {
        print "<script>alert('Fornecedor já cadastrada!');</script>";
    } else {
        $sql = "INSERT INTO `fornecedores`
        (`fornecedor`) 
        VALUES ('$fornecedor')";

        mysqli_query($conn, $sql);
    }

    //LOGS
    date_default_timezone_set('America/Sao_Paulo');
    $acao = "Cadastrou o fornecedor: " . $fornecedor;
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