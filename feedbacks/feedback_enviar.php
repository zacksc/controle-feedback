<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

// Buscar pessoas e itens para os selects
$pessoas = $conn->query("SELECT * FROM tbPessoas ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$itens = $conn->query("SELECT * FROM tbItem ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST["cliente_id"];
    $produto_id = $_POST["produto_id"];
    $observacao = trim($_POST["observacao"]);
    $notas = $_POST["nota"];
    $datahora = date('H:i:s');
    $atualizado_por = 1; // Para compatibilidade, pode ser obtido da sessão

    if (empty($observacao) || empty($notas)) {
        $mensagem = "Preencha todos os campos.";
    } else {
        // Verificar se já existe feedback similar
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbFeedback WHERE cliente_id = :cliente_id AND observacao = :observacao");
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->bindParam(":observacao", $observacao);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $mensagem = "Este feedback já foi enviado.";
        } else {
            try {
                $conn->beginTransaction();

                // Inserir feedback
                $stmt = $conn->prepare("INSERT INTO tbFeedback (datahora, cliente_id, produto_id, observacao, atualizado_por) VALUES (:datahora, :cliente_id, :produto_id, :observacao, :atualizado_por)");
                $stmt->bindParam(":datahora", $datahora);
                $stmt->bindParam(":cliente_id", $cliente_id);
                $stmt->bindParam(":produto_id", $produto_id);
                $stmt->bindParam(":observacao", $observacao);
                $stmt->bindParam(":atualizado_por", $atualizado_por);
                $stmt->execute();

                $feedback_id = $conn->lastInsertId();

                // Inserir avaliações
                foreach ($notas as $item_id => $nota) {
                    $stmt = $conn->prepare("INSERT INTO tbAvaliacao (item_id, nota, feedback_id, atualizado_por) VALUES (:item_id, :nota, :feedback_id, :atualizado_por)");
                    $stmt->bindParam(":item_id", $item_id);
                    $stmt->bindParam(":nota", $nota);
                    $stmt->bindParam(":feedback_id", $feedback_id);
                    $stmt->bindParam(":atualizado_por", $atualizado_por);
                    $stmt->execute();
                }

                $conn->commit();
                // Log da operação
                $log_msg = "Feedback enviado: ID=$feedback_id, Cliente=$cliente_id, Produto=$produto_id";
                salvar_log($log_msg, 'inserir');

                $mensagem = "Feedback enviado com sucesso!";
            } catch (Exception $e) {
                $conn->rollback();
                $log_msg = "Erro ao enviar feedback: " . $e->getMessage();
                salvar_log($log_msg, 'geral');
                $mensagem = "Erro ao enviar feedback.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Enviar Feedback</title>
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
        padding: 30px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 700px;
        margin: 20px auto;
    }

    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .module-title {
        color: #0d473f;
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .module-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    .form-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #e9ecef;
    }

    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }

    .btn-custom-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .btn-custom-success:hover {
        background: linear-gradient(135deg, #218838, #1aa085);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
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

    .form-label {
        color: #0d473f;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 10px 12px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4CB8C4;
        box-shadow: 0 0 0 0.2rem rgba(76, 184, 196, 0.25);
    }

    .rating-section {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
    }

    .rating-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .rating-item:last-child {
        border-bottom: none;
    }

    .rating-label {
        font-weight: 600;
        color: #0d473f;
        flex: 1;
        font-size: 0.9rem;
    }

    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 2px;
        flex-wrap: wrap;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        width: 20px;
        height: 20px;
        display: block;
        background: #e9ecef;
        color: #6c757d;
        font-size: 14px;
        text-align: center;
        line-height: 20px;
        transition: all 0.3s;
        border-radius: 50%;
    }

    .rating label:hover,
    .rating label:hover~label,
    .rating input:checked~label {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #fff;
        transform: scale(1.1);
    }

    .alert {
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: none;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1, #b8daff);
        color: #0c5460;
        border-left: 4px solid #17a2b8;
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
                    <i class="fas fa-paper-plane"></i>
                </div>
                Enviar Feedback
            </h1>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>
        <div class="form-container">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_id" class="form-label">
                            <i class="fas fa-user"></i> Colaborador
                        </label>
                        <select name="cliente_id" id="cliente_id" class="form-select" required>
                            <option value="">Selecione um colaborador</option>
                            <?php foreach ($pessoas as $pessoa): ?>
                                <option value="<?php echo $pessoa['pessoa_id']; ?>">
                                    <?php echo htmlspecialchars($pessoa['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="produto_id" class="form-label">
                            <i class="fas fa-box"></i> Produto
                        </label>
                        <select name="produto_id" id="produto_id" class="form-select" required>
                            <option value="">Selecione um produto</option>
                            <?php foreach ($itens as $item): ?>
                                <option value="<?php echo $item['item_id']; ?>">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-star"></i> Avaliações por Item
                    </label>
                    <div class="rating-section"> <?php foreach ($itens as $item): ?>
                            <div class="rating-item">
                                <div class="rating-label"><?php echo htmlspecialchars($item['nome']); ?></div>
                                <div class="rating">
                                    <input type="radio" id="star10_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="10" required>
                                    <label for="star10_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star9_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="9">
                                    <label for="star9_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star8_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="8">
                                    <label for="star8_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star7_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="7">
                                    <label for="star7_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star6_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="6">
                                    <label for="star6_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star5_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="5">
                                    <label for="star5_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star4_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="4">
                                    <label for="star4_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star3_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="3">
                                    <label for="star3_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star2_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="2">
                                    <label for="star2_<?php echo $item['item_id']; ?>">★</label>
                                    <input type="radio" id="star1_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="1">
                                    <label for="star1_<?php echo $item['item_id']; ?>">★</label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="observacao" class="form-label">
                        <i class="fas fa-comment"></i> Observações
                    </label>
                    <textarea name="observacao" id="observacao" class="form-control" rows="3" placeholder="Digite seu feedback detalhado..." required></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-custom btn-custom-success">
                        <i class="fas fa-paper-plane"></i> Enviar Feedback
                    </button>
                    <button type="button" class="btn-custom btn-custom-secondary" onclick="voltar()">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>