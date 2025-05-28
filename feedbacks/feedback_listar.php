<?php
    include_once '../inc/funcoes.php';
    require_once '../inc/conexao.php';
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Feedbacks</title>
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
        width: 95%;
        max-width: 1400px;
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
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    
    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .btn-custom-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }
    
    .btn-custom-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    
    .btn-custom-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }
    
    .btn-custom-danger:hover {
        background: linear-gradient(135deg, #c82333, #a71e2a);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }
    
    .btn-custom-dark {
        background: linear-gradient(135deg, #343a40, #23272b);
        color: white;
    }
    
    .btn-custom-dark:hover {
        background: linear-gradient(135deg, #23272b, #1c2025);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 58, 64, 0.3);
    }
    
    .btn-custom-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }
    
    .btn-custom-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }
    
    .table-container {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        font-weight: 600;
        padding: 15px;
    }
    
    .table tbody tr {
        transition: background-color 0.3s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table tbody td {
        padding: 15px;
        border-color: #e9ecef;
        vertical-align: middle;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        color: white;
        transition: all 0.3s ease;
    }
      .btn-info:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
        transform: translateY(-1px);
    }
      .star-rating {
        color: #ffc107;
        font-size: 14px;
        display: inline-block;
        line-height: 1;
    }
    
    .star-rating .fa-star {
        margin-right: 1px;
    }
      .star-rating .empty-star {
        color: #e9ecef;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }
      .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border: none;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            margin: 2% auto;
            max-height: 95vh;
        }
        
        .modal-header {
            padding: 15px 20px;
        }
        
        .modal-title {
            font-size: 1.3rem;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .detail-label {
            min-width: auto;
            margin-bottom: 5px;
        }
        
        .avaliacoes-container {
            grid-template-columns: 1fr;
        }
    }
    
    @keyframes modalSlideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px 30px;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-title {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.3s;
    }
    
    .close:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .modal-body {
        padding: 30px;
        max-height: 70vh;
        overflow-y: auto;
    }
    
    .detail-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #667eea;
    }
    
    .detail-section h4 {
        color: #667eea;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .detail-row {
        display: flex;
        margin-bottom: 10px;
        align-items: center;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
        min-width: 120px;
        margin-right: 15px;
    }
    
    .detail-value {
        color: #212529;
    }
    
    .loading {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }
    
    .loading i {
        font-size: 2rem;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .avaliacoes-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .avaliacao-item {
        background: white;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        text-align: center;
    }
    
    .avaliacao-stars {
        color: #ffc107;
        font-size: 1.2rem;
        margin: 10px 0;
    }
</style>

<script language='JavaScript'>
    function incluir()
    {
        window.location.href = "feedback_enviar.php";            
    }

    function sair()
    {
        window.location.href = "../index.php";            
    }

    function voltar()
    {
        window.location.href = "../index.php";            
    }

    function excluir()
    {
        var checkboxes = document.querySelectorAll('input[name="check_id"]:checked');
        var selectedValues = [];

        checkboxes.forEach(function(checkbox) 
        {
            selectedValues.push(checkbox.value);
        });

        if (checkboxes.length === 0) 
        {
            alert("Nenhum feedback foi selecionado.");
        } 
        else if (checkboxes.length > 1) 
        {
            alert("Selecione somente um feedback.");
        } 
        else 
        {
            if (confirm("Tem certeza que deseja excluir este item?"))
            {
                $.ajax({
                    url: 'feedback_excluir.php',
                    type: 'POST',
                    data: { pFeedback_id: selectedValues[0] },
                    success: function(data) {
                        const cRetorno = data.replace(/(<([^>]+)>)/ig, '').trim();
                        if (cRetorno === "0") 
                        {
                            alert("Erro na exclusão!");
                        } 
                        else 
                        {
                            alert("Exclusão realizada com sucesso!");
                            location.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) 
                    {
                        alert("Erro na requisição: " + textStatus + " - " + errorThrown);                
                    }
                });
            }
        }
    }       function exibirDetalhes(feedback_id) {
        const modal = document.getElementById('detalhesModal');
        const modalBody = document.getElementById('modalBody');
        
        // Mostrar modal com loading
        modalBody.innerHTML = '<div class="loading"><i class="fas fa-spinner"></i><br>Carregando detalhes...</div>';
        modal.style.display = 'block';
        
        // Carregar dados via AJAX
        fetch('feedback_detalhes_ajax.php?feedback_id=' + feedback_id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    modalBody.innerHTML = data.html;
                } else {
                    modalBody.innerHTML = '<div class="alert alert-danger">Erro ao carregar detalhes: ' + data.message + '</div>';
                }
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Erro de conexão. Tente novamente.</div>';
                console.error('Erro:', error);
            });
    }
    
    function fecharModal() {
        document.getElementById('detalhesModal').style.display = 'none';
    }
      // Fechar modal clicando fora dele
    window.onclick = function(event) {
        const modal = document.getElementById('detalhesModal');
        if (event.target === modal) {
            fecharModal();
        }
    }
    
    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            fecharModal();
        }
    });
    
    // Melhorar responsividade do modal
    window.addEventListener('resize', function() {
        const modal = document.getElementById('detalhesModal');
        if (modal.style.display === 'block') {
            // Ajustar altura do modal se necessário
            const modalContent = modal.querySelector('.modal-content');
            const maxHeight = window.innerHeight * 0.9;
            modalContent.style.maxHeight = maxHeight + 'px';
        }
    });
