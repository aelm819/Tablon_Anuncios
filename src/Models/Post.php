<?php

declare(strict_types=1);

namespace App\Models;

class Post extends BaseModel
{
    public function search(string $keyword)
    {
        $keyword = '%' . $keyword . '%';
        return $this->db->fetchAll(
            "SELECT * FROM {$this->nombreTabla} WHERE title LIKE :keyword OR category LIKE :keyword",
            ['keyword' => $keyword]
        );
    }
}
