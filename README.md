# Controle de Feedback de Colaboradores

## Visão Geral

O **Controle de Feedback de Colaboradores** é um sistema web desenvolvido para gerenciar feedbacks de colaboradores de uma empresa. Ele permite que administradores cadastrem colaboradores e usuários, enviem feedbacks com avaliações de 1 a 10 estrelas e comentários, e visualizem uma lista completa de todos os feedbacks registrados com modal popup para detalhes.

O projeto foi criado como parte de um aprendizado prático em desenvolvimento web, com foco em **PHP, MySQL, HTML, CSS** e técnicas modernas de interface responsiva.

> **Sistema totalmente renovado:** Agora com interface moderna, sistema de avaliação de 10 estrelas, modal popup para detalhes, logs funcionais e layout otimizado!

## 🚀 Funcionalidades Principais

- **Login de Administrador:** Sistema de autenticação seguro _(usuário: admin, senha: admin)_
- **Gestão Completa de Colaboradores:** CRUD completo para cadastro, edição e exclusão de colaboradores
- **Gestão de Usuários:** Sistema completo de usuários do sistema
- **Envio de Feedback Avançado:** Interface otimizada com avaliações de **1 a 10 estrelas** por item
- **Lista Inteligente de Feedbacks:** Tabela com modal popup para visualização de detalhes sem quebra de layout
- **Sistema de Avaliação Visual:** Display de estrelas em tempo real nas listagens
- **Logs Funcionais:** Sistema completo de logging para auditoria
- **Design Responsivo:** Layout moderno que funciona perfeitamente em mobile e desktop
- **Interface Moderna:** Gradientes, animações e componentes estilizados

## 🛠️ Tecnologias Utilizadas

- **PHP 8+:** Lógica do backend com orientação a objetos e boas práticas
- **MySQL:** Banco de dados relacional otimizado para performance
- **HTML5 & CSS3:** Estrutura semântica e estilos modernos com flexbox/grid
- **JavaScript:** Interatividade, modal popup e AJAX
- **Bootstrap 5:** Framework CSS para responsividade
- **FontAwesome 6:** Ícones modernos e consistentes
- **PDO (PHP Data Objects):** Consultas seguras com prepared statements
- **AJAX:** Carregamento dinâmico de conteúdo no modal

## 📁 Estrutura do Projeto

```
controle-feedback/
├── css/
│   └── style.css               # Estilos modernos com gradientes e animações
├── inc/
│   ├── conexao.php             # Conexão segura com banco de dados
│   └── funcoes.php             # Funções auxiliares e logs
├── colaboradores/              # Módulo completo de colaboradores
│   ├── colaborador_listar.php  # Lista com ações CRUD
│   ├── colaborador_cadastrar.php
│   ├── colaborador_editar.php
│   └── colaborador_excluir.php
├── usuarios/                   # Módulo completo de usuários
│   ├── usuario_listar.php      # Gestão de usuários do sistema
│   ├── usuario_cadastrar.php
│   ├── usuario_editar.php
│   └── usuario_excluir.php
├── feedbacks/                  # Módulo principal de feedbacks
│   ├── feedback_listar.php     # Lista com modal popup
│   ├── feedback_enviar.php     # Formulário otimizado (10 estrelas)
│   ├── feedback_detalhes.php   # Página de detalhes
│   └── feedback_detalhes_ajax.php # Endpoint AJAX para modal
├── logs/                       # Sistema de logs organizados
│   ├── inserir.sql            # Logs de inserção
│   ├── editar.sql             # Logs de edição/consulta
│   ├── excluir.sql            # Logs de exclusão
│   ├── validar.sql            # Logs de autenticação
│   └── geral.sql              # Logs gerais e relatórios
├── media/                     # Recursos visuais
├── pasta_exemplo/             # Backup e arquivos de exemplo
└── README.md                  # Documentação completa
```

## 📊 Estrutura do Banco de Dados

- **tbUsuarios:** Usuários do sistema _(usuario_id, login, senha)_
- **tbPessoas:** Colaboradores cadastrados _(pessoa_id, nome, cpf, telefone)_
- **tbItem:** Itens para avaliação _(item_id, nome, descricao)_
- **tbFeedback:** Feedbacks principais _(feedback_id, cliente_id, produto_id, datahora, observacao)_
- **tbAvaliacao:** Avaliações detalhadas _(avaliacao_id, feedback_id, item_id, nota 1-10)_

