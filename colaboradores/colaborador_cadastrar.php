<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Colaborador</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>            
</head>

<style>
    /* Estilos específicos para páginas de módulos */
    body {
        background: rgb(230,255,245);
        background: radial-gradient(circle, rgba(230,255,245,1) 0%, rgba(182,229,222,1) 50%, rgba(122,186,177,1) 100%);
    }
    
    .module-container {
        background-color: #ffffff;
        border-radius: 25px;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
    }
    
    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
    }
    
    .module-title {
        color: #0d473f;
        font-size: 2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .module-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #ff9a56, #ff6b35);
    }
    
    .form-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #e9ecef;
    }
    
    .btn-custom {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }
    
    .btn-custom-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }
    
    .btn-custom-success:hover {
        background: linear-gradient(135deg, #218838, #1aa085);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-custom-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }
    
    .btn-custom-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #343a40);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }
    
    .form-label {
        color: #0d473f;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: border-color 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #4CB8C4;
        box-shadow: 0 0 0 0.2rem rgba(76, 184, 196, 0.25);
    }
</style>

<script language='JavaScript'>
    function salvar() 
    {
        $.ajax({
            url: 'colaborador_salvar.php',
            type: 'POST',
            data: $('#form_colaborador').serialize(),
            success: function(data) {
                const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                if (cRetorno === "0") 
                {
                    alert("Erro na gravação!");
                } 
                else 
                {
                    alert("Colaborador cadastrado com sucesso!");
                    window.location.href = "colaborador_listar.php";
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
        window.location.href = "colaborador_listar.php";            
    }    function validarFormulario() 
    {
        const nome = document.getElementById('nome').value.trim();
        const cpf = document.getElementById('cpf').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        const nascimento = document.getElementById('nascimento').value.trim();
        
        if (nome === '') {
            alert('O campo Nome é obrigatório!');
            document.getElementById('nome').focus();
            return false;
        }
        
        if (cpf === '') {
            alert('O campo CPF é obrigatório!');
            document.getElementById('cpf').focus();
            return false;
        }
        
        // Validação básica de CPF (11 dígitos)
        const cpfNumeros = cpf.replace(/\D/g, '');
        if (cpfNumeros.length !== 11) {
            alert('CPF deve ter 11 dígitos!');
            document.getElementById('cpf').focus();
            return false;
        }
        
        if (telefone === '') {
            alert('O campo Telefone é obrigatório!');
            document.getElementById('telefone').focus();
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
<div class="module-container">
    <div class="module-header">
        <h1 class="module-title">
            <div class="module-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            Cadastro de Colaborador
        </h1>
    </div>
    
    <div class="form-container">
        <form id="form_colaborador" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="200" required>
            </div>
            
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" required>
            </div>
            
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" maxlength="20" required>
            </div>
            
            <div class="mb-3">
                <label for="nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="nascimento" name="nascimento">
            </div>
            
            <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn-custom btn-custom-success" onclick="salvarValidando()">
                    <i class="fas fa-save"></i> Salvar
                </button>
                <button type="button" class="btn-custom btn-custom-secondary" onclick="voltar()">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