</script><body>
<div class="module-container">
    <div class="module-header">
        <h1 class="module-title">
            <div class="module-icon">
                <i class="fas fa-comments"></i>
            </div>
            Gerenciar Feedbacks
        </h1>
    </div>
    
    <div class="action-buttons">
        <button type="button" class="btn-custom btn-custom-primary" onclick="incluir()">
            <i class="fas fa-plus"></i> Enviar Feedback
        </button>
        <button type="button" class="btn-custom btn-custom-danger" onclick="excluir()">
            <i class="fas fa-trash"></i> Excluir
        </button>
        <button type="button" class="btn-custom btn-custom-warning" onclick="voltar()">
            <i class="fas fa-arrow-left"></i> Voltar
        </button>
        <button type="button" class="btn-custom btn-custom-dark" onclick="sair()">
            <i class="fas fa-sign-out-alt"></i> Sair
        </button>
    </div>
    
    <div class="table-container">
        <table class="table table-striped">
            <thead>                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Data/Hora</th>
                    <th>Colaborador</th>
                    <th>Produto</th>
                    <th>Avaliação</th>
                    <th>Observação</th>
                    <th style="width: 120px;">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaFeedbacks"><?php                $sql = "SELECT f.feedback_id, f.datahora, f.observacao, 
                               p.nome as nome_pessoa, 
                               i.nome as nome_item,
                               ROUND(AVG(a.nota), 1) as media_nota
                        FROM tbFeedback f
                        LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
                        LEFT JOIN tbItem i ON f.produto_id = i.item_id
                        LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
                        GROUP BY f.feedback_id, f.datahora, f.observacao, p.nome, i.nome
                        ORDER BY f.datahora DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($result) > 0) 
                {
                    foreach ($result as $row)                    {
                        $feedback_id = htmlspecialchars($row['feedback_id']);
                        $datahora = htmlspecialchars($row['datahora']);
                        $nome_pessoa = htmlspecialchars($row['nome_pessoa']);
                        $nome_item = htmlspecialchars($row['nome_item']);                        $media_nota = $row['media_nota'];
                        $observacao = htmlspecialchars(substr($row['observacao'], 0, 50)) . (strlen($row['observacao']) > 50 ? '...' : '');
                          // Gerar estrelas em PHP (sistema de 10 estrelas)
                        $stars_html = '';
                        if ($media_nota && $media_nota > 0) {
                            $fullStars = floor($media_nota);
                            $emptyStars = 10 - $fullStars;
                            
                            for ($i = 0; $i < $fullStars; $i++) {
                                $stars_html .= '<i class="fas fa-star"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                $stars_html .= '<i class="far fa-star empty-star"></i>';
                            }
                            $stars_html = '<span class="star-rating">' . $stars_html . '</span> <small>(' . $media_nota . '/10)</small>';
                        } else {
                            $stars_html = '<span class="text-muted">Sem avaliação</span>';
                        }
                        
                          echo '<tr>';
                        echo '<td><input type="checkbox" id="id" name="check_id" value="'.$feedback_id.'" style="transform: scale(1.2);"></td>';                            
                        echo '<td>' . date('d/m/Y H:i', strtotime($datahora)) . '</td>';
                        echo '<td>' . $nome_pessoa . '</td>';
                        echo '<td>' . $nome_item . '</td>';
                        echo '<td>' . $stars_html . '</td>';
                        echo '<td>' . $observacao . '</td>';
                        echo '<td><button class="btn btn-sm btn-info" onclick="exibirDetalhes(' . $feedback_id . ')"><i class="fas fa-eye"></i> Detalhes</button></td>';
                        echo '</tr>';
                    }
                }
                else                {
                    echo '<tr>';
                    echo '<td>0</td>';
                    echo '<td>Tabela vazia</td>';
                    echo '<td>Nenhum registro encontrado</td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '<td>-</td>';
                    echo '</tr>';
                }?>
        </tbody>    </table>
    </div>
</div>

<!-- Modal para Detalhes do Feedback -->
<div id="detalhesModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">
                <i class="fas fa-eye"></i> Detalhes do Feedback
            </h2>
            <button class="close" onclick="fecharModal()">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
            <div class="loading">
                <i class="fas fa-spinner"></i><br>
                Carregando detalhes...
            </div>
        </div>
    </div>
</div>

</body>
</html>
