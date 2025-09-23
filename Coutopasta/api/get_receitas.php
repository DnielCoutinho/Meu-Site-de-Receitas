<?php
require_once('../config.php');

header('Content-Type: application/json');

// 1. Buscar todas as categorias para os botões de filtro
$categorias = [];
$sql_categorias = "SELECT id, nome FROM categorias ORDER BY nome";
$result_categorias = $conn->query($sql_categorias);
if ($result_categorias) {
    while ($row = $result_categorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

// 2. Buscar as receitas, aplicando o filtro e removendo duplicatas de nome
$receitas = [];
$category_filter_for_subquery = '';
$params = [];
$types = '';

if (isset($_GET['categoria_id']) && $_GET['categoria_id'] !== 'all' && is_numeric($_GET['categoria_id'])) {
    $category_filter_for_subquery = "WHERE categoria_id = ?";
    $params[] = (int)$_GET['categoria_id'];
    $types .= 'i';
}

// Usamos uma subquery para pegar o ID mais recente de cada nome de receita, aplicando o filtro
$sql_receitas = "
    SELECT r1.id, r1.nome, r1.foto, c.nome as categoria
    FROM receitas r1
    INNER JOIN (
        SELECT MAX(id) as max_id 
        FROM receitas 
        $category_filter_for_subquery 
        GROUP BY nome
    ) r2 ON r1.id = r2.max_id
    JOIN categorias c ON r1.categoria_id = c.id
    ORDER BY r1.id DESC
";

$stmt_receitas = $conn->prepare($sql_receitas);

if ($stmt_receitas) {
    if (!empty($params)) {
        // Usando a forma compatível de bind_param
        $bind_names = array();
        $bind_names[] = $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_names[] = &$params[$i];
        }
        call_user_func_array(array($stmt_receitas, 'bind_param'), $bind_names);
    }

    $stmt_receitas->execute();
    $result_receitas = $stmt_receitas->get_result();

    if ($result_receitas) {
        while ($row = $result_receitas->fetch_assoc()) {
            $receitas[] = $row;
        }
    }
    $stmt_receitas->close();
}

$conn->close();

echo json_encode(['categorias' => $categorias, 'receitas' => $receitas]);
