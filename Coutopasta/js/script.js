document.addEventListener('DOMContentLoaded', function() {
    // 1. Lógica do Menu Hambúrguer
    const hamburger = document.querySelector('.hamburger-menu');
    const nav = document.querySelector('.main-nav');
    const body = document.querySelector('body');

    if (hamburger && nav) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita que o clique feche o menu imediatamente
            nav.classList.toggle('is-active');
            // Animação do ícone
            hamburger.classList.toggle('is-active');
        });

        // Fecha o menu se clicar fora dele
        document.addEventListener('click', (e) => {
            if (nav.classList.contains('is-active') && !nav.contains(e.target)) {
                nav.classList.remove('is-active');
                hamburger.classList.remove('is-active');
            }
        });
    }

    // 2. Lógica de Filtros Dinâmicos da Página Inicial
    const filterContainer = document.querySelector('.filter-container');
    const recipesGrid = document.querySelector('.receitas-grid');

    function displayRecipes(receitas) {
        if (!recipesGrid) return;
        recipesGrid.innerHTML = '';
        if (receitas && receitas.length > 0) {
            receitas.forEach(receita => {
                const fotoSrc = receita.foto;
                let imagePath = (fotoSrc && fotoSrc.startsWith('http')) ? fotoSrc : (fotoSrc ? `/coutopasta/uploads/receitas/${fotoSrc}` : '/coutopasta/assets/placeholder.svg');
                
                const card = `
                    <article class="receita-card">
                        <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=${receita.id}" style="text-decoration: none; color: inherit;">
                            <img src="${imagePath}" alt="Foto de ${receita.nome}">
                            <div class="receita-card-content">
                                <h3>${receita.nome}</h3>
                                <span class="btn" style="width: 100%; margin-top: 1rem;">Ver Receita</span>
                            </div>
                        </a>
                    </article>`;
                recipesGrid.innerHTML += card;
            });
        } else {
            recipesGrid.innerHTML = '<p style="text-align:center; grid-column: 1 / -1;">Nenhuma receita encontrada para esta categoria.</p>';
        }
    }

    async function fetchRecipes(categoryId = '') {
        try {
            const response = await fetch(`/coutopasta/api/get_receitas.php?categoria_id=${categoryId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            displayRecipes(data.receitas);
        } catch (error) {
            console.error('Erro ao buscar receitas:', error);
            if (recipesGrid) recipesGrid.innerHTML = '<p>Erro ao carregar as receitas.</p>';
        }
    }

    async function initFilters() {
        if (!filterContainer) return;
        try {
            const response = await fetch('/coutopasta/api/get_receitas.php');
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const data = await response.json();
            if (data.categorias && data.categorias.length > 0) {
                data.categorias.forEach(cat => {
                    const btn = document.createElement('a');
                    btn.href = '#';
                    btn.className = 'filter-btn';
                    btn.dataset.category = cat.id;
                    btn.textContent = cat.nome;
                    filterContainer.appendChild(btn);
                });
            }
        } catch (error) {
            console.error('Erro ao inicializar filtros:', error);
        }
    }

    if (filterContainer) {
        filterContainer.addEventListener('click', (e) => {
            e.preventDefault();
            if (e.target.classList.contains('filter-btn')) {
                if (filterContainer.querySelector('.active')) {
                    filterContainer.querySelector('.active').classList.remove('active');
                }
                e.target.classList.add('active');
                const categoryId = e.target.dataset.category || '';
                fetchRecipes(categoryId);
            }
        });
        
        // Carga inicial das receitas e filtros
        fetchRecipes();
        initFilters();
    }
});