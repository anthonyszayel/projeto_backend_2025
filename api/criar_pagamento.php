<?php
// /api/criar_pagamento.php
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/mercado_pago.php';

header('Content-Type: application/json');

// 1. **AUTENTICAÇÃO E DADOS**
// Assumindo que o ID do cliente está na sessão após o login
$cliente_id = $_SESSION['cliente_id'] ?? null;
if (!$cliente_id) {
    http_response_code(401);
    echo json_encode(['status' => 'erro', 'mensagem' => 'Cliente não autenticado.']);
    exit;
}

// Dados simulados da compra (viriam do POST/GET do frontend)
$dados_compra = [
    'evento_nome' => $_POST['evento_nome'] ?? 'Evento Teste IF',
    'setor_id' => (int)($_POST['setor_id'] ?? 1),
    'lote_id' => (int)($_POST['lote_id'] ?? 1),
    'quantidade' => (int)($_POST['quantidade'] ?? 1),
    'preco_unitario' => (float)($_POST['preco_unitario'] ?? 50.00),
    // Outros campos necessários: valor_bruto, taxa, desconto, total_liquido
];

$db = Database::getConnection();

try {
    // 2. **CRIAR O REGISTRO DO PEDIDO NO BANCO DE DADOS**
    
    // Calcula o total líquido (simplificado para o exemplo)
    $total_liquido = $dados_compra['quantidade'] * $dados_compra['preco_unitario'];
    
    // Inserir na tabela 'pedido' (Status inicial: pendente)
    $stmt_pedido = $db->prepare("
        INSERT INTO pedido (cliente_id, canal_venda, setor_id, lote_id, quantidade, valor_bruto, taxa, desconto, total_liquido, status, prazo_expiracao)
        VALUES (?, 'ecommerce', ?, ?, ?, ?, 0.00, 0.00, ?, 'pendente', DATE_ADD(NOW(), INTERVAL 30 MINUTE))
    ");
    $stmt_pedido->execute([
        $cliente_id, 
        $dados_compra['setor_id'], 
        $dados_compra['lote_id'], 
        $dados_compra['quantidade'], 
        $total_liquido, 
        $total_liquido
    ]);
    $pedido_id = $db->lastInsertId();

    // Inserir na tabela 'pagamento' (Status inicial: pendente)
    $stmt_pagamento = $db->prepare("
        INSERT INTO pagamento (pedido_id, metodo, status, valor, taxa)
        VALUES (?, 'pix', 'pendente', ?, 0.00)
    ");
    $stmt_pagamento->execute([$pedido_id, $total_liquido]);


    // 3. **CRIAR A PREFERÊNCIA DE PAGAMENTO NO MERCADO PAGO**
    $preference = new MercadoPago\Preference();
    
    // Item
    $item = new MercadoPago\Item();
    $item->title = $dados_compra['evento_nome'] . " (" . $dados_compra['quantidade'] . " unid)";
    $item->quantity = 1; // A preferência é para o pedido completo
    $item->unit_price = $total_liquido;
    $item->currency_id = "BRL";
    $preference->items = array($item);

    // URLs de Retorno
    $preference->back_urls = array(
        "success" => BASE_URL . "/pages/sucesso.php?pedido_id=" . $pedido_id,
        "failure" => BASE_URL . "/pages/erro.php?pedido_id=" . $pedido_id,
        "pending" => BASE_URL . "/pages/pendente.php?pedido_id=" . $pedido_id
    );

    // Webhook (Notificação) - O mais importante para o status final
    $preference->notification_url = BASE_URL . "/api/webhook_mercadopago.php?source_topic=payment";
    
    // Referência Externa: Nossa chave para ligar o pagamento ao pedido
    $preference->external_reference = (string)$pedido_id; 

    $preference->save();

    // 4. **RESPOSTA DE SUCESSO**
    echo json_encode([
        'status' => 'ok', 
        'link_pagamento' => $preference->init_point // Link para redirecionar o cliente
    ]);

} catch (Exception $e) {
    http_response_code(500);
    error_log("Erro ao criar pagamento: " . $e->getMessage());
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro interno ao processar o pagamento.']);
}
?>