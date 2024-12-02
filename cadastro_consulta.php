<?php include('valida_sessao.php'); ?>
<?php include('conexao.php'); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CodConsulta = $_POST['CodConsulta'];
    $CodAnimal = $_POST['CodAnimal'];
    $CodVeterinario = $_POST['CodVeterinario'];
    $Exame = $_POST['Exame'];
    $DataeHora = $_POST['DataeHora'];
    $Valor = $_POST['Valor'];
    $Relatorio = $_POST['Relatorio'];

    if ($CodConsulta) {
        $sql = "UPDATE Consulta SET CodAnimal='$CodAnimal', CodVeterinario='$CodVeterinario', Exame='$Exame', DataeHora='$DataeHora', Valor='$Valor', Relatorio='$Relatorio' WHERE CodConsulta='$CodConsulta'";
        $mensagem = "Consulta atualizada com sucesso!";
    } else {
        $sql = "INSERT INTO Animal (CodAnimal, CodVeterinario, Exame, DataeHora, Valor, Relatorio) VALUES ('$CodAnimal', '$CodVeterinario', '$Exame', '$DataeHora', '$Valor', '$Relatorio')";
        $mensagem = "Consulta cadastrada com sucesso!";
    }

    if ($conn->query($sql) !== TRUE) {
        $mensagem = "Erro: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM Consulta WHERE CodConsulta='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Consulta excluída com sucesso!";
    } else {
        $mensagem = "Erro ao excluir Consulta: " . $conn->error;
    }
}

$Consultas = $conn->query("SELECT cs.CodConsulta, cs.Exame, cs.DataeHora, cs.Valor, cs.Relatorio, a.Nome AS Animal_nome FROM Consulta cs JOIN Animal a ON cs.CodAnimal = a.CodAnimal");
$Consulta = $conn->query("SELECT cs.CodConsulta, cs.Exame, cs.DataeHora, cs.Valor, cs.Relatorio, v.Nome AS Veterinario_nome FROM Consulta cs JOIN Veterinario v ON cs.CodVeterinario = v.CodVeterinario");

$Consulta = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $Consulta = $conn->query("SELECT * FROM Consulta WHERE CodConsulta='$edit_id'")->fetch_assoc();
}

$Consultas = $conn->query("SELECT CodAnimal, Nome FROM Animal");
$Consultas = $conn->query("SELECT CodVeterinario, Nome FROM Veterinario");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Consulta de Animal</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Consulta</h2>
        <form method="post" action="">
            <input type="hidden" name="CodConsulta" value="<?php echo $Consulta['CodConsulta'] ?? ''; ?>">
            <label for="CodAnimal">Animal Consultado:</label>
            <select name="CodAnimal" required>
                <?php while ($row = $Clientes->fetch_assoc()): ?>
                    <option value="<?php echo $row['CodAnimal']; ?>" <?php if ($Consulta && $Consulta['CodAnimal'] == $row['CodAnimal']) echo 'selected'; ?>><?php echo $row['Nome']; ?></option>
                <?php endwhile; ?>
            </select>
            <select>
            <label for="CodAnimal">Veterinário Responsável:</label>
                <?php while ($row = $Clientes->fetch_assoc()): ?>
                        <option value="<?php echo $row['CodVeterinario']; ?>" <?php if ($Consulta && $Consulta['CodVeterinario'] == $row['CodVeterinario']) echo 'selected'; ?>><?php echo $row['Nome']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="Exame">Exame:</label>
            <input type="radio" name="Exame" value="<?php echo $Consulta['Exame'] ?? ''; ?>" required>
            <label for="DataeHora">DataeHora:</label>
            <input type="datetime" name="DataeHora" value="<?php echo $Consulta['DataeHora'] ?? ''; ?>" required>
            <label for="Valor">Valor:</label>
            <input type="text" name="Valor" value="<?php echo $Consulta['Valor'] ?? ''; ?>" required>
            <label for="Relatorio">Relatorio:</label>
            <textarea name="Relatorio"><?php echo $Consulta['Relatorio'] ?? ''; ?></textarea>
            <button type="submit"><?php echo $Consulta ? 'Atualizar' : 'Cadastrar'; ?></button>
        </form>
        <?php if (isset($mensagem)) echo "<p class='message " . ($conn->error ? "error" : "success") . "'>$mensagem</p>"; ?>

        <h2>Listagem de Produtos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Exame</th>
                <th>DataeHora</th>
                <th>Valor</th>
                <th>Relatorio</th>
                <th>Veterinário</th>
                <th>Animal</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $Animais->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['CodConsulta']; ?></td>
                <td><?php echo $row['Exame']; ?></td>
                <td><?php echo $row['DataeHora']; ?></td>
                <td><?php echo $row['Valor']; ?></td>
                <td><?php echo $row['Relatorio']; ?></td>
                <td><?php echo $row['Cliente_nome']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['CodConsulta']; ?>">Editar</a>
                    <a href="?delete_id=<?php echo $row['CodConsulta']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Voltar</a>
    </div>
</body>
</html>