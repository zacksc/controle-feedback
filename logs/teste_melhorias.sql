-- ============================================
-- SCRIPT DE TESTE PARA VALIDAR AS MELHORIAS
-- Sistema de Controle de Feedback
-- Data: 27 de Maio de 2025
-- ============================================

-- 1. TESTE: Verificar se a consulta de detalhes funciona sem erro PDO
-- (Sem o campo 'cargo' que causava erro)
SELECT f.feedback_id, f.datahora, f.observacao, 
       p.nome as nome_pessoa, p.cpf, p.telefone,
       i.nome as nome_item
FROM tbFeedback f
LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
LEFT JOIN tbItem i ON f.produto_id = i.item_id
WHERE f.feedback_id = 1;

-- 2. TESTE: Verificar consulta da listagem com avaliações por estrelas
SELECT f.feedback_id, f.datahora, f.observacao, 
       p.nome as nome_pessoa, 
       i.nome as nome_item,
       ROUND(AVG(a.nota), 1) as media_nota,
       COUNT(a.avaliacao_id) as total_avaliacoes
FROM tbFeedback f
LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
LEFT JOIN tbItem i ON f.produto_id = i.item_id
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY f.feedback_id, f.datahora, f.observacao, p.nome, i.nome
ORDER BY f.datahora DESC;

-- 3. TESTE: Verificar estrutura da tabela tbPessoas (confirmar ausência de 'cargo')
DESCRIBE tbPessoas;

-- 4. TESTE: Inserir dados de exemplo para testar as estrelas
INSERT INTO tbPessoas (nome, cpf, telefone, nascimento) 
VALUES ('Teste Usuário', '111.111.111-11', '(11) 91234-5678', '1990-01-01');

INSERT INTO tbFeedback (datahora, cliente_id, produto_id, observacao, atualizado_por) 
VALUES ('10:30:00', LAST_INSERT_ID(), 1, 'Feedback de teste para validar sistema', 1);

INSERT INTO tbAvaliacao (item_id, nota, feedback_id, atualizado_por) 
VALUES (1, 8, LAST_INSERT_ID(), 1);
VALUES (2, 9, LAST_INSERT_ID(), 1);

-- 5. TESTE: Consulta de estatísticas gerais (do arquivo geral.sql)
SELECT COUNT(*) as total_feedbacks, 
       AVG(a.nota) as media_geral,
       DATE(f.datahora) as data_feedback
FROM tbFeedback f
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY DATE(f.datahora)
ORDER BY data_feedback DESC;

-- ============================================
-- RESULTADOS ESPERADOS:
-- ============================================
-- ✅ Consulta 1: Deve retornar dados sem erro PDO
-- ✅ Consulta 2: Deve mostrar média das notas por feedback
-- ✅ Consulta 3: Deve mostrar que tbPessoas não tem campo 'cargo'
-- ✅ Consulta 4: Deve inserir dados de teste com sucesso
-- ✅ Consulta 5: Deve mostrar estatísticas gerais funcionando

-- Se todos os testes passarem, as melhorias foram implementadas com sucesso!
