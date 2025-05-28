-- Script para limpeza de logs antigos
-- Projeto: Sistema de Controle de Feedback
-- Executar periodicamente para manter o tamanho dos logs controlado

-- COMANDOS DE BACKUP (Windows PowerShell)
-- Execute estes comandos no terminal antes da limpeza:

-- cd "c:\xampp\htdocs\controle-feedback\logs"
-- Copy-Item validar.sql "validar_backup_$(Get-Date -Format 'yyyy-MM-dd').sql"
-- Copy-Item inserir.sql "inserir_backup_$(Get-Date -Format 'yyyy-MM-dd').sql"
-- Copy-Item editar.sql "editar_backup_$(Get-Date -Format 'yyyy-MM-dd').sql"
-- Copy-Item excluir.sql "excluir_backup_$(Get-Date -Format 'yyyy-MM-dd').sql"
-- Copy-Item geral.sql "geral_backup_$(Get-Date -Format 'yyyy-MM-dd').sql"

-- COMANDOS DE LIMPEZA (Windows PowerShell)
-- Execute estes comandos para limpar os logs:

-- # Manter apenas cabeçalhos dos arquivos de log
-- Clear-Content validar.sql
-- Clear-Content inserir.sql
-- Clear-Content editar.sql
-- Clear-Content excluir.sql
-- Clear-Content geral.sql

-- # Ou para manter os últimos 100 registros de cada arquivo:
-- Get-Content validar.sql | Select-Object -Last 100 | Set-Content validar_temp.sql
-- Move-Item validar_temp.sql validar.sql

-- EXEMPLO DE USO:
-- 1. Abra PowerShell como administrador
-- 2. Navegue até a pasta logs: cd "c:\xampp\htdocs\controle-feedback\logs"
-- 3. Execute os comandos de backup acima
-- 4. Execute os comandos de limpeza conforme necessário

-- NOTA: Os logs são importantes para auditoria e debugging
-- SEMPRE fazer backup antes de limpar
