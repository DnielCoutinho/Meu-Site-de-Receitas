# 🍝 CoutoPasta

## Descrição
Sistema web para compartilhamento e busca de receitas culinárias, desenvolvido em PHP, HTML, CSS e JavaScript com banco de dados MySQL. A plataforma CoutoPasta permite que os usuários encontrem receitas por nome ou com base nos ingredientes que possuem em casa, filtrem por categoria e enviem suas próprias criações em uma interface moderna e responsiva.

## Funcionalidades Implementadas

1.  **Gestão de Usuários** ✅
    * ✅ Criar novo usuário (auto-cadastro)
    * ✅ Entrar no sistema (login)
    * ✅ Sair do sistema (logout)
    * ✅ Alterar dados cadastrais (nome, e-mail)
    * ✅ Alterar senha
    * ✅ Recuperação de senha (simulada)

2.  **Gestão de Receitas** ✅
    * ✅ Cadastrar novas receitas com foto (para usuários logados)
    * ✅ Visualizar detalhes completos de uma receita
    * ✅ Editar receitas existentes (apenas o criador ou admin)
    * ✅ Excluir receitas (apenas o criador ou admin)
    * ✅ Listagem na página inicial com destaque aleatório e populares
    * ✅ Página de listagem completa com filtros

3.  **Busca e Descoberta** ✅
    * ✅ Buscar por nome da receita ou por um único ingrediente
    * ✅ Buscar por múltiplos ingredientes (separados por vírgula)
    * ✅ Exibição dos ingredientes que combinaram na busca
    * ✅ Filtros por categoria diretamente na página inicial

4.  **Funcionalidades de Administrador** ✅
    * ✅ Permissão para editar e excluir qualquer receita do sistema
    * ✅ Ferramenta de gerenciamento para visualizar e remover receitas duplicadas
        * **Acesso:** `http://localhost/coutopasta/paginas/comidas/gerenciar_duplicatas.php`

5.  **Sistema de Autenticação e Segurança** ✅
    * ✅ Senhas criptografadas com `password_hash`
    * ✅ Controle de sessão com `$_SESSION` do PHP
    * ✅ Proteção de páginas restritas (ex: cadastrar/editar receita)
    * ✅ Prevenção de SQL Injection com *Prepared Statements*
    * ✅ Proteção contra XSS com `htmlspecialchars()`

6.  **Interface Responsiva (Mobile-First)** ✅
    * ✅ Design moderno e amigável com CSS Flexbox e Grid
    * ✅ Menu "hambúrguer" em formato overlay para uma melhor experiência mobile
    * ✅ Mensagens de feedback para o usuário (sucesso, erro)

## Estrutura do Projeto

* `/coutopasta` (Pasta Raiz)
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

## Instalação

### Pré-requisitos
* XAMPP ou similar (Apache + MySQL + PHP)
* Navegador web (Chrome, Firefox, etc.)

### Passos para instalação:

1.  **Copiar os Arquivos**
    * Coloque a pasta `coutopasta` dentro do diretório `htdocs` da sua instalação do XAMPP (geralmente `C:\xampp\htdocs\`).

2.  **Configurar o Banco de Dados**
    * Inicie os módulos Apache e MySQL no painel de controle do XAMPP.
    * Acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
    * Crie um novo banco de dados chamado `coutopasta_receitas`.
    * Selecione o banco recém-criado, vá na aba "Importar" e execute o arquivo `database.sql` para criar as tabelas.
    * Importe novamente, desta vez o arquivo `data.sql`, para adicionar os dados de exemplo.

3.  **Configurar a Conexão**
    * Verifique o arquivo `config.php`. As credenciais padrão (`host=localhost`, `user=root`, `password=""`) já estão configuradas. Altere apenas se sua configuração for diferente.

4.  **Permissões de Pasta**
    * Garanta que a pasta `uploads/receitas/` tenha permissão de escrita para que o PHP possa salvar as imagens.

5.  **Acessar a Aplicação**
    * Abra o navegador e acesse: `http://localhost/coutopasta/`

## Tecnologias Utilizadas

* **Backend:** PHP
* **Frontend:** HTML5, CSS3 (Flexbox, Grid), JavaScript
* **Banco de dados:** MySQL / MariaDB
* **Design:** Mobile-First, Design Responsivo

## Estrutura do Banco de Dados

* **Tabela `usuarios`**: `id`, `nome`, `email`, `senha`, `is_admin`
* **Tabela `receitas`**: `id`, `nome`, `ingredientes`, `preparo`, `info_adicional`, `foto`, `usuario_id`, `pais_id`, `tipo_refeicao_id`, `categoria_id`
* **Tabela `categorias`**: `id`, `nome`
* **Tabela `paises`**: `id`, `nome`
* **Tabela `tipos_refeicao`**: `id`, `nome`

## Próximos Desenvolvimentos

As próximas funcionalidades a serem implementadas podem incluir:

* Sistema de avaliação (estrelas) e comentários nas receitas.
* Página de perfil do usuário com a listagem das receitas que ele cadastrou.
* Paginação na seção "Todas as Receitas" para melhor performance.
* Filtros avançados combinando múltiplos critérios (país + categoria, etc.).
