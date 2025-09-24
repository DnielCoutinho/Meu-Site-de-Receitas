<?php
require_once('../includes/header.php'); // já carrega config e BASE_URL

$receitas_encontradas = [];
$ingredientes_buscados = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ingredientes'])) {
    $ingredientes_buscados = trim($_POST['ingredientes']);
    $ingredientes = array_filter(array_map('trim', explode(',', $ingredientes_buscados)));

    if ($ingredientes) {
        $cond = [];
        $params = [];
        $types = '';
        foreach ($ingredientes as $ing) {
            $cond[] = 'ingredientes LIKE ?';
            $params[] = '%' . $ing . '%';
            $types .= 's';
        }
        $sql = 'SELECT id, nome, foto, ingredientes FROM receitas WHERE ' . implode(' AND ', $cond) . ' LIMIT 100';
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                // conta quantos ingredientes bateram para rankear se quiser
                $matchCount = 0;
                foreach ($ingredientes as $ing) {
                    if (stripos($row['ingredientes'], $ing) !== false) { $matchCount++; }
                }
                $row['matches'] = $matchCount;
                $receitas_encontradas[] = $row;
            }
            $stmt->close();
        }
        // Ordena pelo número de matches desc
        usort($receitas_encontradas, function($a,$b){ return $b['matches'] <=> $a['matches']; });
    }
}
?>

<section class="ingredientes-search container" style="padding:2rem 0;">
    <h1 style="margin-bottom:1rem;">Encontre Receitas com os Ingredientes que Você Tem</h1>
    <form method="POST" class="form-ingredientes" style="display:flex;flex-direction:column;gap:1rem;max-width:720px;">
        <label for="ingredientes">Digite os ingredientes separados por vírgula:</label>
        <input type="text" id="ingredientes" name="ingredientes" placeholder="Ex: tomate, queijo, manjericão" value="<?php echo htmlspecialchars($ingredientes_buscados); ?>" required style="padding:.8rem 1rem;border:1px solid #ddd;border-radius:8px;font-size:1rem;"/>
        <button type="submit" class="btn" style="align-self:flex-start;">Buscar</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="resultados-busca" style="margin-top:2.5rem;">
            <h2 style="margin-bottom:1rem;">Resultados</h2>
            <?php if ($receitas_encontradas): ?>
                <div class="receitas-grid" style="--cols:repeat(auto-fill,minmax(220px,1fr));">
                    <?php foreach ($receitas_encontradas as $r): ?>
                        <article class="receita-card" style="animation-delay:0ms;">
                            <a href="<?php echo BASE_URL; ?>/paginas/comidas/visualizar_receita.php?id=<?php echo $r['id']; ?>" style="text-decoration:none;color:inherit;display:flex;flex-direction:column;height:100%;">
                                <?php $foto = get_foto_src($r['foto'] ?? ''); ?>
                                <img src="<?php echo $foto; ?>" alt="Imagem da receita <?php echo htmlspecialchars($r['nome']); ?>" loading="lazy"/>
                                <div class="receita-card-content">
                                    <h3><?php echo htmlspecialchars($r['nome']); ?></h3>
                                    <p style="font-size:.7rem;color:#666;line-height:1.3;margin-top:.4rem;">Combina com <strong><?php echo $r['matches']; ?></strong> ingrediente(s) que você digitou.</p>
                                    <span class="btn" style="margin-top:auto;">Ver Receita</span>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="margin-top:1rem;">Nenhuma receita encontrada com os ingredientes fornecidos.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>

<?php require_once('../includes/footer.php'); ?>
