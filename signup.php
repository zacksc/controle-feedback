<?php
session_start();

$mensagem = "";

require_once "./includes/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)){
        $mensagem = "Preencha todos os dados";
    } else{
        try{
            $sql ="SELECT id FROM usuarios WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0){
                $mensagem = "Este usuário já existe, faça login ou escolha outro.";
            } else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql ="INSERT INTO usuarios (username, password) VALUES (:username, :password)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $hashed_password);
                $stmt->execute();

                $mensagem = "Administrador registrado com sucesso. Agora faça o login!";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao registrar: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="imagem">
            <img src="media/Login.png" alt="">
        </div>
        <div class="login">
        <div class="titulo">
            <h2>Cadastrar</h2>
            <p>Faça seu cadastro para ter controle sobre os feedbacks.</p>
        </div>
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" name="username" id="username" placeholder="exemplo@gmail.com" required>
            </div><br>
            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" placeholder="*****" required>
            </div>
            
            <input class="button" type="submit" value="Registrar">
        </form>

        <a href="index.php" class="button-voltar" style="text-align: center; align-self: center; width: 200px;">Voltar</a>
        </div>
    </div>
</body>

</html>