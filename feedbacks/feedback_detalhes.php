<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

$feedback_id = isset($_GET['feedback_id']) ? intval($_GET['feedback_id']) : 0;

if ($feedback_id <= 0) {
    header("Location: feedback_listar.php");
    exit;
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
    header("Location: feedback_listar.php");
    exit;
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
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<style>
    /* Estilos específicos para páginas de módulos */
    body {
        background: rgb(230, 255, 245);
        background: radial-gradient(circle, rgba(230, 255, 245, 1) 0%, rgba(182, 229, 222, 1) 50%, rgba(122, 186, 177, 1) 100%);
    }

    .module-container {
        background-color: #ffffff;
        border-radius: 25px;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
    }

    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
    }

    .module-title {
        color: #0d473f;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .module-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .details-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .btn-custom {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }

    .btn-custom-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #343a40);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #0d473f;
        width: 30%;
    }

    .info-value {
        color: #555;
        width: 65%;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 1.2em;
    }

    .rating-empty {
        color: #e9ecef;
        font-size: 1.2em;
    }

    .observations-box {
        background-color: #ffffff;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        min-height: 100px;
        line-height: 1.6;
    }
</style>

<script language='JavaScript'>
    function voltar() {
        window.location.href = "feedback_listar.php";
    }
</script>

<body>
    <div class="module-container">
        <div class="module-header">
            <h1 class="module-title">
                <div class="module-icon">
                    <i class="fas fa-eye"></i>
                </div>
                Detalhes do Feedback
            </h1>
        </div>

        <div class="details-container">
            <h4 class="mb-4" style="color: #0d473f;">
                <i class="fas fa-info-circle"></i> Informações Gerais
            </h4>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-calendar"></i> Data/Hora:
                </div>
                <div class="info-value">
                    <?php echo date('d/m/Y H:i:s', strtotime($feedback['datahora'])); ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-user"></i> Colaborador:
                </div>
                <div class="info-value">
                    <?php echo htmlspecialchars($feedback['nome_pessoa']); ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-id-card"></i> CPF:
                </div>
                <div class="info-value">
                    <?php echo htmlspecialchars($feedback['cpf']); ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-phone"></i> Telefone:
                </div>
                <div class="info-value">
                    <?php echo htmlspecialchars($feedback['telefone'] ?? 'Não informado'); ?>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">
                    <i class="fas fa-box"></i> Produto:
                </div>
                <div class="info-value">
                    <?php echo htmlspecialchars($feedback['nome_item']); ?>
                </div>
            </div>
        </div>

        <div class="details-container">
            <h4 class="mb-4" style="color: #0d473f;">
                <i class="fas fa-comment"></i> Observações
            </h4>
            <div class="observations-box">
                <?php echo nl2br(htmlspecialchars($feedback['observacao'])); ?>
            </div>
        </div>

        <div class="details-container">
            <h4 class="mb-4" style="color: #0d473f;">
                <i class="fas fa-star"></i> Avaliações por Item
            </h4>
            <?php if (count($avaliacoes) > 0): ?>
                <?php foreach ($avaliacoes as $avaliacao): ?>
                    <div class="info-row">
                        <div class="info-label">
                            <?php echo htmlspecialchars($avaliacao['nome_item']); ?>:
                        </div>
                        <div class="info-value">
                            <span style="font-weight: 600; margin-right: 10px;">
                                <?php echo $avaliacao['nota']; ?>/5
                            </span>
                            <?php
                            $nota = intval($avaliacao['nota']);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $nota) {
                                    echo '<span class="rating-stars">★</span>';
                                } else {
                                    echo '<span class="rating-empty">★</span>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #6c757d; text-align: center; font-style: italic;">
                    Nenhuma avaliação encontrada para este feedback.
                </p>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button type="button" class="btn-custom btn-custom-secondary" onclick="voltar()">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </div>
    </div>
</body>

</html>
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<style>
    /* Estilos específicos para páginas de módulos */
    body {
        background: rgb(230, 255, 245);
        background: radial-gradient(circle, rgba(230, 255, 245, 1) 0%, rgba(182, 229, 222, 1) 50%, rgba(122, 186, 177, 1) 100%);
    }

    .module-container {
        background-color: #ffffff;
        border-radius: 25px;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
    }

    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
    }

    .module-title {
        color: #0d473f;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .module-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .details-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .btn-custom {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }

    .btn-custom-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #343a40);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .info-card {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #667eea;
    }

    .star-rating {
        color: #ffc107;
        font-size: 20px;
    }

    .star-empty {
        color: #ddd;
    }
</style>

<script language='JavaScript'>
    function voltar() {
        window.location.href = "feedback_listar.php";
    }

    function gerarEstrelas(nota) {
        let estrelas = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= nota) {
                estrelas += '<span class="star-rating">★</span>';
            } else {
                estrelas += '<span class="star-empty">★</span>';
            }
        }
        return estrelas;
    }
</script>

<body class="bg-light">
    <div class="container mt-5">
        <h3 class="mb-4">Detalhes do Feedback</h3>

        <div class="card">
            <div class="card-header">
                <h5>Informações Gerais</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Data/Hora:</strong> <?php echo date('d/m/Y H:i:s', strtotime($feedback['datahora'])); ?></p>
                        <p><strong>Colaborador:</strong> <?php echo htmlspecialchars($feedback['nome_pessoa']); ?></p>
                        <p><strong>CPF:</strong> <?php echo htmlspecialchars($feedback['cpf']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($feedback['telefone'] ?? 'Não informado'); ?></p>
                        <p><strong>Produto:</strong> <?php echo htmlspecialchars($feedback['nome_item']); ?></p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Observações:</strong></p>
                        <div class="border p-3 bg-light">
                            <?php echo nl2br(htmlspecialchars($feedback['observacao'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Avaliações por Item</h5>
            </div>
            <div class="card-body">
                <?php if (count($avaliacoes) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nota</th>
                                    <th>Avaliação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($avaliacoes as $avaliacao): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($avaliacao['nome_item']); ?></td>
                                        <td><?php echo $avaliacao['nota']; ?>/5</td>
                                        <td>
                                            <?php
                                            $nota = intval($avaliacao['nota']);
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $nota) {
                                                    echo '<span class="star-rating">★</span>';
                                                } else {
                                                    echo '<span class="star-empty">★</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Nenhuma avaliação encontrada para este feedback.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" class="btn btn-secondary" onclick="voltar()">Voltar</button>
        </div>
    </div>
</body>

</html>