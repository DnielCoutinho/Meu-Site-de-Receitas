document.addEventListener('DOMContentLoaded', function() {
    // 1. Menu Hambúrguer
    const hamburger = document.querySelector('.hamburger-menu');
    const nav = document.querySelector('.main-nav');

    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            nav.classList.toggle('is-active');
        });
    }

    // 2. Animações de Scroll (Fade-in)
    const fadeInSections = document.querySelectorAll('.fade-in-section');
    const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
    const sectionObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    fadeInSections.forEach(section => {
        sectionObserver.observe(section);
    });

    // 3. Header shrink on scroll
    const header = document.querySelector('.main-header');
    if(header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // 4. Lógica de Filtros de Receitas
    const filterContainer = document.querySelector('.filter-container');
    const recipesGrid = document.querySelector('.receitas-grid');

    // Função para renderizar as receitas na tela
    function displayRecipes(receitas) {
        if (!recipesGrid) return;
        recipesGrid.innerHTML = ''; // Limpa a grade
        if (receitas && receitas.length > 0) {
            receitas.forEach(receita => {
                const fotoSrc = receita.foto;
                let imagePath;

                if (fotoSrc && fotoSrc.startsWith('http')) {
                    imagePath = fotoSrc;
                } else if (fotoSrc) {
                    imagePath = `/coutopasta/uploads/receitas/${fotoSrc}`;
                } else {
                    imagePath = `/coutopasta/assets/placeholder.svg`;
                }

                const card = `
                    <article class="receita-card">
                        <img src="${imagePath}" alt="Foto de ${receita.nome}">
                        <div class="receita-card-content">
                            <h3>${receita.nome}</h3>
                            <a href="/coutopasta/paginas/comidas/visualizar_receita.php?id=${receita.id}" class="btn">Ver Receita</a>
                        </div>
                    </article>
                `;
                recipesGrid.innerHTML += card;
            });
        } else {
            recipesGrid.innerHTML = '<p>Nenhuma receita encontrada para esta categoria.</p>';
        }
    }

    // Função para buscar as receitas de uma categoria específica
    async function fetchRecipes(categoryId = 'all') {
        try {
            const response = await fetch(`/coutopasta/api/get_receitas.php?categoria_id=${categoryId}`);
            const data = await response.json();
            displayRecipes(data.receitas);
        } catch (error) {
            console.error('Erro ao buscar receitas:', error);
            if (recipesGrid) recipesGrid.innerHTML = '<p>Erro ao carregar as receitas.</p>';
        }
    }

    // Função para buscar as categorias e criar os botões de filtro
    async function initFilters() {
        if (!filterContainer) return;
        try {
            const response = await fetch('/coutopasta/api/get_receitas.php');
            const data = await response.json();
            if (data.categorias && data.categorias.length > 0) {
                // Limpa filtros antigos, exceto o botão "Todas"
                while (filterContainer.children.length > 1) {
                    filterContainer.removeChild(filterContainer.lastChild);
                }
                // Adiciona os novos botões de filtro
                data.categorias.forEach(cat => {
                    const btn = document.createElement('button');
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

    // Adiciona o listener de evento para os cliques nos filtros
    if (filterContainer) {
        filterContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('filter-btn')) {
                if (filterContainer.querySelector('.active')) {
                    filterContainer.querySelector('.active').classList.remove('active');
                }
                e.target.classList.add('active');
                const categoryId = e.target.dataset.category;
                fetchRecipes(categoryId);
            }
        });
    }

    // Carga Inicial: Apenas inicializa os filtros.
    // As receitas iniciais já são carregadas pelo PHP no index.php.
    initFilters();

});