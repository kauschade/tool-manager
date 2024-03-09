<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    include('./funcoes/config.php');

    $user = $_SESSION["usuario"];

    $sql = "SELECT * FROM ferramentas";
    $con = $conn->query($sql) or die($conn->error);

    $sql2 = "SELECT MAX(id) AS max_id FROM ferramentas";
    $result = $conn->query($sql2);

    $sql3 = "SELECT * FROM fornecedores";
    $con2 = $conn->query($sql3) or die($conn->error);

    $consulta_codigo_antigo = "SELECT Max(id) as max_id FROM ferramentas";
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

    <div id="popup-fundo-consulta" class="popups escondido">
        <div id="popup-consulta" class="popup escondido">
            <form action="consultar_ferramenta.php" method="POST">
                <input id="ipt-tela-cons" name="codigo" class="ipt-tela-cons" type="text" placeholder="Código Ferramenta" required>
                <input type="submit" class="btn-popup" value="Consultar">
            </form>
            <p class="sair-msg">ESC para Sair</p>
        </div>
    </div>

    <article>
    <div class="acessos">
            <div id="btn-consultar" class="acesso-rapido">
                <span class="ar-icon"><i class="bi bi-pencil-square"></i></span>
                <span class="ar-label"><h1>Editar / Consultar</h1></span>
            </div>
        </div>

        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <form action="./funcoes/cadastrar_ferramenta.php" method="POST">
                    <label>Código</label>
                    <?php 
                        //colocar o valor do código dentro da input
                        if ($codigo_antigo_resultado->num_rows > 0) {
                            echo "<input type='text' name='codigo' class='block' value='". $codigo_antigo + 1 ."' title='Código' readonly>";
                        } else {
                            echo "<input type='text' name='codigo' class='block' value='". 1 ."' title='Código' readonly>";
                        }
                    ?>
                    <label>Ferramenta</label>
                    <input type="text" name="ferramenta" required>
                    <label>Fornecedor</label>
                    <select style="width: 100%;padding: 8px;margin-bottom: 10px;border: 1px solid #ccc;border-radius: 5px;display: block;box-sizing: border-box;" name="fornecedor" required>
                        <option value="">Selecione o Fornecedor</option>
                        <?php //Conexão e variavel $con2 estão no topo do documento
                            while($dados2 = mysqli_fetch_assoc($con2)) {
                                echo "<option value='".$dados2['fornecedor']."'>".$dados2['fornecedor']."</option>";
                            } 
                        ?>
                    </select>
                    <label>Estoque Mínimo</label>
                    <input type="text" name="estoque_min" required>
                    <label>Estoque Atual</label>
                    <input type="text" name="estoque_atual" required>
                    <input type="submit" value="Cadastrar">
                </form>
            </div>
        </div>
    </article>
</body>

</script>

<script src="./scripts/menu.js"></script>
<script src="./scripts/consultas.js"></script>

</html>
