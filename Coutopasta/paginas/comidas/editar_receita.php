<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

$mensagem = '';
$receita = null;
$receita_id = null;

// NOVO: Verifica se a página foi redirecionada com uma mensagem de sucesso
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem = "<p style='color:green;'>Receita atualizada com sucesso!</p>";
}

// Busca dados para os dropdowns
$paises_result = $conn->query("SELECT id, nome FROM paises ORDER BY nome");
$tipos_refeicao_result = $conn->query("SELECT id, nome FROM tipos_refeicao ORDER BY nome");
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

// Verifica se o ID da receita foi passado e é um número
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $receita_id = intval($_GET['id']);

    // Busca os detalhes da receita existente
    $sql_select = "SELECT * FROM receitas WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $receita_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($result_select->num_rows > 0) {
        $receita = $result_select->fetch_assoc();
    } else {
        $mensagem = "<p style='color:red;'>Receita não encontrada.</p>";
    }
    $stmt_select->close();
} else {
    $mensagem = "<p style='color:red;'>ID da receita inválido ou não fornecido.</p>";
}

// Verifica permissão para editar
if ($receita && $receita['usuario_id'] != $_SESSION['usuario_id'] && (isset($_SESSION['is_admin']) && !$_SESSION['is_admin'])) {
    $mensagem = "<p style='color:red;'>Você não tem permissão para editar esta receita.</p>";
    $receita = null;
}

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && $receita_id) {
    $nome = $_POST['nome'];
    $pais_id = $_POST['pais_id'];
    $tipo_refeicao_id = $_POST['tipo_refeicao_id'];
    $categoria_id = $_POST['categoria_id'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo'];
    $info_adicional = isset($_POST['info_adicional']) ? $_POST['info_adicional'] : '';

    if (empty($nome) || empty($pais_id) || empty($tipo_refeicao_id) || empty($categoria_id) || empty($ingredientes) || empty($preparo)) {
        $mensagem = "<p style='color:red;'>Todos os campos obrigatórios devem ser preenchidos.</p>";
    } else {
        $foto_nome_novo = $receita['foto'];
        $update_foto = false;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/receitas/';
            $nome_arquivo = basename($_FILES['foto']['name']);
            $nome_foto_unico = uniqid() . '-' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $nome_arquivo);
            $caminho_foto_novo = $upload_dir . $nome_foto_unico;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto_novo)) {
                if (!empty($receita['foto']) && !filter_var($receita['foto'], FILTER_VALIDATE_URL)) {
                    $caminho_foto_antiga = $upload_dir . $receita['foto'];
                    if (file_exists($caminho_foto_antiga)) { unlink($caminho_foto_antiga); }
                }
                $foto_nome_novo = $nome_foto_unico;
                $update_foto = true;
            } else {
                $mensagem = "<p style='color:red;'>Erro ao fazer upload da nova foto.</p>";
            }
        }

        if (empty($mensagem)) {
            if ($update_foto) {
                $sql_update = "UPDATE receitas SET nome = ?, pais_id = ?, tipo_refeicao_id = ?, categoria_id = ?, ingredientes = ?, preparo = ?, info_adicional = ?, foto = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("siiissssi", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $foto_nome_novo, $receita_id);
            } else {
                $sql_update = "UPDATE receitas SET nome = ?, pais_id = ?, tipo_refeicao_id = ?, categoria_id = ?, ingredientes = ?, preparo = ?, info_adicional = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("siiisssi", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $receita_id);
            }

            if ($stmt_update->execute()) {
                // --- MUDANÇA PRINCIPAL AQUI ---
                // Em vez de recarregar os dados, redirecionamos para a mesma página com um status de sucesso
                header("Location: editar_receita.php?id=" . $receita_id . "&status=sucesso");
                exit(); // É crucial chamar exit() após um redirecionamento
            } else {
                $mensagem = "<p style='color:red;'>Erro ao atualizar receita: " . $stmt_update->error . "</p>";
            }
            $stmt_update->close();
        }
    }
}
?>

<div class="container">
    <?php if ($receita): ?>
        <div class="form-container">
            <h2>Editar Receita</h2>
            <p style="text-align: center; margin-top: -1rem; margin-bottom: 2rem; color: var(--grey-text);">"<?php echo htmlspecialchars($receita['nome']); ?>"</p>

            <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>

            <form method="POST" action="editar_receita.php?id=<?php echo $receita_id; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome">Nome da Receita:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>
                </div>
                <div class="form-grid">
                    <div class="form-group"><label for="pais_id">País:</label><select name="pais_id" id="pais_id" required><?php $paises_result->data_seek(0); while($pais = $paises_result->fetch_assoc()): ?><option value="<?php echo $pais['id']; ?>" <?php echo ($receita['pais_id'] == $pais['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($pais['nome']); ?></option><?php endwhile; ?></select></div>
                    <div class="form-group"><label for="tipo_refeicao_id">Tipo de Refeição:</label><select name="tipo_refeicao_id" id="tipo_refeicao_id" required><?php $tipos_refeicao_result->data_seek(0); while($tipo = $tipos_refeicao_result->fetch_assoc()): ?><option value="<?php echo $tipo['id']; ?>" <?php echo ($receita['tipo_refeicao_id'] == $tipo['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tipo['nome']); ?></option><?php endwhile; ?></select></div>
                    <div class="form-group"><label for="categoria_id">Categoria:</label><select name="categoria_id" id="categoria_id" required><?php $categorias_result->data_seek(0); while($cat = $categorias_result->fetch_assoc()): ?><option value="<?php echo $cat['id']; ?>" <?php echo ($receita['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['nome']); ?></option><?php endwhile; ?></select></div>
                </div>
                <hr class="form-separator">
                <div class="form-group"><label for="ingredientes">Ingredientes (um por linha):</label><textarea name="ingredientes" id="ingredientes" rows="10" required><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea></div>
                <div class="form-group"><label for="preparo">Modo de Preparo (um passo por linha):</label><textarea name="preparo" id="preparo" rows="15" required><?php echo htmlspecialchars($receita['preparo']); ?></textarea></div>
                <div class="form-group"><label for="info_adicional">Informações Adicionais / Dicas:</label><textarea id="info_adicional" name="info_adicional" rows="5"><?php echo htmlspecialchars($receita['info_adicional'] ?? ''); ?></textarea></div>
                <hr class="form-separator">
                <div class="form-group">
                    <label for="foto">Alterar Foto da Receita:</label>
                    <img src="<?php echo get_foto_src($receita['foto']); ?>" alt="Foto da Receita" class="foto-preview">
                    <input type="file" id="foto" name="foto" accept="image/*" style="width:100%;">
                </div>
                <input type="submit" value="Atualizar Receita" class="btn" style="width: 100%; padding: 1rem;">
            </form>
        </div>
    <?php else: ?>
        <div class="form-container">
             <?php echo $mensagem ?: "<p>Não foi possível carregar os dados da receita para edição.</p>"; ?>
        </div>
    <?php endif; ?>
</div>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>