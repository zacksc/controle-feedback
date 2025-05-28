<?php
include_once 'inc/funcoes.php';
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Feedback</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="inner-container">
        <h2 class="index-title">Controle de Feedback</h2>
        <div class="index-cards">
            <a href="usuarios/usuario_listar.php" class="index-card">
                <div class="icon-container gradient-user-plus">
                    <i class="fas fa-user-plus icon"></i>
                </div>
                <h3>Gerenciar Usuários</h3>
                <p>Gerencie usuários administradores do sistema.</p>
                <div class="gradient-line gradient-user-plus"></div>
            </a>
            <a href="colaboradores/colaborador_listar.php" class="index-card">
                <div class="icon-container gradient-users">
                    <i class="fas fa-users icon"></i>
                </div>
                <h3>Gerenciar Colaboradores</h3>
                <p>Gerencie colaboradores que podem enviar feedbacks.</p>
                <div class="gradient-line gradient-users"></div>
            </a>
            <a href="feedbacks/feedback_enviar.php" class="index-card">
                <div class="icon-container gradient-star">
                    <i class="fas fa-star icon"></i>
                </div>
                <h3>Enviar Feedback</h3>
                <p>Espaço onde colaboradores podem fazer seus feedbacks!</p>
                <div class="gradient-line gradient-star"></div>
            </a>
            <a href="feedbacks/feedback_listar.php" class="index-card">
                <div class="icon-container gradient-list">
                    <i class="fas fa-list icon"></i>
                </div>
                <h3>Listar Feedbacks</h3>
                <p>Visualize de forma organizada os feedbacks dos colaboradores.</p>
                <div class="gradient-line gradient-list"></div>
            </a>
        </div>
        <a href="logout.php" class="button-sair"> <i class="fas fa-sign-out-alt"></i> Sair</a>
    </div>
</body>

</html>