<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }

    $user = $_SESSION['usuario'];

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
        <?php 
            $sqlversao = "SELECT versao AS versao FROM sisinfos";
            $selvel = $conn->query($sqlversao) or die($conn->error);
            $versao = $selvel->fetch_assoc()['versao']; 

            $sqlmudancas = "SELECT mudancas AS mudancas FROM sisinfos";
            $selvel2 = $conn->query($sqlmudancas) or die($conn->error);
            $mudancas = $selvel2->fetch_assoc()['mudancas']; 
        ?>
        <style>
            #versao {
                text-align: right;
                margin-top: 0px;
                margin-right: 5px;
                font-size: 14px;
                color: #ffffff; /* Cor do texto */
            }
        </style>
        <?php echo "<p id='versao'>Versão " . $versao . "</p>";
            $usuario = $_SESSION["usuario"];
            $lidoatt = "SELECT lido_att FROM usuarios WHERE usuario = '$usuario'";
            $con_lido = $conn->query($lidoatt) or die($conn->error);
            $lido = $con_lido->fetch_assoc()['lido_att'];
        ?>

        <div class="container" <?php if ($lido == 'lido') echo 'style="display:none;"'; ?>>
            <div class="padrao-div">
                <?php echo "<p><strong>Atualização " . $versao . "</strong></p>"?>
                <?php echo "<p><strong>Mudanças</strong>: " . $mudancas . "</p>"?>
                <form action="./funcoes/lido_att.php" method="post">
                    <input type="submit" value="Fechar">
                </form>
            </div>
        </div>


        <div class="acessos">
        <?php //Conexão e variavel $con estão no topo do documento
            if ($_SESSION["tipo"]  == 'usuario') {
                echo ("
                    <a class='acesso-rapido' href=''>
                        <span class='ar-icon'><i class='bi bi-plus-circle'></i></span>
                        <span class='ar-label'><h1>Cadastros</h1></span>
                    </a>

                    <a class='acesso-rapido' href='./logs.php'>
                        <span class='ar-icon'><i class='bi bi-card-list'></i></span>
                        <span class='ar-label'><h1>Consultar Logs</h1></span>
                    </a>

                    <a class='acesso-rapido' onclick='filtrarPorEstoqueMinimo(event)'>
                        <span class='ar-icon'><i class='bi bi-clipboard-data'></i></span>
                        <span class='ar-label'><h1>Estoque Baixo</h1></span>
                    </a>

                    <a class='acesso-rapido' href='./adicionar-baixar.php'>
                        <span class='ar-icon'><i class='bi bi-plus-slash-minus'></i></span>
                        <span class='ar-label'><h1>Movimentação</h1></span>
                    </a>
                ");
            } else {
                echo ("
                    <a class='acesso-rapido' href='./cadastros.php'>
                        <span class='ar-icon'><i class='bi bi-plus-circle'></i></span>
                        <span class='ar-label'><h1>Cadastros</h1></span>
                    </a>

                    <a class='acesso-rapido' href='./logs.php'>
                        <span class='ar-icon'><i class='bi bi-card-list'></i></span>
                        <span class='ar-label'><h1>Consultar Logs</h1></span>
                    </a>

                    <a class='acesso-rapido' onclick='filtrarPorEstoqueMinimo(event)'>
                        <span class='ar-icon'><i class='bi bi-clipboard-data'></i></span>
                        <span class='ar-label'><h1>Estoque Baixo</h1></span>
                    </a>

                    <a class='acesso-rapido' href='./adicionar-baixar.php'>
                        <span class='ar-icon'><i class='bi bi-plus-slash-minus'></i></span>
                        <span class='ar-label'><h1>Movimentação</h1></span>
                    </a>
                ");
            } 
        ?>
        </div>

        <div class="container">
            <div class="padrao-div">
                <h1>Consulta de Estoque</h1>
                <form class="form">
                    <input class="form-inpt" type="text" id="filtroFerramenta" onkeyup="filtrarTabela('tabela', 2)" name="nome" placeholder="Pesquisa p/ ferramenta">
                    <select class="form-inpt" id="filtroFornecedor" onchange="filtrarTabela('tabela', 3)">
                        <option value="">Selecione o Fornecedor</option>
                        <?php //Conexão e variavel $con2 estão no topo do documento
                            while($dados2 = mysqli_fetch_assoc($con2)) {
                                echo "<option value='".$dados2['fornecedor']."'>".$dados2['fornecedor']."</option>";
                            }
                        ?>
                    </select>
                </form>
                <table id="tabela">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Ferramenta</th>
                            <th>Fornecedor</th>
                            <th>Estoque Mínimo</th>
                            <th>Estoque Atual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            .baixo-estoque {
                                background-color: red;
                                color: white;
                            }

                            .igual-estoque {
                                background-color: blue;
                                color: white;
                            }

                            tr {
                                cursor: pointer;
                            }
                        </style>
                        <?php 
                            //Conexão e variavel $con estão no topo do documento
                            while($dados = mysqli_fetch_assoc($con)) {
                                $classe = '';
                                if ($dados['estoque_atual'] < $dados['estoque_min']) {
                                    $classe .= 'baixo-estoque ';
                                } if ($dados['estoque_atual'] == $dados['estoque_min']) {
                                    $classe .= 'igual-estoque ';
                                }

                                echo "<tr onclick=\"window.location='adicionar-baixar.php?ferramenta=".$dados['ferramenta']."';\">";
                                echo "<td class='".$classe."'>".$dados['id']."</td>";
                                echo "<td class='".$classe."'>".$dados['ferramenta']."</td>";
                                echo "<td class='".$classe."'>".$dados['fornecedor']."</td>";
                                echo "<td class='".$classe."'>".$dados['estoque_min']."</td>";
                                echo "<td class='".$classe."'>".$dados['estoque_atual']."</td>";
                                echo "</tr>";
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </article>
</body>

<script>
    function filtrarTabela(idTabela, coluna) {
        var input, filtro, tabela, tr, td, i, txtValue;
        input = coluna === 2 ? document.getElementById("filtroFerramenta") : document.getElementById("filtroFornecedor");
        filtro = input.value.toUpperCase();
        tabela = document.getElementById(idTabela);
        tr = tabela.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[coluna - 1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filtro) > -1 || filtro === '') {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function filtrarPorEstoqueMinimo(event) {
        event.preventDefault(); // Evita a ação padrão do botão (atualizar a página)
        var tabela, tr, tdEstoqueMinimo, tdEstoqueAtual, i;
        tabela = document.getElementById("tabela");
        tr = tabela.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            tdEstoqueMinimo = tr[i].getElementsByTagName("td")[3];
            tdEstoqueAtual = tr[i].getElementsByTagName("td")[4];
            if (tdEstoqueMinimo && tdEstoqueAtual) {
                var estoqueMinimo = parseInt(tdEstoqueMinimo.textContent || tdEstoqueMinimo.innerText);
                var estoqueAtual = parseInt(tdEstoqueAtual.textContent || tdEstoqueAtual.innerText);
                if (estoqueMinimo >= estoqueAtual) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script src="./scripts/menu.js"></script>

</html>
