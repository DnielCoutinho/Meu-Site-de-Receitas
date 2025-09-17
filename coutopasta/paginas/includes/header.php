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
        <div class="container">
            <a href="/coutopasta/" class="logo">CoutoPasta</a>
            <nav class="main-nav">
                <a href="/coutopasta/">Início</a>
                <a href="/coutopasta/paginas/comidas/buscar_por_ingredientes.php">Buscar</a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/coutopasta/paginas/comidas/cadastrar_receita.php">Cadastrar Receita</a>
                    <a href="/coutopasta/paginas/usuarios/alterar_dados.php">Minha Conta</a>
                    <a href="/coutopasta/paginas/usuarios/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/coutopasta/paginas/usuarios/login.php">Login</a>
                    <a href="/coutopasta/paginas/usuarios/criar_usuario.php" class="btn-nav">Criar Conta</a>
                <?php endif; ?>
            </nav>
            <button class="hamburger-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </div>
    </header>
    <main>
