<?php
include_once 'inc/funcoes.php';
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}
require_once "inc/conexao.php";

$pessoas = $conn->query("SELECT * FROM tbPessoas")->fetchAll(PDO::FETCH_ASSOC);
$itens = $conn->query("SELECT * FROM tbItem")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST["cliente_id"];
    $produto_id = $_POST["produto_id"];
    $observacao = trim($_POST["observacao"]);
    $notas = $_POST["nota"];
    $datahora = date('H:i:s');

    if (empty($observacao) || empty($notas)) {
        $mensagem = "Preencha todos os campos.";
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tbFeedback WHERE cliente_id = :cliente_id AND observacao = :observacao");
        $stmt->bindParam(":cliente_id", $cliente_id);
        $stmt->bindParam(":observacao", $observacao);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $mensagem = "Este feedback já foi enviado.";
        } else {
            $stmt = $conn->prepare("INSERT INTO tbFeedback (datahora, cliente_id, produto_id, observacao, atualizado_por) VALUES (:datahora, :cliente_id, :produto_id, :observacao, :atualizado_por)");
            $stmt->bindParam(":datahora", $datahora);
            $stmt->bindParam(":cliente_id", $cliente_id);
            $stmt->bindParam(":produto_id", $produto_id);
            $stmt->bindParam(":observacao", $observacao);
            $stmt->bindParam(":atualizado_por", $_SESSION["usuario_id"]);
            $stmt->execute();

            $feedback_id = $conn->lastInsertId();

            foreach ($notas as $item_id => $nota) {
                $stmt = $conn->prepare("INSERT INTO tbAvaliacao (item_id, nota, feedback_id, atualizado_por) VALUES (:item_id, :nota, :feedback_id, :atualizado_por)");
                $stmt->bindParam(":item_id", $item_id);
                $stmt->bindParam(":nota", $nota);
                $stmt->bindParam(":feedback_id", $feedback_id);
                $stmt->bindParam(":atualizado_por", $_SESSION["usuario_id"]);
                $stmt->execute();
            }

            $mensagem = "Feedback enviado com sucesso!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container controle">
        <h2>Envie seu Feedback</h2>
        <?php if (!empty($mensagem)): ?>
            <p><?php echo $mensagem; ?></p>
        <?php endif; ?>
        <form method="post">
            <select name="cliente_id" required>
                <option value="">Selecione um colaborador</option>
                <?php foreach ($pessoas as $pessoa) { ?>
                    <option value="<?php echo $pessoa['pessoa_id'] ?>">
                        <?php echo $pessoa['nome']; ?>
                    </option>
                <?php } ?>
            </select><br><br>
            <select name="produto_id" required>
                <option value="">Selecione um produto</option>
                <?php foreach ($itens as $item) { ?>
                    <option value="<?php echo $item['item_id'] ?>">
                        <?php echo $item['nome']; ?>
                    </option>
                <?php } ?>
            </select><br><br>
            <?php foreach ($itens as $item) { ?>
                <div class="input-group">
                    <label><?php echo $item['nome']; ?></label>
                    <div class="rating">
                        <input type="radio" id="star5_<?php echo $item['item_id']; ?>" name="nota[<?php echo $item['item_id']; ?>]" value="5" required>
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
            <?php } ?>
            <textarea name="observacao" placeholder="Digite seu feedback" required></textarea><br><br>
            <input type="submit" value="Enviar" class="button-lista">
        </form>
        <a href="index.php" class="button-voltar">Voltar</a>
    </div>
</body>

</html>