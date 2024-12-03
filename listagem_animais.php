<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Animais</title>
    <link rel="stylesheet" href="css/animal.css">
</head>
<body>
    <div class="container">
        <h2>Listagem de Animais</h2>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Raça</th>
                <th>RGA</th>
                <th>Observação</th>
                <th>Dono</th>
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
                    <a href="cadastro_animal.php?edit_id=<?php echo $row['CodAnimal']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodAnimal']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>
