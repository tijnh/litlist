<?php

/**
 * Main Model trait
 */
trait Model
{
	use Database;

	protected $limit = MAXLIMIT;
	protected $offset = 0;
	public $errors = [];

	public function findAll($orderColumn, $orderType)
	{

		$query = "SELECT * FROM $this->table ORDER BY $orderColumn $orderType LIMIT $this->limit OFFSET $this->offset";

		return $this->query($query);
	}


	public function findFirst($orderColumn, $orderType)
	{
		$result = $this->findAll($orderColumn, $orderType);

		if ($result)
			return $result[0];

		return false;
	}

	public function findMin($column)
	{
		$query = "SELECT MIN($column) FROM $this->table";
		$result = $this->query($query);
		
		if ($result)
			return $result[0]["MIN($column)"];

		return false;
	}
	
	public function findMax($column)
	{
		$query = "SELECT MAX($column) FROM $this->table";
		$result = $this->query($query);

		if ($result)
			return $result[0]["MAX($column)"];

		return false;
	}

	public function findDistinct($column, $orderType)
	{
		$query = "SELECT DISTINCT $column FROM $this->table ORDER BY $column $orderType LIMIT $this->limit OFFSET $this->offset";
		$results = $this->query($query);

		// Flatten the multidimensional array
		$distinctValues = array_column($results, $column);

		return $distinctValues;
	}

	public function insert($data)
	{

		/** remove unwanted data **/
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {

				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "INSERT INTO $this->table (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
		$this->query($query, $data);

		return false;
	}

	public function update($id, $data, $id_column = 'id')
	{

		/** remove unwanted data **/
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {

				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query = "UPDATE $this->table SET ";

		foreach ($keys as $key) {
			$query .= $key . " = :" . $key . ", ";
		}

		$query = trim($query, ", ");

		$query .= " WHERE $id_column = :$id_column ";

		$data[$id_column] = $id;

		$this->query($query, $data);
		return false;
	}

	public function delete($id, $id_column = 'id')
	{

		$data[$id_column] = $id;
		$query = "DELETE FROM $this->table WHERE $id_column = :$id_column ";
		$this->query($query, $data);

		return false;
	}
}
