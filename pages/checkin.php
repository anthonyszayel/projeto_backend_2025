<?php
// /pages/checkin.php
session_start();
require_once __DIR__ . '/../includes/db.php';

// 1. **PROTEÇÃO DE ACESSO**
// Verifica se o usuário tem o perfil 'portaria' 
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] !== 'portaria') { 
    header("Location: /pages/auth.html"); // Redireciona para o login
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <title>Check-in | Portaria</title>
    <script src="https://unpkg.com/html5-qrcode" defer></script> <script>
        // Lógica de leitura e envio (ver /scripts/checkin.js)
    </script>
</head>
<body>
    <h1>Painel de Check-in (Portaria)</h1>
    <p>Operador logado: <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></p>
    
    <div id="reader" style="width: 400px; height: 300px;"></div> <input type="text" id="manual_input" placeholder="Ou digite o código do ingresso" />
    <button onclick="iniciarCheckin(document.getElementById('manual_input').value)">Validar Manualmente</button>

    <div id="resultado_checkin" style="margin-top: 20px; padding: 10px; border: 1px solid;">
        Aguardando leitura...
    </div>
</body>
</html>