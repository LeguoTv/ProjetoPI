<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Verifica se o email já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='error'>Este e-mail já está cadastrado.</div>";
    } else {
        // Inserir usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuário cadastrado com sucesso!";
            header('Location: pasta Dos HTML/login.html');
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LM R. Finanças</title>
    <link rel="stylesheet" href="../src/styles/pasta Dos CSS/Paginicial.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Questrial&display=swap" rel="stylesheet">


</head>
<body>
 <div id="preloader">
  <img id="image1" src="../src/assets/Imagens do Site/Padrão vertical - ByAvanced (1).png" alt="Logo 1">
  
</div> 


    <!-- Cabeçalho -->
    <div id="navbar-container"></div>
    

    <!-- Comteudo do futuro da sua liberdade.... -->
    <div class="hero-section">
        <h1>
            O Futuro da sua<br>
            Liberdade <span class="highlight">Financeira</span>
        </h1>
        
        <p>
            Organize suas finanças com
            <strong>inteligência e<br>eficiência</strong>
        </p>

        <div class="cta-buttonn">
            <a href="#">ASSINE JÁ</a>
        </div>
    </div>

    <!-- agora vem a imagem deacordo com o pdf -->
    <!-- Imagem centralizada abaixo do conteúdo -->
  <div class="dashboard-image">
    <img src="../src/assets/Imagens do Site/print do ver os gastos.png" alt="Dashboard Financeiro" />
  </div>

    <div class="Paragrafo">
        <p> Ferramentas exclusivas <br>
            que vão te <span>ajudar na sua Jornada</span>
        </p>
    </div>

    <!-- IA. SISTEMA FINANCEIRO E DASHBOARD - AUCTUS -->

    <section class="info-section">

        <div class="info-container">

            <!-- Bloco 1: IA Assistente -->
            <div class="info-box">
                <div class="image-box">
                    <!--tamanho da imagem 510 x 420 fica perfeita-->
                    <img src="../src/assets/Imagens do Site/Conteudo do site/IA ASSISTENTE E IA FINANCEIRA.jpg" alt="IA Assistente">
                </div>

                <div class="text-box">
                    <h2>IA. Assistente Financeira</h2>
                    <p>
                        Sempre ativa e pronta para te atender oferecendo respostas em 
                        <strong>tempo real</strong> com 
                        <strong>agilidade, precisão</strong> e total compromisso com a sua necessidade.
                    </p>
                    <p>
                    Conte com a gente para <strong>esclarecer dúvidas</strong>, resolver problemas e garantir uma 
                    <strong>experiência cada vez mais eficiente</strong>.
                    </p>
                </div>
            </div>

    <!-- Bloco 2: Dashboard -->
            <div class="info-box reverse">
                <div class="image-box">
                    <!--tamanho da imagem 510 x 420 fica perfeita-->
                    <img src="../src/assets/Imagens do Site/print dos graficor .png" alt="Dashboard Gráfico">
                </div>
        
                <div class="text-box">
                    <h2>Dashboard - Auctus</h2>
                    <p>
                    Uma ferramenta <strong>estratégica</strong> que oferece uma 
                    <strong>visão clara e em tempo real</strong> dos principais indicadores.
                    Decisões mais rápidas, acompanha o <strong>desempenho</strong> e identifica 
                    <strong>oportunidades com agilidade</strong>.
                    </p>
                    <a href="#" class="cta-button">ASSINE JÁ</a>
                </div>
        
            </div>

        </div>

    </section>

   <!-- abaixo esta a parte do Descomplique suas finanças e foque no crescimento -->
    
   <h1>Descomplique suas finanças e<br> foque no <span>crescimento</span></h1>

<div class="card-container">
    <div class="feature-card">
        <i class="bi bi-piggy-bank"></i>
        <div>
            <h2>Controle de Gastos</h2>
            <p>Controle seus gastos de forma eficiente e organizada</p>
        </div>
    </div>
    <div class="feature-card" id="feature-seguranca">
        <i class="bi bi-shield-check"></i>
        <div>
            <h2>Segurança de dados</h2>
            <p>Garantimos que seus dados estarão protegidos de qualquer tipo de ameaça</p>
        </div>
    </div>
</div>

<!-- Conteudo de Controle de Gastos Assistente Inteligente etc-->
<div class="section-container">
    <div class="benefits-box">
        <ul>
            <li><i class="bi bi-check-circle-fill"></i>Controle de Gastos</li>
            <li><i class="bi bi-check-circle-fill"></i>Assistente Inteligente</li>
            <li><i class="bi bi-check-circle-fill"></i>Dashboard Estratégico</li>
        </ul>
        <button class="subscribe-btn">ASSINE JÁ</button>
    </div>

    <div class="image-boxx">
        <div class="image-contentt">
            <!-- Substitua o src com o caminho da sua imagem -->
            <img src="../src/assets/Imagens do Site/Captura de tela 2025-04-15 094053.png" alt="Imagem do sistema">
        </div>
    </div>
</div>

<script>
  window.addEventListener("load", () => {
    const image1 = document.getElementById("image1");
    const preloader = document.getElementById("preloader");

    // Verifica se o preloader já foi mostrado nesta sessão
    const preloaderShown = sessionStorage.getItem("preloaderShown");

    if (!preloaderShown) {
      // Mostra o preloader normalmente
      image1.classList.add("mostrar");

      setTimeout(() => {
        preloader.style.opacity = '0';
        setTimeout(() => preloader.style.display = 'none', 500);
      }, 3000);

      // Marca como mostrado
      sessionStorage.setItem("preloaderShown", "true");
    } else {
      // Oculta imediatamente se já foi mostrado
      preloader.style.display = 'none';
    }
  });
</script>


<script src="/projetopi/src/JS/footer.js" defer></script>
<script src="/projetopi/src/JS/nav.js"></script>
</body>
</html>
