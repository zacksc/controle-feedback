<?php
header('Content-Type: application/json');
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

$response = ['success' => false, 'message' => '', 'html' => ''];

try {
    if (!isset($_GET['feedback_id']) || empty($_GET['feedback_id'])) {
        throw new Exception('ID do feedback não fornecido');
    }

    $feedback_id = intval($_GET['feedback_id']);

    if ($feedback_id <= 0) {
        throw new Exception('ID do feedback inválido');
    }

    // Buscar dados do feedback
    $sql = "SELECT f.feedback_id, f.datahora, f.observacao, 
                   p.nome as nome_pessoa, p.cpf, p.telefone,
                   i.nome as nome_item
            FROM tbFeedback f
            LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
            LEFT JOIN tbItem i ON f.produto_id = i.item_id
            WHERE f.feedback_id = :feedback_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':feedback_id', $feedback_id);
    $stmt->execute();
    $feedback = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$feedback) {
        throw new Exception('Feedback não encontrado');
    }

    // Buscar avaliações do feedback
    $sql_avaliacoes = "SELECT a.nota, i.nome as nome_item
                       FROM tbAvaliacao a
                       LEFT JOIN tbItem i ON a.item_id = i.item_id
                       WHERE a.feedback_id = :feedback_id
                       ORDER BY i.nome";
    $stmt_avaliacoes = $conn->prepare($sql_avaliacoes);
    $stmt_avaliacoes->bindParam(':feedback_id', $feedback_id);
    $stmt_avaliacoes->execute();
    $avaliacoes = $stmt_avaliacoes->fetchAll(PDO::FETCH_ASSOC);

    // Calcular média das avaliações
    $media_geral = 0;
    if (count($avaliacoes) > 0) {
        $soma = array_sum(array_column($avaliacoes, 'nota'));
        $media_geral = round($soma / count($avaliacoes), 1);
    }

    // Gerar HTML para o modal
    $html = '
    <div class="detail-section">
        <h4><i class="fas fa-info-circle"></i> Informações do Feedback</h4>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-hashtag"></i> ID:</span>
            <span class="detail-value">' . htmlspecialchars($feedback['feedback_id']) . '</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-clock"></i> Data/Hora:</span>
            <span class="detail-value">' . date('d/m/Y H:i:s', strtotime($feedback['datahora'])) . '</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-box"></i> Produto:</span>
            <span class="detail-value">' . htmlspecialchars($feedback['nome_item']) . '</span>
        </div>
    </div>
    
    <div class="detail-section">
        <h4><i class="fas fa-user"></i> Dados do Colaborador</h4>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-user-circle"></i> Nome:</span>
            <span class="detail-value">' . htmlspecialchars($feedback['nome_pessoa']) . '</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-id-card"></i> CPF:</span>
            <span class="detail-value">' . htmlspecialchars($feedback['cpf']) . '</span>
        </div>
        <div class="detail-row">
            <span class="detail-label"><i class="fas fa-phone"></i> Telefone:</span>
            <span class="detail-value">' . htmlspecialchars($feedback['telefone'] ?? 'Não informado') . '</span>
        </div>
    </div>';

    if (count($avaliacoes) > 0) {
        $html .= '
        <div class="detail-section">
            <h4><i class="fas fa-star"></i> Avaliações</h4>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-chart-line"></i> Média Geral:</span>
                <span class="detail-value">
                    <span class="star-rating">';

        // Gerar estrelas para a média
        for ($i = 1; $i <= 10; $i++) {
            if ($i <= $media_geral) {
                $html .= '<i class="fas fa-star"></i>';
            } else {
                $html .= '<i class="far fa-star empty-star"></i>';
            }
        }

        $html .= '</span> (' . $media_geral . '/10)
                </span>
            </div>
            <div class="avaliacoes-container">';

        foreach ($avaliacoes as $avaliacao) {
            $html .= '
                <div class="avaliacao-item">
                    <strong>' . htmlspecialchars($avaliacao['nome_item']) . '</strong>
                    <div class="avaliacao-stars">';

            // Gerar estrelas para cada avaliação
            for ($i = 1; $i <= 10; $i++) {
                if ($i <= $avaliacao['nota']) {
                    $html .= '<i class="fas fa-star"></i>';
                } else {
                    $html .= '<i class="far fa-star empty-star"></i>';
                }
            }

            $html .= '</div>
                    <div>Nota: ' . $avaliacao['nota'] . '/10</div>
                </div>';
        }

        $html .= '</div></div>';
    }

    if (!empty($feedback['observacao'])) {
        $html .= '
        <div class="detail-section">
            <h4><i class="fas fa-comment"></i> Observações</h4>
            <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef; line-height: 1.6;">
                ' . nl2br(htmlspecialchars($feedback['observacao'])) . '
            </div>
        </div>';
    }

    $response['success'] = true;
    $response['html'] = $html;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
