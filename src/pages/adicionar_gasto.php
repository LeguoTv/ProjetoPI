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

// Obter informações do usuário
$user_id = $_SESSION['usuario_id'];

$get_name = $conn->prepare("SELECT nome FROM usuarios WHERE id = ?");
$get_name->bind_param("i", $user_id);
$get_name->execute();
$get_name_result = $get_name->get_result();
$user_data = $get_name_result->fetch_assoc();
$nome = $user_data ? $user_data['nome'] : "Usuário Desconhecido";


// Verificar se o ID existe na tabela de usuários
$check_user = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
$check_user->bind_param("i", $user_id);
$check_user->execute();
$result = $check_user->get_result();

if ($result->num_rows === 0) {
    // Usuário não existe no banco
    header("Location: adicionar_gasto.php?error=Usuário não encontrado no banco de dados.");
    exit();
}

// Adicionar gasto ao banco de dados (se o formulário foi enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Produto = $_POST['Produto'];
    $data_gasto = $_POST['data_gasto'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];

    // Validação de tipo
    if (!in_array($tipo, ['lucro', 'divida'])) {
        header("Location: adicionar_gasto.php?error=Tipo inválido.");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO gastos (user_id, Produto, data_gasto, preco, categoria, tipo, descricao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $user_id, $Produto, $data_gasto, $preco, $categoria, $tipo, $descricao);

     if ($stmt->execute()) {
    $_SESSION['success'] = "Gasto adicionado com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao adicionar o gasto. Verifique os dados.";
}
header("Location: adicionar_gasto.php");
exit();



    $stmt->close();
    $check_user->close(); // fecha a verificação do usuário também
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Registro Financeiro</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/adicionar_gasto.css">

</head>
<body>

<!-- Cabeçalho -->
<div id="navbar-container"></div>


<span class="bem-vindo"><?php echo htmlspecialchars($nome); ?>, Este campo é destinado ao registro de suas informações.</span>


<div class="form-page">
  <div class="form-wrapper">
    <form action="adicionar_gasto.php" method="post">

      <div class="messages">
  <?php
  
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

      <label for="gasto">Nome do Produto:</label>
      <input type="text" step="0.01" name="Produto" id="Produto" required>

      <label for="data_gasto">Data do Gasto:</label>
      <input type="date" name="data_gasto" id="data_gasto" max="<?= date('Y-m-d') ?>" 
         min="1900-01-01" required>

      <label for="preco">Preço do Produto:</label>
      <input type="number" step="0.01" name="preco" id="preco" required>

      <label for="categoria">Categoria:</label>
      <select name="categoria" id="categoria" required>
        <option value=""></option>
        <option value="Alimentação">Alimentação</option>
        <option value="Transporte">Transporte</option>
        <option value="Lazer">Lazer</option>
        <option value="Saúde">Saúde</option>
        <option value="Educação">Educação</option>
        <option value="Outros">Outros</option>
      </select>

      <label for="tipo">Tipo:</label>
      <select name="tipo" id="tipo" required>
        <option value=""></option>
        <option value="lucro">Lucro</option>
        <option value="divida">Dívida</option>
      </select>

      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" rows="3" maxlength="1000" placeholder="Descrição do gasto"></textarea>

      <input type="submit" value="Adicionar">
    </form>
    <p id="p">Preste atenção na hora<br>de organizar seus<br>gastos!</p>
  </div>
</div>

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
