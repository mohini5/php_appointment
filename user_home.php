<?php
include 'connection.php';
if(!isset($_SESSION['id'])){
header('location:index.php');
}else if($_SESSION['user_type']==1){
header('location:lawyer_home.php');
}
echo 'user_home';
?>
