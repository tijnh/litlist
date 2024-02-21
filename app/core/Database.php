<?php 

Trait Database
{

	private function connect()
	{
		$string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		try {
			$con = new PDO($string, DBUSER, DBPASS);
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $con;
		} catch (PDOException $e) {
			// Output or log the error message
			echo "Connection failed: " . $e->getMessage();
			return false;
		}
	}

	public function query($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($result) AND count($result))
			{
				return $result;
			}
		}

		return false;
	}

	public function get_row($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if($check)
		{
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($result) AND count($result))
			{
				return $result[0];
			}
		}

		return false;
	}
	
}


