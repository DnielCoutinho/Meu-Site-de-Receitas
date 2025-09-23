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
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="/coutopasta/" class="logo">CoutoPasta</a>

            <div class="search-container">
                <form action="/coutopasta/paginas/comidas/buscar_receitas.php" method="get">
                    <input type="text" name="q" placeholder="Procure uma receita, ingrediente..." required>
                    <button type="submit">Buscar</button>
                </form>
            </div>

            <div class="user-options">
                <nav class="main-nav">
                    <a href="/coutopasta/">Início</a>
                    <a href="/coutopasta/paginas/comidas/cadastrar_receita.php">Enviar Receita</a>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <a href="/coutopasta/paginas/usuarios/alterar_dados.php" class="user-icon" title="Minha Conta">
                            <img src="/coutopasta/assets/user-icon.svg" alt="Minha Conta">
                        </a>
                        <a href="/coutopasta/paginas/usuarios/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="/coutopasta/paginas/usuarios/login.php">Login</a>
                    <?php endif; ?>
                </nav>
            </div>

            <button class="hamburger-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            
        </div>
    </header>
    <main class="container">