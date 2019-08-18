<?php
include 'connection.php';
if(!isset($_SESSION['id'])){
header('location:index.php');
}else if($_SESSION['user_type']==2){
header('location:user_home.php');
}
echo 'lawyer_home';
?>