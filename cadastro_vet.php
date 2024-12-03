<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CodVeterinario = $_POST['CodVeterinario'];
    $Nome = $_POST['Nome'];
    $CRMV = $_POST['CRMV'];
    $Telefone = $_POST['Telefone'];

    if ($CodVeterinario) {
        $sql = "UPDATE Veterinario SET Nome='$Nome', CRMV='$CRMV', Telefone='$Telefone' WHERE CodVeterinario ='$CodVeterinario'";
        $mensagem =  "Veterinario atualizado com sucesso!";
    } else {
        $sql = "INSERT INTO Veterinario (Nome, CRMV, Telefone) VALUES ('$Nome', '$CRMV', '$Telefone')";
        $mensagem = "Veterinario cadastrado com sucesso!";
    }

    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Veterinario WHERE CodVeterinario='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Veterinario excluído com sucesso!";
    } else {
        $mensagem = "Erro ao excluir Veterinario: " . $conn->error;
    }
}

$Veterinarios = $conn->query("SELECT * FROM Veterinario");

$Veterinario = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $Veterinario = $conn->query("SELECT * FROM Veterinario WHERE CodVeterinario='$edit_id'")->fetch_assoc();
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
        <h2>Cadastro de Veterinário</h2>
        <form method="post" action="">
            <input type="hidden" name="CodVeterinario" value="<?php echo $Veterinario['CodVeterinario'] ?? ''; ?>">
            <label for="Nome">Nome:</label>
            <input type="text" name="Nome" value="<?php echo $Veterinario['Nome'] ?? ''; ?>" required>
            <label for="CRMV">CRMV:</label>
            <input type="CRMV" name="CRMV" value="<?php echo $Veterinario['CRMV'] ?? ''; ?>">
            <label for="Telefone">Telefone:</label>
            <input type="text" name="Telefone" value="<?php echo $Veterinario['Telefone'] ?? ''; ?>">
            <button type="submit"><?php echo $Veterinario ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Lista de Clientes</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CRMV</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $Veterinarios->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['CodVeterinario']; ?></td>
                <td><?php echo $row['Nome']; ?></td>
                <td><?php echo $row['CRMV']; ?></td>
                <td><?php echo $row['Telefone']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['CodVeterinario']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodVeterinario']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>