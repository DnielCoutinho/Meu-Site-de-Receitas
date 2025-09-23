# Meu Site de Receitas

## Descrição
Sistema web para compartilhamento e busca de receitas culinárias, desenvolvido em PHP, HTML, CSS e JavaScript com banco de dados MySQL. A plataforma permite que os usuários encontrem receitas com base nos ingredientes que possuem em casa, além de poderem cadastrar e visualizar pratos de diversas culinárias.

## Funcionalidades Implementadas

1.  **Gestão de Usuários** ✅
    *   ✅ Criar novo usuário (auto-cadastro)
    *   ✅ Entrar no sistema (login)
    *   ✅ Sair do sistema (logout)
    *   ✅ Alterar dados cadastrais
    *   ✅ Alterar senha

2.  **Gestão de Receitas** ✅
    *   ✅ Cadastrar novas receitas (para usuários logados)
    *   ✅ Visualizar detalhes completos de uma receita, incluindo informações adicionais
    *   ✅ Listar receitas na página inicial

3.  **Busca Inteligente** ✅
    *   ✅ Buscar receitas com base nos ingredientes disponíveis

4.  **Sistema de Autenticação** ✅
    *   ✅ Senhas criptografadas com `password_hash`
    *   ✅ Controle de sessão com `$_SESSION` do PHP
    *   ✅ Proteção de páginas restritas

5.  **Interface Responsiva** ✅
    *   ✅ Design moderno e amigável com CSS Flexbox e Grid
    *   ✅ Mensagens de feedback para o usuário

## Estrutura do Projeto

```
coutopasta/
├── api/
│   └── get_receitas.php       # API para buscar receitas
├── css/
│   └── style.css              # Folha de estilos principal
├── js/
│   └── script.js              # Interatividade do frontend
├── paginas/
│   ├── comidas/
│   │   ├── buscar_receitas.php         # Página de busca por receitas
│   │   ├── cadastrar_receita.php       # Formulário de cadastro de receita
│   │   └── visualizar_receita.php      # Página de detalhes da receita
│   ├── includes/
│   │   ├── header.php         # Cabeçalho e menu de navegação
│   │   └── footer.php         # Rodapé
│   └── usuarios/
│       ├── alterar_dados.php  # Edição de perfil do usuário
│       ├── alterar_senha.php  # Alteração de senha
│       ├── criar_usuario.php  # Página de cadastro de usuário
│       ├── login.php          # Página de login
│       └── logout.php         # Script de logout
├── scripts/
│   ├── padronizar_e_remover_duplicatas.php # Script para padronizar e remover duplicatas
│   ├── padronizar_nomes_receitas.php # Script para padronizar nomes de receitas
│   ├── remover_duplicatas_receitas.php # Script para remover receitas duplicadas
│   └── remover_fotos_receitas.php # Script para remover fotos de receitas
├── uploads/
│   └── receitas/              # Armazenamento de fotos de receitas
├── config.php                 # Configuração do banco de dados
├── data.sql                   # Script SQL com a estrutura do banco e dados de exemplo
├── index.php                  # Página inicial com listagem de receitas
└── README.md                  # Este arquivo
```

## Instalação

### Pré-requisitos
*   XAMPP ou similar (Apache + MySQL + PHP 7.4+)
*   Navegador web (Chrome, Firefox, etc.)

### Passos para instalação:

1.  **Clonar o Repositório**
    *   Coloque a pasta `coutopasta` dentro do diretório `htdocs` da sua instalação do XAMPP (geralmente `C:\xampp\htdocs\`).

2.  **Configurar o Banco de Dados**
    *   Inicie os módulos Apache e MySQL no painel de controle do XAMPP.
    *   Acesse o phpMyAdmin em `http://localhost/phpmyadmin`.
    *   Crie um novo banco de dados chamado `meu_site_de_receitas`.
    *   Selecione o banco recém-criado e use a aba "Importar" para executar o script `dados_iniciais.sql`. Isso criará as tabelas e adicionará as receitas de exemplo.

3.  **Configurar a Conexão**
    *   Verifique o arquivo `config.php`. As credenciais padrão do XAMPP (`host=localhost`, `user=root`, `password=vazio`) já estão configuradas. Altere apenas se sua configuração for diferente.

4.  **Acessar a Aplicação**
    *   Abra o navegador e acesse: `http://localhost/coutopasta/`

## Como Usar

*   **Para novos usuários:**
    1.  Acesse a página inicial.
    2.  Clique em "Criar Usuário" no menu de navegação.
    3.  Preencha o formulário de cadastro.
    4.  Faça login com suas novas credenciais.

*   **Funcionalidades disponíveis:**
    *   **Página Inicial:** Explore receitas em destaque.
    *   **Buscar por Ingredientes:** Digite os ingredientes que você tem em casa (separados por vírgula) para encontrar receitas compatíveis.
    *   **Cadastrar Receita:** Adicione suas próprias receitas ao site (requer login).
    *   **Meu Perfil:** Edite seus dados pessoais e altere sua senha.

## Recursos de Segurança

*   **Criptografia de senhas:** Uso da função `password_hash()` do PHP para proteger as senhas dos usuários.
*   **Prevenção de SQL Injection:** Uso de *Prepared Statements* em todas as consultas ao banco de dados.
*   **Proteção contra XSS:** Uso da função `htmlspecialchars()` para tratar todas as saídas de dados no HTML.

## Tecnologias Utilizadas

*   **Backend:** PHP 7.4+
*   **Frontend:** HTML5, CSS3, JavaScript
*   **Banco de dados:** MySQL
*   **Design:** CSS Flexbox, CSS Grid, Design Responsivo

## Estrutura do Banco de Dados

*   **Tabela `usuarios`**: `id`, `nome`, `email`, `senha`
*   **Tabela `categorias`**: `id`, `nome`
*   **Tabela `tipos_refeicao`**: `id`, `nome`
*   **Tabela `paises`**: `id`, `nome`
*   **Tabela `receitas`**: `id`, `nome`, `ingredientes`, `preparo`, `foto`, `info_adicional`, `usuario_id`, `pais_id`, `tipo_refeicao_id`, `categoria_id`

## Próximos Desenvolvimentos

As próximas funcionalidades a serem implementadas incluem:

*   Sistema de avaliação (estrelas) e comentários nas receitas.
*   Adicionar imagens reais para cada receita.
*   Busca por nome da receita.
*   Página de perfil do usuário com as receitas que ele cadastrou.
*   Filtro de receitas por categoria e subcategoria.

