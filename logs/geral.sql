-- Script de log para operações gerais
-- Projeto: Sistema de Controle de Feedback
-- Database: feedback_colaboradores

-- Logs de operações gerais do sistema
-- Consultas de relatórios e estatísticas gerais

-- Relatório geral de feedbacks
SELECT COUNT(*) as total_feedbacks, 
       AVG(a.nota) as media_geral,
       DATE(f.datahora) as data_feedback
FROM tbFeedback f
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY DATE(f.datahora)
ORDER BY data_feedback DESC;

-- Estatísticas por colaborador
SELECT p.nome, COUNT(f.feedback_id) as total_feedbacks, AVG(a.nota) as media_notas
FROM tbPessoas p
LEFT JOIN tbFeedback f ON p.pessoa_id = f.cliente_id
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY p.pessoa_id, p.nome
ORDER BY media_notas DESC;

-- Estatísticas por produto/item
SELECT i.nome, COUNT(f.feedback_id) as total_feedbacks, AVG(a.nota) as media_notas
FROM tbItem i
LEFT JOIN tbFeedback f ON i.item_id = f.produto_id
LEFT JOIN tbAvaliacao a ON f.feedback_id = a.feedback_id
GROUP BY i.item_id, i.nome
ORDER BY media_notas DESC;
