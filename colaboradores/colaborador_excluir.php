<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pessoa_id = intval($_POST['pPessoa_id']);

        if ($pessoa_id <= 0) {
            echo "0";
            exit;
        }
        // Buscar dados do colaborador antes de excluir (para log)
        $sqlSelect = "SELECT nome, cpf, cargo FROM tbPessoas WHERE pessoa_id = :pessoa_id";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':pessoa_id', $pessoa_id);
        $stmtSelect->execute();
        $colaborador = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!$colaborador) {
            echo "0"; // Colaborador não encontrado
            exit;
        }

        // Verificar se o colaborador pode ser excluído (não tem feedbacks relacionados)
        $sqlCheckFeedback = "SELECT COUNT(*) FROM tbFeedback WHERE pessoa_id = :pessoa_id";
        $stmtCheckFeedback = $conn->prepare($sqlCheckFeedback);
        $stmtCheckFeedback->bindParam(':pessoa_id', $pessoa_id);
        $stmtCheckFeedback->execute();

        if ($stmtCheckFeedback->fetchColumn() > 0) {
            echo "0"; // Colaborador tem feedbacks relacionados, não pode ser excluído
            exit;
        }

        // Excluir colaborador
        $sql = "DELETE FROM tbPessoas WHERE pessoa_id = :pessoa_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pessoa_id', $pessoa_id);
        if ($stmt->execute()) {
            // Log da operação
            $log_msg = "Colaborador excluido: ID=$pessoa_id, Nome={$colaborador['nome']}, CPF={$colaborador['cpf']}, Cargo={$colaborador['cargo']}";
            salvar_log($log_msg, 'excluir');

            echo "1"; // Sucesso
        } else {
            echo "0"; // Erro na exclusão
        }
    } else {
        echo "0"; // Método inválido
    }
} catch (Exception $e) {        // Log do erro
    $log_msg = "Erro ao excluir colaborador: " . $e->getMessage();
    salvar_log($log_msg, 'geral');
    echo "0";
}
