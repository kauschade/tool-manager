<?php
    include('config.php');

    $ferramenta = $_POST['ferramenta'];
    $fornecedor = $_POST['fornecedor'];
    $estoque_min = $_POST['estoque_min'];
    $estoque_atual = $_POST['estoque_atual'];

    $sql = "SELECT ferramenta FROM ferramentas WHERE ferramenta = '$ferramenta'";

    $res = $conn->query($sql) or die($conn->error);
    $row = $res->fetch_object();
    $qtd = $res->num_rows;

    if($qtd > 0) {
        print "<script>alert('Ferramenta já cadastrada!');</script>";
    } else {
        $sql = "INSERT INTO `ferramentas`
        (`ferramenta`, `fornecedor`, `estoque_min`, `estoque_atual`) 
        VALUES ('$ferramenta','$fornecedor','$estoque_min','$estoque_atual')";

        mysqli_query($conn, $sql);
    }

    //LOGS
    date_default_timezone_set('America/Sao_Paulo');
    $acao = "Cadastrou a ferramenta: " . $ferramenta . " / Fornecedor: " . $fornecedor . " / estoque min: " . $estoque_min . " / Estoque atual " . $estoque_atual;
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