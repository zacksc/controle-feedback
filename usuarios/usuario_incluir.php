<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nome = $_POST["pNome"];
    $login = $_POST["pLogin"];
    $senha = $_POST["pSenha"];

    try 
    {
        $sql = "INSERT INTO tbUsuarios (nome, login, senha) VALUES ('$nome', '$login', '$senha')";
        salvar_log($sql, 'inserir');
        
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO tbUsuarios (nome, login, senha, atualizado_por) VALUES (:nome, :login, :senha, :atualizado_por)");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":login", $login);
        $stmt->bindParam(":senha", $hashed_password);
        $stmt->bindParam(":atualizado_por", $_SESSION["usuario_id"]);
        
        if ($stmt->execute()) 
        {
            $retorno = "Usuário inserido com sucesso!";
        } 
        else 
        {
            $retorno = "Erro na inserção";
        }

    } 
    catch (PDOException $e) 
    {
        $retorno = "Erro ao cadastrar: " . $e->getMessage();
    }
}

echo $retorno;
?>
