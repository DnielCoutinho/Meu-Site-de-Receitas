<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

$mensagem = '';

// Busca categorias e subcategorias para os dropdowns
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");
$subcategorias_result = $conn->query("SELECT id, nome FROM subcategorias ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $categoria_id = $_POST['categoria_id'];
    $subcategoria_id = $_POST['subcategoria_id'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo'];
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($nome) || empty($categoria_id) || empty($subcategoria_id) || empty($ingredientes) || empty($preparo)) {
        $mensagem = "<p style='color:red;'>Todos os campos são obrigatórios.</p>";
    } else {
        $sql = "INSERT INTO comidas (nome, categoria_id, subcategoria_id, ingredientes, preparo, usuario_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siissi", $nome, $categoria_id, $subcategoria_id, $ingredientes, $preparo, $usuario_id);

        if ($stmt->execute()) {
            $mensagem = "<p style='color:green;'>Receita cadastrada com sucesso!</p>";
        } else {
            $mensagem = "<p style='color:red;'>Erro ao cadastrar receita: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<h2>Cadastrar Nova Receita</h2>
<?php echo $mensagem; ?>
<form method="POST">
    <label for="nome">Nome da Receita:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="categoria_id">Categoria:</label>
    <select name="categoria_id" id="categoria_id" required>
        <option value="">Selecione uma categoria</option>
        <?php while($cat = $categorias_result->fetch_assoc()): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="subcategoria_id">Subcategoria:</label>
    <select name="subcategoria_id" id="subcategoria_id" required>
        <option value="">Selecione uma subcategoria</option>
        <?php while($sub = $subcategorias_result->fetch_assoc()): ?>
            <option value="<?php echo $sub['id']; ?>"><?php echo htmlspecialchars($sub['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="ingredientes">Ingredientes:</label>
    <textarea name="ingredientes" id="ingredientes" rows="8" placeholder="Liste os ingredientes, um por linha." required></textarea>

    <label for="preparo">Modo de Preparo:</label>
    <textarea name="preparo" id="preparo" rows="12" placeholder="Descreva o passo a passo da receita." required></textarea>

    <input type="submit" value="Cadastrar Receita">
</form>

<style>
    select, textarea {
        width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif;
    }
</style>

<?php require_once('../includes/footer.php'); ?>