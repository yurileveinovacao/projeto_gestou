<?php
/**
 * Sessões via PostgreSQL — Gestou
 * Substitui o armazenamento de sessões em filesystem (incompatível com Cloud Run).
 * Usa a conexão $pdo de config/database.php.
 *
 * Uso: require este arquivo ANTES de session_start().
 */

require_once __DIR__ . '/database.php';

class PgSessionHandler implements SessionHandlerInterface
{
    /** @var PDO */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    /**
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        $stmt = $this->pdo->prepare('SELECT data FROM php_sessions WHERE id = :id');
        $stmt->execute(array('id' => $id));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['data'] : '';
    }

    /**
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO php_sessions (id, data, last_access) VALUES (:id, :data, NOW())
             ON CONFLICT (id) DO UPDATE SET data = :data2, last_access = NOW()'
        );
        return $stmt->execute(array(
            'id' => $id,
            'data' => $data,
            'data2' => $data
        ));
    }

    /**
     * @param string $id
     * @return bool
     */
    public function destroy($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM php_sessions WHERE id = :id');
        return $stmt->execute(array('id' => $id));
    }

    /**
     * @param int $maxLifetime
     * @return bool
     */
    public function gc($maxLifetime)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM php_sessions WHERE last_access < NOW() - CAST(:lifetime AS INTERVAL)'
        );
        return $stmt->execute(array(
            'lifetime' => $maxLifetime . ' seconds'
        ));
    }
}

// Registrar o handler apenas se a tabela existir (evita erro em dev sem a tabela)
$sessionHandler = new PgSessionHandler($pdo);
session_set_save_handler($sessionHandler, true);
