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
            r.info_adicional,
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
    <div class="receita-view container">
        <h2><?php echo htmlspecialchars($receita['nome']); ?></h2>

        <div class="receita-meta">
            <span><strong>País:</strong> <?php echo htmlspecialchars($receita['pais_nome']); ?></span>
            <span><strong>Tipo de Refeição:</strong> <?php echo htmlspecialchars($receita['tipo_refeicao_nome']); ?></span>
            <span><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria_nome']); ?></span>
        </div>

        <?php if (isset($_SESSION['usuario_id']) && (isset($receita['usuario_id']) && $receita['usuario_id'] == $_SESSION['usuario_id'] || (isset($_SESSION['is_admin']) && $_SESSION['is_admin']))): ?>
            <div class="receita-actions" style="text-align: center; margin-bottom: 20px;">
                <a href="editar_receita.php?id=<?php echo $receita_id; ?>" class="btn">Editar Receita</a>
            </div>
        <?php endif; ?>

        <div class="receita-details">
            <div class="receita-img">
                <img src="/coutopasta/paginas/comidas/imagem_receita.php?id=<?php echo $receita_id; ?>" alt="<?php echo htmlspecialchars($receita['nome']); ?>">
            </div>

            <div class="receita-content">
                <div class="ingredientes">
                    <h3>Ingredientes</h3>
                    <p><?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?></p>
                </div>
                
                <div class="preparo">
                    <div class="preparo-header">
                        <h3>Modo de Preparo</h3>
                        <div class="preparo-tempos">
                            <span class="tempo-item"><span class="tempo-icone">⏱️</span> <strong>Preparo:</strong> <?php echo htmlspecialchars($receita['tempo_preparo'] ?? ''); ?></span>
                            <span class="tempo-item"><span class="tempo-icone">🍳</span> <strong>Cozimento:</strong> <?php echo htmlspecialchars($receita['tempo_cozimento'] ?? ''); ?></span>
                            <span class="tempo-item"><span class="tempo-icone">⏳</span> <strong>Espera:</strong> <?php echo htmlspecialchars($receita['tempo_espera'] ?? ''); ?></span>
                        </div>
                    </div>
                    <?php
                    // Novo formato: cada seção começa com um título (linha sem indentação), seguida de passos (linhas com indentação)
                    $linhas = preg_split('/\r?\n/', $receita['preparo']);
                    $secoes = [];
                    $secaoAtual = null;
                    foreach ($linhas as $linha) {
                        if (trim($linha) === '') continue;
                        if (preg_match('/^[^\s].+$/', $linha)) {
                            $linhaTrimmed = trim($linha);
                        if ($linhaTrimmed === '') continue;

                        // Identifica se a linha é um título de seção
                        // Critério: começa com "Número. " OU termina com ":"
                        $isTitulo = preg_match('/^\d+\.\s/', $linhaTrimmed) || substr($linhaTrimmed, -1) === ':';

                        if ($isTitulo) {
                            $secaoAtual = $linhaTrimmed;
                            $secoes[$secaoAtual] = [];
                        } else if ($secaoAtual) {
                            $secoes[$secaoAtual][] = $linhaTrimmed;
                        } else {
                            // Se não é título e não há seção atual, adiciona a uma seção "Geral"
                            if (!isset($secoes['Geral'])) {
                                $secoes['Geral'] = [];
                            }
                            $secoes['Geral'][] = $linhaTrimmed;
                        }
                        } else if ($secaoAtual) {
                            $secoes[$secaoAtual][] = trim($linha);
                        }
                    }
                    ?>
                    <div class="preparo-secoes">
                        <?php foreach ($secoes as $titulo => $passos): ?>
                            <div class="preparo-bloco">
                                <div class="preparo-titulo"> <?php echo htmlspecialchars($titulo); ?> </div>
                                <ol class="preparo-lista">
                                    <?php foreach ($passos as $passo): ?>
                                        <li><?php echo preg_replace('/\*\*(.*?)\*\*/', '<span class="destaque">$1</span>', htmlspecialchars($passo)); ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($receita['info_adicional'])): ?>
        <div class="info-adicional">
            <h3>Informações adicionais</h3>
            <p><?php echo nl2br(htmlspecialchars($receita['info_adicional'])); ?></p>
        </div>
        <?php endif; ?>
    </div>
<?php
} else {
    echo "<h2>Receita não encontrada</h2><p>A receita que você está procurando não existe.</p>";
}

$stmt->close();
$conn->close();
require_once('../includes/footer.php');
?>
