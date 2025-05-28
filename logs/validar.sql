-- Script de log para operações de validação e autenticação
-- Projeto: Sistema de Controle de Feedback
-- Database: feedback_colaboradores

-- Logs de validação de login
SELECT usuario_id, nome, login, senha FROM tbUsuarios WHERE login = ? AND senha = ?;

-- Logs de verificação de existência de usuário
SELECT COUNT(*) AS existe FROM tbUsuarios WHERE login = ?;

-- Logs de verificação de existência de CPF
SELECT COUNT(*) AS existe FROM tbPessoas WHERE cpf = ?;

-- Logs de verificação de duplicidade de feedback
SELECT COUNT(*) AS existe FROM tbFeedback WHERE cliente_id = ? AND observacao = ?;

-- Logs de verificação de dados para relatórios
SELECT COUNT(*) AS total FROM tbFeedback WHERE DATE(datahora) = CURDATE();
SELECT COUNT(*) AS total FROM tbPessoas WHERE atualizado_por = ?;

-- Logs de autenticação específica
SELECT usuario_id, nome, login FROM tbUsuarios WHERE login = 'admin';

-- [2025-05-28 04:19:22] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Sa
SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = 'admin'

-- [2025-05-28 04:36:09] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.100.2 Chrome
SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = 'admin'

-- [2025-05-28 04:36:14] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.100.2 Chrome
SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = 'admin'

-- [2025-05-28 04:43:30] IP: ::1 | User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Sa
SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = 'admin'

