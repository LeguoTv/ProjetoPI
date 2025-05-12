document.addEventListener("DOMContentLoaded", function() {
    // Configurações
    const config = {
        navPath: "/projetopi/src/components/nav.html",
        cssPath: "/projetopi/src/styles/pastaDosCSS/nav.css"
    };

    // 1. Carrega a navbar
    const navbarContainer = document.getElementById('navbar-container') || document.body;
    
    fetch(config.navPath)
        .then(response => {
            if (!response.ok) throw new Error(`Erro ${response.status}`);
            return response.text();
        })
        .then(html => {
            navbarContainer.insertAdjacentHTML('afterbegin', html);
            
            // Ajuste para não cobrir conteúdo
            document.body.style.paddingTop = '90px';
            
            initNavbar();
            loadCSS();
        })
        .catch(error => {
            console.error('Erro ao carregar navbar:', error);
            showErrorUI(error);
        });

    // 2. Inicializa funcionalidades
    function initNavbar() {
        updateNavVisibility();
        setupMobileMenu();
        highlightActiveLinks();
    }

    // 3. Controle de visibilidade SIMPLES E EFETIVO
    function updateNavVisibility() {
        const currentPage = window.location.pathname.split('/').pop();
        const isLoggedPage = [
            'paginaprincipal.php',
            'ver_gastos.php',
            'adicionar_gasto.php',
            'servicos.php'
        ].includes(currentPage);

        // Controle de visibilidade (usa display: none/block)
        document.querySelectorAll('.logged-link').forEach(el => {
            el.style.display = isLoggedPage ? 'block' : 'none';
        });

        document.querySelectorAll('.guest-link').forEach(el => {
            el.style.display = isLoggedPage ? 'none' : 'block';
        });

        // Atualiza botão Entrar/Sair
        const loginBtn = document.querySelector('.login .btn');
        if (loginBtn) {
            if (isLoggedPage) {
                document.body.classList.add('logged-in');
              } else {
                document.body.classList.remove('logged-in');
              }
        }
    }

    // 4. Menu Mobile FUNCIONAL
    function setupMobileMenu() {
        const hamburger = document.querySelector('.hamburger');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (!hamburger || !mobileMenu) return;

        hamburger.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = isExpanded ? 'auto' : 'hidden';

            // Atualiza links ao abrir
            if (!isExpanded) {
                updateMobileLinks();
            }
        });

        function updateMobileLinks() {
            const currentPage = window.location.pathname.split('/').pop();
            const isLoggedPage = [
                'paginaprincipal.php',
                'ver_gastos.php',
                'adicionar_gasto.php',
                'servicos.php'
            ].includes(currentPage);
        
            // Limpa conteúdo
            mobileMenu.innerHTML = '';
        
            // Clona links
            const linksContainer = document.createElement('ul');
            const linksToShow = document.querySelectorAll(isLoggedPage ? '.nav-links .logged-link' : '.nav-links .guest-link');
            
            linksToShow.forEach(link => {
                const clonedLink = link.cloneNode(true);
                clonedLink.style.display = 'block';
                clonedLink.style.padding = '12px 25px';
                linksContainer.appendChild(clonedLink);
            });
            mobileMenu.appendChild(linksContainer);
        
            // Cria a área dos botões
            const loginContainer = document.createElement('div');
            loginContainer.classList.add('mobile-login');
        
            // Clona botão apropriado
            const btnSelector = isLoggedPage ? '.login .logged-link' : '.login .guest-link';
            const btn = document.querySelector(btnSelector)?.cloneNode(true);
        
            if (btn) {
                btn.style.display = 'block';
                btn.style.margin = '15px 25px';
                btn.style.width = 'calc(100% - 50px)';
                loginContainer.appendChild(btn);
            }
        
            mobileMenu.appendChild(loginContainer);
        }
        
    }

    // 5. Destaca link ativo
    function highlightActiveLinks() {
        const currentPage = window.location.pathname.split('/').pop();
        document.querySelectorAll('nav a').forEach(link => {
            const linkPage = link.getAttribute('href').split('/').pop();
            if (linkPage === currentPage) {
                link.classList.add('active');
            }
        });
    }

    // 6. Carrega CSS
    function loadCSS() {
        if (!document.querySelector(`link[href="${config.cssPath}"]`)) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = config.cssPath;
            document.head.appendChild(link);
        }
    }

    // 7. Tratamento de erros
    function showErrorUI(error) {
        const errorDiv = document.createElement('div');
        errorDiv.innerHTML = `
            <div style="
                background: #ffebee;
                color: #d32f2f;
                padding: 15px;
                text-align: center;
                border-bottom: 2px solid #ef9a9a;
            ">
                ⚠️ Erro ao carregar menu
                <button onclick="window.location.reload()" style="
                    background: #d32f2f;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    margin-left: 10px;
                    border-radius: 3px;
                    cursor: pointer;
                ">
                    Recarregar
                </button>
            </div>
        `;
        document.body.prepend(errorDiv);
    }
});