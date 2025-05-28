<?php
include_once 'inc/funcoes.php';

$mensagem = "";

require_once "inc/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if (empty($nome) || empty($login) || empty($password)){
        $mensagem = "Preencha todos os dados";
    } else{
        try{
            $sql ="SELECT usuario_id FROM tbUsuarios WHERE login = :login";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":login", $login);
            $stmt->execute();

            if ($stmt->rowCount() > 0){
                $mensagem = "Este usuário já existe, faça login ou escolha outro.";
            } else{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql ="INSERT INTO tbUsuarios (nome, login, senha, atualizado_por) VALUES (:nome, :login, :senha, :atualizado_por)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":login", $login);
                $stmt->bindParam(":senha", $hashed_password);
                $stmt->bindParam(":atualizado_por", $_SESSION["usuario_id"]);
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
<html lang="pt-br">
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
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Seu nome" required>
            </div><br>
            <div class="input-group">
                <label for="login">Login</label>
                <input type="text" name="login" id="login" placeholder="exemplo@gmail.com" required>
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