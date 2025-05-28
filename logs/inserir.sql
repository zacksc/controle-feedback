-- Script de log para operações de inserção/atualização
-- Projeto: Sistema de Controle de Feedback
-- Database: feedback_colaboradores

-- Logs de inserção de usuários
INSERT INTO tbUsuarios (nome, login, senha, atualizado_por, atualizado_em) 
VALUES (?, ?, ?, ?, NOW());

-- Logs de atualização de usuários
UPDATE tbUsuarios 
SET nome = ?, login = ?, senha = ?, atualizado_por = ?, atualizado_em = NOW() 
WHERE usuario_id = ?;

-- Logs de inserção de pessoas/colaboradores
INSERT INTO tbPessoas (nome, cpf, telefone, nascimento, pessoa_tipo_id, atualizado_por, atualizado_em) 
VALUES (?, ?, ?, ?, ?, ?, CURDATE());

-- Logs de atualização de pessoas/colaboradores
UPDATE tbPessoas 
SET nome = ?, cpf = ?, telefone = ?, nascimento = ?, pessoa_tipo_id = ?, atualizado_por = ?, atualizado_em = CURDATE() 
WHERE pessoa_id = ?;

-- Logs de inserção de feedbacks
INSERT INTO tbFeedback (datahora, cliente_id, produto_id, observacao, atualizado_por) 
VALUES (NOW(), ?, ?, ?, ?);

-- Logs de inserção de avaliações
INSERT INTO tbAvaliacao (item_id, nota, feedback_id, atualizado_por, atualizado_em) 
VALUES (?, ?, ?, ?, NOW());

-- Logs de inserção de itens/produtos
-- INSERT INTO tbItem (nome, atualizado_por) VALUES (?, ?)
-- [2025-05-28 04:31:10] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Sa
Feedback enviado: ID=4, Cliente=3, Produto=1

