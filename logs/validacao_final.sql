-- SCRIPT DE VALIDAÇÃO FINAL
-- Verificar se sistema está funcionando corretamente
-- Data: 27/05/2025

-- 1. TESTAR CONSULTA DE FEEDBACKS COM AVALIAÇÕES
SELECT 
    f.feedback_id,
    f.datahora,
    p.nome as colaborador,
    i.nome as produto,
    ROUND(AVG(a.nota), 1) as media_avaliacao,
    f.observacao
FROM tbFeedback f
LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id  
LEFT JOIN tbItem i ON f.produto_id = i.item_id
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY f.feedback_id, f.datahora, p.nome, i.nome, f.observacao
ORDER BY f.datahora DESC
LIMIT 5;

-- 2. VERIFICAR ESCALA DE AVALIAÇÕES (deve ser 1-10)
SELECT 
    MIN(nota) as nota_minima,
    MAX(nota) as nota_maxima,
    COUNT(*) as total_avaliacoes
FROM tbAvaliacao;

-- 3. TESTAR DETALHES DE UM FEEDBACK ESPECÍFICO
SELECT 
    f.*,
    p.nome as colaborador,
    p.cpf,
    p.telefone,
    i.nome as produto
FROM tbFeedback f
LEFT JOIN tbPessoas p ON f.cliente_id = p.pessoa_id
LEFT JOIN tbItem i ON f.produto_id = i.item_id
WHERE f.feedback_id = (SELECT MIN(feedback_id) FROM tbFeedback)
LIMIT 1;

-- 4. LISTAR AVALIAÇÕES POR ITEM
SELECT 
    i.nome as item,
    a.nota,
    f.feedback_id
FROM tbAvaliacao a
LEFT JOIN tbItem i ON a.item_id = i.item_id  
LEFT JOIN tbFeedback f ON a.feedback_id = f.feedback_id
WHERE f.feedback_id = (SELECT MIN(feedback_id) FROM tbFeedback)
ORDER BY i.nome;

-- RESULTADO ESPERADO:
-- ✅ Todas as consultas devem retornar dados válidos
-- ✅ Notas devem estar no range 1-10
-- ✅ Médias devem ser calculadas corretamente  
-- ✅ Não deve haver erros de SQL

-- SE TUDO FUNCIONAR: Sistema validado com sucesso! ✅
