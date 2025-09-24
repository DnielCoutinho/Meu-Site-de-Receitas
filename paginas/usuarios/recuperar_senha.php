<?php
require_once('../includes/header.php');
// require_once('../../config.php'); // O header.php já inclui o config.php

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verificar se o email existe
    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Gerar token
        $token = bin2hex(random_bytes(50));
        $expires = time() + 3600; // 1 hora

        // Armazenar token no banco de dados
        $sql_insert = "INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssi", $email, $token, $expires);
        $stmt_insert->execute();

        // Simular envio de email usando a BASE_URL
        $reset_link = "http://localhost" . BASE_URL . "/paginas/usuarios/redefinir_senha.php?token=" . $token;
        $mensagem = "<p style='color:green;'>Um link para redefinição de senha foi gerado. Acesse: <a href='" . $reset_link . "'>" . $reset_link . "</a></p>";

    } else {
        $mensagem = "<p style='color:red;'>Nenhum usuário encontrado com este email.</p>";
    }
}
?>

<div class="form-container">
    <h2>Recuperar Senha</h2>
    <?php echo $mensagem; ?>
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Recuperar" class="btn">
        </div>
    </form>
</div>

<?php require_once('../includes/footer.php'); ?>