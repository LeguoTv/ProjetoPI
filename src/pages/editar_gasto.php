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

$user_id = $_SESSION['usuario_id'];
$Produto_id = $_GET['id'] ?? null;

// Validar se o ID foi fornecido
if (!$Produto_id) {
    header("Location: ver_gastos.php?error=ID do gasto não fornecido.");
    exit();
}

// Buscar dados do gasto
$stmt = $conn->prepare("SELECT * FROM gastos WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $Produto_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$Produto = $result->fetch_assoc();  

// Verificar se o gasto foi encontrado
if (!$Produto) {
    header("Location: ver_gastos.php?error=Gasto não encontrado.");
    exit();
}

// Atualizar gasto (processar formulário)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_Produto = $_POST['Produto'];
    $nova_data = $_POST['data_gasto'];
    $novo_preco = $_POST['preco'];
    $nova_categoria = $_POST['categoria'];
    $novo_tipo = $_POST['tipo']; // Novo campo
    $nova_descricao = $_POST['descricao'];

    // Atualizando os dados no banco
    $stmt = $conn->prepare("UPDATE gastos SET Produto = ?, data_gasto = ?, preco = ?, categoria = ?, tipo = ?, descricao = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssdsssii", $novo_Produto, $nova_data, $novo_preco, $nova_categoria, $novo_tipo, $nova_descricao, $Produto_id, $user_id);
    if ($stmt->execute()) {
        header("Location: ver_gastos.php?success=Gasto atualizado com sucesso.");
    } else {
        header("Location: editar_gasto.php?id=$Produto_id&error=Erro ao atualizar gasto.");
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Gasto</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/editar_gasto.css">
</head>
<body>

<div id="navbar-container"></div>


<main class="main-content">
    <span class="bem-vindo"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>! Aqui, você pode modificar os dados conforme necessário.</span>

<form action="editar_gasto.php?id=<?php echo $Produto_id; ?>" method="post">
    <label for="Produto">Nome do Produto:</label>
    <input type="text" step="0.01" name="Produto" id="Produto" value="<?php echo htmlspecialchars($Produto['Produto']); ?>" required>

    <label for="data_gasto">Data do Gasto:</label>
    <input type="date" name="data_gasto" id="data_gasto" value="<?php echo htmlspecialchars($Produto['data_gasto']); ?>" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" name="preco" id="preco" value="<?php echo htmlspecialchars($Produto['preco']); ?>" required>

    <div class="select-group">
    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" required>
        <option value="Alimentação" <?php echo $Produto['categoria'] === 'Alimentação' ? 'selected' : ''; ?>>Alimentação</option>
        <option value="Transporte" <?php echo $Produto['categoria'] === 'Transporte' ? 'selected' : ''; ?>>Transporte</option>
        <option value="Lazer" <?php echo $Produto['categoria'] === 'Lazer' ? 'selected' : ''; ?>>Lazer</option>
        <option value="Saúde" <?php echo $Produto['categoria'] === 'Saúde' ? 'selected' : ''; ?>>Saúde</option>
        <option value="Educação" <?php echo $Produto['categoria'] === 'Educação' ? 'selected' : ''; ?>>Educação</option>
        <option value="Outros" <?php echo $Produto['categoria'] === 'Outros' ? 'selected' : ''; ?>>Outros</option>
    </select>
</div>

<div class="select-group">
    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required>
        <option value="Lucro" <?php echo $Produto['Tipo'] === 'Lucro' ? 'selected' : ''; ?>>Lucro</option>
        <option value="Dívida" <?php echo $Produto['Tipo'] === 'Dívida' ? 'selected' : ''; ?>>Dívida</option>
    </select>
</div>

<br><br>
    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao" rows="3"><?php echo htmlspecialchars($Produto['descricao']); ?></textarea>

    <input type="submit" value="Atualizar Gasto">
</form>
</main>

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






</body>



