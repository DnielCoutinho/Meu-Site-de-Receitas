# 🍝 CoutoPasta - Sistema de Receitas

## Projeto de Aplicação Web Completa

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

> **Sistema web completo e responsivo para gerenciamento de receitas, desenvolvido em PHP e MySQL com uma abordagem moderna e focada na usabilidade.**

---

## 🎯 **SOBRE O PROJETO**

Este repositório contém o código-fonte completo do **CoutoPasta**, uma aplicação web funcional para um site de receitas. O projeto foi desenvolvido de forma interativa, passando por diversas fases de refatoração e melhorias, servindo como um estudo de caso prático para o desenvolvimento de aplicações PHP modernas.

O sistema permite que usuários se cadastrem, publiquem, gerenciem e encontrem receitas de forma intuitiva.

### **🌟 Características do Sistema:**
- ✅ **Design Responsivo** - Abordagem Mobile-first, garantindo usabilidade em qualquer dispositivo
- ✅ **PHP Estruturado** - Lógica de backend organizada e segura
- ✅ **CSS3 Moderno** - Layouts com Grid e Flexbox, e design visualmente agradável
- ✅ **JavaScript Interativo** - Menu mobile funcional e melhorias na experiência do usuário
- ✅ **CRUD Completo** - Funcionalidades de Criar, Ler, Atualizar e Deletar para receitas
- ✅ **Segurança Essencial** - Proteção contra ataques comuns (SQL Injection, XSS)

---

## 🎓 **OBJETIVOS DO PROJETO**

### **Objetivo Geral:**
Construir uma aplicação web dinâmica e completa com PHP e MySQL, demonstrando um ciclo de desenvolvimento que inclui criação, depuração de bugs, refatoração de código e implementação de novas funcionalidades com base no feedback do usuário.

### **Objetivos Específicos:**
1. **Compreender a arquitetura** de uma aplicação PHP com múltiplos arquivos
2. **Aplicar operações CRUD** (Create, Read, Update, Delete) em um banco de dados MySQL
3. **Implementar um sistema de autenticação** de usuários seguro (cadastro, login, sessões)
4. **Construir layouts responsivos** e modernos com CSS (Grid/Flexbox)
5. **Desenvolver uma busca inteligente** com múltiplos parâmetros
6. **Aplicar boas práticas de segurança** em PHP e SQL
7. **Refatorar e melhorar um código** existente para maior qualidade e manutenibilidade

### **Competências Desenvolvidas:**
- 🔧 **Técnicas:** PHP, MySQL, HTML5, CSS3, JavaScript ES6+, Design Responsivo
- 🧠 **Cognitivas:** Análise de código, debugging, resolução de problemas complexos
- 📂 **Arquitetura:** Organização de arquivos, separação de responsabilidades (backend/frontend)

---

## 📁 **ESTRUTURA DO PROJETO**

* `/coutoasta` (Pasta Raiz)
    * `config.php` - Configuração do banco de dados e funções
    * `database.sql` - Script para criar a estrutura do banco
    * `data.sql` - Script com dados iniciais
    * `index.php` - Página inicial com destaques e filtros
    * `README.md` - Documentação do projeto
    * `/css`
        * `style.css` - Folha de estilos principal (Mobile-First)
    * `/js`
        * `script.js` - Interatividade do frontend (Menu)
    * `/paginas`
        * `/comidas`
            * `buscar_receitas.php` - Página de resultados da busca
            * `cadastrar_receita.php` - Formulário de cadastro
            * `editar_receita.php` - Formulário de edição
            * `excluir_receita.php` - Script de exclusão
            * `gerenciar_duplicatas.php` - Ferramenta do Admin
            * `visualizar_receita.php` - Página de detalhes da receita
        * `/includes`
            * `header.php` - Cabeçalho e menu de navegação
            * `footer.php` - Rodapé
        * `/usuarios`
            * `alterar_dados.php` - Edição de perfil
            * `alterar_senha.php` - Alteração de senha
            * `criar_usuario.php` - Página de cadastro de usuário
            * `login.php` - Página de login
            * `logout.php` - Script de logout
            * `recuperar_senha.php` - Formulário de recuperação
            * `redefinir_senha.php` - Formulário para nova senha
    * `/uploads`
        * `/receitas` - Pasta para as imagens das receitas

---

## 🚀 **TECNOLOGIAS E RECURSOS**

### **Stack Tecnológico:**
- **Backend:** PHP
- **Banco de Dados:** MySQL / MariaDB
- **Servidor Local:** XAMPP (Apache)
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)

### **Funcionalidades Implementadas:**
- 🍔 **Menu hambúrguer** responsivo em formato overlay
- 🎲 **Destaque de receita aleatório** na página inicial
- 🎠 **Carrossel horizontal** de receitas populares (CSS-driven)
- ✅ **Validação de formulários** (ex: prevenção de receitas duplicadas)
- 🔍 **Busca por múltiplos ingredientes** com exibição dos que combinaram
- 📂 **Filtros de categoria** na página inicial (Server-side)
- 🔐 **Sistema de autenticação completo** com recuperação de senha

---

## ⚡ **COMO USAR ESTE PROJETO**

### **Para Executar Localmente:**
1.  **Copie os Arquivos:** Coloque a pasta `coutopasta` no diretório `htdocs` do seu XAMPP.
2.  **Crie o Banco de Dados:** Use o phpMyAdmin para criar um banco de dados chamado `coutopasta_receitas`.
3.  **Importe os Dados:**
    * Primeiro, importe o arquivo `database.sql` para criar as tabelas.
    * Em seguida, importe `data.sql` para popular com dados de exemplo.
4.  **Verifique a Configuração:** O arquivo `config.php` já está configurado para o ambiente padrão do XAMPP (`root`, sem senha).
5.  **Verifique as Permissões:** Garanta que a pasta `uploads/receitas/` tenha permissão de escrita.
6.  **Acesse:** Abra o navegador e acesse `http://localhost/coutopasta/`.

---

## 📊 **CARACTERÍSTICAS DE QUALIDADE**

### **Segurança:**
- 🔐 **Senhas Criptografadas:** Uso de `password_hash()` para total segurança das senhas.
- 🛡️ **Prevenção de SQL Injection:** Uso exclusivo de *Prepared Statements* em todas as interações com o banco.
- ✒️ **Prevenção de XSS:** Tratamento de todas as saídas de dados com `htmlspecialchars()`.

### **Performance:**
- ⚡ **Carregamento Rápido:** A página inicial carrega um número limitado de receitas para garantir a velocidade.
- 📱 **Mobile-First:** O CSS é otimizado para carregar primeiro os estilos essenciais para dispositivos móveis.

### **Acessibilidade:**
- ♿ **HTML Semântico:** Uso correto de tags HTML para melhor estrutura e compatibilidade com leitores de tela.
- 🎨 **Contraste de Cores:** Paleta de cores escolhida para garantir boa legibilidade.

---
