<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoutoPasta - Sabores Inesquecíveis</title>
    <link rel="stylesheet" href="/coutopasta/css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="/coutopasta/" class="logo">CoutoPasta</a>
            
            <div class="center-nav">
                <nav class="main-nav">
                    <a href="/coutopasta/">Início</a>
                    <a href="/coutopasta/paginas/comidas/cadastrar_receita.php">Enviar Receita</a>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <a href="/coutopasta/paginas/usuarios/gerenciar_usuarios.php">Gerenciar Usuários</a>
                    <?php endif; ?>
                </nav>
            </div>

            <div class="header-actions">
                <form action="/coutopasta/paginas/comidas/buscar_receitas.php" method="get" class="search-container">
                    <input type="text" name="q" placeholder="Procure uma receita..." required>
                    <button type="submit" class="search-button"><i class="material-icons">search</i></button>
                </form>

                <div class="user-actions">
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="/coutopasta/paginas/usuarios/alterar_dados.php" class="user-icon"><i class="material-icons">person</i></a>
                        <a href="/coutopasta/paginas/usuarios/logout.php" class="btn btn-logout">Logout</a>
                    <?php else: ?>
                        <a href="/coutopasta/paginas/usuarios/login.php" class="btn">Login</a>
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
    <main>