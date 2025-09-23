<?php
require_once('paginas/includes/header.php');
require_once('config.php'); // Conexão com o banco de dados

// Busca uma receita aleatória para a seção de destaque (Hero Section)
$featuredRecipe = null;
$sqlFeatured = "SELECT id, nome, foto FROM receitas WHERE foto IS NOT NULL AND foto != '' ORDER BY RAND() LIMIT 1";
$resultFeatured = $conn->query($sqlFeatured);

if ($resultFeatured && $resultFeatured->num_rows > 0) {
    $featuredRecipe = $resultFeatured->fetch_assoc();
}

// Busca receitas do banco de dados para exibir na página inicial (grade)
$receitas = [];
// Query compatível para buscar 1 receita por nome, incluindo a foto.
$sql = "SELECT r1.id, r1.nome, r1.foto 
        FROM receitas r1 
        INNER JOIN (SELECT MAX(id) as id FROM receitas GROUP BY nome) r2 ON r1.id = r2.id 
        ORDER BY r1.id DESC LIMIT 9";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receitas[] = $row;
    }
}

$conn->close();
?>

<?php if ($featuredRecipe): ?>
<section class="hero-section" style="background-image: url('/coutopasta/uploads/receitas/<?php echo htmlspecialchars($featuredRecipe['foto']); ?>');">
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
                        <?php if (!empty($receita['foto'])): 
                            $grid_foto_url = $receita['foto'];
                            if (filter_var($grid_foto_url, FILTER_VALIDATE_URL)) {
                                $grid_image_path = htmlspecialchars($grid_foto_url);
                            }
                            else {
                                $grid_image_path = '/coutopasta/uploads/receitas/' . htmlspecialchars($grid_foto_url);
                            }
                        ?>
                            <img src="<?php echo $grid_image_path; ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>">
                        <?php else: ?>
                            <img src="/coutopasta/assets/placeholder.svg" alt="Imagem não disponível">
                        <?php endif; ?>
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