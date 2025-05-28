<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $nascimento = trim($_POST['nascimento']);

        // Validações básicas
        if (empty($nome) || empty($cpf) || empty($telefone)) {
            echo "0";
            exit;
        }

        // Verificar se o CPF já existe
        $sqlCheck = "SELECT COUNT(*) FROM tbPessoas WHERE cpf = :cpf";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bindParam(':cpf', $cpf);
        $stmtCheck->execute();

        if ($stmtCheck->fetchColumn() > 0) {
            echo "0"; // CPF já existe
            exit;
        }

        // Inserir colaborador
        $sql = "INSERT INTO tbPessoas (nome, cpf, telefone, nascimento, atualizado_por) VALUES (:nome, :cpf, :telefone, :nascimento, :atualizado_por)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':nascimento', !empty($nascimento) ? $nascimento : null);
        $stmt->bindParam(':atualizado_por', 1); // Usuario padrão

        if ($stmt->execute()) {
            $pessoa_id = $conn->lastInsertId();

            // Log da operação
            $log_msg = "Colaborador incluido: ID=$pessoa_id, Nome=$nome, CPF=$cpf";
            salvar_log($log_msg, 'inserir');

            echo "1"; // Sucesso
        } else {
            echo "0"; // Erro na inserção
        }
    } else {
        echo "0"; // Método inválido
    }
} catch (Exception $e) {        // Log do erro
    $log_msg = "Erro ao incluir colaborador: " . $e->getMessage();
    salvar_log($log_msg, 'geral');
    echo "0";
}
