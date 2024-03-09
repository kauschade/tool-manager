<?php
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    include("./funcoes/config.php");

    $user = $_SESSION["usuario"];

    $sql = "SELECT nome,usuario FROM usuarios";
    $con = $conn->query($sql) or die($conn->error);

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
        <p id="logo"><b>Prime Usinagens:</b> Tool Manager</p>
        <nav id="nav">
            <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-controls="menu"
                aria-expanded="false">Menu
                <span id="hamburger"></span>
            </button>
            <ul id="menu" role="menu">
                <li><a class="link-cab" href="./index.php">Home</a></li>
                <li><a class="link-cab" href="./alterarsenha.php">Alterar Senha</a></li>
                <li><a class="link-cab" id="ativo" href="./adicionar-baixar.php">Add/Rem Ferramentas Estoque</a></li>
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
            <form action="1-0-1_consulta_cliente.php" method="POST">
                <input id="ipt-tela-cons" name="codigo" class="ipt-tela-cons" type="text" placeholder="Código Ferramenta" required>
                <input type="submit" class="btn-popup" value="Consultar">
            </form>
            <p class="sair-msg">ESC para Sair</p>
        </div>
    </div>

    <article>
        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <form action="./funcoes/movimentacao-estoque.php" method="POST">
                    <label>Ferramenta</label>
                    <input style="text-transform: uppercase;" type="text" value="<?php echo isset($_GET['ferramenta']) ? htmlspecialchars($_GET['ferramenta']) : ''; ?>" name="ferramenta" required>
                    <label>Quantidade</label>
                    <input type="text" name="quantidade" name="estoque_min" required>
                    <label>Tipo de Movimentação</label>
                    <select name="tipo-mov" required>
                    <?php //Conexão e variavel $con estão no topo do documento
                        if ($_SESSION["tipo"]  == 'usuario') {
                            echo "<option selected value='baixa'>BAIXA</option>";
                        } else {
                            echo "<option value='baixa'>BAIXA</option>";
                            echo "<option value='entrada'>ENTRADA</option>";
                        }
                    ?>
                    </select>
                    <label>Usuário</label>
                    <select name="usuario" required>
                    <?php //Conexão e variavel $con estão no topo do documento
                        if ($_SESSION["tipo"]  == 'usuario') {
                            echo "<option selected value='" . $_SESSION["usuario"] . "'>" . $_SESSION["nome"] . "</option>";
                        } else {
                            echo "<option value=''></option>";
                            while($dados = mysqli_fetch_assoc($con)) {
                                if(strtoupper($dados["usuario"]) !== "DEV.KAUE.SCHADE") {
                                    $selected = (strtoupper($dados["usuario"]) === strtoupper($_SESSION["usuario"])) ? "selected" : "";
                                    echo "<option value='" . $dados["usuario"] . "' $selected>" . $dados["nome"] . "</option>";
                                }
                            }
                        }
                    ?>
                    </select>
                    <input type="submit" value="Gravar">
                </form>
            </div>
        </div>
    </article>
</body>

<script src="./scripts/menu.js"></script>
<script src="./scripts/consultas.js"></script>

</html>
