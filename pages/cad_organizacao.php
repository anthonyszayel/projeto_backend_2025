<?php
include "conecta.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $contato = $_POST["contato"];

    $sql = "INSERT INTO organizacao (nome, contato)
            VALUES ('$nome', '$contato')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Organização cadastrada com sucesso!";
    } else {
        $msg = "Erro ao cadastrar organização.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Organização</title>

    <link rel="stylesheet" href="../src/styles/global.css">
    <link rel="stylesheet" href="../src/styles/index.css">

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
    <h1 class="title">Cadastro de Organização</h1>
    <i class="ph ph-list" id="openModal"></i>
</header>


<div class="modal-wrapper" id="termsModal">
    <div class="modal main-modal">
        <header class="modal-header">
            <h2 class="modal-title">Menu</h2>
        </header>

        <div class="modal-content">
            <a href="../index.html" class="button">Início</a>
            <a href="lista_organizacao.php" class="button">Listar Organizações</a>
            <a href="cad_usuario.php" class="button">Cadastrar Usuário</a>
            <a href="cad_local.php" class="button">Cadastrar Local</a>
            <a href="../src/pages/auth/auth.html" class="link">Sair</a>
        </div>
    </div>
</div>


<main class="main">

    <?php if ($msg): ?>
        <p class="msg"><?= $msg ?></p>
    <?php endif; ?>

    <form method="post" class="form">

        <input
            type="text"
            name="nome"
            class="input"
            placeholder="Nome da organização"
            required
        >

        <input
            type="text"
            name="contato"
            class="input"
            placeholder="Contato (email ou telefone)"
        >

        <button type="submit" class="button">
            Cadastrar Organização
        </button>

    </form>
</main>

<script src="../src/scripts/index.js"></script>
</body>
</html>
