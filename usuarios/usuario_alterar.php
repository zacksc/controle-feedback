<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = intval($_POST['usuario_id']);
        $nome = trim($_POST['nome']);
        $login = trim($_POST['login']);
        $senha = trim($_POST['senha']);

        // Validações básicas
        if ($usuario_id <= 0 || empty($nome) || empty($login)) {
            echo "0";
            exit;
        }

        // Verificar se o login já existe para outro usuário
        $sqlCheck = "SELECT COUNT(*) FROM tbUsuarios WHERE login = :login AND usuario_id != :usuario_id";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':login', $login);
        $stmtCheck->bindParam(':usuario_id', $usuario_id);
        $stmtCheck->execute();

        if ($stmtCheck->fetchColumn() > 0) {
            echo "0"; // Login já existe para outro usuário
            exit;
        }

        // Atualizar usuário
        if (!empty($senha)) {
            // Atualizar com nova senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE tbUsuarios SET nome = :nome, login = :login, senha = :senha WHERE usuario_id = :usuario_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->bindParam(':usuario_id', $usuario_id);
        } else {
            // Atualizar sem alterar senha
            $sql = "UPDATE tbUsuarios SET nome = :nome, login = :login WHERE usuario_id = :usuario_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':usuario_id', $usuario_id);
        }

        if ($stmt->execute()) {
            // Log da operação
            $log_msg = "Usuario alterado: ID=$usuario_id, Nome=$nome, Login=$login";
            if (!empty($senha)) {
                $log_msg .= " (senha alterada)";
            }
            salvar_log($log_msg, 'editar');

            echo "1"; // Sucesso
        } else {
            echo "0"; // Erro na atualização
        }
    } else {
        echo "0"; // Método inválido
    }
} catch (Exception $e) {        // Log do erro
    $log_msg = "Erro ao alterar usuario: " . $e->getMessage();
    salvar_log($log_msg, 'geral');
    echo "0";
}
