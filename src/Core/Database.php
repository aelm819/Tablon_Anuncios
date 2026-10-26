<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOStatement;

class Database
{
	// Todas las instancias reutilizan la misma conexión PDO.
	private static ?PDO $connection = null;

	public function __construct()
	{
		if (self::$connection === null) {
			// El archivo .env devuelve la configuración de la base de datos.
			$config = require dirname(__DIR__, 2) . '/config.php';
			$database = $config['db'];

			self::$connection = new PDO(
				"mysql:host={$database['host']};dbname={$database['dbname']};charset={$database['charset']}",
				$database['user'],
				$database['pass'],
				[
					// Los errores de PDO se lanzan como excepciones y las filas son asociativas.
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				]
			);
		}
	}

	/** Ejecuta una consulta preparada y devuelve su PDOStatement. */
	public function query(string $sql, array $params = []): PDOStatement
	{
		$statement = self::$connection->prepare($sql);
		$statement->execute($params);

		return $statement;
	}

	/** Devuelve todas las filas encontradas o null si el resultado está vacío. */
	public function fetchAll(string $sql, array $params = []): ?array
	{
		$rows = $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

		return $rows === [] ? null : $rows;
	}

	/** Devuelve la primera fila encontrada o null si no hay resultados. */
	public function fetchOne(string $sql, array $params = []): ?array
	{
		$row = $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);

		return $row === false ? null : $row;
	}
}