## 🎨 Design System Moderno

- **Cores:** Gradientes personalizados por módulo (azul, roxo, verde)
- **Layout:** Container responsivo de 700px-1400px conforme dispositivo
- **Componentes:** Botões com hover effects, tabelas estilizadas, formulários modernos
- **Animações:** Transições suaves e transform effects
- **Tipografia:** Hierarquia clara com ícones FontAwesome
- **Modal:** Sistema popup com backdrop blur e animações

## 🌟 O Que Eu Aprendi

### Desenvolvimento Web Avançado:

- Criar um sistema **completo e modular** com PHP orientado a objetos
- Implementar **modal popup com AJAX** para melhor UX
- Usar **PDO com prepared statements** para máxima segurança
- Desenvolver **sistema de logs categorizado** para auditoria

### Interface Moderna e Responsiva:

- Criar **gradientes CSS** e **animações** profissionais
- Implementar **layout responsivo** com flexbox e grid
- Desenvolver **sistema de 10 estrelas** com feedback visual
- Otimizar **formulários extensos** com layout em colunas

### Arquitetura e Organização:

- Estruturar projeto em **módulos independentes**
- Implementar **sistema de logs organizados** por tipo de operação
- Criar **documentação técnica** completa com SQL comentado
- Usar **versionamento** adequado com .gitignore configurado

### Segurança e Boas Práticas:

- Prevenir **SQL Injection** com prepared statements
- Implementar **sanitização** adequada de dados
- Criar **sistema de autenticação** robusto
- Organizar **logs de auditoria** para debugging

### UX/UI e Usabilidade:

- Desenvolver **modal popup** para evitar navegação desnecessária
- Criar **feedback visual** com sistema de estrelas
- Otimizar **loading states** e **animações de transição**
- Implementar **design responsivo** real para todos os dispositivos

## 🚀 Como Executar o Projeto

### Pré-requisitos:

- **XAMPP, WAMP ou LAMP** (Apache + MySQL + PHP 8+)
- **phpMyAdmin** para gestão do banco

### Configuração Rápida:

1. **Clone ou baixe o projeto:**

   ```bash
   git clone [url-do-repositorio]
   ```

2. **Coloque na pasta do servidor:**

   - Mova para `htdocs` (XAMPP) ou `www` (WAMP)

3. **Configure o banco de dados:**

   - Acesse **phpMyAdmin** (http://localhost/phpmyadmin)
   - Crie banco: `controle_feedback`
   - Importe: `pasta_exemplo/Controle-de-feeback-bacckup-local.sql`

4. **Configure conexão:**

   ```php
   // inc/conexao.php
   $host = "localhost";
   $username = "root";
   $password = ""; // Vazio no XAMPP
   $db = "controle_feedback";
   ```

5. **Inicie os serviços:**

   - Apache ✅
   - MySQL ✅

6. **Acesse o sistema:**
   - **URL:** http://localhost/controle-feedback
   - **Login:** `admin` / `admin`

## 🔧 Funcionalidades Implementadas Recentemente

- ✅ **Sistema de 10 estrelas** funcionando corretamente
- ✅ **Modal popup** para detalhes sem quebra de layout
- ✅ **Layout otimizado** para formulários extensos
- ✅ **Scripts de log funcionais** e organizados
- ✅ **Interface responsiva** moderna
- ✅ **Segurança** com prepared statements
- ✅ **Documentação** completa e atualizada

## 🔮 Melhorias Futuras

- **Criptografia de Senhas:** Implementar `password_hash()` para mais segurança
- **Sistema de Relatórios:** Dashboard com gráficos de desempenho
- **Notificações:** Sistema de alertas por email
- **API REST:** Endpoints para integração com outros sistemas
- **Temas:** Sistema de cores personalizáveis
- **Backup Automático:** Rotina automatizada de backup do banco

## 📄 Licença

Este projeto é de uso **educacional** e está licenciado sob a **MIT License**.

## 📞 Contato

Se tiver dúvidas, sugestões ou quiser contribuir:

- **GitHub:** [Perfil do Desenvolvedor]
- **Email:** [ezequielsantoscoutinho@gmail.com](mailto:ezequielsantoscoutinho@gmail.com)

---

**Desenvolvido com ❤️ para aprendizado e controle de feedback de colaboradores**
