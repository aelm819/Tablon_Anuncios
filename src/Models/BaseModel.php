<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

abstract class BaseModel
{


	public function __construct(
		protected Database $db,
		protected string $nombreTabla,
	) {}

	// Obtenir todos los registros
	public function getAll(): ?array
	{
		return $this->db->fetchAll("SELECT * FROM $this->nombreTabla ORDER BY id DESC");
	}

	// Obtener un registro por id
	public function getById(int $id): ?array
	{
		return $this->db->fetchOne("SELECT * FROM $this->nombreTabla WHERE id = :id", ['id' => $id]);
	}
	// borrar un registro
	public function delete(int $id): void
	{
		$this->db->query(
			"DELETE FROM $this->nombreTabla WHERE `id` = :id",
			[':id' => $id]
		);
	}

	//  Insertar registros
	public function insert(array $data): void
	{
		// Extraemos los nombres de las columnas
		$columnas = array_keys($data);
		$columnasString = implode(', ', $columnas);

		// Creamos los marcadores para PDO  
		$marcadores = [];
		foreach ($columnas as $columna) {
			$marcadores[] = ":" . $columna;
		}
		$marcadoresString = implode(', ', $marcadores);

		$sql = "INSERT INTO {$this->nombreTabla} ($columnasString) VALUES ($marcadoresString)";

		$this->db->query($sql, $data);
	}

	// Actualizar registros
	public function update(int $id, array $data): void
	{
		// Extraemos los nombres de las columnas
		$columnas = array_keys($data);

		// Creamos los pares de actualización (ej: title = :title)
		$marcadores = [];
		foreach ($columnas as $columna) {
			$marcadores[] = $columna . " = :" . $columna;
		}
		$marcadoresString = implode(', ', $marcadores);

		$sql = "UPDATE {$this->nombreTabla} SET $marcadoresString WHERE id = :id";

		// Añadimos el id al array de datos para que PDO lo encuentre
		$data['id'] = $id;

		$this->db->query($sql, $data);
	}
}
