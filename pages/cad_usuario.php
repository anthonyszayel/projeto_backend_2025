<?php
include "conecta.php";

/* Buscar organizações para o select */
$orgs = mysqli_query($conn, "SELECT id, nome FROM organizacao");

/* Inserção do usuário */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $perfil = $_POST["perfil"];
    $ativo = $_POST["ativo"];
    $organizacao_id = $_POST["organizacao_id"];

    $sql = "INSERT INTO usuario (nome, perfil, ativo, organizacao_id)
            VALUES ('$nome', '$perfil', '$ativo', '$organizacao_id')";

    if (mysqli_query($conn, $sql)) {
        $mensagem = "Usuário cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar usuário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Gestão de Eventos">
    <meta name="author" content="Quarto Período SI">

    <title>Cadastro de Usuário</title>

    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/lista.css">
    <link rel="stylesheet" href="../styles/cad.css">
    <link rel="stylesheet" href="../styles/select.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <a href="../index.html">Início</a>
    <a href="lista_usuario.php">Lista de Usuários</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<div class="main">

    <h2 class="title">Cadastro de Usuário</h2>

    <?php if (!empty($mensagem)) : ?>
        <p class="msg"><strong><?= $mensagem ?></strong></p>
    <?php endif; ?>

    <form method="post" class="form">

        <label class="label">Nome</label>
        <input
            type="text"
            name="nome"
            class="input"
            placeholder="Digite o nome do usuário"
            required
        >

        <label class="label">Perfil</label>
        <select name="perfil" class="select" required>
            <option value="">Selecione</option>
            <option value="organizador">Organizador</option>
            <option value="bilheteria">Bilheteria</option>
            <option value="financeiro">Financeiro</option>
            <option value="portaria">Portaria</option>
            <option value="admin">Admin</option>
        </select>

        <label class="label">Ativo</label>
        <select name="ativo" class="select">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>

        <label class="label">Organização</label>
        <select name="organizacao_id" class="select" required>
            <option value="">Selecione</option>
            <?php while ($org = mysqli_fetch_assoc($orgs)) : ?>
                <option value="<?= $org['id']; ?>">
                    <?= $org['nome']; ?>
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
