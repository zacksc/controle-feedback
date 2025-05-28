-- Script de log para operações de edição/consulta
-- Projeto: Sistema de Controle de Feedback
-- Database: feedback_colaboradores

-- Logs de consultas para edição de usuários
SELECT usuario_id, nome, login, senha, atualizado_em, atualizado_por 
FROM tbUsuarios WHERE usuario_id = ?;

-- Logs de consultas para edição de pessoas/colaboradores  
SELECT pessoa_id, nome, cpf, telefone, nascimento, pessoa_tipo_id, atualizado_por, atualizado_em 
FROM tbPessoas WHERE pessoa_id = ?;

-- Logs de consultas para edição de feedbacks
SELECT feedback_id, datahora, cliente_id, produto_id, observacao, atualizado_por 
FROM tbFeedback WHERE feedback_id = ?;

-- Logs de consultas para edição de itens/produtos
SELECT item_id, nome FROM tbItem WHERE item_id = ?;

-- Logs de consultas para edição de avaliações
SELECT avaliacao_id, item_id, nota, feedback_id, atualizado_por, atualizado_em 
FROM tbAvaliacao WHERE avaliacao_id = ?;
