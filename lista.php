<?php 
session_start();
if(!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}
require_once "includes/conexao.php";

$feedbacks = $conn->query("SELECT f.*, c.nome, c.cargo FROM feedbacks f JOIN colaboradores c ON f.colaborador_id = c.id ORDER BY f.data DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista</title>
    <link rel="stylesheet" href="css/style.css">
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
                <td><?php echo $feedback['nome']; ?></td>
                <td><?php echo $feedback['cargo']; ?></td>
                <td><?php echo $feedback['texto']; ?></td>
                <td><?php echo $feedback['nota']; ?></td>
                <td><?php echo $feedback['data']; ?></td>
            </tr>
            <?php }?>
    </table>
    <a href="index.php" class="button-voltar">Voltar</a>
    </div>
    
</body>
</html>