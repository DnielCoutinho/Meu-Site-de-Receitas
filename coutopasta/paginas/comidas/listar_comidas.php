<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Fetch filter data
$paises_result = $conn->query("SELECT id, nome FROM paises ORDER BY nome");
$tipos_refeicao_result = $conn->query("SELECT id, nome FROM tipos_refeicao ORDER BY nome");
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

// Build query
$base_subquery = "SELECT * FROM receitas";
$where = [];
$params = [];
$types = '';

if (!empty($_GET['pais_id'])) {
    $where[] = "pais_id = ?";
    $params[] = $_GET['pais_id'];
    $types .= 'i';
}
if (!empty($_GET['tipo_refeicao_id'])) {
    $where[] = "tipo_refeicao_id = ?";
    $params[] = $_GET['tipo_refeicao_id'];
    $types .= 'i';
}
if (!empty($_GET['categoria_id'])) {
    $where[] = "categoria_id = ?";
    $params[] = $_GET['categoria_id'];
    $types .= 'i';
}
if (!empty($where)) {
    $base_subquery .= " WHERE " . implode(" AND ", $where);
}
$sql = "SELECT r1.id, r1.nome, r1.foto FROM (" . $base_subquery . ") r1 INNER JOIN (SELECT nome, MAX(id) as max_id FROM (" . $base_subquery . ") r2 GROUP BY nome) r2 ON r1.nome = r2.nome AND r1.id = r2.max_id";

// Como os filtros já foram aplicados na subquery, não é necessário aplicar novamente depois
$params = array_merge($params, $params); // duplicar para o bind_param das duas subqueries
$types = $types . $types;
$where = [];
$params = [];
$types = '';

if (!empty($_GET['pais_id'])) {
    $where[] = "r.pais_id = ?";
    $params[] = $_GET['pais_id'];
    $types .= 'i';
}

if (!empty($_GET['tipo_refeicao_id'])) {
    $where[] = "r.tipo_refeicao_id = ?";
    $params[] = $_GET['tipo_refeicao_id'];
    $types .= 'i';
}

if (!empty($_GET['categoria_id'])) {
    $where[] = "r.categoria_id = ?";
    $params[] = $_GET['categoria_id'];
    $types .= 'i';
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$receitas_result = $stmt->get_result();

?>

<h2>Listar Receitas</h2>

<form method="GET">
    <div class="row">
        <div class="col-md-4">
            <label for="pais_id">País:</label>
            <select name="pais_id" id="pais_id" class="form-control">
                <option value="">Todos</option>
                <?php while($pais = $paises_result->fetch_assoc()): ?>
                    <option value="<?php echo $pais['id']; ?>" <?php echo (!empty($_GET['pais_id']) && $_GET['pais_id'] == $pais['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($pais['nome']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="tipo_refeicao_id">Tipo de Refeição:</label>
            <select name="tipo_refeicao_id" id="tipo_refeicao_id" class="form-control">
                <option value="">Todos</option>
                <?php while($tipo = $tipos_refeicao_result->fetch_assoc()): ?>
                    <option value="<?php echo $tipo['id']; ?>" <?php echo (!empty($_GET['tipo_refeicao_id']) && $_GET['tipo_refeicao_id'] == $tipo['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tipo['nome']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="categoria_id">Categoria:</label>
            <select name="categoria_id" id="categoria_id" class="form-control">
                <option value="">Todas</option>
                <?php while($cat = $categorias_result->fetch_assoc()): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo (!empty($_GET['categoria_id']) && $_GET['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Filtrar</button>
</form>

<div class="row mt-4">
    <?php while($receita = $receitas_result->fetch_assoc()): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?php echo htmlspecialchars($receita['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($receita['nome']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($receita['nome']); ?></h5>
                    <a href="visualizar_receita.php?id=<?php echo $receita['id']; ?>" class="btn btn-primary">Ver Receita</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php require_once('../includes/footer.php'); ?>
