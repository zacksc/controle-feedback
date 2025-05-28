<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario_id = intval($_POST['pUsuario_id']);

        if ($usuario_id <= 0) {
            echo "0";
            exit;
        }

        // Buscar dados do usuário antes de excluir (para log)
        $sqlSelect = "SELECT nome, login FROM tbUsuarios WHERE usuario_id = :usuario_id";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':usuario_id', $usuario_id);
        $stmtSelect->execute();
        $usuario = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "0"; // Usuário não encontrado
            exit;
        }

        // Verificar se o usuário pode ser excluído (não tem feedbacks relacionados)
        $sqlCheckFeedback = "SELECT COUNT(*) FROM tbFeedback WHERE usuario_id = :usuario_id";
        $stmtCheckFeedback = $conn->prepare($sqlCheckFeedback);
        $stmtCheckFeedback->bindParam(':usuario_id', $usuario_id);
        $stmtCheckFeedback->execute();

        if ($stmtCheckFeedback->fetchColumn() > 0) {
            echo "0"; // Usuário tem feedbacks relacionados, não pode ser excluído
            exit;
        }

        // Excluir usuário
        $sql = "DELETE FROM tbUsuarios WHERE usuario_id = :usuario_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            // Log da operação
            $log_msg = "Usuario excluido: ID=$usuario_id, Nome={$usuario['nome']}, Login={$usuario['login']}";
            salvar_log($log_msg, 'excluir');

            echo "1"; // Sucesso
        } else {
            echo "0"; // Erro na exclusão
        }
    } else {
        echo "0"; // Método inválido
    }
} catch (Exception $e) {        // Log do erro
    $log_msg = "Erro ao excluir usuario: " . $e->getMessage();
    salvar_log($log_msg, 'geral');
    echo "0";
}
