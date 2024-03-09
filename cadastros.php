<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    $user = $_SESSION["usuario"];

    include('./funcoes/config.php');

    $sql = "SELECT * FROM ferramentas";
    $con = $conn->query($sql) or die($conn->error);

    $sql2 = "SELECT * FROM fornecedores";
    $con2 = $conn->query($sql2) or die($conn->error);

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
</head>
<body>
<header id="header">
        <p id="logo"><b>Prime Usinagens:</b> Tool Manager</p>
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

    <article>
        <h1 style="color: white; text-align: center;">O QUE DESEJA CADASTRAR?</h1>
        <div class="acessos">
            <a class="acesso-rapido" href="./cadastro_ferramenta.php">
                <span class="ar-icon"><i class="bi bi-wrench-adjustable-circle"></i></span>
                <span class="ar-label"><h1>Cadastrar Ferramenta</h1></span>
            </a>

            <a class="acesso-rapido" href="./cadastro_fornecedor.php">
                <span class="ar-icon"><i class="bi bi-box2"></i></span>
                <span class="ar-label"><h1>Cadastrar Fornecedor</h1></span>
            </a>

            <a class="acesso-rapido" href="./cadastro_usuario.php">
                <span class="ar-icon"><i class="bi bi-person-plus"></i></span>
                <span class="ar-label"><h1>Cadastrar Usuário</h1></span>
            </a>
        </div>
    </article>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputCodigo = document.getElementById('codigo');
        const inputNome = document.getElementById('nome');
        const tabela = document.getElementById('tabela');
        const linhas = tabela.getElementsByTagName('tr');

        inputCodigo.addEventListener('keyup', filtrarTabela);
        inputNome.addEventListener('keyup', filtrarTabela);

        function filtrarTabela() {
            const filtroCodigo = inputCodigo.value.toUpperCase();
            const filtroNome = inputNome.value.toUpperCase();

            for (let i = 1; i < linhas.length; i++) {
                const codigoColuna = linhas[i].getElementsByTagName('td')[0];
                const nomeColuna = linhas[i].getElementsByTagName('td')[1];

                if (codigoColuna && nomeColuna) {
                    const codigoTexto = codigoColuna.textContent.toUpperCase();
                    const nomeTexto = nomeColuna.textContent.toUpperCase();

                    if (codigoTexto.indexOf(filtroCodigo) > -1 && nomeTexto.indexOf(filtroNome) > -1) {
                        linhas[i].style.display = '';
                    } else {
                        linhas[i].style.display = 'none';
                    }
                }
            }
        }
    });
</script>

<script src="./scripts/menu.js"></script>

</html>
