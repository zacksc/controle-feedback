<?php
include_once '../inc/funcoes.php';
require_once '../inc/conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<style>
    /* Estilos específicos para páginas de módulos */
    body {
        background: rgb(230, 255, 245);
        background: radial-gradient(circle, rgba(230, 255, 245, 1) 0%, rgba(182, 229, 222, 1) 50%, rgba(122, 186, 177, 1) 100%);
    }

    .module-container {
        background-color: #ffffff;
        border-radius: 25px;
        padding: 40px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        width: 90%;
        max-width: 1200px;
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
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to right, #4CB8C4, #3CD3AD);
    }

    .module-actions {
        display: flex;
        gap: 10px;
    }

    .btn-custom {
        border-radius: 8px;
        padding: 10px 20px;
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

    .btn-danger-custom {
        background-color: #dc3545;
        color: white;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .table-container {
        background-color: #f8f9fa;
        border-radius: 15px;
        padding: 20px;
        overflow-x: auto;
    }

    .table-custom {
        margin: 0;
    }

    .table-custom thead th {
        background-color: #0d473f;
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }

    .table-custom tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .table-custom tbody tr:hover {
        background-color: #e8f5e8;
    }
</style>

<script language='JavaScript'>
    function incluir() {
        window.location.href = "usuario_cadastrar.php";
    }

    function sair() {
        window.location.href = "../index.php";
    }

    function voltar() {
        window.location.href = "../index.php";
    }

    function excluir() {
        var checkboxes = document.querySelectorAll('input[name="check_id"]:checked');
        var selectedValues = [];

        checkboxes.forEach(function(checkbox) {
            selectedValues.push(checkbox.value);
        });

        if (checkboxes.length === 0) {
            alert("Nenhum usuário foi selecionado.");
        } else if (checkboxes.length > 1) {
            alert("Selecione somente um usuário.");
        } else {
            if (confirm("Tem certeza que deseja excluir este item?")) {
                $.ajax({
                    url: 'usuario_excluir.php',
                    type: 'POST',
                    data: {
                        pUsuario_id: selectedValues[0]
                    },
                    success: function(data) {
                        const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                        if (cRetorno === "0") {
                            alert("Erro na exclusão!");
                        } else {
                            alert("Exclusão realizada com sucesso!");
                            location.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Erro na requisição: " + textStatus + " - " + errorThrown);
                    }
                });
            }
        }
    }
</script>

<body>
    <div class="module-container">
        <div class="module-header">
            <h1 class="module-title">
                <div class="module-icon">
                    <i class="fas fa-users icon" style="color: white;"></i>
                </div>
                Gerenciar Usuários
            </h1>
            <div class="module-actions">
                <button type="button" class="btn-custom btn-primary-custom" onclick="incluir()">
                    <i class="fas fa-plus"></i> Incluir
                </button>
                <button type="button" class="btn-custom btn-danger-custom" onclick="excluir()">
                    <i class="fas fa-trash"></i> Excluir
                </button>
                <button type="button" class="btn-custom btn-secondary-custom" onclick="voltar()">
                    <i class="fas fa-arrow-left"></i> Voltar
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">Selecionar</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th style="width: 100px;">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaUsuarios">
                    <?php
                    $sql = "SELECT usuario_id, nome, login FROM tbUsuarios ORDER BY nome";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($result) > 0) {
                        foreach ($result as $row) {
                            $usuario_id = htmlspecialchars($row['usuario_id']);
                            $nome = htmlspecialchars($row['nome']);
                            $login = htmlspecialchars($row['login']);

                            echo '<tr>';
                            echo '<td><input type="checkbox" id="id" name="check_id" value="' . $usuario_id . '" class="form-check-input"></td>';
                            echo '<td>' . $nome . '</td>';
                            echo '<td>' . $login . '</td>';
                            echo '<td><a href="usuario_editar.php?usuario_id=' . $usuario_id . '" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr>';
                        echo '<td colspan="4" class="text-center text-muted">Nenhum usuário cadastrado</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>