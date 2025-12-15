<?php
// /includes/mercado_pago.php
require_once __DIR__ . '/../vendor/autoload.php';

// Substitua pelo seu Access Token REAL do Mercado Pago
define('MP_ACCESS_TOKEN', 'SEU_ACCESS_TOKEN_AQUI'); 
// URL base do seu sistema (Importante para Webhooks e Retornos)
define('BASE_URL', 'http://localhost/iftickets'); 

// Inicializa o SDK
MercadoPago\SDK::setAccessToken(MP_ACCESS_TOKEN);

?>