<?php
require_once('../includes/header.php');
require_once('../../config.php');

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    echo "<div class='container'><div class='form-container'><p style='color:red;text-align:center;'>Acesso negado.</p></div></div>";
    require_once('../includes/footer.php');
    exit();
}
?>

<main class="container admin-dashboard" aria-labelledby="admin-title">
    <h1 id="admin-title" class="section-title" style="text-align:left;">Painel Administrativo</h1>
    <p style="margin:-1rem 0 2rem;color:var(--grey-text);max-width:760px;">Gerencie recursos avançados do Sabor em Clique. Apenas administradores têm acesso a estas funções sensíveis. Proceda com cautela ao remover dados.</p>

    <div class="admin-cards-grid">
        <article class="admin-card">
            <h2>Usuários</h2>
            <p>Promova, edite ou remova contas de usuários.</p>
            <a class="mini-btn" href="../usuarios/gerenciar_usuarios.php">Gerenciar Usuários</a>
        </article>
        <article class="admin-card">
            <h2>Duplicatas</h2>
            <p>Localize e elimine receitas duplicadas mantendo a versão correta.</p>
            <a class="mini-btn" href="../comidas/Gerenciar_duplicatas.php">Gerenciar Duplicatas</a>
        </article>
        <article class="admin-card">
            <h2>Receitas</h2>
            <p>Cadastrar, revisar e manter a base de receitas.</p>
            <a class="mini-btn" href="../comidas/cadastrar_receita.php">Nova Receita</a>
        </article>
        <article class="admin-card">
            <h2>Relatórios</h2>
            <p>(Futuro) Estatísticas de uso e conteúdo mais acessado.</p>
            <button class="mini-btn" disabled style="opacity:.5;cursor:not-allowed;">Em breve</button>
        </article>
    </div>
</main>

<style>
.admin-dashboard { padding-top:2rem; }
.admin-cards-grid { display:grid; gap:2rem; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); margin-top:1rem; }
.admin-card { background:#fff; border:1.5px solid var(--border-color); border-radius:18px; padding:1.4rem 1.4rem 1.6rem; position:relative; box-shadow: var(--shadow-card); display:flex; flex-direction:column; gap:.6rem; }
.admin-card h2 { font-size:1.25rem; margin:0; font-family:var(--font-heading); color:var(--orange-dark); }
.admin-card p { font-size:.9rem; color:var(--grey-text); line-height:1.4; }
.admin-card .mini-btn { margin-top:auto; background:var(--gradient-btn); color:#fff; text-decoration:none; font-weight:600; font-size:.75rem; padding:.55rem 1rem; border-radius:40px; display:inline-flex; align-items:center; gap:.35rem; border:none; }
.admin-card .mini-btn:hover:not([disabled]) { background:var(--orange-dark); }
@media (prefers-reduced-motion:no-preference) { .admin-card { transition: transform .35s cubic-bezier(.4,0,.2,1), box-shadow .35s; } .admin-card:hover { transform:translateY(-6px); box-shadow: var(--shadow-hover); } }
</style>

<?php require_once('../includes/footer.php'); ?>
