<?php
require_once('../includes/header.php');
require_once('../../config.php');

$mensagem = '';
$token = $_GET['token'];

if (!$token) {
    header("Location: login.php");
    exit();
}

// Verificar token
$sql = "SELECT * FROM password_resets WHERE token = ? AND expires > ?";
$stmt = $conn->prepare($sql);
$time = time();
$stmt->bind_param("si", $token, $time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $reset_info = $result->fetch_assoc();
    $email = $reset_info['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nova_senha = $_POST['nova_senha'];
        $confirmar_nova_senha = $_POST['confirmar_nova_senha'];

        if ($nova_senha == $confirmar_nova_senha) {
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            // Atualizar senha
            $sql_update = "UPDATE usuarios SET senha = ? WHERE email = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ss", $nova_senha_hash, $email);
            $stmt_update->execute();

            // Deletar token
            $sql_delete = "DELETE FROM password_resets WHERE email = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("s", $email);
            $stmt_delete->execute();

            $mensagem = "<p style='color:green;'>Senha redefinida com sucesso! Você já pode fazer login.</p>";
        } else {
            $mensagem = "<p style='color:red;'>As senhas não coincidem.</p>";
        }
    }
} else {
    $mensagem = "<p style='color:red;'>Token inválido ou expirado.</p>";
}

?>

<div class="form-container">
    <h2>Redefinir Senha</h2>
    <?php echo $mensagem; ?>
    <?php if ($result->num_rows > 0): ?>
    <form method="POST">
        <div class="form-group">
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirmar_nova_senha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" value="Redefinir" class="btn">
        </div>
    </form>
    <?php endif; ?>
</div>

<?php require_once('../includes/footer.php'); ?>
