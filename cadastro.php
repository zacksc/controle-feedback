<?php
include_once 'inc/funcoes.php';
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}
require "inc/conexao.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $nascimento = $_POST["nascimento"];
    $telefone = $_POST["telefone"];

    $sql = "INSERT INTO tbPessoas (nome, cpf, nascimento, telefone, atualizado_por) VALUES (:nome, :cpf, :nascimento, :telefone, :atualizado_por)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->bindParam(":nascimento", $nascimento);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":atualizado_por", $_SESSION["usuario_id"]);
    $stmt->execute();

    $sucesso = "Colaborador cadastrado!";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Colaboradores</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container controle">
        <h2>Cadastrar Colaborador</h2>
        <?php if (isset($sucesso)) echo "<p>$sucesso</p>"; ?>
        <div class="cadastro">
            <form method="post">
                <div>
                    <label for="nome">Nome</label>
                    <input type="text" placeholder="Nome" name="nome" id="nome" required>
                </div><br>
                <div>
                    <label for="cpf">CPF</label>
                    <input type="text" placeholder="CPF" name="cpf" id="cpf" required>
                </div><br>
                <div>
                    <label for="nascimento">Data de Nascimento</label>
                    <input type="date" name="nascimento" id="nascimento" required>
                </div><br>
                <div>
                    <label for="telefone">Telefone</label>
                    <input type="text" placeholder="Telefone" name="telefone" id="telefone" required>
                </div><br>
                <input type="submit" class="button" value="Cadastrar">
            </form><br>
            <a href="index.php" class="button-voltar"> Voltar</a>
        </div>
    </div>
</body>

</html>