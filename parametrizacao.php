<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    include('./funcoes/config.php');

    $user = $_SESSION['usuario'];

    $validacaotela = "SELECT * FROM usuarios WHERE usuario = '$user' AND tipo = 'dev'";
    $res2 = $conn->query($validacaotela) or die($conn->error);
    $row2 = $res2->fetch_object();
    $qtd2 = $res2->num_rows;

    if($qtd2 <= 0) {
        print "<script>alert('Acesso disponível apenas para usuários do tipo desenvolvedor');</script>";
        print "<script>location.href='./index.php';</script>";
    }

    $sql = "SELECT * FROM ferramentas";
    $con = $conn->query($sql) or die($conn->error);

    $sql2 = "SELECT * FROM fornecedores";
    $con2 = $conn->query($sql2) or die($conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parametrização</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./styles/menu.css">
    <link rel="stylesheet" href="./styles/padrao.css">
    <link rel="stylesheet" href="./styles/padrao-tabelas.css">
    <link rel="stylesheet" href="./styles/padrao-form.css">
    <link rel="stylesheet" href="./styles/popups.css">
</head>
<body>
<header id="header">
        <p id="logo"><b>Horizon:</b> Parametros</p>
        <nav id="nav">
            <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu"
                aria-expanded="false">Menu
                <span id="hamburger"></span>
            </button>
            <ul id="menu" role="menu">
                <li><a class="link-cab" href="./index.php">Home</a></li>
                <li><a class="link-cab" href="./alterarsenha.php">Alterar Senha</a></li>
                <li><a class="link-cab"  href="./adicionar-baixar.php">Add/Rem Ferramentas Estoque</a></li>
                <?php
                    if($qtd2 > 0) {
                        print "<li><a class='link-cab' id='ativo' href='./parametrizacao.php'>Parametrização</a></li>";
                        print "<li><a class='link-cab' href='./editorsql.php'>SQL</a></li>";
                    }
                    print "<li><a class='link-cab' href='./funcoes/deslogarsistema.php'>". $_SESSION["nome"] ."</a></li>"
                ?>
            </ul>
        </nav>
    </header>
    
    <article>
        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <style>
                    h1 {
                        color: white;
                    }

                    .param {
                        background-color: rgba(0,0,0,0.5);
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 5px;
                    } 

                    .fixed-button {
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        background-color: Orange;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        padding: 10px 20px;
                        cursor: pointer;
                    }

                    .fixed-button:hover {
                        background-color: DarkOrange;
                    }
                </style>

                <h1>TELA DE PARAMETRIZAÇÃO, SÓ MEXA SE SOUBER!</h1>
                <?php 
                $consulta_telas = "SELECT DISTINCT tela FROM parametros";
                $resultado_telas = $conn->query($consulta_telas) or die($conn->error);

                while ($tela_row = mysqli_fetch_assoc($resultado_telas)) {
                    $tela = $tela_row['tela'];
                    $consulta_parametros = "SELECT * FROM parametros WHERE tela = '$tela'";
                    $resultado_parametros = $conn->query($consulta_parametros) or die($conn->error);

                    echo "<div class='param'>";
                    echo "<h1>{$tela}</h1>";

                    while ($parametro = mysqli_fetch_assoc($resultado_parametros)) {
                        echo "<div class='param'>";
                        echo "<p><b>{$parametro['tela']} {$parametro['funcao']}</b>: {$parametro['descricao']}</p>";
                        echo "<select>";
                        echo "<option value='S'" . ($parametro['valor'] == 'S' ? ' selected' : '') . ">Sim</option>";
                        echo "<option value='N'" . ($parametro['valor'] == 'N' ? ' selected' : '') . ">Não</option>";
                        echo "</select>";
                        echo "</div>";
                    }

                    echo "</div>";
                }
                ?>
            </div>
        </div>
        <button class="fixed-button">Atualizar Parâmetros</button>
    </article>
</body>

<script src="./scripts/menu.js"></script>

</html>
