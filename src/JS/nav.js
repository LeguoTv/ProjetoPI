// Executa quando todo o DOM estiver carregado
document.addEventListener("DOMContentLoaded", function() {

  // Caminhos para o HTML e o CSS da navbar
  const config = {
    navPath: "/projetopi/src/components/nav.html", // Caminho do HTML da navbar
    cssPath: "/projetopi/src/styles/pastaDosCSS/nav.css" // Caminho do CSS da navbar
  };

  // Define onde a navbar será inserida. Se não tiver um container específico, usa o <body>
  const navbarContainer = document.getElementById('navbar-container') || document.body;

  // Faz a requisição do arquivo nav.html
  fetch(config.navPath)
    .then(response => {
      // Se a resposta não for OK (200-299), lança erro
      if (!response.ok) throw new Error(`Erro ${response.status}`);
      return response.text(); // Converte o conteúdo em texto
    })
    .then(html => {
      // Insere o HTML da navbar no início do container
      navbarContainer.insertAdjacentHTML('afterbegin', html);
      
      // Garante espaço no topo da página se a navbar for fixa
      document.body.style.paddingTop = '90px';

      // Inicializa as funções da navbar
      initNavbar();

      // Carrega o CSS da navbar dinamicamente
      loadCSS();
    })
    .catch(error => {
      // Exibe erro no console
      console.error('Erro ao carregar navbar:', error);

      // Mostra mensagem amigável na tela
      showErrorUI(error);
    });

  // Função principal de inicialização da navbar
  function initNavbar() {
    updateNavVisibility(); // Atualiza visibilidade dos links com base no login
    setupMobileMenu();     // Configura o menu mobile
    highlightActiveLinks(); // Destaca o link da página atual
  }

  // Atualiza os links exibidos com base na página atual (logado ou não)
  function updateNavVisibility() {
    const currentPage = window.location.pathname.split('/').pop(); // Nome do arquivo atual
    const isLoggedPage = [
      'paginaprincipal.php',
      'ver_gastos.php',
      'adicionar_gasto.php',
      'servicos.php'
    ].includes(currentPage); // Verifica se é uma página "logada"

    // Mostra ou esconde links visíveis apenas para usuários logados
    document.querySelectorAll('.logged-link').forEach(el => {
      el.style.display = isLoggedPage ? 'block' : 'none';
    });

    // Mostra ou esconde links visíveis apenas para visitantes
    document.querySelectorAll('.guest-link').forEach(el => {
      el.style.display = isLoggedPage ? 'none' : 'block';
    });

    // Adiciona ou remove classe no body para ajustes de estilo (opcional)
    const loginBtn = document.querySelector('.login .btn');
    if (loginBtn) {
      if (isLoggedPage) {
        document.body.classList.add('logged-in');
      } else {
        document.body.classList.remove('logged-in');
      }
    }
  }

  // Configura o menu hamburguer no mobile
  function setupMobileMenu() {
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');

    // Se não existir, não faz nada
    if (!hamburger || !mobileMenu) return;

    // Evento de clique no botão hamburguer
    hamburger.addEventListener('click', function() {
      const isExpanded = this.getAttribute('aria-expanded') === 'true';

      // Alterna o estado do menu mobile
      this.setAttribute('aria-expanded', !isExpanded);
      mobileMenu.classList.toggle('active');

      // Se o menu abriu, atualiza os links mostrados nele
      if (!isExpanded) {
        updateMobileLinks();
      }
    });

    // Atualiza os links do menu mobile com base no login
    function updateMobileLinks() {
      const currentPage = window.location.pathname.split('/').pop();
      const isLoggedPage = [
        'paginaprincipal.php',
        'ver_gastos.php',
        'adicionar_gasto.php',
        'servicos.php'
      ].includes(currentPage);

      // Limpa o menu mobile
      mobileMenu.innerHTML = '';

      // Cria uma lista para os links
      const linksContainer = document.createElement('ul');

      // Seleciona os links adequados (logado ou visitante)
      const linksToShow = document.querySelectorAll(
        isLoggedPage ? '.nav-links .logged-link' : '.nav-links .guest-link'
      );

      // Clona e estiliza os links para o mobile
      linksToShow.forEach(link => {
        const clonedLink = link.cloneNode(true);
        clonedLink.style.display = 'block';
        clonedLink.style.padding = '12px 25px';
        linksContainer.appendChild(clonedLink);
      });

      // Adiciona a lista de links ao menu mobile
      mobileMenu.appendChild(linksContainer);

      // Cria botão de login/logout no menu mobile
      const loginContainer = document.createElement('div');
      loginContainer.classList.add('mobile-login');

      const btnSelector = isLoggedPage ? '.login .logged-link' : '.login .guest-link';
      const btn = document.querySelector(btnSelector)?.cloneNode(true);

      // Estiliza e adiciona o botão, se existir
      if (btn) {
        btn.style.display = 'block';
        btn.style.margin = '15px 25px';
        btn.style.width = 'calc(100% - 50px)';
        loginContainer.appendChild(btn);
      }

      // Adiciona o container ao menu mobile
      mobileMenu.appendChild(loginContainer);
    }
  }

  // Destaca o link da navbar correspondente à página atual
  function highlightActiveLinks() {
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('nav a').forEach(link => {
      const linkPage = link.getAttribute('href').split('/').pop();
      if (linkPage === currentPage) {
        link.classList.add('active'); // Adiciona classe 'active' ao link atual
      }
    });
  }

  // Carrega dinamicamente o CSS da navbar, se ainda não foi carregado
  function loadCSS() {
    if (!document.querySelector(`link[href="${config.cssPath}"]`)) {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = config.cssPath;
      document.head.appendChild(link);
    }
  }

  // Exibe mensagem de erro amigável na interface do usuário
  function showErrorUI(error) {
    const errorDiv = document.createElement('div');
    errorDiv.innerHTML = `
      <div style="background: #ffebee; color: #d32f2f; padding: 15px; text-align: center; border-bottom: 2px solid #ef9a9a;">
        ⚠️ Erro ao carregar menu<br><small>${error.message}</small>
      </div>
    `;
    document.body.insertAdjacentElement('afterbegin', errorDiv);
  }
});
