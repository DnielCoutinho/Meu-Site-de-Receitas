<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Função para gerar o embed de vídeo ou imagem
function embed_video_ou_imagem($url, $titulo_receita) {
    if (empty($url)) {
        return '<img src="/coutopasta/assets/placeholder.svg" alt="Imagem não disponível">';
    }
    $youtube_id = ''; $vimeo_id = '';
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
        return '<img src="' . get_foto_src($url) . '" alt="Foto de ' . htmlspecialchars($titulo_receita) . '">';
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
?>
    <div class="container">
        <article class="receita-container">
            <header class="receita-header">
                <h1><?php echo htmlspecialchars($receita['nome']); ?></h1>
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
                    <ul>
                    <?php
                    $texto_ingredientes = $receita['ingredientes'];
                    if (strpos($texto_ingredientes, "\n") !== false || strpos($texto_ingredientes, "\r") !== false) {
                        $lista = explode("\n", str_replace(["\r\n", "\r"], "\n", $texto_ingredientes));
                    } else {
                        $lista = explode(",", $texto_ingredientes);
                    }
                    foreach ($lista as $item) {
                        $item_limpo = ltrim(trim($item), '- ');
                        if (!empty($item_limpo)) echo '<li>' . htmlspecialchars($item_limpo) . '</li>';
                    }
                    ?>
                    </ul>
                </aside>
                
                <article class="preparo">
                    <h3>Modo de Preparo</h3>
                    <?php
                    $linhas_preparo = explode("\n", str_replace(["\r\n", "\r"], "\n", $receita['preparo']));
                    $lista_aberta = false;
                    foreach ($linhas_preparo as $linha) {
                        $linha_trim = trim($linha);
                        if (empty($linha_trim)) continue;
                        if (substr($linha_trim, -1) === ':') {
                            if ($lista_aberta) { echo '</ol>'; $lista_aberta = false; }
                            echo '<h4 class="preparo-secao-titulo">' . htmlspecialchars($linha_trim) . '</h4>';
                        } else {
                            if (!$lista_aberta) { echo '<ol class="preparo-lista">'; $lista_aberta = true; }
                            $passo_formatado = preg_replace('/\*\*(.*?)\*\*/', '<span class="destaque">$1</span>', htmlspecialchars($linha_trim));
                            echo '<li>' . $passo_formatado . '</li>';
                        }
                    }
                    if ($lista_aberta) echo '</ol>';
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
require_once('../includes/footer.php');
?>