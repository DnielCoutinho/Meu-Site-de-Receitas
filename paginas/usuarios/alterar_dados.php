<?php
require_once('../includes/header.php');
require_once('../../config.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];
$mensagem = '';

$stmt_select = $conn->prepare("SELECT nome, email FROM usuarios WHERE id = ?");
$stmt_select->bind_param("i", $usuario_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
$usuario = $result->fetch_assoc();
$stmt_select->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $novo_nome, $novo_email, $usuario_id);

    if ($stmt->execute()) {
        $mensagem = "<p style='color:green;'>Dados alterados com sucesso!</p>";
        $_SESSION['usuario_nome'] = $novo_nome;
        $usuario['nome'] = $novo_nome;
        $usuario['email'] = $novo_email;
    } else {
        $mensagem = "<p style='color:red;'>Erro ao alterar dados: " . $stmt->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>

<div class="container">
    <div class="form-container">
        <h2>Alterar Dados Cadastrais</h2>
        <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Salvar Alterações" class="btn" style="width: 100%;">
            </div>
        </form>
         <div style="text-align: center; margin-top: 20px;">
            <p><a href="alterar_senha.php">Deseja alterar sua senha?</a></p>
        </div>
    </div>
</div>

<?php require_once('../includes/footer.php'); ?>