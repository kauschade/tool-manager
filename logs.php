<?php 
    session_start();
    if (empty($_SESSION)){
        print "<script>location.href='./login.php';</script>";
    }
    $usuario = $_SESSION["usuario"];

    include('./funcoes/config.php');

    if ($_SESSION["tipo"]  == 'usuario') {
        $sql = "SELECT usuario,acao,data_e_hora FROM logs WHERE usuario = '$usuario'";
        $con = $conn->query($sql) or die($conn->error);
    } else {
        $sql = "SELECT usuario,acao,data_e_hora FROM logs";
        $con = $conn->query($sql) or die($conn->error);
    } 

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
        <div class="container" style="margin-top: 20px;">
            <div class="padrao-div">
                <h1>Consulta de Logs</h1>
                <form class="form">
                    <input class="form-inpt" type="text" id="filtroFerramenta" onkeyup="filtrarTabela('tabela', 2)" name="nome" placeholder="Pesquisa p/ ferramenta">
                </form>
                <table id="tabela">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Ação</th>
                            <th>Data e Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php //Conexão e variavel $con estão no topo do documento
                        while($dados = mysqli_fetch_assoc($con)) {
                            echo "<tr>";
                            echo "<td>".$dados['usuario']."</td>";
                            echo "<td>".$dados['acao']."</td>";
                            echo "<td>".$dados['data_e_hora']."</td>";
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
</script>

<script src="./scripts/menu.js"></script>

</html>