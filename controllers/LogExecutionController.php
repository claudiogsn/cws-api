<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../database/db.php';

class LogExecutionController {

    public static function getLogExecutions() {
        global $pdo;

        $stmt = $pdo->prepare('SELECT * FROM log_execution');
        $stmt->execute();

        $logExecutions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $logExecutions;
    }

    public static function getLogExecutionById($id) {
        global $pdo;

        $stmt = $pdo->prepare('SELECT * FROM log_execution WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createLogExecution($data) {
        global $pdo;

        $stmt = $pdo->prepare('INSERT INTO log_execution (estabelecimento, tipo, content, created_at) VALUES (:estabelecimento, :tipo, :content, :created_at)');
        $stmt->execute([
            ':estabelecimento' => $data['estabelecimento'],
            ':tipo' => $data['tipo'],
            ':content' => $data['content'],
            ':created_at' => $data['created_at']
        ]);

        return ['id' => $pdo->lastInsertId()];
    }

    public static function updateLogExecution($id, $data) {
        global $pdo;

        $stmt = $pdo->prepare('UPDATE log_execution SET estabelecimento = :estabelecimento, tipo = :tipo, content = :content, created_at = :created_at WHERE id = :id');
        $result = $stmt->execute([
            ':estabelecimento' => $data['estabelecimento'],
            ':tipo' => $data['tipo'],
            ':content' => $data['content'],
            ':created_at' => $data['created_at'],
            ':id' => $id
        ]);

        return ['success' => $result];
    }

    public static function deleteLogExecution($id) {
        global $pdo;

        $stmt = $pdo->prepare('DELETE FROM log_execution WHERE id = :id');
        $result = $stmt->execute([':id' => $id]);

        return ['success' => $result];
    }
}
?>
