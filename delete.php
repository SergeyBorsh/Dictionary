<?php
require_once 'db_connect.php';
$choice = $_POST['choiceDict'];
$queryDelete = "drop table $choice";
$startDelete = mysqli_query($dbcon,$queryDelete);
mysqli_close($dbcon);