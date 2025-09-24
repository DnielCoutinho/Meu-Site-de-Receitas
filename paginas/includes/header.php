<?php
session_start();
// A inclusão do config.php deve vir antes de qualquer HTML para que a constante BASE_URL esteja disponível
require_once(__DIR__ . '/../../config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sabor em Clique - Sabores Inesquecíveis</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script>
        // Passa a constante do PHP para uma variável global do JavaScript
        const baseURL = '<?php echo BASE_URL; ?>';
    </script>
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="<?php echo BASE_URL; ?>/" class="logo">Sabor em Clique</a>
            
            <div class="center-nav">
                <nav class="main-nav">
                    <a href="<?php echo BASE_URL; ?>/">Início</a>
                    <a href="<?php echo BASE_URL; ?>/paginas/comidas/cadastrar_receita.php">Enviar Receita</a>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="<?php echo BASE_URL; ?>/paginas/admin/painel.php">Área Admin</a>
                    <?php endif; ?>
                </nav>
            </div>

            <div class="header-actions">
                <div class="user-actions">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="<?php echo BASE_URL; ?>/paginas/usuarios/alterar_dados.php" class="user-icon" title="Perfil" aria-label="Perfil"><i class="material-icons" aria-hidden="true">person</i></a>
                        <a href="<?php echo BASE_URL; ?>/paginas/usuarios/logout.php" class="icon-btn-small logout-btn" title="Sair" aria-label="Sair">
                            <i class="material-icons" aria-hidden="true">logout</i>
                            <span class="sr-only">Logout</span>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>/paginas/usuarios/login.php" class="btn">Login</a>
                    <?php endif; ?>
                </div>
                
                <button class="hamburger-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </div>
    </header>
        <div class="global-search-bar" role="search" aria-label="Buscar receitas">
            <div class="global-search-inner">
                <form action="<?php echo BASE_URL; ?>/paginas/comidas/buscar_receitas.php" method="get" class="search-container has-icon" autocomplete="off">
                    <input type="text" name="q" placeholder="Procure uma receita..." aria-label="Campo de busca" required aria-autocomplete="list" aria-expanded="false" aria-haspopup="listbox" aria-controls="search-suggestions">
                    <button type="button" class="clear-search-btn" aria-label="Limpar busca" hidden><i class="material-icons" aria-hidden="true">close</i></button>
                    <button type="submit" class="search-button" aria-label="Buscar"><i class="material-icons" aria-hidden="true">search</i></button>
                    <ul class="search-suggestions" id="search-suggestions" role="listbox" hidden></ul>
                </form>
            </div>
        </div>
        <?php
        $script = basename($_SERVER['SCRIPT_NAME']);
        if ($script !== 'index.php') : ?>
            <nav class="back-nav" aria-label="Navegação secundária">
                <button type="button" class="btn-back" onclick="history.back()" aria-label="Voltar para a página anterior">
                    <span class="material-icons" aria-hidden="true">arrow_back</span>
                    Voltar
                </button>
            </nav>
        <?php endif; ?>
        <main>