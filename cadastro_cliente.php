<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CodCliente = $_POST['CodCliente'];
    $Cliente = $_POST['Cliente'];
    $Telefone = $_POST['Telefone'];
    $QtdAnimal = $_POST['QtdAnimal'];

    if ($CodCliente) {
        $sql = "UPDATE Clientes SET Cliente='$Cliente', Telefone='$Telefone', QtdAnimal='$QtdAnimal' WHERE CodCliente ='$CodCliente'";
        $mensagem =  "Cliente atualizado com sucesso!";
    } else {
        $sql = "INSERT INTO Clientes (Cliente, Telefone, QtdAnimal) VALUES ('$Cliente', '$Telefone', '$QtdAnimal')";
        $mensagem = "Cliente cadastrado com sucesso!";
    }

    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Clientes WHERE CodCliente='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Cliente excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir Cliente: " . $conn->error;
    }
}

$Clientes = $conn->query("SELECT * FROM Clientes");

$Cliente = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $Cliente = $conn->query("SELECT * FROM Clientes WHERE CodCliente='$edit_id'")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Dono de Pet</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Dono de Pet</h2>
        <form method="post" action="">
            <input type="hidden" name="CodCliente" value="<?php echo $Cliente['CodCliente'] ?? ''; ?>">
            <label for="Cliente">Nome:</label>
            <input type="text" name="Cliente" value="<?php echo $Cliente['Cliente'] ?? ''; ?>" required>
            <label for="Telefone">Telefone:</label>
            <input type="Telefone" name="Telefone" value="<?php echo $Cliente['Telefone'] ?? ''; ?>">
            <label for="QtdAnimal">Quantidade de Animais:</label>
            <input type="text" name="QtdAnimal" value="<?php echo $Cliente['QtdAnimal'] ?? ''; ?>">
            <button type="submit"><?php echo $Cliente ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Lista de Clientes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Quantidade de Animais</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $Clientes->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['CodCliente']; ?></td>
                <td><?php echo $row['Cliente']; ?></td>
                <td><?php echo $row['Telefone']; ?></td>
                <td><?php echo $row['QtdAnimal']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['CodCliente']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodCliente']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>