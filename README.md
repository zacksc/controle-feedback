# Controle de Feedback de Colaboradores

## Visão Geral
O **Controle de Feedback de Colaboradores** é um sistema web desenvolvido para gerenciar feedbacks de colaboradores de uma empresa. Ele permite que administradores cadastrem colaboradores, enviem feedbacks com notas e comentários, e visualizem uma lista de todos os feedbacks registrados. O projeto foi criado como parte de um aprendizado prático em desenvolvimento web, com foco em **PHP, MySQL, HTML, CSS** e **hospedagem de aplicações**.

O sistema está hospedado no **ProFreeHost** e pode ser acessado em: [seufeedback.unaux.com](http://seufeedback.unaux.com).

> **Nota:** O site está em HTTP, pois enfrentamos limitações ao tentar configurar HTTPS com o Cloudflare devido ao controle restrito do domínio raiz `unaux.com` pelo ProFreeHost.

## Funcionalidades
- **Login de Administrador:** O sistema possui uma página de login para administradores *(usuário: admin, senha: admin)*.
- **Cadastro de Colaboradores:** Permite cadastrar novos colaboradores com seus nomes.
- **Envio de Feedback:** Os administradores podem enviar feedbacks para os colaboradores, incluindo uma nota *(de 1 a 5 estrelas)* e um comentário.
- **Lista de Feedbacks:** Exibe uma tabela com todos os feedbacks registrados, incluindo o nome do colaborador, a nota, o comentário e a data do feedback.
- **Logout:** Os administradores podem sair do sistema, encerrando a sessão.
- **Design Responsivo:** O layout foi ajustado para ser responsivo, funcionando bem em dispositivos móveis e desktops.

## Tecnologias Utilizadas
- **PHP:** Para a lógica do backend, incluindo autenticação, manipulação de formulários e interação com o banco de dados.
- **MySQL:** Banco de dados relacional para armazenar informações de usuários, colaboradores e feedbacks.
- **HTML e CSS:** Para a estrutura e o estilo das páginas, com foco em um design simples e responsivo.
- **PDO (PHP Data Objects):** Para consultas seguras ao banco de dados, prevenindo SQL Injection.
- **ProFreeHost:** Hospedagem gratuita usada para implantar o sistema online.

## Estrutura do Projeto
```
controle-feedback/
├── css/
│   └── style.css           # Estilos do site, incluindo design responsivo
├── includes/
│   └── conexao.php         # Arquivo de conexão com o banco de dados MySQL
├── media/
│   └── Login.png           # Imagem usada na página de login
├── login.php               # Página de login para administradores
├── index.php               # Página inicial com opções de cadastro, feedback e lista
├── cadastro.php            # Página para cadastrar novos colaboradores
├── feedback.php            # Página para enviar feedbacks
├── lista.php               # Página que lista todos os feedbacks
└── logout.php              # Script para encerrar a sessão
```

## Tabelas do Banco de Dados
- **usuarios:** Armazena os dados dos administradores *(id, username, password).*
- **colaboradores:** Armazena os nomes dos colaboradores *(id, nome).*
- **feedbacks:** Armazena os feedbacks *(id, colaborador_id, nota, texto, data).*

## O Que Eu Aprendi
### Desenvolvimento Web com PHP e MySQL:
- Criar um sistema web completo, do **frontend** *(HTML/CSS)* ao **backend** *(PHP/MySQL).*
- Usar **PDO** para consultas seguras ao banco de dados, prevenindo SQL Injection.
- Implementar **autenticação de usuários** com sessões PHP `session_start(), $_SESSION`.

### Design Responsivo:
- Ajustar o **CSS** para tornar o site responsivo usando **flexbox**, **media queries** e **rolagem horizontal** em tabelas.
- Testar o layout em diferentes dispositivos para garantir uma boa experiência de usuário.

### Hospedagem e Implantação:
- Configurar arquivos e permissões no **ProFreeHost** *(ex.: 755 para pastas, 644 para arquivos)*.
- Importar o banco de dados via **phpMyAdmin** e ajustar `conexao.php` com as credenciais.

### Resolução de Problemas:
- Corrigir erro de conexão com o banco de dados *(SQLSTATE[HY000] [1045] Access denied)*.
- Resolver problema de login *("Usuário ou senha inválidos")* depurando com `echo` para encontrar falhas na autenticação.

### Tentativa de Configurar HTTPS com Cloudflare:
- Tentei adicionar HTTPS, mas encontrei limitações devido à falta de controle sobre o domínio raiz `unaux.com`.
- Aprendi sobre **registros DNS** *(A, CNAME)* e as diferenças entre **Full Setup** e **CNAME Setup** no Cloudflare.
- Descobri alternativas como hospedagens gratuitas que **suportam HTTPS nativamente** *(ex.: AwardSpace, GoogieHost).*

### Boas Práticas:
- Fazer **backups regulares** do banco de dados e arquivos.
- **Criptografar senhas** com `password_hash()` e `password_verify()` para melhorar a segurança *(ainda não implementado).*

## Como Executar o Projeto Localmente
### Pré-requisitos:
- Servidor local com **PHP** *(ex.: XAMPP, WAMP).*
- **MySQL** instalado.

### Configuração:
1. **Clone o repositório:**
```bash
git clone https://github.com/seu-usuario/controle-feedback.git
```
2. **Coloque a pasta** `controle-feedback` **na pasta do servidor local** *(ex.: htdocs no XAMPP).*
3. **Crie o banco de dados:**
   - Acesse o **phpMyAdmin** e crie um banco chamado `controle_feedback`.
   - Importe o arquivo `controle_feedback.sql`.
4. **Configure a conexão com o banco:**
   - Abra `includes/conexao.php` e ajuste as credenciais:
   ```php
   $host = "localhost";
   $username = "root";
   $password = ""; // Senha do MySQL (geralmente vazia no XAMPP)
   $db = "controle_feedback";
   ```
5. **Acesse o site:**
   - Inicie o servidor local *(Apache e MySQL no XAMPP).*  
   - Acesse: [http://localhost/controle-feedback/login.php](http://localhost/controle-feedback/login.php).
   - Faça login *(usuário: admin, senha: admin).*  

## Melhorias Futuras
- **Criptografia de Senhas:** Implementar `password_hash()` e `password_verify()` para segurança.
- **HTTPS:** Migrar para uma hospedagem que suporte HTTPS nativamente *(ex.: AwardSpace).*
- **Validação de Formulários:** Adicionar validação no lado do servidor para evitar entradas inválidas.
- **Melhorias no Design:** Adicionar mais estilos e animações.
- **Testes:** Implementar testes unitários para garantir a funcionalidade.

## Licença
Este projeto é de uso educacional e está licenciado sob a **MIT License** *(LICENSE).*

## Contato
Se tiver dúvidas ou sugestões, entre em contato comigo pelo **GitHub** ou **e-mail**: [ezequielsantoscoutinho@gmail.com](mailto:ezequielsantoscoutinho@gmail.com).

