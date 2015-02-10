<?php

namespace DA;

USE \PDO;
USE \BE;

class DA_Base {
	public function __construct(PDO $connection = null) {
		$this->connection = $connection;
		if ($this->connection === null) {
			$this->connection = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
			$this->connection->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
	}
}
