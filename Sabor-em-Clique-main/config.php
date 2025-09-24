<?php
// ==================================================================
// CONFIGURAÇÃO CENTRAL DO PROJETO
// ==================================================================

// 1. URL BASE DO PROJETO
// Este é o nome da pasta do seu projeto.
define('BASE_URL', '/sabor-em-clique-main');

// 2. CONFIGURAÇÕES DO BANCO DE DADOS
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sabor_em_clique_receitas";

$conn = new mysqli($servername, $username, $password, $dbname);

// Ajusta charset para corresponder ao schema (utf8mb4)
mysqli_set_charset($conn, 'utf8mb4');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==================================================================
// FUNÇÃO CENTRAL PARA GERENCIAR A EXIBIÇÃO DE FOTOS
// ==================================================================
if (!function_exists('get_foto_src')) {
function get_foto_src($nome_foto_do_banco) {
    $caminho_padrao = BASE_URL . '/assets/placeholder.svg';

    if (empty($nome_foto_do_banco)) {
        return $caminho_padrao;
    }

    if (filter_var($nome_foto_do_banco, FILTER_VALIDATE_URL)) {
        return htmlspecialchars($nome_foto_do_banco);
    }
    
    return BASE_URL . '/uploads/receitas/' . htmlspecialchars($nome_foto_do_banco);
}
}
?>