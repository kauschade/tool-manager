<?php
    include('config.php');

    $criartabela_ferramentas = "CREATE TABLE ferramentas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ferramenta VARCHAR(255),
        fornecedor VARCHAR(255),
        estoque_min VARCHAR(255),
        estoque_atual VARCHAR(255)
    )";

    $criartabela_fornecedores = "CREATE TABLE fornecedores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fornecedor VARCHAR(255)
    )";

    $criartabela_logs = "CREATE TABLE logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(255),
        acao VARCHAR(255),
        data_e_hora VARCHAR(255)
    )";

    $criartabela_logstotais = "CREATE TABLE logs_totais (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(255),
        acao VARCHAR(255),
        data_e_hora VARCHAR(255)
    )";

    $criartabela_parametros = "CREATE TABLE parametros (
        id INT AUTO_INCREMENT PRIMARY KEY,
        valor VARCHAR(255),
        tela VARCHAR(255),
        funcao VARCHAR(255),
        descricao VARCHAR(255)
    )"; //sem parametros no momento!

    $criartabela_sisinfos = "CREATE TABLE sisinfos (
        versao VARCHAR(255),
        mudancas VARCHAR(255)
    )";

    $criartabela_usuarios = "CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255),
        usuario VARCHAR(255),
        senha VARCHAR(255),
        tipo VARCHAR(255),
        lido_att VARCHAR(255)
    )";

    $incluir_usuario = "INSERT INTO usuarios (nome, usuario, senha, tipo, lido_att) VALUES ('Primeiro Acesso', 'acesso', '123456', 'dev', '')";
    $incluir_versao = "INSERT INTO sisinfos (versao, mudancas) VALUES ('1.0', 'PRIMEIRO ACESSO')";
 
    $sql_commands = array(
        $criartabela_ferramentas,
        $criartabela_fornecedores,
        $criartabela_logs,
        $criartabela_logstotais,
        $criartabela_parametros,
        $criartabela_sisinfos,
        $criartabela_usuarios,
        $incluir_usuario,
        $incluir_versao
    );

    foreach ($sql_commands as $sql) {
        if ($conn->query($sql) === TRUE) {
            print "<script>alert('Comando executado com sucesso: $sql');</script>";
        } else {
            print "<script>alert('Erro ao executar comando: $sql | Erro: " . $conn->error . "');</script>";
        }
    }

    print "<script>location.href='../login.php';</script>";

    $conn->close();