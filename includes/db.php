<?php
// Arquivo: Conexao.php
class Conexao {
    private $host = 'localhost';
    private $db   = 'iftickets';
    private $user = 'root';
    private $pass = '';
    
    public function getConexao() {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            // Configura para lançar erros (Exceptions) em caso de falha
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // Em um sistema real, gravaríamos log. Aqui, mostramos o erro.
            die("Erro crítico de conexão: " . $e->getMessage());
        }
    }
}
?>
