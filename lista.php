<?php 
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}
require_once "includes/conexao.php";

// Defina o número de itens por página
$itens_por_pagina = 10;

// Obtenha o número total de feedbacks
$total_feedbacks = $conn->query("SELECT COUNT(*) FROM feedbacks")->fetchColumn();

// Calcule o número total de páginas
$total_paginas = ceil($total_feedbacks / $itens_por_pagina);

// Obtenha a página atual
$pagina_atual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? $_GET['pagina'] : 1;
$pagina_atual = max(1, min($pagina_atual, $total_paginas));

// Calcule o índice do primeiro item da página atual
$offset = ($pagina_atual - 1) * $itens_por_pagina;

// Busque os feedbacks da página atual
$stmt = $conn->prepare("SELECT f.*, c.nome, c.cargo FROM feedbacks f JOIN colaboradores c ON f.colaborador_id = c.id ORDER BY f.data DESC LIMIT :limit OFFSET :offset");
$stmt->bindParam(':limit', $itens_por_pagina, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
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
    <h2>Feedbacks recebidos</h2>
    <table>
        <tr>
            <th>Colaborador</th>
            <th>Cargo</th>
            <th>Texto</th>
            <th>Nota</th>
            <th>Data</th>
        </tr>
        <?php foreach ($feedbacks as $feedback) {?>
            <tr>
                <td><?php echo htmlspecialchars($feedback['nome']); ?></td>
                <td><?php echo htmlspecialchars($feedback['cargo']); ?></td>
                <td><?php echo htmlspecialchars($feedback['texto']); ?></td>
                <td><?php echo htmlspecialchars($feedback['nota']); ?></td>
                <td><?php echo htmlspecialchars($feedback['data']); ?></td>
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