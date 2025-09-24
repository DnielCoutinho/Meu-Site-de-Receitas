<?php
require_once('paginas/includes/header.php'); 
require_once('config.php');

// Apenas a lógica do Hero permanece no PHP para um carregamento inicial rápido
$stmt_hero = $conn->prepare("SELECT * FROM receitas ORDER BY RAND() LIMIT 1");
$stmt_hero->execute();
$result_hero = $stmt_hero->get_result();
$receita_hero = $result_hero->fetch_assoc();
$stmt_hero->close();
$conn->close();
?>

<?php if ($receita_hero): ?>
<div class="container">
    <section class="featured-recipe">
        <div class="featured-recipe-image">
            <img src="<?php echo get_foto_src($receita_hero['foto']); ?>" alt="<?php echo htmlspecialchars($receita_hero['nome']); ?>">
        </div>
        <div class="featured-recipe-content">
            <h1 class="featured-title">Receita em Destaque</h1>
            <h2><?php echo htmlspecialchars($receita_hero['nome']); ?></h2>
            <p>Descubra sabores que contam histórias e delicie-se com pratos incríveis.</p>
            <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita_hero['id']; ?>" class="btn btn-large">Ver Receita Completa</a>
        </div>
    </section>
</div>
<?php endif; ?>

<main class="container">
    <section class="all-recipes">
        <h2>Nossas Receitas</h2>
        
        <div class="filter-container">
            <a href="#" data-category="" class="filter-btn active">Todas</a>
        </div>

        <div class="receitas-grid" style="margin-top: 2rem;">
            <p style="text-align:center; grid-column: 1 / -1;">Carregando receitas...</p>
        </div>
    </section>
</main>

<?php 
require_once('paginas/includes/footer.php'); 
?>