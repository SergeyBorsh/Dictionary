<?php


	class ImportFile
	{
		public $tableName;
		protected $dbcon;

		public function __construct ($host = 'localhost', $root = 'root', $pass = '', $db = 'dict1')
		{
			$this->dbcon = mysqli_connect($host, $root, $pass, $db);
			mysqli_query($this->dbcon, "SET CHARACTER SET cp1251");
		}

		public function import ()
		{
			$name = $_FILES["file"]["name"];
			$fileName = $_FILES["file"]["tmp_name"];
			$tableName = str_replace(".csv", "", $name);
			$this->deleteTable($tableName);
			$this->createTable($tableName);
			$file = fopen($fileName, "r");
			$ii = 0;
			while (($row = fgetcsv($file, 10000, ";")) !== false) {
				if ($ii++ == 0) continue;
				$row0[] = $row[0];
				$row1[] = $row[1];
				$row[0] = mysqli_real_escape_string($this->dbcon, $row[0]);
				$row[1] = mysqli_real_escape_string($this->dbcon, $row[1]);
				$sqlInsert = "insert into $tableName (engWords, rusWords) values ('".$row[0]."', '".$row[1]."')";
				$result = mysqli_query($this->dbcon, $sqlInsert);
			}
		}

		private function deleteTable ($tableName)
		{
			$this->tableName = $tableName;
			return mysqli_query($this->dbcon, "drop table {$this->tableName}");
		}

		private function createTable ($tableName)
		{
			$this->tableName = $tableName;
			$createTable = "create table {$this->tableName} (
        	id int(30) NOT NULL AUTO_INCREMENT, 
        	engWords varchar(200) NOT NULL,
        	rusWords nvarchar(200) NOT NULL,
        	PRIMARY KEY (id)) engine=InnoDB;";
			$startCreate = mysqli_query($this->dbcon, $createTable);
		}

		public function __destruct ()
		{
			mysqli_close($this->dbcon);
		}
	}