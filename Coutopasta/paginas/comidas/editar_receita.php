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
    $receita = null; // Impede que o formulário seja exibido
}


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
        $foto_nome_novo = $receita['foto']; // Manter a foto antiga por padrão
        $update_foto = false;

        // Verifica se uma nova foto foi enviada
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/receitas/';
            $nome_arquivo = basename($_FILES['foto']['name']);
            $nome_foto_unico = uniqid() . '-' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $nome_arquivo);
            $caminho_foto_novo = $upload_dir . $nome_foto_unico;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto_novo)) {
                // Se o upload deu certo, define o novo nome da foto
                $foto_nome_novo = $nome_foto_unico;
                $update_foto = true;

                // Apaga a foto antiga, se ela existir
                if (!empty($receita['foto']) && file_exists($upload_dir . $receita['foto'])) {
                    unlink($upload_dir . $receita['foto']);
                }
            } else {
                $mensagem = "<p style='color:red;'>Erro ao fazer upload da nova foto.</p>";
            }
        }

        if (empty($mensagem)) {
            // Se uma nova foto foi enviada, atualiza o campo 'foto'
            if ($update_foto) {
                $sql_update = "UPDATE receitas SET nome = ?, pais_id = ?, tipo_refeicao_id = ?, categoria_id = ?, ingredientes = ?, preparo = ?, info_adicional = ?, foto = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("siiissssi", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $foto_nome_novo, $receita_id);
            } else {
                // Se não, atualiza todo o resto, menos a foto
                $sql_update = "UPDATE receitas SET nome = ?, pais_id = ?, tipo_refeicao_id = ?, categoria_id = ?, ingredientes = ?, preparo = ?, info_adicional = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("siiisssi", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $receita_id);
            }

            if ($stmt_update->execute()) {
                $mensagem = "<p style='color:green;'>Receita atualizada com sucesso!</p>";
                // Recarrega os dados da receita para refletir as mudanças no formulário
                $stmt_select = $conn->prepare("SELECT * FROM receitas WHERE id = ?");
                $stmt_select->bind_param("i", $receita_id);
                $stmt_select->execute();
                $receita = $stmt_select->get_result()->fetch_assoc();
                $stmt_select->close();
            } else {
                $mensagem = "<p style='color:red;'>Erro ao atualizar receita: " . $stmt_update->error . "</p>";
            }
            $stmt_update->close();
        }
    }
}

?>

<h2>Editar Receita: <?php echo htmlspecialchars($receita['nome'] ?? 'Nova Receita'); ?></h2>
<?php echo $mensagem; ?>

<?php if ($receita): ?>
<form method="POST" enctype="multipart/form-data">
    <label for="nome">Nome da Receita:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>

    <label for="pais_id">País:</label>
    <select name="pais_id" id="pais_id" required>
        <option value="">Selecione um país</option>
        <?php
        $paises_result->data_seek(0);
        while($pais = $paises_result->fetch_assoc()): ?>
            <option value="<?php echo $pais['id']; ?>" <?php echo ($receita['pais_id'] == $pais['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($pais['nome']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="tipo_refeicao_id">Tipo de Refeição:</label>
    <select name="tipo_refeicao_id" id="tipo_refeicao_id" required>
        <option value="">Selecione um tipo de refeição</option>
        <?php
        $tipos_refeicao_result->data_seek(0);
        while($tipo = $tipos_refeicao_result->fetch_assoc()): ?>
            <option value="<?php echo $tipo['id']; ?>" <?php echo ($receita['tipo_refeicao_id'] == $tipo['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($tipo['nome']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="categoria_id">Categoria:</label>
    <select name="categoria_id" id="categoria_id" required>
        <option value="">Selecione uma categoria</option>
        <?php
        $categorias_result->data_seek(0);
        while($cat = $categorias_result->fetch_assoc()): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo ($receita['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($cat['nome']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label for="ingredientes">Ingredientes:</label>
    <textarea name="ingredientes" id="ingredientes" rows="8" required><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea>

    <label for="preparo">Modo de Preparo:</label>
    <textarea name="preparo" id="preparo" rows="12" required><?php echo htmlspecialchars($receita['preparo']); ?></textarea>

    <label for="info_adicional">Informações adicionais / Dicas (opcional):</label>
    <textarea id="info_adicional" name="info_adicional" rows="5"><?php echo htmlspecialchars($receita['info_adicional'] ?? ''); ?></textarea>

    <label for="foto">Alterar Foto da Receita (opcional):</label>
    <?php if (!empty($receita['foto'])): ?>
        <p>Foto atual:</p>
        <img src="/coutopasta/uploads/receitas/<?php echo htmlspecialchars($receita['foto']); ?>" alt="Foto da Receita" style="max-width: 200px; height: auto; margin-bottom: 15px; border-radius: 8px;">
    <?php endif; ?>
    <input type="file" id="foto" name="foto" accept="image/*">

    <input type="submit" value="Atualizar Receita">
</form>
<?php else: ?>
    <p>Não foi possível carregar os dados da receita para edição.</p>
<?php endif; ?>

<style>
    select, textarea {
        width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif;
    }
</style>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>