<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #303030;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #ffedba;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100%);
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Garante que o padding não afete a largura total */
            text-transform: uppercase;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: orange;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: darkorange;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <script>
            let atualizacao = ""; //caso S atualização em andamento e não é possivel acessar o sistema
            
            if (atualizacao === "S") {
                alert ("SISTEMA EM MANUTENÇÃO!"); 
                window.location.href = '/login.php';
            }</script>
        <h2>Login</h2>
        <form action="./funcoes/logarnosistema.php" method="post">
            <input type="text" name="usuario" placeholder="Nome de usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Entrar">
            <p>Não tem uma conta? Solicite ao seu gestor!</p>
        </form>
    </div>
</body>
</html>
