<?php
session_start();
require_once "./includes/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT usuario_id, login, senha FROM tbUsuarios where login = :login");
    $stmt->bindParam(":login", $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['senha'])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["usuario_id"] = $user['usuario_id'];
        header("Location: index.php");
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="imagem">
            <img src="media/Login.png" alt="">
        </div>
        <div class="login">
        <div class="titulo">
            <h2>Seja bem-vindo!</h2>
            <p>Faça seu login para fazer seu feedback.</p>
        </div>
        <div style="text-align: center; color: red; top: 0;">
        <?php  if (isset($erro)) echo "<p>$erro</p>"; ?>
        </div>
        <form method="post">
            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" name="username" id="username" placeholder="exemplo@gmail.com" required>
            </div><br>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="*****" required>
            </div>
            <input class="button" type="submit" value="Entrar">
        </form>
        <p style="text-align: center;">Não tem cadastro? <a href="signup.php">Faça seu cadastro.</a> </p> 
        </div>
    </div>
</body>
</html>