<?php
$root='root';
$pass='';
$host='localhost';
$db='dict1';
$dbcon=mysqli_connect($host,$root,$pass,$db); 
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}