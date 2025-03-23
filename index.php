<?php 
session_start();
if (!isset($_SESSION["loggedin"])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de feedback</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
</head>
<body>
    <div class="container controle">
    <h2 class="controle-feedback">Controle de Feedback</h2>
    <div class="lista">
    <p><a href="cadastro.php" class="button-lista"><i class="fas fa-users"></i> Cadastrar Colaborador</a></p>
    <p><a href="feedback.php" class="button-lista"><i class="fas fa-star"></i> Enviar Feedback</a></p>
    <p><a href="lista.php" class="button-lista"><i class="fas fa-list"></i> Listar Feedbacks</a></p>
    <p><a href="logout.php" class="button-sair"> <i class="fas fa-sign-out-alt"></i> Sair</a></p>

    </div>
    
    </div>
</body>
</html>