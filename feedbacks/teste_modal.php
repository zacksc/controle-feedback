<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Teste Modal - Sistema de Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .test-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .test-btn {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 5px;
        }

        .test-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
        }

        .status {
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="test-container">
        <h1><i class="fas fa-vial"></i> Teste do Sistema Modal</h1>
        <p>Use os botões abaixo para testar o sistema de popup modal dos detalhes de feedback:</p>

        <div>
            <button class="test-btn" onclick="testarModal(1)">
                <i class="fas fa-eye"></i> Testar Modal - Feedback ID 1
            </button>

            <button class="test-btn" onclick="testarModal(999)">
                <i class="fas fa-exclamation-triangle"></i> Testar Erro - ID Inexistente
            </button>

            <button class="test-btn" onclick="window.location.href='feedback_listar.php'">
                <i class="fas fa-list"></i> Ir para Listagem Completa
            </button>
        </div>

        <div id="status"></div>

        <h3>Funcionalidades Implementadas:</h3>
        <ul>
            <li>✅ Modal popup responsivo</li>
            <li>✅ Carregamento via AJAX</li>
            <li>✅ Exibição de avaliações com estrelas</li>
            <li>✅ Fechamento por ESC, clique fora ou botão X</li>
            <li>✅ Animações suaves</li>
            <li>✅ Layout responsivo para mobile</li>
            <li>✅ Tratamento de erros</li>
        </ul>

        <h3>Melhorias vs. Sistema Anterior:</h3>
        <ul>
            <li>🚫 <strong>Antes:</strong> Redirecionava para página separada</li>
            <li>✅ <strong>Agora:</strong> Popup modal que não quebra o layout</li>
            <li>🚫 <strong>Antes:</strong> Perdia o contexto da listagem</li>
            <li>✅ <strong>Agora:</strong> Mantém a listagem visível ao fundo</li>
            <li>🚫 <strong>Antes:</strong> Navegação lenta</li>
            <li>✅ <strong>Agora:</strong> Carregamento instantâneo via AJAX</li>
        </ul>
    </div>

    <script>
        function testarModal(feedbackId) {
            const statusDiv = document.getElementById('status');
            statusDiv.innerHTML = '<div class="status"><i class="fas fa-spinner fa-spin"></i> Testando carregamento do modal...</div>';

            // Simular o carregamento via AJAX
            fetch('feedback_detalhes_ajax.php?feedback_id=' + feedbackId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusDiv.innerHTML = '<div class="status success"><i class="fas fa-check-circle"></i> ✅ Modal carregado com sucesso! O conteúdo seria exibido no popup.</div>';
                    } else {
                        statusDiv.innerHTML = '<div class="status error"><i class="fas fa-exclamation-circle"></i> ❌ Erro esperado: ' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    statusDiv.innerHTML = '<div class="status error"><i class="fas fa-times-circle"></i> ❌ Erro de conexão: ' + error.message + '</div>';
                });
        }
    </script>
</body>

</html>