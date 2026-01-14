<?php
include "../../conecta.php";

$sql = "SELECT id, endereco, capacidade_total, created_at FROM local";
$result = mysqli_query($bancodedados, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Locais</title>

    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/index.css">

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
    />
</head>

<body>


<header class="header">
    <h1 class="title">Locais Cadastrados</h1>
    <i class="ph ph-list" id="openModal"></i>
</header>


<div class="modal-wrapper" id="termsModal">
    <div class="modal main-modal">
        <header class="modal-header">
            <h2 class="modal-title">Menu</h2>
        </header>

        <div class="modal-content">
            <a href="../../index.html" class="button">Início</a>
            <a href="cad_local.php" class="button">Cadastrar Local</a>
            <a href="cad_usuario.php" class="button">Cadastrar Usuário</a>
            <a href="cad_organizacao.php" class="button">Cadastrar Organização</a>
            <a href="./auth/auth.html" class="link">Sair</a>
        </div>
    </div>
</div>


<main class="main">

<?php if (mysqli_num_rows($result) > 0): ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Endereço</th>
                <th>Capacidade</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["endereco"] ?></td>
                    <td><?= $row["capacidade_total"] ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($row["created_at"])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

<?php else: ?>
    <p class="msg">Nenhum local cadastrado.</p>
<?php endif; ?>

</main>

<script src="../scripts/index.js"></script>
</body>
</html>
