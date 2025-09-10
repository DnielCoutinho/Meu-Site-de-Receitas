<?php
require_once('paginas/includes/header.php');
require_once('config.php'); // Conexão com o banco de dados

// Busca receitas do banco de dados para exibir na página inicial
$receitas = [];
$sql = "SELECT id, nome FROM comidas ORDER BY RAND() LIMIT 9"; // Pega 9 receitas aleatórias
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receitas[] = $row;
    }
}
$conn->close();
?>

<h2>Receitas em Destaque</h2>

<div class="receitas-grid">
    <?php if (!empty($receitas)): ?>
        <?php foreach ($receitas as $receita): ?>
            <article class="receita-card">
                <img src="https://via.placeholder.com/400x250.png?text=<?php echo urlencode($receita['nome']); ?>" alt="<?php echo htmlspecialchars($receita['nome']); ?>">
                <div class="receita-card-content">
                    <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>
                    <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita['id']; ?>" class="btn-ver-receita">Ver Receita</a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="index-content">Nenhuma receita encontrada no banco de dados. Execute o script de dados iniciais ou cadastre a primeira receita!</p>
    <?php endif; ?>
</div>

<?php require_once('paginas/includes/footer.php'); ?>
