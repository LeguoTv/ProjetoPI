<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/pasta Dos CSS/cadastrar.css">
    <title>Formulário de cadastro</title>
   
</head>
<body>
    <div class="box">
    
    <div id="navbar-container"></div>
    




<div class="main-content">

<div class="container-formulario">
  <h2>Faça Seu Cadastro</h2>

  <div class="messages">
  <?php
  session_start();
  if (isset($_SESSION['success'])) {
      echo "<div class='success'>" . $_SESSION['success'] . "</div>";
      unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
      echo "<div class='error'>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
  }
  

  ?>
</div>

  <form action="cadastro.php" method="POST">
    <fieldset>
      <div class="inputBox">
        <input type="text" name="nome" class="inputUser" minlength="1" required>
        <label for="nome" class="labelInput">Nome do Usuário</label>
      </div>
      <div class="inputBox">
        <input type="email" 
        name="email" class="inputUser" 
        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required>
        <label for="email" class="labelInput">Email</label>
      </div>
      <div class="inputBox">
        <input type="password" name="senha" class="inputUser" minlength="8" required>
        <label for="senha" class="labelInput">Senha</label>
      </div>
       <div class="inputBox">
        <label for="data_nascimento"><b>Data de Nascimento:</b></label>
        <input type="date" name="data_nascimento" class="inputUser"
          max="<?= date('Y-m-d') ?>" 
          min="1900-01-01"
          required>
       </div>
       <div class="inputBox">
       <input type="text" name="telefone" id="telefone" class="inputUser" 
              pattern="\d{11}"
              maxlength="11"
              title="Digite 11 números sem espaços ou símbolos. Ex: 81988887777" required>
       <label for="telefone" class="labelInput">Telefone</label>
       </div>
       <div class="inputBox">
       <input type="text" name="cidade" class="inputUser" 

              pattern="^[A-Za-zÀ-ÿ\s\-']{2,50}$"
              title="A cidade deve conter apenas letras, espaços, hífen ou apóstrofo. Ex São Paulo" required>
       <label for="cidade" class="labelInput">Cidade</label>
       </div>
       <div class="inputBox">
       <input type="text" name="estado" class="inputUser" 
 
              pattern="^(AC|AL|AP|AM|BA|CE|DF|ES|GO|MA|MT|MS|MG|PA|PB|PR|PE|PI|RJ|RN|RS|RO|RR|SC|SP|SE|TO)$"
              title="Digite a sigla do estado em MAIÚSCULO, ex: PE"
              maxlength="2" required>
       <label for="estado" class="labelInput">Estado</label>
       </div>
       <div class="inputBox">
        
       <input type="text" name="endereco" class="inputUser" 
              pattern="^[A-Za-zÀ-ÿ\s]+,\s?\d+\s?-\s?[A-Za-zÀ-ÿ\s]+$"
              title="Digite um endereço válido (letras, números, vírgula, ponto, traço...). Ex: Rua Exemplo, 123 - Bairro" required>
       <label for="endereco" class="labelInput">Endereço</label>
       </div>
      <input type="submit" name="submit" id="submit" value="Cadastrar">
      <a href="loginN.php" id="VolTar">Já tem conta? Voltar</a>
    </fieldset>
  </form>
</div>


    </div>
</div>

<script>
  const hamburger = document.querySelector('.hamburger');
  const navLinks = document.querySelector('.nav-links');
  const login = document.querySelector('.login');
  const body = document.body;

  hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    login.classList.toggle('active');
    body.classList.toggle('menu-ativo');
  });
</script>

<script>
  setTimeout(() => {
    const alertBox = document.querySelector(".success, .error");
    if (alertBox) {
      alertBox.style.transition = "opacity 0.5s ease-out";
      alertBox.style.opacity = "0";
      setTimeout(() => alertBox.remove(), 500);
    }
  }, 4000);
</script>


<script src="/projetopi/src/JS/nav.js"></script>
</body>
</html>