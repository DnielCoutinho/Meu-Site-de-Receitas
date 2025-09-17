<?php
require_once('paginas/includes/header.php');
require_once('config.php'); // Conexão com o banco de dados

// Busca uma receita aleatória para a seção de destaque (Hero Section)
$featuredRecipe = null;
$sqlFeatured = "SELECT id, nome FROM receitas ORDER BY RAND() LIMIT 1";
$resultFeatured = $conn->query($sqlFeatured);

if ($resultFeatured && $resultFeatured->num_rows > 0) {
    $featuredRecipe = $resultFeatured->fetch_assoc();
}

// Busca receitas do banco de dados para exibir na página inicial (grade)
$receitas = [];
$sql = "SELECT MIN(id) as id, nome FROM receitas GROUP BY nome ORDER BY id LIMIT 9"; // Pega 9 receitas únicas
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receitas[] = $row;
    }
}

$conn->close();
?>

<?php if ($featuredRecipe): ?>
<section class="hero-section" style="background-image: url('/coutopasta/paginas/comidas/imagem_receita.php?id=<?php echo $featuredRecipe['id']; ?>');">
    <div class="hero-content">
        <h1><?php echo htmlspecialchars($featuredRecipe['nome']); ?></h1>
        <p>Descubra sabores que contam histórias.</p>
        <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $featuredRecipe['id']; ?>" class="btn">Ver Receita</a>
    </div>
</section>
<?php endif; ?>

<div class="container">
    <section id="receitas" class="fade-in-section">
        <h2>Receitas Populares</h2>
        <div class="receitas-grid">
            <?php if (!empty($receitas)): ?>
                <?php foreach ($receitas as $receita): ?>
                    <article class="receita-card">
                        <img src="/coutopasta/paginas/comidas/imagem_receita.php?id=<?php echo $receita['id']; ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>">
                        <div class="receita-card-content">
                            <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>
                            <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita['id']; ?>" class="btn">Ver Receita</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma receita encontrada. Que tal cadastrar a primeira?</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Seção de Depoimentos (a ser implementada com JS) -->
    <section id="depoimentos" class="fade-in-section">
        <h2>O que nossos cozinheiros dizem</h2>
        <div class="testimonial-slider">
            <!-- Depoimentos serão inseridos aqui via JS -->
            <div class="testimonial">
                <p>"Este site transformou minha cozinha! As receitas são fáceis de seguir e deliciosas."</p>
                <h4>- Ana Clara</h4>
            </div>
            <div class="testimonial">
                <p>"Encontrei pratos que me lembram a infância. Uma verdadeira viagem gastronômica!"</p>
                <h4>- Bruno Martins</h4>
            </div>
        </div>
    </section>

    <!-- Seção de Filtros -->
    <section id="filtros" class="fade-in-section">
        <h2>Filtre por Categoria</h2>
        <div class="filter-container">
            <button class="filter-btn active" data-category="all">Todas</button>
            <!-- Categorias serão inseridas aqui -->
        </div>
    </section>
</div>

<?php require_once('paginas/includes/footer.php'); ?>