<?php
    include("config/db_conn.php");

    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $yr=2020;
    $toss=$_POST['toss'];
    $ch=$_POST['ch'];

    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];

    echo "running";

    mysqli_query($conn,"INSERT INTO TOSS VALUES($yr,$mid,$toss,'$ch')");
    $conn->close();
?>
