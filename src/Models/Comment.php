<?php

declare(strict_types=1);

namespace App\Models;

class Comment extends BaseModel
{
    //  Necesitamos buscar todos los comentarios de UN post en concreto
    public function getByPostId(int $postId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->nombreTabla} WHERE post_id = :post_id ORDER BY created_at ASC",
            ['post_id' => $postId]
        )?: []; // <-- Esto evita el error si devuelve null
    }
}