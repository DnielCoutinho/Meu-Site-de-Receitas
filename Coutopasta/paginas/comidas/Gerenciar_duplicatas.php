<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Apenas admins podem acessar esta página
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo "<h2>Acesso Negado</h2><p>Você não tem permissão para acessar esta página.</p>";
    require_once('../includes/footer.php');
    exit();
}

$mensagem = '';

// Processa a exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_para_manter'])) {
    $id_para_manter = intval($_POST['id_para_manter']);
    $nome_receita = $_POST['nome_receita'];

    // Deleta todas as outras receitas com o mesmo nome, exceto a que foi escolhida
    $stmt_delete = $conn->prepare("DELETE FROM receitas WHERE nome = ? AND id != ?");
    $stmt_delete->bind_param("si", $nome_receita, $id_para_manter);
    
    if ($stmt_delete->execute()) {
        $mensagem = "<p style='color:green;'>Duplicatas de '" . htmlspecialchars($nome_receita) . "' removidas com sucesso!</p>";
    } else {
        $mensagem = "<p style='color:red;'>Erro ao remover duplicatas.</p>";
    }
    $stmt_delete->close();
}

// Busca por nomes de receitas duplicados
$sql_duplicatas = "SELECT nome, COUNT(*) as count FROM receitas GROUP BY nome HAVING count > 1 ORDER BY nome";
$result_duplicatas = $conn->query($sql_duplicatas);
?>

<div class="container">
    <h2>Gerenciar Receitas Duplicadas</h2>
    <p>Use esta ferramenta para visualizar receitas com o mesmo nome e escolher qual versão manter. A versão mais recente (ID mais alto) é selecionada por padrão.</p>
    
    <?php echo $mensagem; ?>

    <?php if ($result_duplicatas->num_rows > 0): ?>
        <?php while ($row = $result_duplicatas->fetch_assoc()): ?>
            <?php
            $nome_duplicado = $row['nome'];
            // Busca todas as versões da receita duplicada
            $stmt_versoes = $conn->prepare("SELECT id, SUBSTRING(ingredientes, 1, 100) as ing_preview, SUBSTRING(preparo, 1, 100) as prep_preview FROM receitas WHERE nome = ? ORDER BY id DESC");
            $stmt_versoes->bind_param("s", $nome_duplicado);
            $stmt_versoes->execute();
            $result_versoes = $stmt_versoes->get_result();
            ?>
            <div class="duplicata-card">
                <h3><?php echo htmlspecialchars($nome_duplicado); ?> <span class="badge">(<?php echo $row['count']; ?> versões)</span></h3>
                <form method="POST">
                    <input type="hidden" name="nome_receita" value="<?php echo htmlspecialchars($nome_duplicado); ?>">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Manter</th>
                                <th>ID</th>
                                <th>Prévia dos Ingredientes</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $is_first = true; ?>
                            <?php while ($versao = $result_versoes->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <input type="radio" name="id_para_manter" value="<?php echo $versao['id']; ?>" <?php if ($is_first) { echo 'checked'; $is_first = false; } ?>>
                                </td>
                                <td><?php echo $versao['id']; ?></td>
                                <td><?php echo htmlspecialchars($versao['ing_preview']); ?>...</td>
                                <td><a href="visualizar_receita.php?id=<?php echo $versao['id']; ?>" target="_blank">Ver Completa</a></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza? Todas as outras versões serão permanentemente excluídas.');">Manter Selecionada e Excluir as Outras</button>
                </form>
            </div>
        <?php endwhile; ?>
        <?php $stmt_versoes->close(); ?>

    <?php else: ?>
        <p style="color:green; font-weight:bold;">Nenhuma receita duplicada encontrada no banco de dados!</p>
    <?php endif; ?>
</div>

<style>
    .duplicata-card { background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
    .badge { background-color: #ff6600; color: white; padding: 4px 8px; border-radius: 10px; font-size: 0.9em; }
    .table { width: 100%; margin-top: 15px; border-collapse: collapse; }
    .table th, .table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    .btn-danger { background-color: #dc3545; color: white; }
</style>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>