<?php
include_once 'inc/funcoes.php';
require_once "inc/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<script language='JavaScript'>
    function validar() {
        $.ajax({
            url: 'login_validar.php',
            type: 'POST',
            data: $('#form_login').serialize(),
            success: function(data) {
                const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                if (cRetorno === "0") {
                    alert("Usuário ou senha inválidos!");
                } else if (cRetorno === "1") {
                    window.location.href = "index.php";
                } else {
                    alert("Erro no servidor. Resposta: " + cRetorno);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Erro na requisição: " + textStatus + " - " + errorThrown);
            }
        });
    }

    function validarFormulario() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (username === '') {
            alert('O campo Usuário é obrigatório!');
            document.getElementById('username').focus();
            return false;
        }

        if (password === '') {
            alert('O campo Senha é obrigatório!');
            document.getElementById('password').focus();
            return false;
        }

        return true;
    }

    function validarLogin() {
        if (validarFormulario()) {
            validar();
        }
    }
</script>

<body>
    <div class="container">
        <div class="imagem">
            <img src="media/Login.png" alt="">
        </div>
        <div class="login">
            <div class="titulo">
                <h2>Seja bem-vindo!</h2>
                <p>Faça seu login para fazer seu feedback.</p>
            </div>
            <div style="text-align: center; color: red; top: 0;" id="erro_msg">
            </div>
            <form id="form_login" method="post">
                <div class="input-group">
                    <label for="username">Usuário</label>
                    <input type="text" name="username" id="username" placeholder="exemplo@gmail.com" required>
                </div><br>
                <div class="input-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" placeholder="*****" required>
                </div>
                <input class="button" type="button" value="Entrar" onclick="validarLogin()">
            </form>
            <p style="text-align: center;">Não tem cadastro? <a href="signup.php">Faça seu cadastro.</a> </p>
        </div>
    </div>
</body>

</html>