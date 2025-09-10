<?php
require_once('../includes/header.php');
require_once('../../config.php');
 
// Se o usuário já estiver logado, redireciona para a página inicial
if (isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/");
    exit();
}

$mensagem = '';
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem = "<p style='color:green;'>Usuário criado com sucesso! Faça o login.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header("Location: /coutopasta/"); // Redireciona para a página principal
            exit();
        } else {
            $mensagem = "<p style='color:red;'>Email ou senha incorretos.</p>";
        }
    } else {
        $mensagem = "<p style='color:red;'>Email ou senha incorretos.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<h2>Login</h2>
<?php echo $mensagem; ?>
<form method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <input type="submit" value="Entrar">
</form>

<?php require_once('../includes/footer.php'); ?>
