<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=Por favor, faça o login primeiro.");
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Buscar dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    die("Usuário não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ouvidoria</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/servicos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Questrial&display=swap" rel="stylesheet">

<body>

<div id="navbar-container"></div>


  <div class="Titulo">
    <h1>Fale conosco!</h1>
  </div>
  <main>

    <form id="formEmail" action="enviar_mensagem.php" method="post">
      <div class="DadosPrincipais">
<label for="nome">Nome completo</label><br />
<input 
  type="text" 
  id="nome" 
  name="nome" 
  minlength="1" 
  required 
  value="<?php echo htmlspecialchars($usuario['nome']); ?>" 
/><br />

<label for="email">Email</label><br />
<input
  type="email"
  id="email"
  name="email"
  pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
  required
  value="<?php echo htmlspecialchars($usuario['email']); ?>" 
/><br />

<label for="tel">Telefone</label><br />
<input 
  type="text" 
  id="tel" 
  name="telefone"        
  pattern="\d{11}"
  maxlength="11"
  title="Digite 11 números sem espaços ou símbolos. Ex: 81988887777"
  required 
  value="<?php echo htmlspecialchars($usuario['telefone']); ?>" 
/><br />
</div>

    
      <div class="Mensagem">
        <label for="message">Envie sua mensagem</label><br>
        <textarea name="mensagem" required></textarea>
    
        <div class="Social-links">
          <a href="#"><i class="bi bi-youtube"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>
      <div class="botao">
        <button id="enviar" type="submit">Enviar</button>
      </div>
    </form>
    
  

  </main>
  
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script src="../JS/From.js"></script>  
  <script src="/projetopi/src/JS/nav.js"></script>
</body>
</html>
