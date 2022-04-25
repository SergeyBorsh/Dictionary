<?php


	class DeleteFile
	{
		public $choice;

		protected $dbcon;

		public function __construct ($host = 'localhost', $root = 'root', $pass = '', $db = 'dict1')
		{
			$this->dbcon = mysqli_connect($host, $root, $pass, $db);
		}

		public function delete ($choice)
		{
			$this->choice = $choice;
			$queryDelete = "drop table {$this->choice}";
			$startDelete = mysqli_query($this->dbcon, $queryDelete);
		}

		public function __destruct ()
		{
			mysqli_close($this->dbcon);
		}
	}