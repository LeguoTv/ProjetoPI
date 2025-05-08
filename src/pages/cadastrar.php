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
    <!-- Mensagens de erro ou sucesso aparecerão aqui -->
    <?php
  if (isset($_GET['error'])) {
      echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
  }
  if (isset($_GET['success'])) {
      echo "<div class='success'>" . htmlspecialchars($_GET['success']) . "</div>";
  }
  ?>
                </div>

  <form action="cadastro.php" method="POST">
    <fieldset>
      <div class="inputBox">
        <input type="text" name="nome" class="inputUser" required>
        <label for="nome" class="labelInput">Nome completo</label>
      </div>
      <div class="inputBox">
        <input type="email" name="email" class="inputUser" required>
        <label for="email" class="labelInput">Email</label>
      </div>
      <div class="inputBox">
        <input type="password" name="senha" class="inputUser" required>
        <label for="senha" class="labelInput">Senha</label>
      </div>
       <div class="inputBox">
       <label for="data_nascimento"><b>Data de Nascimento:</b></label>
       <input type="date" name="data_nascimento" class="inputUser" required>
       </div>
       <div class="inputBox">
       <input type="text" name="telefone" id="telefone" class="inputUser" required>
       <label for="telefone" class="labelInput">Telefone</label>
       </div>
       <div class="inputBox">
       <input type="text" name="cidade" class="inputUser" required>
       <label for="cidade" class="labelInput">Cidade</label>
       </div>
       <div class="inputBox">
       <input type="text" name="estado" class="inputUser" required>
       <label for="estado" class="labelInput">Estado</label>
       </div>
       <div class="inputBox">
        
       <input type="text" name="endereco" class="inputUser" required>
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



<script src="/projetopi/src/JS/nav.js"></script>
</body>
</html>