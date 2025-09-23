<?php
// Habilitar a exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('paginas/includes/header.php'); 
require_once('config.php');

// 1. Buscar uma receita aleatória para o destaque (hero)
$stmt_hero = $conn->prepare("SELECT * FROM receitas ORDER BY RAND() LIMIT 1");
$stmt_hero->execute();
$result_hero = $stmt_hero->get_result();
$receita_hero = $result_hero->fetch_assoc();
$stmt_hero->close();

// 2. Buscar as 5 receitas mais recentes para a seção de populares (excluindo a do hero)
$stmt_populares = $conn->prepare("SELECT * FROM receitas WHERE id != ? ORDER BY id DESC LIMIT 5");
$hero_id = $receita_hero['id'] ?? 0;
$stmt_populares->bind_param("i", $hero_id);
$stmt_populares->execute();
$result_populares = $stmt_populares->get_result();

// 3. Buscar todas as categorias para criar os botões de filtro
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

// 4. Buscar as receitas para o grid principal, aplicando o filtro se houver
$filtro_categoria_id = null;
$sql_todas = "SELECT * FROM receitas";
if (isset($_GET['categoria_id']) && is_numeric($_GET['categoria_id'])) {
    $filtro_categoria_id = intval($_GET['categoria_id']);
    $sql_todas .= " WHERE categoria_id = ?";
}
$sql_todas .= " ORDER BY id DESC LIMIT 24"; // Limita a 24 receitas no grid principal

$stmt_todas = $conn->prepare($sql_todas);
if ($filtro_categoria_id) {
    $stmt_todas->bind_param("i", $filtro_categoria_id);
}
$stmt_todas->execute();
$todas_receitas_result = $stmt_todas->get_result();
?>

<?php if ($receita_hero): ?>
<div class="container">
    <section class="hero-section" style="background-image: url('<?php echo get_foto_src($receita_hero['foto']); ?>');">
        <div class="hero-content">
            <h1><?php echo htmlspecialchars($receita_hero['nome']); ?></h1>
            <p>Descubra sabores que contam histórias.</p>
            <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita_hero['id']; ?>" class="btn">Ver Receita</a>
        </div>
    </section>
</div>
<?php endif; ?>

<main class="container">

    <?php if ($result_populares->num_rows > 0): ?>
    <section class="popular-recipes">
        <h2>Receitas Populares</h2>
        <div class="popular-grid">
            <?php while($receita = $result_populares->fetch_assoc()): ?>
                <article class="receita-card">
                    <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita['id']; ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?php echo get_foto_src($receita['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>">
                        <div class="receita-card-content">
                            <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>
                            <span class="btn" style="width: 100%; margin-top: 1rem;">Ver Receita</span>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php endif; ?>

    <section class="all-recipes">
        <h2>Todas as Receitas</h2>

        <div class="filter-container">
            <a href="/coutopasta/" class="filter-btn <?php echo !$filtro_categoria_id ? 'active' : ''; ?>">Todas</a>
            <?php while($cat = $categorias_result->fetch_assoc()): ?>
                <a href="/coutopasta/?categoria_id=<?php echo $cat['id']; ?>" class="filter-btn <?php echo ($filtro_categoria_id == $cat['id']) ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($cat['nome']); ?>
                </a>
            <?php endwhile; ?>
        </div>

        <div class="receitas-grid" style="margin-top: 2rem;">
             <?php while($receita = $todas_receitas_result->fetch_assoc()): ?>
                <article class="receita-card">
                    <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=<?php echo $receita['id']; ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?php echo get_foto_src($receita['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>">
                        <div class="receita-card-content">
                            <h3><?php echo htmlspecialchars($receita['nome']); ?></h3>
                            <span class="btn" style="width: 100%; margin-top: 1rem;">Ver Receita</span>
                        </div>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
         <?php if ($todas_receitas_result->num_rows === 0): ?>
            <p style="text-align: center; font-size: 1.2rem; color: var(--grey-text);">Nenhuma receita encontrada para esta categoria.</p>
        <?php endif; ?>
    </section>

</main>

<?php 
$stmt_populares->close();
$stmt_todas->close();
$conn->close();
require_once('paginas/includes/footer.php'); 
?>