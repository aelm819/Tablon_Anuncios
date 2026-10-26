<?php

declare(strict_types=1);

namespace App\Models;

class User extends BaseModel
{
	public function findByEmail(string $email, string $password): ?int
	{
		$user = $this->db->fetchOne(
			"SELECT id, password FROM {$this->nombreTabla} WHERE email = :email",
			['email' => $email]
		);

		if ($user === null) {
			return null;
		}

		if (!password_verify($password, $user['password'])) {
			return null;
		}

		return (int) $user['id'];
	}
}
