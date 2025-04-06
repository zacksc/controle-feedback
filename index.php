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
    <div class="inner-container">
        <h2 class="index-title">Controle de Feedback</h2>
        <div class="index-cards">
            <a href="cadastro.php" class="index-card">
                <div class="icon-container gradient-users">
                    <i class="fas fa-users icon"></i>
                </div>
                <h3>Cadastrar colaborador</h3>
                <p>Faça o cadastro de colaboradores para que seja possível eles registrarem seus feedbacks.</p>
                <div class="gradient-line gradient-users"></div>
            </a>
            <a href="feedback.php" class="index-card">
                <div class="icon-container gradient-star">
                    <i class="fas fa-star icon"></i>
                </div>
                <h3>Enviar feedback</h3>
                <p>Espaço onde colaboradores podem fazer seus feedbacks!</p>
                <div class="gradient-line gradient-star"></div>
            </a>
            <a href="lista.php" class="index-card">
                <div class="icon-container gradient-list">
                    <i class="fas fa-list icon"></i>
                </div>
                <h3>Listar feedbacks</h3>
                <p>Visualize de forma organizada os feedbacks dos colaboradores.</p>
                <div class="gradient-line gradient-list"></div>
            </a>
        </div>
        <a href="logout.php" class="button-sair"> <i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>
</body>
</html>