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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Editor</title>

    <!-- Adicionando estilos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./styles/menu.css">
    <link rel="stylesheet" href="./styles/padrao.css">
    <link rel="stylesheet" href="./styles/padrao-form.css">
    <link rel="stylesheet" href="./styles/padrao-tabelas.css">
</head>
<body>
<header id="header">
        <p id="logo"><b>Prime Usinagens:</b> Editor SQL</p>
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
                        print "<li><a class='link-cab' href='./parametrizacao.php'>Parametrização</a></li>";
                        print "<li><a class='link-cab' id='ativo' href='./editorsql.php'>SQL</a></li>";
                    }
                    print "<li><a class='link-cab' href='./funcoes/deslogarsistema.php'>". $_SESSION["nome"] ."</a></li>"
                ?>
            </ul>
        </nav>
    </header>

    <article>
        <style>
            form {
                margin-bottom: 20px;
            }

            textarea {
                resize: none;
                width: 100%;
                outline: none;
                border: none;
            }
            
            button {
                width: 100%
            }
        </style>
        
        <div class="container" style="margin-top: 10px;">
            <div class="padrao-div">
                <form id="sqlForm">
                    <textarea id="sqlQuery" name="sqlQuery" rows="4" cols="50">SELECT * FROM your_table;</textarea><br>
                    <button type="button" onclick="executeQuery()">Execute</button>
                </form>

                <div id="queryResult"></div>
            </div>
        </div>

        <script>
            function executeQuery() {
                var sqlQuery = document.getElementById("sqlQuery").value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("queryResult").innerHTML = this.responseText;
                    }
                };
                xhr.open("POST", "./funcoes/execute_query.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("sqlQuery=" + encodeURIComponent(sqlQuery));
            }
        </script>
    </article>
</body>

<script src="./scripts/menu.js"></script>

</html>
