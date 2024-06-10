<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../database/db.php';

class ValidationController {

    public static function validateEstabelecimento($cnpj, $hash) {
        global $pdo;

        $stmt = $pdo->prepare('SELECT * FROM estabelecimento WHERE cnpj = :cnpj AND hash = :hash');
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':hash', $hash);
        $stmt->execute();

        $estabelecimento = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($estabelecimento) {
            http_response_code(200);
            return ['exists' => true];
        } else {
            http_response_code(404);
            return ['exists' => false];
        }
    }
}
?>
