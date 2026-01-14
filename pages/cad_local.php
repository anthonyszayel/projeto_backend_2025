<?php
include "conecta.php";

/* Buscar organizações */
$orgs = mysqli_query($conn, "SELECT id, nome FROM organizacao");

/* Inserção do local */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $capacidade = $_POST["capacidade"];
    $organizacao_id = $_POST["organizacao_id"];

    $sql = "INSERT INTO local_evento (nome, endereco, capacidade, organizacao_id)
            VALUES ('$nome', '$endereco', '$capacidade', '$organizacao_id')";

    if (mysqli_query($conn, $sql)) {
        $mensagem = "Local cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar local.";
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

    <title>Cadastro de Local</title>

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
    <a href="lista_local.php">Lista de Locais</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main">

    <h2 class="title">Cadastro de Local</h2>

    <?php if (!empty($mensagem)) : ?>
        <p class="msg"><strong><?= $mensagem ?></strong></p>
    <?php endif; ?>

    <form method="post" class="form">

        <label class="label">Nome do Local</label>
        <input
            type="text"
            name="nome"
            class="input"
            placeholder="Digite o nome do local"
            required
        >

        <label class="label">Endereço</label>
        <input
            type="text"
            name="endereco"
            class="input"
            placeholder="Digite o endereço"
            required
        >

        <label class="label">Capacidade</label>
        <input
            type="number"
            name="capacidade"
            class="input"
            placeholder="Digite a capacidade"
            required
        >

        <label class="label">Organização</label>
        <select name="organizacao_id" class="input" required>
            <option value="">Selecione</option>
            <?php while ($org = mysqli_fetch_assoc($orgs)) : ?>
                <option value="<?= $org['id'] ?>">
                    <?= $org['nome'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" class="button">
            Cadastrar
        </button>

    </form>

</div>

</body>
</html>
