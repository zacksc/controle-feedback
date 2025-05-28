<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
    $pessoa_id = isset($_GET['pessoa_id']) ? intval($_GET['pessoa_id']) : 0;
    
    if ($pessoa_id <= 0) {
        header("Location: colaborador_listar.php");
        exit;
    }
      // Buscar dados do colaborador
    $sql = "SELECT pessoa_id, nome, cpf, nascimento, telefone, cargo FROM tbPessoas WHERE pessoa_id = :pessoa_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':pessoa_id', $pessoa_id);
    $stmt->execute();
    $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$colaborador) {
        header("Location: colaborador_listar.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Colaborador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>            
</head>

<script language='JavaScript'>
    function salvar() 
    {
        $.ajax({
            url: 'colaborador_alterar.php',
            type: 'POST',
            data: $('#form_colaborador').serialize(),
            success: function(data) {
                const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                if (cRetorno === "0") 
                {
                    alert("Erro na alteração!");
                } 
                else 
                {
                    alert("Colaborador alterado com sucesso!");
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
        const cargo = document.getElementById('cargo').value.trim();
        
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
        
        if (telefone === '') {
            alert('O campo Telefone é obrigatório!');
            document.getElementById('telefone').focus();
            return false;
        }
        
        if (nascimento === '') {
            alert('O campo Data de Nascimento é obrigatório!');
            document.getElementById('nascimento').focus();
            return false;
        }
        
        if (cargo === '') {
            alert('O campo Cargo é obrigatório!');
            document.getElementById('cargo').focus();
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
    <h3 class="mb-4">Editar Colaborador</h3>
    
    <form id="form_colaborador" method="POST">
        <input type="hidden" name="pessoa_id" value="<?php echo htmlspecialchars($colaborador['pessoa_id']); ?>">
        
        <div class="card">
            <div class="card-body">                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" maxlength="100" 
                           value="<?php echo htmlspecialchars($colaborador['nome']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" 
                           value="<?php echo htmlspecialchars($colaborador['cpf']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" id="nascimento" name="nascimento" 
                           value="<?php echo htmlspecialchars($colaborador['nascimento']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" maxlength="20" 
                           value="<?php echo htmlspecialchars($colaborador['telefone']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text" class="form-control" id="cargo" name="cargo" maxlength="50" 
                           value="<?php echo htmlspecialchars($colaborador['cargo']); ?>" required>
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
