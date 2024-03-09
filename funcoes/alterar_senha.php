<?php
    session_start();

    include('config.php');

    $usuario = $_SESSION["usuario"];
    $senha_atual = $_POST["senha_atual"];
    $nova_senha = $_POST["nova_senha"];
    $repetir_senha = $_POST["repetir_senha"];

    // Verifica se a nova senha e a senha repetida são iguais
    if ($nova_senha != $repetir_senha) {
        print "<script>alert('As senhas não coincidem');</script>";
        print "<script>location.href='../alterarsenha.php';</script>";
        exit(); // Encerra o script se as senhas não coincidirem
    }

    // Consulta para verificar se a senha atual está correta
    $sql_verifica_senha = "SELECT * FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha_atual}'";
    $res_verifica_senha = $conn->query($sql_verifica_senha) or die($conn->error);
    $qtd_verifica_senha = $res_verifica_senha->num_rows;

    if($qtd_verifica_senha > 0) {
        // Senha atual está correta, então atualiza a senha
        $sql_atualiza_senha = "UPDATE usuarios SET senha = '{$nova_senha}' WHERE usuario = '{$usuario}'";
        $conn->query($sql_atualiza_senha) or die($conn->error);

        // Redireciona para a página de perfil ou outra página desejada
        print "<script>alert('Senha alterada com sucesso');</script>";
        print "<script>location.href='../index.php';</script>";
    } else {
        // Senha atual incorreta, exibe mensagem de erro e redireciona para a página de alteração de senha
        print "<script>alert('Senha atual incorreta');</script>";
        print "<script>location.href='../alterarsenha.php';</script>";
    }
?>
