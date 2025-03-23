<?php 
require_once "includes/conexao.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $colaborador_id = $_POST["colaborador_id"];
    $texto = $_POST["texto"];
    $nota = $_POST["nota"];

    $stmt = $conn->prepare("INSERT INTO feedbacks (colaborador_id, texto, nota) VALUES (:colaborador_id, :texto, :nota)");
    $stmt->bindParam(":colaborador_id", $colaborador_id);
    $stmt->bindParam(":texto", $texto); 
    $stmt->bindParam(":nota", $nota);
    $stmt->execute();
    
    $sucesso = "Feedback enviado com sucesso!!";
}

$colaboradores = $conn->query("SELECT * FROM colaboradores")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container controle">
    <h2>Envie seu Feedback</h2>
    <?php if(isset($sucesso)) echo "<p>$sucesso</p>";?>
    <form method="post">
        <select name="colaborador_id" required>
            <option value="">Selecione um colaborador</option>
            <?php foreach ($colaboradores as $colaborador) {?>
                <option value="<?php echo $colaborador['id']?>">
                    <?php echo $colaborador['nome']; ?>
                </option>
                <?php }?>
        </select><br><br>
        <textarea name="texto" placeholder="Digite seu feedback" required></textarea><br><br>
        <div class="input-group">
                <label>Nota</label>
                <div class="rating">
                    <input type="radio" id="star5" name="nota" value="5" required>
                    <label for="star5">★</label>
                    <input type="radio" id="star4" name="nota" value="4">
                    <label for="star4">★</label>
                    <input type="radio" id="star3" name="nota" value="3">
                    <label for="star3">★</label>
                    <input type="radio" id="star2" name="nota" value="2">
                    <label for="star2">★</label>
                    <input type="radio" id="star1" name="nota" value="1">
                    <label for="star1">★</label>
                </div>
            </div>
        <input type="submit" value="Enviar" class="button-lista">
    </form>
    <a href="index.php" class="button-voltar">Voltar</a>
    </div>
</body>
</html>