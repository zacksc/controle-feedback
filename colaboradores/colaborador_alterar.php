<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
    try {        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pessoa_id = intval($_POST['pessoa_id']);
            $nome = trim($_POST['nome']);
            $cpf = trim($_POST['cpf']);
            $nascimento = trim($_POST['nascimento']);
            $telefone = trim($_POST['telefone']);
            $cargo = trim($_POST['cargo']);
            
            // Validações básicas
            if ($pessoa_id <= 0 || empty($nome) || empty($cpf) || empty($nascimento) || empty($telefone) || empty($cargo)) {
                echo "0";
                exit;
            }
            
            // Verificar se o CPF já existe para outro colaborador
            $sqlCheck = "SELECT COUNT(*) FROM tbPessoas WHERE cpf = :cpf AND pessoa_id != :pessoa_id";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':cpf', $cpf);
            $stmtCheck->bindParam(':pessoa_id', $pessoa_id);
            $stmtCheck->execute();
            
            if ($stmtCheck->fetchColumn() > 0) {
                echo "0"; // CPF já existe para outro colaborador
                exit;
            }
            
            // Atualizar colaborador
            $sql = "UPDATE tbPessoas SET nome = :nome, cpf = :cpf, nascimento = :nascimento, telefone = :telefone, cargo = :cargo WHERE pessoa_id = :pessoa_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':nascimento', $nascimento);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':cargo', $cargo);
            $stmt->bindParam(':pessoa_id', $pessoa_id);
            
            if ($stmt->execute()) {
                // Log da operação
                $log_msg = "Colaborador alterado: ID=$pessoa_id, Nome=$nome, CPF=$cpf, Cargo=$cargo";
                salvar_log($log_msg, 'editar');
                
                echo "1"; // Sucesso
            } else {
                echo "0"; // Erro na atualização
            }
        } else {
            echo "0"; // Método inválido
        }
    } catch (Exception $e) {        // Log do erro
        $log_msg = "Erro ao alterar colaborador: " . $e->getMessage();
        salvar_log($log_msg, 'geral');
        echo "0";
    }
?>
