<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CodAnimal = $_POST['CodAnimal'];
    $CodCliente = $_POST['CodCliente'];
    $Animal = $_POST['Animal'];
    $Raça = $_POST['Raça'];
    $RGA = $_POST['RGA'];
    $Observação = $_POST['Observação'];

    if ($CodAnimal) {
        $sql = "UPDATE Animais SET CodCliente='$CodCliente', Animal='$Animal', Raça='$Raça', RGA='$RGA', Observação='$Observação' WHERE CodAnimal='$CodAnimal'";
        $mensagem = "Animal atualizado com sucesso!";
    } else {
        $sql = "INSERT INTO Animais (CodCliente, Animal, Raça, RGA, Observação) VALUES ('$CodCliente', '$Animal', '$Raça', '$RGA', '$Observação')";
        $mensagem = "Animal cadastrado com sucesso!";
    }

    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Animais WHERE CodAnimal='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Animal excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir Animal: " . $conn->error;
    }
}

$Animais = $conn->query("SELECT a.CodAnimal, a.Animal, a.Raça, a.RGA, a.Observação, c.Cliente AS Cliente_nome FROM Animais a JOIN Clientes c ON a.CodCliente = c.CodCliente");

$Animal = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $Animal = $conn->query("SELECT * FROM Animais WHERE CodAnimal='$edit_id'")->fetch_assoc();
}

$Clientes = $conn->query("SELECT CodCliente, Cliente FROM Clientes");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Animal</h2>
        <form method="post" action="">
            <input type="hidden" name="CodAnimal" value="<?php echo $Animal['CodAnimal'] ?? ''; ?>">
            <label for="CodCliente">Dono do Animal:</label>
            <select name="CodCliente" required>
                <?php while ($row = $Clientes->fetch_assoc()): ?>
                    <option value="<?php echo $row['CodCliente']; ?>" <?php if ($Animal && $Animal['CodCliente'] == $row['CodCliente']) echo 'selected'; ?>><?php echo $row['Cliente']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="Animal">Animal:</label>
            <input type="text" name="Animal" value="<?php echo $Animal['Animal'] ?? ''; ?>" required>
            <label for="Raça">Raça:</label>
            <input type="text" name="Raça" value="<?php echo $Animal['Raça'] ?? ''; ?>" required>
            <label for="Raça">RGA:</label>
            <input type="text" name="RGA" value="<?php echo $Animal['RGA'] ?? ''; ?>" required>
            <label for="Raça">Observação:</label>
            <textarea name="Observação"><?php echo $Animal['Observação'] ?? ''; ?></textarea>
            <button type="submit"><?php echo $Animal ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Listagem de Produtos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Raça</th>
                <th>RGA</th>
                <th>Observação</th>
                <th>Dono do Animal</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $Animais->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['CodAnimal']; ?></td>
                <td><?php echo $row['Animal']; ?></td>
                <td><?php echo $row['Raça']; ?></td>
                <td><?php echo $row['RGA']; ?></td>
                <td><?php echo $row['Observação']; ?></td>
                <td><?php echo $row['Cliente_nome']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['CodAnimal']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodAnimal']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>