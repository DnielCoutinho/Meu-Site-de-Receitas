<?php
// Define o cabeçalho como JSON para que o JavaScript entenda a resposta
header('Content-Type: application/json');
require_once('../config.php');

$response = [
    'receitas' => [],
    'categorias' => []
];

// Busca todas as categorias para popular os botões de filtro
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");
while ($cat = $categorias_result->fetch_assoc()) {
    $response['categorias'][] = $cat;
}

// Monta a query para buscar as receitas
$sql = "SELECT id, nome, foto FROM receitas";
$types = '';
$params = [];

// Se uma categoria específica foi solicitada, adiciona o filtro
if (isset($_GET['categoria_id']) && is_numeric($_GET['categoria_id'])) {
    $sql .= " WHERE categoria_id = ?";
    $types = 'i';
    $params[] = $_GET['categoria_id'];
}

$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$receitas_result = $stmt->get_result();

while ($receita = $receitas_result->fetch_assoc()) {
    $response['receitas'][] = $receita;
}

$stmt->close();
$conn->close();

// Envia a resposta completa em formato JSON
echo json_encode($response);
?>