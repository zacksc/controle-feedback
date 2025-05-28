<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedback_id = intval($_POST['pFeedback_id']);
            
            if ($feedback_id <= 0) {
                echo "0";
                exit;
            }
              // Buscar dados do feedback antes de excluir (para log)
            $sqlSelect = "SELECT f.datahora, f.observacao, p.nome as nome_pessoa, i.nome as nome_item
                          FROM tbFeedback f
                          LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
                          LEFT JOIN tbItem i ON f.produto_id = i.item_id
                          WHERE f.feedback_id = :feedback_id";
            $stmtSelect = $conn->prepare($sqlSelect);
            $stmtSelect->bindParam(':feedback_id', $feedback_id);
            $stmtSelect->execute();
            $feedback = $stmtSelect->fetch(PDO::FETCH_ASSOC);
            
            if (!$feedback) {
                echo "0"; // Feedback não encontrado
                exit;
            }
            
            $conn->beginTransaction();
            
            // Excluir avaliações relacionadas
            $sqlDeleteAvaliacoes = "DELETE FROM tbAvaliacao WHERE feedback_id = :feedback_id";
            $stmtDeleteAvaliacoes = $conn->prepare($sqlDeleteAvaliacoes);
            $stmtDeleteAvaliacoes->bindParam(':feedback_id', $feedback_id);
            $stmtDeleteAvaliacoes->execute();
            
            // Excluir feedback
            $sql = "DELETE FROM tbFeedback WHERE feedback_id = :feedback_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':feedback_id', $feedback_id);
            
            if ($stmt->execute()) {
                $conn->commit();
                
                // Log da operação
                $log_msg = "Feedback excluido: ID=$feedback_id, Pessoa={$feedback['nome_pessoa']}, Item={$feedback['nome_item']}, Data={$feedback['datahora']}";
                salvar_log($log_msg, 'excluir');
                
                echo "1"; // Sucesso
            } else {
                $conn->rollback();
                echo "0"; // Erro na exclusão
            }
        } else {
            echo "0"; // Método inválido
        }
    } catch (Exception $e) {
        $conn->rollback();        // Log do erro
        $log_msg = "Erro ao excluir feedback: " . $e->getMessage();
        salvar_log($log_msg, 'geral');
        echo "0";
    }
?>
