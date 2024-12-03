<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Consulta WHERE CodConsulta='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Consulta excluída com sucesso!";
    } else {
        $mensagem = "Erro ao excluir Consulta: " . $conn->error;
    }
}

$Consultas = $conn->query("SELECT cs.CodConsulta, cs.Exame, cs.DataeHora, cs.Valor, cs.Relatorio, a.Animal AS Animal_nome, v.Nome AS Veterinario_nome FROM Animais a JOIN Consulta cs ON a.CodAnimal = cs.CodAnimal JOIN Veterinario v ON cs.CodVeterinario = v.CodVeterinario;");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Consultas</title>
    <link rel="stylesheet" href="css/animal.css">
</head>
<body>
    <div class="container">
        <h2>Listagem de Consultas</h2>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Animal</th>
                <th>Veterinario</th>
                <th>Data e Hora</th>
                <th>Exame</th>
                <th>Relatório</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $Consultas->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['CodConsulta']; ?></td>
                <td><?php echo $row['Animal_nome']; ?></td>
                <td><?php echo $row['Veterinario_nome']; ?></td>
                <td><?php echo $row['DataeHora']; ?></td>
                <td><?php echo $row['Exame']; ?></td>
                <td><?php echo $row['Relatorio']; ?></td>
                <td><?php echo $row['Valor']; ?></td>
                <td>
                    <a href="cadastro_consulta.php?edit_id=<?php echo $row['CodConsulta']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodConsulta']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>
