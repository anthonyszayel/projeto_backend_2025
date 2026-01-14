<?php
include "conecta.php";

$sql = "SELECT id, endereco, capacidade_total 
        FROM local";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Locais Cadastrados</title>

    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/lista.css">
</head>

<body>

<div class="navbar">
    <a href="../index.html">Início</a>
    <a href="cad_local.php">Cadastrar Local</a>
</div>

<main class="main">
    <h2 class="title">Locais Cadastrados</h2>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Endereço</th>
            <th>Capacidade</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['endereco']}</td>";
                echo "<td>{$row['capacidade_total']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nenhum local cadastrado.</td></tr>";
        }
        ?>
    </table>
</main>

</body>
</html>
