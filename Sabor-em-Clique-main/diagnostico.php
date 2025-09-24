<?php
// Arquivo de teste para diagnosticar problemas do site
echo "<h1>Diagnóstico do Site Sabor em Clique</h1>";

// 1. Teste de conexão com banco de dados
echo "<h2>1. Teste de Conexão com Banco</h2>";
require_once('config.php');

if ($conn->connect_error) {
    echo "<p style='color:red'>❌ ERRO: Falha na conexão: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color:green'>✅ Conexão com banco estabelecida com sucesso</p>";
}

// 2. Verificar se o banco existe e tem tabelas
echo "<h2>2. Verificação de Tabelas</h2>";
$tables = ['paises', 'tipos_refeicao', 'categorias', 'usuarios', 'receitas'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<p style='color:green'>✅ Tabela '$table' existe</p>";
        
        // Contar registros
        $count_result = $conn->query("SELECT COUNT(*) as total FROM $table");
        $count = $count_result->fetch_assoc()['total'];
        echo "<p style='margin-left:20px;'>Total de registros: $count</p>";
    } else {
        echo "<p style='color:red'>❌ Tabela '$table' não encontrada</p>";
    }
}

// 3. Teste da API
echo "<h2>3. Teste da API</h2>";
$api_url = '/api/get_receitas.php';
echo "<p>Tentando acessar: $api_url</p>";

// 4. Verificar configuração BASE_URL
echo "<h2>4. Configuração BASE_URL</h2>";
echo "<p>BASE_URL atual: " . BASE_URL . "</p>";
echo "<p>URL atual da página: " . $_SERVER['REQUEST_URI'] . "</p>";

// 5. Verificar se arquivos existem
echo "<h2>5. Verificação de Arquivos</h2>";
$files = [
    'js/script.js',
    'css/style.css',
    'api/get_receitas.php',
    'paginas/includes/header.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p style='color:green'>✅ $file existe</p>";
    } else {
        echo "<p style='color:red'>❌ $file não encontrado</p>";
    }
}

$conn->close();
?>