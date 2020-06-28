<?php
    include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    $mtch=['QUALIFIER 1','ELIMINATOR','QUALIFIER 2','FINAL'];
    $sql1="SELECT A.FNAME C,B.FNAME D,STATUS,WINNER,MATCH_ID FROM matches,FRANCHISE A,FRANCHISE B WHERE A.FID=TEAM1 AND B.FID=TEAM2 and MATCH_ID<=28 ORDER BY STATUS DESC,MATCH_ID ASC";
    $result=mysqli_query($conn,$sql1);



    $sql="SELECT COUNT(*) FROM MATCHES WHERE WINNER IS NOT NULL";
    $res1=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($res1);
    $count=$row['COUNT(*)'];



?>
<!DOCTYPE html>
<html>
<head>
    <title>matches</title>
    <link rel="stylesheet" type="text/css" href="style_sh/match.css">
</head>
<body>
 <div class="head"><span class="name">SCORER</span><span class="app">CRICKIE</span></div>
 <div class="mtchs">
    <?php while($row=mysqli_fetch_assoc($result)){?>
        <div class="mtch">
        <div class="top">3 OVER MATCH</div>
        <div class="play"><span class="match"><?php echo $row['C'];?></span><span> vs </span><span class="match"><?php echo $row['D'];?></span></div>
        <div class="summ">
        <?php if ($row['STATUS']=="0"){echo "";} else if($row['STATUS']=="1"){echo "<span class='live'><button>LIVE</button></span>";} else{echo "<span>COMPLETED</span>";}?>
        <?php if ($row['STATUS']=="0"){echo "<span class='host'><button>HOST</button></span>";}?></div>
        </div><br><br>
    <?php }?>

<?php
    // echo $count;
    if($count==28){
        $s="SELECT * FROM TEAM_BIO ORDER BY WINS DESC,DRAWS DESC";
        $rs=mysqli_query($conn,$s);
        $t1=mysqli_fetch_assoc($rs)['FID'];
        $t2=mysqli_fetch_assoc($rs)['FID'];
        $t3=mysqli_fetch_assoc($rs)['FID'];
        $t4=mysqli_fetch_assoc($rs)['FID'];
        if($t2>$t1){
            $temp=$t1;
            $t1=$t2;
            $t2=$temp;
        }
        if($t4>$t3){
            $temp=$t3;
            $t3=$t4;
            $t4=$temp;
        }
        $s="UPDATE MATCHES SET TEAM1=$t1,TEAM2=$t2 WHERE MATCH_ID=29";
        mysqli_query($conn,$s);
        $s="UPDATE MATCHES SET TEAM1=$t3,TEAM2=$t4 WHERE MATCH_ID=30";
        mysqli_query($conn,$s);
    }

    if($count==29){
        $s="SELECT * FROM MATCHES WHERE MATCH_ID=29";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$win=$ro['WINNER'];$t1=$ro['TEAM1'];$t2=$ro['TEAM2'];
        if($win==$t1){$loss=$t2;}else{$loss=$t1;}
        $s="UPDATE MATCHES SET TEAM1=$win WHERE MATCH_ID=32";mysqli_query($conn,$s);
        $s="UPDATE MATCHES SET TEAM1=$loss WHERE MATCH_ID=31";mysqli_query($conn,$s);
    }
    if($count==30){
        $s="SELECT * FROM MATCHES WHERE MATCH_ID=30";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$win=$ro['WINNER'];
        $s="UPDATE MATCHES SET TEAM2=$win WHERE MATCH_ID=31";mysqli_query($conn,$s);

        $s="SELECT * FROM MATCHES WHERE MATCH_ID=31";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$t1=$ro['TEAM1'];$t2=$ro['TEAM2'];
        if($t2>$t1){
            $temp=$t1;
            $t1=$t2;
            $t2=$temp;
        }
        $s="UPDATE MATCHES SET TEAM1=$t1,TEAM2=$t2 WHERE MATCH_ID=31";
        mysqli_query($conn,$s);
    }
    if($count==31){
        $s="SELECT * FROM MATCHES WHERE MATCH_ID=31";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$win=$ro['WINNER'];
        $s="UPDATE MATCHES SET TEAM2=$win WHERE MATCH_ID=32";mysqli_query($conn,$s);

        $s="SELECT * FROM MATCHES WHERE MATCH_ID=32";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$t1=$ro['TEAM1'];$t2=$ro['TEAM2'];
        if($t2>$t1){
            $temp=$t1;
            $t1=$t2;
            $t2=$temp;
        }
        $s="UPDATE MATCHES SET TEAM1=$t1,TEAM2=$t2 WHERE MATCH_ID=32";
        mysqli_query($conn,$s);
    }


?>

        <div class="special">
            <?php
                $sql="SELECT * FROM MATCHES WHERE MATCH_ID>28";
                $res=mysqli_query($conn,$sql);
                while($row=mysqli_fetch_assoc($res)){
            ?>
                <div class="topp"><?php echo $mtch[$row['MATCH_ID']-29];?></div>
                <div class="mtch">
                        <div class="top">3 OVER MATCH</div>

                        <div class="play"><span class="match"><?php if($row['TEAM1']){echo $team[$row['TEAM1']-1];}else {echo " TBC ";}?></span><span>vs</span>
                        <span class="match"><?php if($row['TEAM2']){echo $team[$row['TEAM2']-1];}else {echo " TBC ";}?></span></div>
                        <?php if($row['TEAM1']&&($row['TEAM2'])){?>
                        <div class="summ"><?php if ($row['STATUS']=="0"){echo "";} else if($row['STATUS']=="1"){echo "<span class='live'><button>LIVE</button></span>";} else{echo "<span>COMPLETED</span>";}?>
                        <span class="host"><?php if ($row['STATUS']=="0"){echo "<button>HOST</button>";}?></span></div><br>
                        <?php } ?>
                </div><br><br>
                <?php }?>
        </div>

 </div>
 <?php

    if($count==32){
        $s="SELECT * FROM MATCHES WHERE MATCH_ID=32";
        $res=mysqli_query($conn,$s);
        $ro=mysqli_fetch_assoc($res);$win=$ro['WINNER'];$t1=$ro['TEAM1'];$t2=$ro['TEAM2'];
        if($win==$t1){$loss=$t2;}else{$loss=$t1;}


 ?>
<span class="winner"><?php echo $team[$win-1]; ?></span>
<span class="runner"><?php echo $team[$loss-1]; ?></span>
<?php } ?>
 <?php $conn->close();?>
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery.redirect.js"></script>
    <script src="matches.js"></script>
</body>
</html>

