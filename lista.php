<?php 
include_once 'inc/funcoes.php';
if(!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}
require_once "inc/conexao.php";

$itens_por_pagina = 10;

$total_feedbacks = $conn->query("SELECT COUNT(*) FROM tbFeedback")->fetchColumn();

$total_paginas = ceil($total_feedbacks / $itens_por_pagina);

$pagina_atual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? $_GET['pagina'] : 1;
$pagina_atual = max(1, min($pagina_atual, $total_paginas));

$offset = ($pagina_atual - 1) * $itens_por_pagina;

$stmt = $conn->prepare("SELECT f.*, p.nome, u.login FROM tbFeedback f JOIN tbPessoas p ON f.cliente_id = p.pessoa_id JOIN tbUsuarios u ON f.atualizado_por = u.usuario_id ORDER BY f.feedback_id DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $itens_por_pagina, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$avaliacoes = [];
foreach ($feedbacks as $feedback) {
    $stmt = $conn->prepare("SELECT a.nota, i.nome AS item FROM tbAvaliacao a JOIN tbItem i ON a.item_id = i.item_id WHERE a.feedback_id = :feedback_id");
    $stmt->bindParam(':feedback_id', $feedback['feedback_id']);
    $stmt->execute();
    $avaliacoes[$feedback['feedback_id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .paginacao {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .paginacao a, .paginacao span {
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
        }
        .paginacao a:hover {
            background-color: #f0f0f0;
        }
        .paginacao .atual {
            background-color: #4CAF50;
            color: white;
        }
        .paginacao .disabled {
            color: #ccc;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container controle">
    <h2>Feedbacks Recebidos</h2>
    <table>
        <tr>
            <th>Colaborador</th>
            <th>Usuário</th>
            <th>Avaliações</th>
            <th>Observação</th>
            <th>Hora</th>
        </tr>
        <?php foreach ($feedbacks as $feedback) {?>
            <tr>
                <td><?php echo htmlspecialchars($feedback['nome']); ?></td>
                <td><?php echo htmlspecialchars($feedback['login']); ?></td>
                <td>
                    <?php
                    if (isset($avaliacoes[$feedback['feedback_id']])) {
                        foreach ($avaliacoes[$feedback['feedback_id']] as $avaliacao) {
                            echo htmlspecialchars($avaliacao['item']) . ": " . htmlspecialchars($avaliacao['nota']) . "★<br>";
                        }
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($feedback['observacao']); ?></td>
                <td><?php echo htmlspecialchars($feedback['datahora']); ?></td>
            </tr>
        <?php }?>
    </table>

    <div class="paginacao">
        <?php if ($total_paginas > 1): ?>
            <?php if ($pagina_atual > 1): ?>
                <a href="?pagina=<?php echo $pagina_atual - 1; ?>">Anterior</a>
            <?php else: ?>
                <span class="disabled">Anterior</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <?php if ($i == $pagina_atual): ?>
                    <span class="atual"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($pagina_atual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_atual + 1; ?>">Próxima</a>
            <?php else: ?>
                <span class="disabled">Próxima</span>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <a href="index.php" class="button-voltar">Voltar</a>
    </div>
</body>
</html>