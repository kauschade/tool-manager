<?php
// Verifica se foi enviada uma consulta SQL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sqlQuery"])) {
    // Configurações de conexão com o banco de dados MySQL
    include("./config.php");

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém a consulta SQL enviada via AJAX
    $sql = $_POST["sqlQuery"];

    // Verifica se a consulta é SELECT, UPDATE ou DELETE
    $queryType = strtoupper(explode(" ", trim($sql))[0]);

    // Executa a consulta SQL
    $result = $conn->query($sql);

    //LOGS
    date_default_timezone_set('America/Sao_Paulo');
    $acao = "[SQL] Executou o comando: " . $sql;
    $datahora = date('d/m/Y H:i');
    session_start();
    $usuario = $_SESSION["usuario"];

    $log = "INSERT INTO `logs`
    (`usuario`, `acao`, `data_e_hora`) 
    VALUES ('$usuario','$acao','$datahora')";

    $log2 = "INSERT INTO `logs_totais`
    (`usuario`, `acao`, `data_e_hora`) 
    VALUES ('$usuario','$acao','$datahora')";

    mysqli_query($conn, $log);
    mysqli_query($conn, $log2);

    // Se a consulta for SELECT
    if ($queryType === "SELECT") {
        // Exibe os resultados em uma tabela HTML
        if ($result && $result->num_rows > 0) {
            echo "<table>";
            // Cabeçalho da tabela
            echo "<tr>";
            while ($field = $result->fetch_field()) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";

            // Dados da tabela
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    } else {
        // Se a consulta for UPDATE ou DELETE
        if ($result) {
            echo "Consulta executada com sucesso.";
        } else {
            echo "Erro ao executar a consulta: " . $conn->error;
        }
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>
