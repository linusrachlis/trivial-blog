<?php

namespace app;

class Post
{
    public $id;
    public $posted_at;
    public $subject;
    public $body;

    /**
     * @return self[]
     */
    public static function list(): array
    {
        $pdo = env()->pdo();
        $query = $pdo->query("SELECT * FROM `post` ORDER BY `posted_at` DESC");
        $query->setFetchMode(\PDO::FETCH_CLASS, self::class);
        return $query->fetchAll();
    }

    public static function insert(string $subject, string $body): void
    {
        $pdo = env()->pdo();
        $pdo->prepare(
            "INSERT INTO `post` (`posted_at`, `subject`, `body`)"
            . " VALUES (:posted_at, :subject, :body)")
            ->execute([
                ':posted_at' => date('Y-m-d H:i:s'),
                ':subject' => $subject,
                ':body' => $body,
            ]);
    }

    public static function delete($id): int
    {
        $pdo = env()->pdo();
        $stmt = $pdo->prepare(
            "DELETE FROM `post` WHERE `id` = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

}
