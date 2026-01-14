<?php
include "conecta.php";

$sql = "SELECT id, nome, contato, created_at FROM organizacao";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestão de Eventos">
    <meta name="author" content="Quarto Período SI">

    <title>Lista de Organizações</title>

    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/lista.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <a href="../index.html">Início</a>
    <a href="cad_organizacao.php">Cadastrar Organização</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main">

    <h2 class="title">Organizações Cadastradas</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Contato</th>
                <th>Data de Cadastro</th>
            </tr>
        </thead>

        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td><?= $row['contato'] ?></td>
                        <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhuma organização cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="cad_organizacao.php" class="button">
        Cadastrar nova organização
    </a>

</div>

</body>
</html>
