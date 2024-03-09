<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    include('./funcoes/config.php');

    $consulta_codigo_antigo = "SELECT Max(id) as max_id FROM usuarios";
    $codigo_antigo_resultado = $conn->query($consulta_codigo_antigo) or die($conn->error);
    $codigo_antigo = $codigo_antigo_resultado->fetch_assoc()['max_id']; 

    $validacaotela = "SELECT * FROM usuarios WHERE usuario = '$user' AND tipo = 'dev'";
    $res2 = $conn->query($validacaotela) or die($conn->error);
    $row2 = $res2->fetch_object();
    $qtd2 = $res2->num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool Manager</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./styles/menu.css">
    <link rel="stylesheet" href="./styles/padrao.css">
    <link rel="stylesheet" href="./styles/padrao-tabelas.css">
    <link rel="stylesheet" href="./styles/padrao-form.css">
    <link rel="stylesheet" href="./styles/popups.css">
</head>
<body>
<header id="header">
        <p id="logo"><b>Hozizon:</b> Tool Manager</p>
        <nav id="nav">
            <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu"
                aria-expanded="false">Menu
                <span id="hamburger"></span>
            </button>
            <ul id="menu" role="menu">
                <li><a class="link-cab" id="ativo" href="./index.php">Home</a></li>
                <li><a class="link-cab" href="./alterarsenha.php">Alterar Senha</a></li>
                <li><a class="link-cab"  href="./adicionar-baixar.php">Add/Rem Ferramentas Estoque</a></li>
                <?php
                    if($qtd2 > 0) {
                        print "<li><a class='link-cab' href='./parametrizacao.php'>Parametrização</a></li>";
                        print "<li><a class='link-cab' href='./editorsql.php'>SQL</a></li>";
                    }
                    print "<li><a class='link-cab' href='./funcoes/deslogarsistema.php'>". $_SESSION["nome"] ."</a></li>"
                ?>
            </ul>
        </nav>
    </header>

    <div id="popup-fundo-consulta" class="popups escondido">
        <div id="popup-consulta" class="popup escondido">
            <form action="consultar_fornecedor.php" method="POST">
                <input id="ipt-tela-cons" name="codigo" class="ipt-tela-cons" type="text" placeholder="Código Fornecedor" required>
                <input type="submit" class="btn-popup" vaalue="Consultar">
            </form>
            <p class="sair-msg">ESC para Sair</p>
        </div>
    </div>

    <article>
        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <form action="./funcoes/alterar_senha.php" method="POST">
                    <label>Senha Antiga</label>
                    <input type="password" name="senha_atual" required>
                    <label>Senha Nova</label>
                    <input type="password" name="nova_senha" required>
                    <label>Repita</label>
                    <input type="password" name="repetir_senha" required>
                    <input type="submit" value="Alterar">
                </form>
            </div>
        </div>
    </article>
</body>

</script>

<script src="./scripts/menu.js"></script>
<script src="./scripts/consultas.js"></script>

</html>
