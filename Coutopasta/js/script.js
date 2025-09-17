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

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

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

    // 3. Slider de Depoimentos
    const slider = document.querySelector('.testimonial-slider');
    if (slider) {
        const testimonials = slider.querySelectorAll('.testimonial');
        let currentIndex = 0;

        function showTestimonial(index) {
            testimonials.forEach((testimonial, i) => {
                testimonial.classList.remove('active');
                if (i === index) {
                    testimonial.classList.add('active');
                }
            });
        }

        function nextTestimonial() {
            currentIndex = (currentIndex + 1) % testimonials.length;
            showTestimonial(currentIndex);
        }

        // Mostra o primeiro e inicia o intervalo
        if (testimonials.length > 0) {
            showTestimonial(currentIndex);
            setInterval(nextTestimonial, 5000); // Troca a cada 5 segundos
        }
    }

    // 4. Header shrink on scroll
    const header = document.querySelector('.main-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // 4. Filtros de Receitas
    const filterContainer = document.querySelector('.filter-container');
    const recipesGrid = document.querySelector('.receitas-grid');

    async function fetchAndDisplayData(categoryId = 'all') {
        try {
            const response = await fetch(`/coutopasta/api/get_receitas.php?categoria_id=${categoryId}`);
            const data = await response.json();

            // Popula os botões de filtro (apenas uma vez)
            if (filterContainer && filterContainer.children.length === 1) {
                data.categorias.forEach(cat => {
                    const btn = document.createElement('button');
                    btn.className = 'filter-btn';
                    btn.dataset.category = cat.id;
                    btn.textContent = cat.nome;
                    filterContainer.appendChild(btn);
                });
            }

            // Atualiza a grade de receitas
            if (recipesGrid) {
                recipesGrid.innerHTML = ''; // Limpa a grade
                if (data.receitas.length > 0) {
                    data.receitas.forEach(receita => {
                        const card = `
                            <article class="receita-card">
                                <img src="/coutopasta/paginas/comidas/imagem_receita.php?id=${receita.id}" alt="Foto de ${receita.nome}">
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
        } catch (error) {
            console.error('Erro ao buscar dados:', error);
            if (recipesGrid) recipesGrid.innerHTML = '<p>Erro ao carregar as receitas. Tente novamente mais tarde.</p>';
        }
    }

    if (filterContainer) {
        filterContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('filter-btn')) {
                // Atualiza o botão ativo
                filterContainer.querySelector('.active').classList.remove('active');
                e.target.classList.add('active');
                
                // Busca e exibe as receitas da categoria selecionada
                const categoryId = e.target.dataset.category;
                fetchAndDisplayData(categoryId);
            }
        });
    }

    // Carga inicial
    if (recipesGrid) {
       // A carga inicial agora é feita pelo PHP, então não precisamos chamar aqui
       // Apenas populamos os filtros
       fetch('/coutopasta/api/get_receitas.php')
        .then(res => res.json())
        .then(data => {
            if (filterContainer && filterContainer.children.length === 1) {
                data.categorias.forEach(cat => {
                    const btn = document.createElement('button');
                    btn.className = 'filter-btn';
                    btn.dataset.category = cat.id;
                    btn.textContent = cat.nome;
                    filterContainer.appendChild(btn);
                });
            }
        });
    }

    // 5. Validação de Formulário
    const formsToValidate = document.querySelectorAll('.form-validate');

    formsToValidate.forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            
            const fields = form.querySelectorAll('[data-validate]');

            fields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                event.preventDefault();
                // Opcional: Focar no primeiro campo inválido
                const firstInvalidField = form.querySelector('.invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
            }
        });

        const fields = form.querySelectorAll('[data-validate]');
        fields.forEach(field => {
            field.addEventListener('blur', () => validateField(field)); // Valida ao sair do campo
            field.addEventListener('input', () => clearError(field)); // Limpa o erro ao digitar
        });
    });

    function validateField(field) {
        const validationTypes = field.dataset.validate.split(' ');
        let fieldIsValid = true;

        for (const type of validationTypes) {
            if (!runValidation(type, field)) {
                fieldIsValid = false;
                break; 
            }
        }
        return fieldIsValid;
    }

    function runValidation(type, field) {
        let isValid = true;
        let errorMessage = '';

        switch(type) {
            case 'required':
                isValid = field.value.trim() !== '';
                errorMessage = 'Este campo é obrigatório.';
                break;
            case 'email':
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value);
                errorMessage = 'Por favor, insira um email válido.';
                break;
            case 'password':
                isValid = field.value.length >= 6;
                errorMessage = 'A senha deve ter no mínimo 6 caracteres.';
                break;
            case 'match':
                const matchTo = document.querySelector(field.dataset.match);
                isValid = field.value === matchTo.value;
                errorMessage = 'As senhas não correspondem.';
                break;
        }

        if (!isValid) {
            showError(field, errorMessage);
        } else {
            clearError(field);
        }
        return isValid;
    }

    function showError(field, message) {
        field.classList.add('invalid');
        const formGroup = field.closest('.form-group');
        let errorContainer = formGroup.querySelector('.error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.className = 'error-message';
            formGroup.appendChild(errorContainer);
        }
        errorContainer.textContent = message;
        errorContainer.style.display = 'block';
    }

    function clearError(field) {
        field.classList.remove('invalid');
        const formGroup = field.closest('.form-group');
        const errorContainer = formGroup.querySelector('.error-message');
        if (errorContainer) {
            errorContainer.style.display = 'none';
        }
    }
});
