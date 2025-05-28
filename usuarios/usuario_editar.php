<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
    $usuario_id = isset($_GET['usuario_id']) ? intval($_GET['usuario_id']) : 0;
    
    if ($usuario_id <= 0) {
        header("Location: usuario_listar.php");
        exit;
    }
    
    // Buscar dados do usuário
    $sql = "SELECT usuario_id, nome, login FROM tbUsuarios WHERE usuario_id = :usuario_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        header("Location: usuario_listar.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>            
</head>

<script language='JavaScript'>
    function salvar() 
    {
        $.ajax({
            url: 'usuario_alterar.php',
            type: 'POST',
            data: $('#form_usuario').serialize(),
            success: function(data) {
                const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                if (cRetorno === "0") 
                {
                    alert("Erro na alteração!");
                } 
                else 
                {
                    alert("Usuário alterado com sucesso!");
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
        
        const senha = document.getElementById('senha').value.trim();
        if (senha !== '' && senha.length < 6) {
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

<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Editar Usuário</h3>
    
    <form id="form_usuario" method="POST">
        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($usuario['usuario_id']); ?>">
        
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" maxlength="100" 
                           value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" maxlength="50" 
                           value="<?php echo htmlspecialchars($usuario['login']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                    <input type="password" class="form-control" id="senha" name="senha" maxlength="255">
                </div>
            </div>
            
            <div class="card-footer">
                <button type="button" class="btn btn-success" onclick="salvarValidando()">Salvar</button>
                <button type="button" class="btn btn-secondary" onclick="voltar()">Voltar</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
