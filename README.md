Controle de Feedback de Colaboradores
 Visão Geral
O Controle de Feedback de Colaboradores é um sistema web desenvolvido para gerenciar feedbacks de colaboradores de uma empresa. Ele permite que administradores cadastrem colaboradores, enviem feedbacks com notas e comentários, e visualizem uma lista de todos os feedbacks registrados. O projeto foi criado como parte de um aprendizado prático em desenvolvimento web, com foco em PHP, MySQL, HTML, CSS e hospedagem de aplicações.
O sistema está hospedado no ProFreeHost e pode ser acessado em: seufeedback.unaux.com. Nota: O site está em HTTP, pois enfrentamos limitações ao tentar configurar HTTPS com o Cloudflare devido ao controle restrito do domínio raiz unaux.com pelo ProFreeHost.
 Funcionalidades
Login de Administrador: O sistema possui uma página de login para administradores (usuário: admin, senha: admin).

Cadastro de Colaboradores: Permite cadastrar novos colaboradores com seus nomes.

Envio de Feedback: Os administradores podem enviar feedbacks para os colaboradores, incluindo uma nota (de 1 a 5 estrelas) e um comentário.

Lista de Feedbacks: Exibe uma tabela com todos os feedbacks registrados, incluindo o nome do colaborador, a nota, o comentário e a data do feedback.

Logout: Os administradores podem sair do sistema, encerrando a sessão.

Design Responsivo: O layout foi ajustado para ser responsivo, funcionando bem em dispositivos móveis e desktops.

 Tecnologias Utilizadas
PHP: Para a lógica do backend, incluindo autenticação, manipulação de formulários e interação com o banco de dados.

MySQL: Banco de dados relacional para armazenar informações de usuários, colaboradores e feedbacks.

HTML e CSS: Para a estrutura e o estilo das páginas, com foco em um design simples e responsivo.

PDO (PHP Data Objects): Para consultas seguras ao banco de dados, prevenindo SQL Injection.

ProFreeHost: Hospedagem gratuita usada para implantar o sistema online.

 Estrutura do Projeto

controle-feedback/
├── css/
│   └── style.css           # Estilos do site, incluindo design responsivo
├── includes/
│   └── conexao.php         # Arquivo de conexão com o banco de dados MySQL
├── login.php               # Página de login para administradores
├── index.php               # Página inicial com opções de cadastro, feedback e lista
├── cadastro.php            # Página para cadastrar novos colaboradores
├── feedback.php            # Página para enviar feedbacks
├── lista.php               # Página que lista todos os feedbacks
├── logout.php              # Script para encerrar a sessão
├── imagem.jpg              # Imagem usada na página de login
└── controle_feedback.sql   # Script SQL para criar o banco de dados e as tabelas

Tabelas do Banco de Dados
usuarios: Armazena os dados dos administradores (id, username, password).

colaboradores: Armazena os nomes dos colaboradores (id, nome).

feedbacks: Armazena os feedbacks (id, colaborador_id, nota, texto, data).

 O Que Eu Aprendi
Durante o desenvolvimento e a implantação deste projeto, adquiri várias habilidades e enfrentei desafios que me ajudaram a crescer como desenvolvedor:
Desenvolvimento Web com PHP e MySQL:
Aprendi a criar um sistema web completo, desde o frontend (HTML/CSS) até o backend (PHP/MySQL).

Entendi como usar o PDO para fazer consultas seguras ao banco de dados, prevenindo SQL Injection.

Implementei autenticação de usuários com sessões PHP (session_start(), $_SESSION).

Design Responsivo:
Ajustei o CSS para tornar o site responsivo, usando técnicas como flexbox, media queries e rolagem horizontal em tabelas para dispositivos móveis.

Testei o layout em diferentes dispositivos pra garantir uma boa experiência de usuário.

Hospedagem e Implantação:
Hospedei o site no ProFreeHost, uma hospedagem gratuita, aprendendo a configurar arquivos, permissões (ex.: 755 pra pastas, 644 pra arquivos) e o banco de dados no VistaPanel.

Importei o banco de dados via phpMyAdmin e ajustei o arquivo conexao.php com as credenciais fornecidas pelo ProFreeHost.

Resolução de Problemas:
Resolvi o erro de conexão com o banco de dados (SQLSTATE[HY000] [1045] Access denied), corrigindo as credenciais no conexao.php e confirmando a senha do VistaPanel.

Corrigir o erro "Usuário ou senha inválidos" no login, verificando os dados no banco de dados e depurando o código com echo pra entender onde a autenticação falhava.

Tentativa de Configurar HTTPS com Cloudflare:
Tentei adicionar HTTPS ao site usando o Cloudflare, mas enfrentei limitações porque não controlo o domínio raiz unaux.com (pertence ao ProFreeHost).

Aprendi sobre a diferença entre "Full Setup" e "CNAME Setup" no Cloudflare, e como configurar registros DNS (ex.: registros A e CNAME).

Entendi que, sem controle sobre os nameservers do domínio raiz, o Cloudflare não pode gerenciar o subdomínio seufeedback.unaux.com pra fornecer HTTPS.

Descobri alternativas como hospedagens gratuitas que suportam HTTPS nativamente (ex.: AwardSpace, GoogieHost).

Boas Práticas:
Aprendi a importância de fazer backups regulares do banco de dados e dos arquivos, especialmente em hospedagens gratuitas que podem ser instáveis.

Entendi a necessidade de criptografar senhas (ex.: usando password_hash() e password_verify()) pra melhorar a segurança, embora ainda não tenha implementado isso no projeto.

 Como Executar o Projeto Localmente
Pré-requisitos:
Servidor local com PHP (ex.: XAMPP, WAMP).

MySQL instalado.

Configuração:
Clone o repositório:
bash

git clone https://github.com/seu-usuario/controle-feedback.git

Coloque a pasta controle-feedback na pasta do seu servidor local (ex.: htdocs no XAMPP).

Crie o banco de dados:
Acesse o phpMyAdmin e crie um banco chamado controle_feedback.

Importe o arquivo controle_feedback.sql pra criar as tabelas e inserir os dados iniciais (usuário: admin, senha: admin).

Configure a conexão com o banco:
Abra includes/conexao.php e ajuste as credenciais:
php

$host = "localhost";
$username = "root";
$password = ""; // Senha do MySQL (geralmente vazia no XAMPP)
$db = "controle_feedback";

Acesse o Site:
Inicie o servidor local (ex.: Apache e MySQL no XAMPP).

Acesse http://localhost/controle-feedback/login.php no navegador.

Faça login com usuário admin e senha admin.

 Melhorias Futuras
Criptografia de Senhas: Implementar password_hash() e password_verify() pra armazenar senhas de forma segura.

HTTPS: Migrar pra uma hospedagem que suporte HTTPS nativamente (ex.: AwardSpace) pra garantir a segurança do tráfego.

Validação de Formulários: Adicionar validação no lado do servidor pra evitar entradas inválidas.

Melhorias no Design: Adicionar mais estilos e animações pra melhorar a experiência do usuário.

Testes: Implementar testes unitários pra garantir que o sistema funcione corretamente.

 Licença
Este projeto é de uso educacional e está licenciado sob a MIT License (LICENSE).
 Contato
Se tiver dúvidas ou sugestões, entre em contato comigo pelo GitHub ou e-mail: [seu-email@example.com (mailto:seu-email@example.com)].

