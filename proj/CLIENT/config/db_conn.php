<?php
$conn=new mysqli("localhost","ipl","0112358132134","ipl_db");
if($conn->connect_error){
    die("connection failed:".$conn->connect_error);
}
// echo "Connected Successfully";
?>
