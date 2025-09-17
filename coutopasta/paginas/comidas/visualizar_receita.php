<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o ID da receita foi passado e é um número
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Receita não encontrada</h2><p>O ID da receita é inválido ou não foi fornecido.</p>";
    require_once('../includes/footer.php');
    exit();
}

$receita_id = intval($_GET['id']);

// Busca os detalhes completos da receita
$sql = "SELECT 
            r.nome, 
            r.ingredientes, 
            r.preparo, 
            r.foto,
            p.nome AS pais_nome, 
            tr.nome AS tipo_refeicao_nome,
            c.nome AS categoria_nome
        FROM receitas AS r
        JOIN paises AS p ON r.pais_id = p.id
        JOIN tipos_refeicao AS tr ON r.tipo_refeicao_id = tr.id
        JOIN categorias AS c ON r.categoria_id = c.id
        WHERE r.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $receita = $result->fetch_assoc();
?>
    <div class="receita-view">
        <h2><?php echo htmlspecialchars($receita['nome']); ?></h2>

        <div class="receita-meta">
            <span><strong>País:</strong> <?php echo htmlspecialchars($receita['pais_nome']); ?></span>
            <span><strong>Tipo de Refeição:</strong> <?php echo htmlspecialchars($receita['tipo_refeicao_nome']); ?></span>
            <span><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria_nome']); ?></span>
        </div>

        <div class="receita-img">
            <img src="<?php echo htmlspecialchars($receita['foto']); ?>" alt="<?php echo htmlspecialchars($receita['nome']); ?>">
        </div>

        <div class="receita-content">
            <div class="ingredientes">
                <h3>Ingredientes</h3>
                <p><?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?></p>
            </div>
            
            <div class="preparo">
                <h3>Modo de Preparo</h3>
                <p><?php echo nl2br(htmlspecialchars($receita['preparo'])); ?></p>
            </div>
        </div>
    </div>
<?php
} else {
    echo "<h2>Receita não encontrada</h2><p>A receita que você está procurando não existe.</p>";
}

$stmt->close();
$conn->close();
require_once('../includes/footer.php');
?>
