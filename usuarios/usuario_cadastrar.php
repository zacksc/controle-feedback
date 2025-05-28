<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>            
</head>

<style>
    /* Estilos específicos para páginas de formulários */
    body {
        background: rgb(230,255,245);
        background: radial-gradient(circle, rgba(230,255,245,1) 0%, rgba(182,229,222,1) 50%, rgba(122,186,177,1) 100%);
    }
    
    .form-container {
        background-color: #ffffff;
        border-radius: 25px;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 600px;
        margin: 20px auto;
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
    }
    
    .form-title {
        color: #0d473f;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }
    
    .form-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to right, #4CB8C4, #3CD3AD);
    }
    
    .form-control-custom {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-custom:focus {
        border-color: #4CB8C4;
        box-shadow: 0 0 0 0.2rem rgba(76, 184, 196, 0.25);
    }
    
    .form-label-custom {
        color: #0d473f;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .btn-custom {
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-custom {
        background: linear-gradient(to right, #4CB8C4, #3CD3AD);
        color: white;
    }
    
    .btn-secondary-custom {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
</style>

<script language='JavaScript'>
    function salvar() 
    {
        $.ajax({
            url: 'usuario_salvar.php',
            type: 'POST',
            data: $('#form_usuario').serialize(),
            success: function(data) {
                const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                if (cRetorno === "0") 
                {
                    alert("Erro na gravação!");
                } 
                else 
                {
                    alert("Usuário cadastrado com sucesso!");
                    window.location.href = "usuario_listar.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                alert("Erro na requisição: " + textStatus + " - " + errorThrown);                
            }
        });
    }

    function voltar()
    {
        window.location.href = "usuario_listar.php";            
    }

    function validarFormulario() 
    {
        const nome = document.getElementById('nome').value.trim();
        const login = document.getElementById('login').value.trim();
        const senha = document.getElementById('senha').value.trim();
        
        if (nome === '') {
            alert('O campo Nome é obrigatório!');
            document.getElementById('nome').focus();
            return false;
        }
        
        if (login === '') {
            alert('O campo Login é obrigatório!');
            document.getElementById('login').focus();
            return false;
        }
        
        if (senha === '') {
            alert('O campo Senha é obrigatório!');
            document.getElementById('senha').focus();
            return false;
        }
        
        if (senha.length < 6) {
            alert('A senha deve ter pelo menos 6 caracteres!');
            document.getElementById('senha').focus();
            return false;
        }
        
        return true;
    }

    function salvarValidando() 
    {
        if (validarFormulario()) {
            salvar();
        }
    }
</script>

<body>
<div class="form-container">
    <div class="form-header">
        <h1 class="form-title">
            <div class="form-icon">
                <i class="fas fa-user-plus icon" style="color: white;"></i>
            </div>
            Cadastrar Usuário
        </h1>
    </div>
    
    <form id="form_usuario" method="POST">
        <div class="mb-4">
            <label for="nome" class="form-label form-label-custom">Nome Completo</label>
            <input type="text" class="form-control form-control-custom" id="nome" name="nome" maxlength="100" required placeholder="Digite o nome completo">
        </div>
        
        <div class="mb-4">
            <label for="login" class="form-label form-label-custom">Login</label>
            <input type="text" class="form-control form-control-custom" id="login" name="login" maxlength="50" required placeholder="Digite o login">
        </div>
        
        <div class="mb-4">
            <label for="senha" class="form-label form-label-custom">Senha</label>
            <input type="password" class="form-control form-control-custom" id="senha" name="senha" maxlength="255" required placeholder="Digite a senha (mínimo 6 caracteres)">
        </div>
        
        <div class="form-actions">
            <button type="button" class="btn-custom btn-primary-custom" onclick="salvarValidando()">
                <i class="fas fa-save"></i> Salvar
            </button>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="voltar()">
                <i class="fas fa-arrow-left"></i> Voltar
            </button>
        </div>
    </form>
</div>
</body>
</html>
