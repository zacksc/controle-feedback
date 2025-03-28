<?php
session_start();
require_once "./includes/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM usuarios where username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

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
        <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
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
        </div>
    </div>
</body>

</html>