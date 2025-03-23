<?php
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}
require "./includes/conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $email = $_POST["email"];

    $sql = "INSERT INTO colaboradores (nome, cargo, email) VALUES (:nome, :cargo, :email)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cargo", $cargo);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $sucesso = "Coladorador cadastrado!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container controle">
    <h2>Cadastrar Colaborador</h2>
    <?php if(isset($sucesso)) echo "<p>$sucesso</p>";?>
    <div class="cadastro">
        <form method="post">
            <div>
            <label for="nome">Nome</label>
            <input type="text" placeholder="Nome" name="nome" id="nome" required>
            </div><br>
            <div>
            <label for="cargo">Cargo</label>
            <input type="text" placeholder="Cargo" name="cargo" id="cargo" required>
            </div><br>
            <div>
            <label for="email">Email</label>
            <input type="email" placeholder="Email" name="email" id="email" required>
            </div><br>
            
            
            <input type="submit" class="button" value="Cadastrar">
        </form><br>
        <a href="index.php" class="button-voltar"> Voltar</a>
    </div>
    </div>
    
</body>
</html>