<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    include('./funcoes/config.php');

    // Consultar o maior ID na tabela
    $sql = "SELECT MAX(id) AS max_id FROM ferramentas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maiorID = $row["max_id"];
    } else {
        $maiorID = 0; // Se a tabela estiver vazia
    }

    // Verificar se o código inserido é maior que o maior ID
    $codigo_inserido = $_POST['codigo']; // Certifique-se de sanitizar ou validar a entrada do usuário
    if ($codigo_inserido > $maiorID) {
        echo ("
        <script>
            alert('O código inserido é inválido!');
            window.location.href = './cadastro_ferramenta.php';
        </script>");
    }

    $select_ferramentas = "SELECT ferramenta, fornecedor, estoque_min, estoque_atual
    FROM ferramentas 
    WHERE id = '$codigo_inserido'";

    $executar_select_ferramentas = $conn->query($select_ferramentas) or die($conn->error);
    $ferramenta_data = $executar_select_ferramentas->fetch_assoc();

    $ferramenta = $ferramenta_data['ferramenta'];
    $fornecedor = $ferramenta_data['fornecedor'];
    $estoque_min = $ferramenta_data['estoque_min'];
    $estoque_atual = $ferramenta_data['estoque_atual'];

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
    <link rel="stylesheet" href="./styles/padrao-form.css">
    <link rel="stylesheet" href="./styles/popups.css">
</head>
<body>
<header id="header">
        <p id="logo"><b>Horizon:</b> Tool Manager</p>
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
            <form>
                <input id="ipt-tela-cons" name="codigo" class="ipt-tela-cons" type="text" placeholder="Código Ferramenta" required>
                <input type="submit" class="btn-popup" value="Consultar">
            </form>
            <p class="sair-msg">ESC para Sair</p>
        </div>
    </div>

    <article>
        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <form action="./funcoes/atualizar_ferramenta.php" method="POST">
                    <label>Código</label>
                    <input class="block" type="text" value="<?php echo $codigo_inserido; ?>" name="id" readonly>
                    <label>Ferramenta</label>
                    <input type="text" name="ferramenta" value="<?php echo $ferramenta; ?>" name="ferramenta" required>
                    <label>Fornecedor</label>
                    <select style="width: 100%;padding: 8px;margin-bottom: 10px;border: 1px solid #ccc;border-radius: 5px;display: block;box-sizing: border-box;" id="filtroFornecedor" onchange="filtrarTabela('tabela', 3)">
                        <option value="">Selecione o Fornecedor</option>
                        <?php //Conexão e variavel $con2 estão no topo do documento
                            while ($dados2 = mysqli_fetch_assoc($con2)) {
                                $selected = ($fornecedor == $dados2['fornecedor']) ? 'selected' : '';
                                echo "<option value='" . $dados2['fornecedor'] . "' " . $selected . ">" . $dados2['fornecedor'] . "</option>";
                            }
                        ?>
                    </select>
                    <label>Estoque Mínimo</label>
                    <input type="text" name="estoque_min" value="<?php echo $estoque_min; ?>" name="estoque_min" required>
                    <label>Estoque Atual</label>
                    <input class="block" type="text" name="estoque_atual" value="<?php echo $estoque_atual; ?>" name="estoque_atual" readonly required>
                    <label>Ação</label>
                    <select name="acao">
                        <option value="editar">Editar</option>
                        <option value="deletar">Deletar</option>
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
