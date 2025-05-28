-- Script de log para operações de exclusão
-- Projeto: Sistema de Controle de Feedback
-- Database: feedback_colaboradores

-- Logs de exclusões de usuários
DELETE FROM tbUsuarios WHERE usuario_id = ?;

-- Logs de exclusões de pessoas/colaboradores
DELETE FROM tbPessoas WHERE pessoa_id = ?;

-- Logs de exclusões de feedbacks (cascata com avaliações)
DELETE FROM tbAvaliacao WHERE feedback_id = ?;
DELETE FROM tbFeedback WHERE feedback_id = ?;

-- Logs de exclusões de itens/produtos
DELETE FROM tbItem WHERE item_id = ?;

-- Logs de exclusões de avaliações
DELETE FROM tbAvaliacao WHERE avaliacao_id = ?;
-- [2025-05-28 04:24:15] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Sa
Feedback excluido: ID=1, Pessoa=João Silva, Item=Atendimento, Data=10:00:00

