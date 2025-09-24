document.addEventListener('DOMContentLoaded', () => {
    /* ================= MENU HAMBÚRGUER ACESSÍVEL ================= */
    const hamburger = document.querySelector('.hamburger-menu');
    const nav = document.querySelector('.main-nav');
    if (hamburger && nav) {
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.setAttribute('aria-label', 'Abrir menu');
        hamburger.addEventListener('click', e => {
            e.stopPropagation();
            const active = nav.classList.toggle('is-active');
            hamburger.classList.toggle('is-active', active);
            hamburger.setAttribute('aria-expanded', active ? 'true' : 'false');
        });
        document.addEventListener('click', e => {
            if (nav.classList.contains('is-active') && !nav.contains(e.target) && e.target !== hamburger) {
                nav.classList.remove('is-active');
                hamburger.classList.remove('is-active');
                hamburger.setAttribute('aria-expanded','false');
            }
        });
    }

    /* =================== ELEMENTOS BASE =================== */
    const filterContainer = document.querySelector('.filter-container');
    // Grid principal ("Nossas Receitas") precisa ser o dentro de #all-recipes
    const allRecipesGrid = document.querySelector('#all-recipes .receitas-grid');
    const featuredTrack = document.getElementById('featured-track');
    const prevBtn = document.querySelector('.carousel-btn.prev');
    const nextBtn = document.querySelector('.carousel-btn.next');
    const indicatorsWrapper = document.getElementById('carousel-indicators');
    const globalSearchInput = document.querySelector('.global-search-bar input[name="q"]');
    // Seção 'Recentes' removida
    const popularesGrid = document.querySelector('.receitas-populares');
    const suggestionsList = document.getElementById('search-suggestions');
    const clearBtn = document.querySelector('.clear-search-btn');
    let suggestions = [];
    let activeIndex = -1;
    let debounceTimer;

    function debounce(fn, delay=280){ return (...args)=>{ clearTimeout(debounceTimer); debounceTimer=setTimeout(()=>fn(...args), delay); }; }

    async function fetchSuggestions(query){
        if(!query || query.length < 2){ hideSuggestions(); return; }
        try {
                const origin = window.location.origin.replace(/\/$/,'');
                const base = (typeof baseURL === 'string' ? baseURL : '').replace(/\/$/,'');
                const r = await fetch(`${origin}${base}/api/get_receitas.php?q=${encodeURIComponent(query)}`);
            if(!r.ok) throw new Error(r.status);
            const data = await r.json();
            suggestions = (data.receitas || []).slice(0,8);
            renderSuggestions(query);
        } catch(e){ console.error('Sugestões erro', e); }
    }

    function renderSuggestions(query){
        if(!suggestionsList) return;
        suggestionsList.innerHTML='';
        if(!suggestions.length){ hideSuggestions(); return; }
        suggestions.forEach((rec, idx)=>{
            const li=document.createElement('li');
            li.role='option';
            li.id=`sugg-${idx}`;
            li.dataset.id=rec.id;
            li.innerHTML=`<i class="material-icons" aria-hidden="true">restaurant_menu</i><span class="label">${highlight(rec.nome, query)}</span>`;
            li.addEventListener('mousedown', e=>{ // usar mousedown para não perder foco antes do submit
                e.preventDefault(); goToRecipe(rec.id);
            });
            suggestionsList.appendChild(li);
        });
        suggestionsList.hidden=false;
        globalSearchInput.setAttribute('aria-expanded','true');
        activeIndex=-1;
    }

    function hideSuggestions(){ if(suggestionsList){ suggestionsList.hidden=true; suggestionsList.innerHTML=''; } if(globalSearchInput){ globalSearchInput.setAttribute('aria-expanded','false'); } activeIndex=-1; }
    function highlight(text, q){ const re=new RegExp('('+q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')+')','ig'); return text.replace(re,'<mark style="background:#ffe8d1;color:#b04d00;border-radius:4px;padding:0 2px;">$1</mark>'); }
    function goToRecipe(id){ window.location.href = `${baseURL}/paginas/comidas/visualizar_receita.php?id=${id}`; }
    const debouncedFetch = debounce(fetchSuggestions, 300);

    if(globalSearchInput){
        globalSearchInput.addEventListener('input', e=>{
            const v=e.target.value.trim();
            clearBtn.hidden = !v.length;
            debouncedFetch(v);
        });
        globalSearchInput.addEventListener('keydown', e=>{
            if(suggestionsList.hidden) return;
            const max = suggestions.length;
            if(e.key==='ArrowDown'){ e.preventDefault(); activeIndex = (activeIndex+1)%max; updateActive(); }
            else if(e.key==='ArrowUp'){ e.preventDefault(); activeIndex = (activeIndex-1+max)%max; updateActive(); }
            else if(e.key==='Enter'){ if(activeIndex>-1){ e.preventDefault(); goToRecipe(suggestions[activeIndex].id); } }
            else if(e.key==='Escape'){ hideSuggestions(); }
        });
        globalSearchInput.addEventListener('blur', ()=> setTimeout(hideSuggestions, 180));
    }

    function updateActive(){
        [...suggestionsList.children].forEach((li,i)=>{ if(i===activeIndex){ li.setAttribute('aria-selected','true'); li.style.background='#fff4e8'; } else { li.removeAttribute('aria-selected'); li.style.background='transparent'; } });
        if(activeIndex>-1){ suggestionsList.children[activeIndex].scrollIntoView({block:'nearest'}); }
    }

    if(clearBtn && globalSearchInput){
        clearBtn.addEventListener('click', ()=>{ globalSearchInput.value=''; clearBtn.hidden=true; hideSuggestions(); globalSearchInput.focus(); });
    }

    // Atalho: tecla '/' foca na busca (sem estar digitando em outro campo)
    document.addEventListener('keydown', (e) => {
        if (e.key === '/' && !e.metaKey && !e.ctrlKey && !e.altKey) {
            const tag = document.activeElement.tagName;
            if (!['INPUT','TEXTAREA','SELECT'].includes(tag)) {
                e.preventDefault();
                if (globalSearchInput) globalSearchInput.focus();
            }
        }
    });

    /* ============== RENDERIZAÇÃO DE RECEITAS (GRID) ============== */
    function displayRecipes(receitas) {
        if (!allRecipesGrid) return;
        allRecipesGrid.innerHTML = '';
        if (receitas && receitas.length) {
            const frag = document.createDocumentFragment();
            receitas.forEach((r, idx) => {
                const fotoSrc = r.foto;
                const imagePath = (fotoSrc && fotoSrc.startsWith('http')) ? fotoSrc : (fotoSrc ? `${baseURL}/uploads/receitas/${fotoSrc}` : `${baseURL}/assets/placeholder.svg`);
                const article = document.createElement('article');
                article.className = 'receita-card';
                article.style.animationDelay = (idx * 60) + 'ms';
                article.innerHTML = `
                    <a href="${baseURL}/paginas/comidas/visualizar_receita.php?id=${r.id}" aria-label="Ver receita ${r.nome}">
                        <img src="${imagePath}" alt="Foto de ${r.nome}" loading="lazy" />
                        <div class="receita-card-content">
                            <h3>${r.nome}</h3>
                            <span class="btn" style="width:100%;margin-top:auto;">Ver Receita</span>
                        </div>
                    </a>`;
                frag.appendChild(article);
            });
            allRecipesGrid.appendChild(frag);
                    // Fallback: após 1s força visibilidade caso animação não rode
                    setTimeout(()=>{
                        allRecipesGrid.querySelectorAll('.receita-card').forEach(card=>{
                            if (getComputedStyle(card).opacity === '0') {
                                card.classList.add('show-immediate');
                            }
                        });
                    }, 1000);
        } else {
            allRecipesGrid.innerHTML = '<p style="text-align:center;grid-column:1/-1;">Nenhuma receita encontrada.</p>';
        }
    }

    function buildSimpleCards(targetGrid, receitas){
        if(!targetGrid) return;
        targetGrid.innerHTML='';
        if(!receitas.length){ targetGrid.innerHTML='<p style="grid-column:1/-1;text-align:center;">Nenhuma receita.</p>'; return; }
        const frag=document.createDocumentFragment();
        receitas.forEach(r=>{
            const fotoSrc = r.foto;
            const imagePath = (fotoSrc && fotoSrc.startsWith('http')) ? fotoSrc : (fotoSrc ? `${baseURL}/uploads/receitas/${fotoSrc}` : `${baseURL}/assets/placeholder.svg`);
            const art=document.createElement('article');
            art.className='receita-card';
            art.innerHTML=`<a href="${baseURL}/paginas/comidas/visualizar_receita.php?id=${r.id}">
                <img src="${imagePath}" alt="${r.nome}" loading="lazy" />
                <div class='receita-card-content'>
                    <h3>${r.nome}</h3>
                    ${(r.dificuldade||r.tempo_preparo)?`<div style='font-size:.7rem;display:flex;gap:.5rem;flex-wrap:wrap;margin:.4rem 0 .3rem;color:#6b6b6b;'>
                        ${r.tempo_preparo?`<span>⏱ ${r.tempo_preparo}</span>`:''}
                        ${r.dificuldade?`<span>⚙ ${r.dificuldade}</span>`:''}
                    </div>`:''}
                    <span class='btn' style='margin-top:auto;'>Ver Receita</span>
                </div>
            </a>`;
            frag.appendChild(art);
        });
        targetGrid.appendChild(frag);
    }

    async function loadSection(grid, order){
        if(!grid) return;
        try {
                const origin = window.location.origin.replace(/\/$/,'');
                const base = (typeof baseURL === 'string' ? baseURL : '').replace(/\/$/,'');
                const r = await fetch(`${origin}${base}/api/get_receitas.php?order=${order}&limit=8`);
            if(!r.ok) throw new Error(r.status);
            const data = await r.json();
            buildSimpleCards(grid, data.receitas || []);
            console.debug('Seção carregada', order, data.receitas ? data.receitas.length : 0);
        } catch(e){ console.error('Erro seção', order, e); grid.innerHTML='<p style="grid-column:1/-1;text-align:center;">Erro ao carregar.</p>'; }
    }

    async function fetchRecipes(categoryId='', page=1) {
        try {
            const origin = window.location.origin.replace(/\/$/,'');
            const base = (typeof baseURL === 'string' ? baseURL : '').replace(/\/$/,'');
            const absolute = `${origin}${base}/api/get_receitas.php`;
            const url = new URL(absolute);
            if(categoryId) url.searchParams.set('categoria_id', categoryId);
            url.searchParams.set('page', page);
            url.searchParams.set('limit', 24);
            url.searchParams.set('order','recent');
            const finalUrl = url.toString();
            console.debug('[fetchRecipes] URL:', finalUrl);
            const r = await fetch(finalUrl, {headers:{'Accept':'application/json'}});
            if (!r.ok) {
                const txt = await r.text();
                console.error('[fetchRecipes] HTTP error', r.status, txt);
                throw new Error(r.status + ' ' + txt.slice(0,180));
            }
            let rawText = await r.text();
            try {
                const data = JSON.parse(rawText);
                console.debug('[fetchRecipes] Receitas recebidas:', data.receitas ? data.receitas.length : 0);
                displayRecipes(data.receitas || []);
                return;
            } catch(parseErr){
                console.error('[fetchRecipes] Falha ao parsear JSON. Resposta bruta:', rawText);
                throw parseErr;
            }
        } catch(e){
            console.error('Erro fetchRecipes', e);
            if (allRecipesGrid) allRecipesGrid.innerHTML = '<p>Erro ao carregar.</p>';
        }
    }

        async function fetchFeatured() {
            if (!featuredTrack || featuredTrack.dataset.loaded) return;
            try {
                    const origin = window.location.origin.replace(/\/$/,'');
                    const base = (typeof baseURL === 'string' ? baseURL : '').replace(/\/$/,'');
                    const r = await fetch(`${origin}${base}/api/get_receitas.php?featured=1`);
                if (!r.ok) throw new Error(r.status);
                const data = await r.json();
                buildFeaturedCarousel(data.receitas || []);
            } catch(e) { console.error('Erro ao carregar destaques', e); }
        }

    /* ============== FILTROS DINÂMICOS (PILLS) ============== */
    async function initFilters() {
        if (!filterContainer) return;
        try {
            const r = await fetch(`${baseURL}/api/get_receitas.php`);
            if (!r.ok) throw new Error(r.status);
            const data = await r.json();
            if (data.categorias) {
                data.categorias.forEach(cat => {
                    const btn = document.createElement('button');
                    btn.type='button';
                    btn.className='filter-btn';
                    btn.dataset.category=cat.id;
                    btn.setAttribute('aria-pressed','false');
                    btn.textContent=cat.nome;
                    filterContainer.appendChild(btn);
                });
            }
            // Carrega todas as receitas iniciais depois de montar filtros
            fetchRecipes('');
        } catch(e){ console.error('initFilters', e); }
    }

    if (filterContainer) {
        filterContainer.addEventListener('click', e => {
            if (e.target.classList.contains('filter-btn')) {
                const active = filterContainer.querySelector('.filter-btn.active');
                if (active) { active.classList.remove('active'); active.setAttribute('aria-pressed','false'); }
                e.target.classList.add('active');
                e.target.setAttribute('aria-pressed','true');
                fetchRecipes(e.target.dataset.category || '');
            }
        });
        // Botão "Todas" já presente (primeiro elemento HTML): garantir aria
        const first = filterContainer.querySelector('.filter-btn, a.filter-btn');
        if (first) { first.classList.add('active'); first.setAttribute('aria-pressed','true'); }
    }

    /* ============== CARROSSEL DESTAQUE ============== */
    function buildFeaturedCarousel(receitas) {
        if (!featuredTrack) return;
        if (!receitas || !receitas.length) { featuredTrack.dataset.loaded='true'; return; }
        const frag = document.createDocumentFragment();
        receitas.forEach((r, idx) => {
            const fotoSrc = r.foto;
            const imagePath = (fotoSrc && fotoSrc.startsWith('http')) ? fotoSrc : (fotoSrc ? `${baseURL}/uploads/receitas/${fotoSrc}` : `${baseURL}/assets/placeholder.svg`);
            const li = document.createElement('li');
            li.className='carousel-item';
            li.setAttribute('tabindex','0');
            li.innerHTML = `
                <img src="${imagePath}" alt="Imagem da receita ${r.nome}" loading="lazy" />
                <div class="ci-body">
                    <h3>${r.nome}</h3>
                    <p>Experimente ${r.nome} agora mesmo.</p>
                    <a class="mini-btn" href="${baseURL}/paginas/comidas/visualizar_receita.php?id=${r.id}" aria-label="Ver detalhes da receita ${r.nome}">Ver Receita</a>
                </div>`;
            frag.appendChild(li);
            // indicador
            if (indicatorsWrapper) {
                const dot = document.createElement('button');
                dot.setAttribute('aria-label', `Ir para receita ${idx+1}`);
                dot.addEventListener('click', () => scrollToItem(idx));
                if (idx===0) dot.setAttribute('aria-current','true');
                indicatorsWrapper.appendChild(dot);
            }
        });
        featuredTrack.appendChild(frag);
        featuredTrack.dataset.loaded='true';
        updateCarouselButtons();
    }

    function scrollToItem(index) {
        const items = [...featuredTrack.querySelectorAll('.carousel-item')];
        const target = items[index];
        if (!target) return;
        target.scrollIntoView({behavior:'smooth', inline:'start', block:'nearest'});
    }

    function updateCarouselButtons() {
        if (!featuredTrack) return;
        const maxScroll = featuredTrack.scrollWidth - featuredTrack.clientWidth - 5;
        prevBtn && (prevBtn.disabled = featuredTrack.scrollLeft <= 0);
        nextBtn && (nextBtn.disabled = featuredTrack.scrollLeft >= maxScroll);
        if (indicatorsWrapper) {
            const items = [...featuredTrack.querySelectorAll('.carousel-item')];
            const scrollLeft = featuredTrack.scrollLeft;
            let activeIndex = 0;
            let minDistance = Infinity;
            items.forEach((item,i) => {
                const dist = Math.abs(item.offsetLeft - scrollLeft);
                if (dist < minDistance) { minDistance = dist; activeIndex = i; }
            });
            [...indicatorsWrapper.children].forEach((d,i)=>{
                if (i===activeIndex) d.setAttribute('aria-current','true'); else d.removeAttribute('aria-current');
            });
        }
    }

    if (prevBtn) prevBtn.addEventListener('click', ()=> featuredTrack && featuredTrack.scrollBy({left: -featuredTrack.clientWidth * 0.9, behavior:'smooth'}));
    if (nextBtn) nextBtn.addEventListener('click', ()=> featuredTrack && featuredTrack.scrollBy({left: featuredTrack.clientWidth * 0.9, behavior:'smooth'}));
    if (featuredTrack) featuredTrack.addEventListener('scroll', updateCarouselButtons, {passive:true});

    /* ============== INITIAL LOAD ============== */
        fetchFeatured();
        loadSection(popularesGrid,'views');
        // Inicializa filtros e só depois carrega receitas principais
    initFilters();
});