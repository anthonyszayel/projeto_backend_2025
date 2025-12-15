<?php
// /IngressoService.php
// Usará a biblioteca de QR Code instalada via Composer (chillerlan/php-qrcode)
use chillerlan\QRCode\{QRCode};

class IngressoService {

    public static function emitirIngressos(PDO $db, $pedidoId) {
        // 1. Obter dados do Pedido e Cliente (titular)
        $stmt = $db->prepare("
            SELECT p.quantidade, c.nome AS titular_nome, c.documento AS titular_documento
            FROM pedido p
            JOIN cliente c ON p.cliente_id = c.id
            WHERE p.id = ? AND p.status = 'aprovado'
        ");
        $stmt->execute([$pedidoId]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedido) {
            error_log("Tentativa de emissão para pedido não aprovado ou inexistente: ID {$pedidoId}");
            return false;
        }

        $quantidade = $pedido['quantidade'];
        $titularNome = $pedido['titular_nome'];
        $titularDocumento = $pedido['titular_documento'];

        $stmt_insert = $db->prepare("
            INSERT INTO ingresso 
            (pedido_id, identificador_unico, qrcode, status, titular_nome, titular_documento, data_emissao) 
            VALUES (?, ?, ?, 'emitido', ?, ?, NOW())
        ");
        
        for ($i = 0; $i < $quantidade; $i++) {
            // 2. Gerar Token Único (Identificador_unico, VARCHAR(36))
            $token = self::generateUUID(); 
            
            // 3. Gerar URL pública do QR Code (Salvando a imagem no diretório /assets/qrcodes)
            $qrcode_path = self::gerarEsalvarQRCode($token);

            // 4. Inserir o Ingresso
            // Cada ingresso tem um identificador único[cite: 11].
            $stmt_insert->execute([
                $pedidoId, 
                $token, 
                $qrcode_path, 
                $titularNome, 
                $titularDocumento
            ]);
        }
        return true;
    }

    private static function generateUUID() {
        // Implementação simplificada do UUID v4
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
    private static function gerarEsalvarQRCode($token) {
        $caminho_base = __DIR__ . "/assets/qrcodes/"; // Caminho completo no servidor
        $file_name = "qr_{$token}.png";
        
        // Crie o diretório se não existir
        if (!is_dir($caminho_base)) {
            mkdir($caminho_base, 0777, true); 
        }

        try {
            // O conteúdo do QR Code é o token único
            (new QRCode())->render($token, $caminho_base . $file_name);
            return "/assets/qrcodes/{$file_name}"; // Retorna o caminho relativo/público
        } catch (Exception $e) {
            error_log("Falha ao gerar QR Code: " . $e->getMessage());
            return $token; 
        }
    }
}
?>