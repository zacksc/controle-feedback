<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $login = trim($_POST['login']);
        $senha = trim($_POST['senha']);

        // Validações básicas
        if (empty($nome) || empty($login) || empty($senha)) {
            echo "0";
            exit;
        }

        // Verificar se o login já existe
        $sqlCheck = "SELECT COUNT(*) FROM tbUsuarios WHERE login = :login";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':login', $login);
        $stmtCheck->execute();

        if ($stmtCheck->fetchColumn() > 0) {
            echo "0"; // Login já existe
            exit;
        }

        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir usuário
        $sql = "INSERT INTO tbUsuarios (nome, login, senha) VALUES (:nome, :login, :senha)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senhaHash);

        if ($stmt->execute()) {
            $usuario_id = $conn->lastInsertId();

            // Log da operação
            $log_msg = "Usuario incluido: ID=$usuario_id, Nome=$nome, Login=$login";
            salvar_log($log_msg, 'inserir');

            echo "1"; // Sucesso
        } else {
            echo "0"; // Erro na inserção
        }
    } else {
        echo "0"; // Método inválido
    }
} catch (Exception $e) {        // Log do erro
    $log_msg = "Erro ao incluir usuario: " . $e->getMessage();
    salvar_log($log_msg, 'geral');
    echo "0";
}
