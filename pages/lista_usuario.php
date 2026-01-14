<?php
include "conecta.php";

$sql = "SELECT u.id, u.nome, u.perfil, u.ativo, o.nome AS organizacao
        FROM usuario u
        JOIN organizacao o ON u.organizacao_id = o.id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestão de Eventos">
    <meta name="author" content="Quarto Período SI">

    <title>Lista de Usuários</title>

    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/lista.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <a href="../index.html">Início</a>
    <a href="cad_usuario.php">Cadastrar Usuário</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main">

    <h2 class="title">Usuários Cadastrados</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Perfil</th>
                <th>Ativo</th>
                <th>Organização</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nome'] ?></td>
                        <td><?= ucfirst($row['perfil']) ?></td>
                        <td><?= $row['ativo'] ? 'Sim' : 'Não' ?></td>
                        <td><?= $row['organizacao'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum usuário cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="cad_usuario.php" class="button">
        Cadastrar novo usuário
    </a>

</div>

</body>
</html>
