<?php
require_once('../includes/header.php');
require_once('../../config.php');

$receitas_encontradas = [];
$ingredientes_buscados = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['ingredientes'])) {
    $ingredientes_buscados = trim($_POST['ingredientes']);
    // Separa os ingredientes por vírgula e remove espaços extras
    $ingredientes = array_map('trim', explode(',', $ingredientes_buscados));

    // Monta a query dinamicamente
    $sql = "SELECT id, nome FROM comidas WHERE ";
    $condicoes = [];
    $params = [];
    $types = '';

    foreach ($ingredientes as $ingrediente) {
        if (!empty($ingrediente)) {
            $condicoes[] = "ingredientes LIKE ?";
            $params[] = "%" . $ingrediente . "%";
            $types .= 's';
        }
    }

    if (!empty($condicoes)) {
        $sql .= implode(' AND ', $condicoes);
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $receitas_encontradas[] = $row;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<h2>Encontre Receitas com o que Você Tem em Casa</h2>
<form method="POST">
    <label for="ingredientes">Digite os ingredientes que você tem (separados por vírgula):</label>
    <input type="text" id="ingredientes" name="ingredientes" value="<?php echo htmlspecialchars($ingredientes_buscados); ?>" placeholder="Ex: tomate, queijo, manjericão" required>
    <input type="submit" value="Buscar Receitas">
</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <div class="resultados-busca" style="margin-top: 40px;">
        <h3>Resultados da Busca:</h3>
        <?php if (!empty($receitas_encontradas)): ?>
            <ul>
                <?php foreach ($receitas_encontradas as $receita): ?>
                    <!-- Agora o link aponta para a página de visualização -->
                    <li><a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita['id']; ?>"><?php echo htmlspecialchars($receita['nome']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma receita encontrada com os ingredientes fornecidos.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require_once('../includes/footer.php'); ?>