<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coutopasta_receitas";

$conn = new mysqli($servername, $username, $password, $dbname);

mysqli_set_charset($conn,"utf8");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==================================================================
// FUNÇÃO CENTRAL PARA GERENCIAR A EXIBIÇÃO DE FOTOS
// ==================================================================
// Esta função garante que qualquer foto sempre tenha um caminho válido.
function get_foto_src($nome_foto_do_banco) {
    // Define uma imagem padrão para casos de erro ou ausência de foto
    $caminho_padrao = '/coutopasta/assets/placeholder.svg';

    if (empty($nome_foto_do_banco)) {
        return $caminho_padrao;
    }

    // Se o valor for uma URL completa (começa com http), retorna ela mesma
    if (filter_var($nome_foto_do_banco, FILTER_VALIDATE_URL)) {
        return htmlspecialchars($nome_foto_do_banco);
    }
    
    // Se não for uma URL, monta o caminho para a pasta de uploads local
    return '/coutopasta/uploads/receitas/' . htmlspecialchars($nome_foto_do_banco);
}
?>