<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../database/db.php';

class EstabelecimentoController {

    public static function getEstabelecimentos() {
        global $pdo;

        $stmt = $pdo->prepare('SELECT * FROM estabelecimento');
        $stmt->execute();

        $estabelecimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $estabelecimentos;
    }

    public static function getEstabelecimentoByCnpj($cnpj) {
        global $pdo;

        $stmt = $pdo->prepare('SELECT * FROM estabelecimento WHERE cnpj = :cnpj');
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createEstabelecimento($data) {
        global $pdo;

        $stmt = $pdo->prepare('INSERT INTO estabelecimento (cod_estabelecimento, staus, cnpj, hash, version, atualizado) VALUES (:cod_estabelecimento, :staus, :cnpj, :hash, :version, :atualizado)');
        $stmt->execute([
            ':cod_estabelecimento' => $data['cod_estabelecimento'],
            ':staus' => $data['staus'],
            ':cnpj' => $data['cnpj'],
            ':hash' => $data['hash'],
            ':version' => $data['version'],
            ':atualizado' => $data['atualizado']
        ]);

        return ['id' => $pdo->lastInsertId()];
    }

    public static function updateEstabelecimento($id, $data) {
        global $pdo;

        $stmt = $pdo->prepare('UPDATE estabelecimento SET cod_estabelecimento = :cod_estabelecimento, staus = :staus, cnpj = :cnpj, hash = :hash, version = :version, atualizado = :atualizado WHERE id = :id');
        $result = $stmt->execute([
            ':cod_estabelecimento' => $data['cod_estabelecimento'],
            ':staus' => $data['staus'],
            ':cnpj' => $data['cnpj'],
            ':hash' => $data['hash'],
            ':version' => $data['version'],
            ':atualizado' => $data['atualizado'],
            ':id' => $id
        ]);

        return ['success' => $result];
    }

    public static function deleteEstabelecimento($id) {
        global $pdo;

        $stmt = $pdo->prepare('DELETE FROM estabelecimento WHERE id = :id');
        $result = $stmt->execute([':id' => $id]);

        return ['success' => $result];
    }
}
?>
