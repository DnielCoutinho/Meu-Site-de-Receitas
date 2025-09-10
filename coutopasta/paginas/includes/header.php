<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Site de Receitas</title>
    <link rel="stylesheet" href="/coutopasta/css/style.css">
</head>
<body>
    <header>
        <h1>Meu Site de Receitas</h1>
        <nav>
            <a href="/coutopasta/">Início</a>
            <a href="/coutopasta/paginas/comidas/buscar_por_ingredientes.php">Buscar por Ingredientes</a>
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <a href="/coutopasta/paginas/comidas/cadastrar_receita.php">Cadastrar Receita</a>
                <a href="/coutopasta/paginas/usuarios/alterar_dados.php">Alterar Dados</a>
                <a href="/coutopasta/paginas/usuarios/alterar_senha.php">Alterar Senha</a>
                <a href="/coutopasta/paginas/usuarios/logout.php">Logout</a>
            <?php else: ?>
                <a href="/coutopasta/paginas/usuarios/login.php">Login</a>
                <a href="/coutopasta/paginas/usuarios/criar_usuario.php">Criar Usuário</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
