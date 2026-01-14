<?php
include "conecta.php";

/* Inserção da organização */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $contato = $_POST["contato"];

    $sql = "INSERT INTO organizacao (nome, contato)
            VALUES ('$nome', '$contato')";

    if (mysqli_query($conn, $sql)) {
        $mensagem = "Organização cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar organização.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestão de Eventos">
    <meta name="author" content="Quarto Período SI">

    <title>Cadastro de Organização</title>

    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/lista.css">
    <link rel="stylesheet" href="../styles/cad.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <a href="../index.html">Início</a>
    <a href="lista_organizacao.php">Lista de Organizações</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main">

    <h2 class="title">Cadastro de Organização</h2>

    <?php if (!empty($mensagem)) : ?>
        <p class="msg"><strong><?= $mensagem ?></strong></p>
    <?php endif; ?>

    <form method="post" class="form">

        <label class="label">Nome da Organização</label>
        <input
            type="text"
            name="nome"
            class="input"
            placeholder="Digite o nome da organização"
            required
        >

        <label class="label">Contato</label>
        <input
            type="text"
            name="contato"
            class="input"
            placeholder="Telefone, e-mail ou responsável"
        >

        <button type="submit" class="button">
            Cadastrar
        </button>

    </form>

</div>

</body>
</html>
