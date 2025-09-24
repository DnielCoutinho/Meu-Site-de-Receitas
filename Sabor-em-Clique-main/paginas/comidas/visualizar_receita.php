<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Função para gerar o embed de vídeo ou imagem
function embed_video_ou_imagem($url, $titulo_receita) {
    if (empty($url)) {
        return '<img src="/assets/placeholder.svg" alt="Imagem não disponível">';
    }
    $youtube_id = '';
    $vimeo_id = '';
    if (preg_match('/(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/|)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
        $youtube_id = $matches[3];
    }
    if (preg_match('/vimeo\.com\/([0-9]+)/', $url, $matches)) {
        $vimeo_id = $matches[1];
    }
    if ($youtube_id) {
        return '<div class="video-container"><iframe src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
    } elseif ($vimeo_id) {
        return '<div class="video-container"><iframe src="https://player.vimeo.com/video/' . $vimeo_id . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
    } else {
        // Se for URL absoluta (http/https), usa direto. Se for nome de arquivo, monta caminho local
        if (preg_match('/^https?:\/\//', $url)) {
            $src = $url;
        } else {
            $src = '/uploads/receitas/' . $url;
        }
        return '<img src="' . htmlspecialchars($src) . '" alt="Foto de ' . htmlspecialchars($titulo_receita) . '">';
    }
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<main class='container'><div class='receita-container'><p>O ID da receita é inválido ou não foi fornecido.</p></div></main>";
    require_once('../includes/footer.php');
    exit();
}

$receita_id = intval($_GET['id']);
$sql = "SELECT r.*, p.nome AS pais_nome, tr.nome AS tipo_refeicao_nome, c.nome AS categoria_nome FROM receitas r JOIN paises p ON r.pais_id = p.id JOIN tipos_refeicao tr ON r.tipo_refeicao_id = tr.id JOIN categorias c ON r.categoria_id = c.id WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $receita = $result->fetch_assoc();
    // Incrementa views
    $up = $conn->prepare("UPDATE receitas SET views = views + 1 WHERE id = ?");
    $up->bind_param('i', $receita_id);
    $up->execute();
    $up->close();
?>
    <div class="container">
        <article class="receita-container">
            <header class="receita-header">
                <h1><?php echo htmlspecialchars($receita['nome']); ?></h1>
                <?php if(!empty($receita['tempo_preparo']) || !empty($receita['dificuldade'])): ?>
                <div style="display:flex;gap:1rem;margin:.6rem 0 0 0;font-size:.9rem;color:#6b6b6b;flex-wrap:wrap;">
                    <?php if(!empty($receita['tempo_preparo'])): ?><span><strong>Tempo:</strong> <?= htmlspecialchars($receita['tempo_preparo']); ?></span><?php endif; ?>
                    <?php if(!empty($receita['dificuldade'])): ?><span><strong>Dificuldade:</strong> <?= htmlspecialchars($receita['dificuldade']); ?></span><?php endif; ?>
                    <span><strong>Visualizações:</strong> <?= (int)$receita['views'] + 1; ?></span>
                </div>
                <?php endif; ?>
                <div class="receita-meta">
                    <span><strong>País:</strong> <?php echo htmlspecialchars($receita['pais_nome']); ?></span>
                    <span><strong>Tipo:</strong> <?php echo htmlspecialchars($receita['tipo_refeicao_nome']); ?></span>
                    <span><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria_nome']); ?></span>
                </div>
            </header>

            <?php 
            $pode_editar = isset($_SESSION['usuario_id']) && (isset($receita['usuario_id']) && $_SESSION['usuario_id'] == $receita['usuario_id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin']));
            if ($pode_editar): 
            ?>
                <section class="receita-actions">
                    <a href="editar_receita.php?id=<?php echo $receita_id; ?>" class="btn">Editar Receita</a>
                    <a href="excluir_receita.php?id=<?php echo $receita_id; ?>" class="btn btn-excluir" onclick="return confirm('Tem certeza?');">Excluir Receita</a>
                </section>
            <?php endif; ?>

            <section class="receita-media">
                <?php echo embed_video_ou_imagem($receita['foto'], $receita['nome']); ?>
            </section>

            <section class="receita-body">
                <aside class="ingredientes">
                    <h3>Ingredientes</h3>
                    <ul class="ingredientes-lista">
                    <?php
                    $texto_ingredientes = $receita['ingredientes'];
                    // Quebra por vírgula ou quebra de linha
                    if (strpos($texto_ingredientes, "\n") !== false || strpos($texto_ingredientes, "\r") !== false) {
                        $lista = preg_split('/[\r\n]+/', $texto_ingredientes);
                    } else {
                        $lista = explode(",", $texto_ingredientes);
                    }
                    foreach ($lista as $item) {
                        $item_limpo = trim($item);
                        if (!empty($item_limpo)) echo '<li class="ingrediente-item">' . htmlspecialchars($item_limpo) . '</li>';
                    }
                    ?>
                    </ul>
                </aside>
                
                <article class="preparo">
                    <h3>Modo de Preparo</h3>
                    <?php
                    $linhas_preparo = explode("\n", str_replace(["\r\n", "\r"], "\n", $receita['preparo']));
                    $etapas = [];
                    $titulo = '';
                    $descricao = '';
                    foreach ($linhas_preparo as $linha) {
                        $linha = trim($linha);
                        if ($linha === '') continue;
                        // Se for título (ex: "1. ..." ou "2. ...")
                        if (preg_match('/^\d+\./', $linha)) {
                            if ($titulo && $descricao) {
                                $etapas[] = ['titulo' => $titulo, 'descricao' => $descricao];
                                $descricao = '';
                            }
                            $titulo = $linha;
                        } else {
                            $descricao .= ($descricao ? "\n" : "") . $linha;
                        }
                    }
                    if ($titulo && $descricao) {
                        $etapas[] = ['titulo' => $titulo, 'descricao' => $descricao];
                    }
                    echo '<div class="preparo-etapas">';
                    foreach ($etapas as $etapa) {
                        echo '<div class="preparo-etapa">';
                        echo '<h4 class="preparo-etapa-titulo">' . htmlspecialchars($etapa['titulo']) . '</h4>';
                        // Quebra a descrição em tópicos
                        $topicos = preg_split('/\n|\r/', $etapa['descricao']);
                        echo '<ul class="preparo-etapa-descricao">';
                        foreach ($topicos as $topico) {
                            $topico = trim($topico);
                            // Remove asteriscos e traços do início e fim, e asteriscos de formatação
                            $topico = preg_replace('/^([\-*\s]+)+/', '', $topico); // início
                            $topico = preg_replace('/([\-*\s]+)+$/', '', $topico); // fim
                            $topico = preg_replace('/(^\*+|\*+$)/', '', $topico); // asteriscos isolados
                            $topico = preg_replace('/^_+|_+$/', '', $topico); // underlines isolados
                            if ($topico) echo '<li>' . htmlspecialchars($topico) . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                    echo '</div>';
                    ?>
                </article>
            </section>

            <?php if (!empty($receita['info_adicional'])): ?>
            <section class="info-adicional">
                <h3>Informações Adicionais</h3>
                <p><?php echo nl2br(htmlspecialchars($receita['info_adicional'])); ?></p>
            </section>
            <?php endif; ?>
        </article>
    </div>
<?php
} else {
    echo "<main class='container'><div class='receita-container'><p>A receita que você está procurando não existe.</p></div></main>";
}
$stmt->close();
$conn->close();
?>
<script type="application/ld+json">
<?php
// JSON-LD mínimo para Recipe
$jsonLd = [
    '@context' => 'https://schema.org',
    '@type' => 'Recipe',
    'name' => $receita['nome'],
    'image' => (preg_match('/^https?:\/\//',$receita['foto']) ? $receita['foto'] : (BASE_URL . '/uploads/receitas/' . $receita['foto'])),
    'recipeIngredient' => array_filter(array_map('trim', preg_split('/[\r\n,]+/', $receita['ingredientes']))),
    'recipeInstructions' => array_values(array_filter(array_map('trim', preg_split('/[\r\n]+/', $receita['preparo'])))),
    'author' => ['@type'=>'Person','name'=>'Usuário'],
    'recipeCuisine' => $receita['pais_nome'],
    'recipeCategory' => $receita['categoria_nome'],
    'keywords' => $receita['tipo_refeicao_nome'],
];
echo json_encode($jsonLd, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
?>
</script>
<?php
require_once('../includes/footer.php');
?>