<?php
require_once('../includes/header.php');
require_once('../../config.php');

// 1. GARANTIR QUE APENAS ADMINS POSSAM VER ESTA PÁGINA
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo "<div class='container'><div class='form-container'><p style='color:red; text-align:center;'>Acesso Negado. Apenas administradores podem acessar esta página.</p></div></div>";
    require_once('../includes/footer.php');
    exit();
}

$mensagem = '';
$usuario_logado_id = $_SESSION['usuario_id'];

// 2. PROCESSAR A MUDANÇA DE STATUS (PROMOVER/REMOVER ADMIN)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_admin_status'])) {
    $usuario_id_alvo = intval($_POST['usuario_id']);

    // Um admin não pode remover o próprio status de admin
    if ($usuario_id_alvo == $usuario_logado_id) {
        $mensagem = "<p style='color:red;'>Ação não permitida. Você não pode alterar seu próprio status de administrador.</p>";
    } else {
        // Busca o status atual para invertê-lo
        $stmt_check = $conn->prepare("SELECT is_admin FROM usuarios WHERE id = ?");
        $stmt_check->bind_param("i", $usuario_id_alvo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($user_alvo = $result_check->fetch_assoc()) {
            $novo_status = $user_alvo['is_admin'] ? 0 : 1; // Inverte o status (1 vira 0, 0 vira 1)

            $stmt_update = $conn->prepare("UPDATE usuarios SET is_admin = ? WHERE id = ?");
            $stmt_update->bind_param("ii", $novo_status, $usuario_id_alvo);
            
            if ($stmt_update->execute()) {
                $mensagem = "<p style='color:green;'>Status do usuário atualizado com sucesso!</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao atualizar o status do usuário.</p>";
            }
            $stmt_update->close();
        }
        $stmt_check->close();
    }
}

// 3. BUSCAR TODOS OS USUÁRIOS PARA EXIBIR NA TABELA
$result_usuarios = $conn->query("SELECT id, nome, email, is_admin FROM usuarios ORDER BY nome ASC");

?>

<div class="container">
    <div class="form-container">
        <h2>Gerenciar Usuários</h2>
        <p style="text-align: center; margin-top: -1rem; margin-bottom: 2rem; color: var(--grey-text);">
            Promova usuários a administradores ou remova o acesso de administrador.
        </p>
        
        <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1.5rem;'>$mensagem</div>"; ?>

        <div class="user-table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Admin?</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($usuario = $result_usuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $usuario['id']; ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td>
                                <?php if ($usuario['is_admin']): ?>
                                    <span class="status-admin">Sim</span>
                                <?php else: ?>
                                    <span class="status-user">Não</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($usuario['id'] == $usuario_logado_id): ?>
                                    <span class="is-you">(Você)</span>
                                <?php else: ?>
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                                        <?php if ($usuario['is_admin']): ?>
                                            <button type="submit" name="toggle_admin_status" class="btn-action remove">Remover Admin</button>
                                        <?php else: ?>
                                            <button type="submit" name="toggle_admin_status" class="btn-action promote">Tornar Admin</button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>