<?php
require_once('paginas/includes/header.php'); 
require_once('config.php');

// Verifica se o usuário está logado (após iniciar a sessão no header)
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: " . BASE_URL . "/paginas/usuarios/login.php");
    exit();
}

// Apenas a lógica do Hero permanece no PHP para um carregamento inicial rápido
$stmt_hero = $conn->prepare("SELECT * FROM receitas ORDER BY RAND() LIMIT 1");
$stmt_hero->execute();
$result_hero = $stmt_hero->get_result();
$receita_hero = $result_hero->fetch_assoc();
$stmt_hero->close();
$conn->close();
?>

<main>
    <div class="container">
        <section class="featured-carousel" aria-label="Receitas em destaque" role="region">
            <header class="carousel-header">
                <h1 class="featured-title">Receitas em Destaque</h1>
                <div class="carousel-controls" aria-hidden="false">
                    <button class="carousel-btn prev" aria-label="Receita anterior" disabled>&larr;</button>
                    <button class="carousel-btn next" aria-label="Próxima receita" disabled>&rarr;</button>
                </div>
            </header>
            <div class="carousel-track-wrapper">
                <ul class="carousel-track" id="featured-track" tabindex="0" aria-live="polite"></ul>
            </div>
            <div class="carousel-indicators" id="carousel-indicators" aria-hidden="true"></div>
        </section>
    </div>


    <div class="container" id="populares-wrapper">
        <section aria-label="Receitas em Alta" class="populares-section" style="margin-top:3rem;">
            <h2 class="section-title">Em Alta</h2>
            <div class="receitas-grid receitas-populares" data-order="views">
                <p style="grid-column:1/-1;text-align:center;">Carregando...</p>
            </div>
        </section>
    </div>

    <div class="container" id="all-recipes" aria-live="polite" style="margin-top:3rem;">
    <section class="all-recipes">
        <h2>Nossas Receitas</h2>
        
        <div class="filter-container">
            <a href="#" data-category="" class="filter-btn active">Todas</a>
        </div>

        <div class="receitas-grid" style="margin-top: 2rem;">
            <p style="text-align:center; grid-column: 1 / -1;">Carregando receitas...</p>
        </div>
    </section>
    </div>
</main>

<?php 
require_once('paginas/includes/footer.php'); 
?>
<script src="/js/toast.js"></script>