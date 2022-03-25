<?php
require_once 'db_connect.php';
mysqli_query($dbcon, "SET CHARACTER SET cp1251");
$name = $_FILES["file"]["name"];
$fileName = $_FILES["file"]["tmp_name"];
$tableName = str_replace(".csv", "", $name);

$createTable = "create table if not exists $tableName (
        id int(30) NOT NULL AUTO_INCREMENT, 
        engWords varchar(200) NOT NULL,
        rusWords nvarchar(200) NOT NULL,
        PRIMARY KEY (id)) engine=InnoDB;";
$startCreate = mysqli_query($dbcon, $createTable);
$file = fopen($fileName, "r");
$ii=0;
while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
        if($ii++ == 0){ continue; }
        $sqlInsert = "insert into $tableName (engWords, rusWords) values ('" . $column[0] . "', '" . $column[1] . "')";
        $result = mysqli_query($dbcon, $sqlInsert);
}