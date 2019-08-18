<?php
session_start();
$username="root";
$pwd="";
$dbname="php_appointment";
$server="localhost";
$conn = mysqli_connect($server,$username,$pwd,$dbname);
if($conn){
	// echo 'sucessfully connected to server';
}else{
	echo mysqli_connect_error();
}
?>