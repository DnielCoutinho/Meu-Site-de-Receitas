<?php
// Define o cabeçalho como JSON para que o JavaScript entenda a resposta
header('Content-Type: application/json; charset=utf-8');
require_once('../config.php');

$response = [
    'receitas' => [],
    'categorias' => [],
    'pagination' => [
        'page' => 1,
        'limit' => 20,
        'total' => 0,
        'pages' => 0
    ]
];

// Busca todas as categorias para popular os botões de filtro
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");
while ($cat = $categorias_result->fetch_assoc()) {
    $response['categorias'][] = $cat;
}

// Caso seja solicitada uma lista aleatória de destaques (?featured=1)
if (isset($_GET['featured'])) {
    $limit = 6; // quantidade de receitas em destaque
    $featured_sql = "SELECT id, nome, foto FROM receitas ORDER BY RAND() LIMIT ?";
    $stmtF = $conn->prepare($featured_sql);
    $stmtF->bind_param('i', $limit);
    $stmtF->execute();
    $resF = $stmtF->get_result();
    while ($r = $resF->fetch_assoc()) {
        $response['receitas'][] = $r;
    }
    $stmtF->close();
    $conn->close();
    echo json_encode($response);
    exit;
}

// Parâmetros de busca e paginação
$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0 && $_GET['limit'] <= 50 ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;
$response['pagination']['page'] = $page;
$response['pagination']['limit'] = $limit;

$where = [];
$params = [];
$types = '';

if (isset($_GET['categoria_id']) && is_numeric($_GET['categoria_id'])) {
    $where[] = 'categoria_id = ?';
    $types .= 'i';
    $params[] = (int)$_GET['categoria_id'];
}
if (isset($_GET['q']) && $_GET['q'] !== '') {
    // Suporte a busca simples por nome OU ingredientes. (Melhoria: incluir ingredientes)
    $where[] = '(nome LIKE ? OR ingredientes LIKE ?)';
    $types .= 'ss';
    $pattern = '%' . $_GET['q'] . '%';
    $params[] = $pattern;
    $params[] = $pattern;
}

$whereSql = $where ? (' WHERE ' . implode(' AND ', $where)) : '';

// Ordenação
$allowedOrder = ['recent' => 'id DESC', 'views' => 'views DESC', 'az' => 'nome ASC', 'za' => 'nome DESC'];
$orderParam = isset($_GET['order']) ? $_GET['order'] : 'recent';
$orderBy = isset($allowedOrder[$orderParam]) ? $allowedOrder[$orderParam] : $allowedOrder['recent'];

// Total
$countSql = 'SELECT COUNT(*) AS total FROM receitas' . $whereSql;
$stmtCount = $conn->prepare($countSql);
if ($types) { $stmtCount->bind_param($types, ...$params); }
$stmtCount->execute();
$resCount = $stmtCount->get_result();
$rowCount = $resCount->fetch_assoc();
$total = (int)$rowCount['total'];
$stmtCount->close();
$response['pagination']['total'] = $total;
$response['pagination']['pages'] = $total ? (int)ceil($total / $limit) : 0;

// Dados
$sql = 'SELECT id, nome, foto, IFNULL(views,0) AS views, dificuldade, tempo_preparo FROM receitas' . $whereSql . ' ORDER BY ' . $orderBy . ' LIMIT ? OFFSET ?';
$typesData = $types . 'ii';
$paramsData = $params;
$paramsData[] = $limit;
$paramsData[] = $offset;

$stmt = $conn->prepare($sql);
if ($typesData) { $stmt->bind_param($typesData, ...$paramsData); }
$stmt->execute();
$receitas_result = $stmt->get_result();
while ($receita = $receitas_result->fetch_assoc()) { $response['receitas'][] = $receita; }
$stmt->close();
$conn->close();
echo json_encode($response);
?>