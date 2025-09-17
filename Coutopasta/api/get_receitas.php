<?php
require_once('../config.php');

header('Content-Type: application/json');

$categorias = [];
$sql = "SELECT id, nome FROM categorias ORDER BY nome";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categorias[] = $row;
    }
}

$receitas = [];
$category_filter = '';
if (isset($_GET['categoria_id']) && $_GET['categoria_id'] !== 'all') {
    $categoria_id = (int)$_GET['categoria_id'];
    $category_filter = "WHERE r.categoria_id = $categoria_id";
}

$sql_receitas = "
    SELECT r.id, r.nome, c.nome as categoria
    FROM receitas r
    JOIN categorias c ON r.categoria_id = c.id
    $category_filter
    GROUP BY r.nome
    ORDER BY r.id DESC
";

$result_receitas = $conn->query($sql_receitas);

if ($result_receitas) {
    while ($row = $result_receitas->fetch_assoc()) {
        $receitas[] = $row;
    }
}

$conn->close();

echo json_encode(['categorias' => $categorias, 'receitas' => $receitas]);
