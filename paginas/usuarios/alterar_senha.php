<?php
require_once('../includes/header.php');
require_once('../../config.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... Lógica de alteração de senha ...
}
?>

<div class="container">
    <div class="form-container">
        <h2>Alterar Senha</h2>
        <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="senha_atual">Senha Atual:</label>
                <input type="password" id="senha_atual" name="senha_atual" required>
            </div>
            <div class="form-group">
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" required>
            </div>
            <div class="form-group">
                <label for="confirmar_nova_senha">Confirmar Nova Senha:</label>
                <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Alterar Senha" class="btn" style="width: 100%;">
            </div>
        </form>
    </div>
</div>

<?php require_once('../includes/footer.php'); ?>