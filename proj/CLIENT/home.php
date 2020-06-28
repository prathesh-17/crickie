<?php

    include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    $yr=2020;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crickie-HOME</title>
    <link rel="stylesheet" type="text/css" href="style_sh/home.css">
</head>
<body>
    <img src="style_sh/photo6091468918561548869.jpg" >

<div class="head"><span>CRICKIE</span></div>
<div><div class="nav"><span class="live">LIVE </span><span class="upcoming"> UPCOMING </span><span class="recent"> RECENT </span><span class="det"> SEASON DETAILS</span></div>

    <div class="live_mtchs">

        <?php
            $s="SELECT * FROM MATCHES WHERE STATUS=1 AND MATCH_ID<=28 AND YEAR=$yr";
            $res=mysqli_query($conn,$s);
            while($row=mysqli_fetch_assoc($res)){
                $mid=$row['MATCH_ID'];
        ?>
        <div class="live_mtch">
        <div class="top"> 3 OVER MATCH </div>
        <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2 AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
        ?>
        <div class="score1"><span class="team1"><?php echo $team[$row1['TEAM']-1]; ?></span> <span class="scre"><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
        <span class="scre1"><?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?></span></div>

        <div class="obs"><?php if($row1['M_ST']==2 && !mysqli_num_rows($inn2)){echo "Innings Break";}else if($row1['M_ST']==1){echo "Live";} ?></div>
        <?php if($row2=mysqli_fetch_assoc($inn2)){ ?>
                    <div class="score2"><span class="team2"><?php echo $team[$row2['TEAM']-1]; ?></span> <span class="scre"><?php echo $row2['RUNS'] ?>-<?php echo $row2['WICKET'] ?></span>
                    <span class="scre1"><?php echo $row2['OVERS'] ?>.<?php echo $row2['BALLS'] ?></span></div>
                    <?php $r=$row1['RUNS']-$row2['RUNS']; ?>
                    <div class="obs"><span >Need</span>
                    <span class="runs_req"><?php echo $r+1?></span><span> from </span>
                    <span class="balls_more"><?php $b=18-($row2['OVERS']*6)-$row2['BALLS'];echo $b;?></span><span> balls</span></div>
        <?php }?>
        </div><br>
    <?php } ?>

    </div>

    <div class="upcoming_mtchs">
        <?php
            $s="SELECT * FROM MATCHES WHERE STATUS=0 AND MATCH_ID<=28  AND YEAR=$yr";
            $res=mysqli_query($conn,$s);
            while($row=mysqli_fetch_assoc($res)){
                $mid=$row['MATCH_ID'];
        ?>
        <div class="upcoming_match">
                <div class="top"> 3 OVER MATCH </div>
                <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>
        </div><br>
    <?php } ?>
    </div>

    <div class="comp_mtchs">

        <?php
            $s="SELECT * FROM MATCHES WHERE STATUS=2 AND MATCH_ID<=28  AND YEAR=$yr";
            $res=mysqli_query($conn,$s);
            while($row=mysqli_fetch_assoc($res)){
                $mid=$row['MATCH_ID'];
        ?>
        <div class="comp_mtch">
        <div class="top"> 3 OVER MATCH </div>
        <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2  AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
              $row2=mysqli_fetch_assoc($inn2);
        ?>
        <div class="score1">
        <span class="team1"><?php echo $team[$row1['TEAM']-1]; ?></span> <span class="scre"><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
        <span class="scre1"><?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?></span></div>

        <div class="score2">
        <span class="team2"><?php echo $team[$row2['TEAM']-1]; ?></span> <span class="scre"><?php echo $row2['RUNS'] ?>-<?php echo $row2['WICKET'] ?></span>
        <span class="scre1"><?php echo $row2['OVERS'] ?>.<?php echo $row2['BALLS'] ?></span></div>


        <div class="summ">
        <?php
            $win=$row['WINNER'];
            $fb=$row1['TEAM'];
            $sm=$row2['TEAM'];
            if($win){

                $r=$row1['RUNS']-$row2['RUNS'];
                if($fb==$win){
        ?>
        <span class="team"><?php echo $team[$win-1]; ?></span> won by <?php echo $r; ?> runs
            <?php }
                if($sm==$win){
                    $w=10-$row2['WICKET'];
            ?>
        <span class="team"><?php echo $team[$win-1]; ?></span> won by <?php echo $w; ?>  wickets
            <?php } ?>

        <?php } ?>

        <?php if(!$win){?>
            <span class="draw">DRAW</span>
        <?php } ?>
        </div>

        </div><br>
    <?php } ?>

    </div>
    <div class="seas_det">
        <div class="st_sel"><div class="stsel"><div class="pt">POINTS TABLE </div><div class="orc"> ORANGE CAP </div><div class="prc"> PURPLE CAP</div></div></div>
        <div class="pts_tab">
        <?php
            $r=mysqli_query($conn,"SELECT * FROM TEAM_BIO WHERE YEAR+$yr ORDER BY WINS DESC,DRAWS DESC");
        ?>
        <table cellpadding="10">
            <tr><th>Teams</th><th>P</th><th>W</th><th>L</th><th>DR</th></tr>
         <?php while($te=mysqli_fetch_assoc($r)){?>
            <tr class="FRANCHISE" id="<?php echo $te['FID']?>"><td><?php echo $team[$te['FID']-1]?></td><td><?php echo $te['MATCHES']?></td><td><?php echo $te['WINS']?></td><td><?php echo $te['LOSES']?></td><td><?php echo $te['DRAWS']?></td></tr>
        <?php } ?>
            <tr><td></td></tr>
        </table>
        </div>

        <div class="org_cap">
            <?php
                $r=mysqli_query($conn,"SELECT * FROM PLAYER_BIO WHERE YEAR=$yr ORDER BY RUNS DESC LIMIT 10");
            ?>
        <table cellpadding="10">
            <tr><th>Batsman</th><th>Innings</th><th>Runs</th></tr>
            <?php while($bt=mysqli_fetch_assoc($r)){?>
                <tr class="player" id="<?php echo $bt['PNAME']?>"><td><?php echo $bt['PNAME']?></td><td><?php echo $bt['INNINGS_B'];?></td><td><?php echo $bt['RUNS'];?></td></tr>
            <?php } ?>
            <tr><td></td></tr>
        </table>
        </div>

        <div class="purp_cap">
            <?php
                $r=mysqli_query($conn,"SELECT * FROM PLAYER_BIO WHERE YEAR=$yr ORDER BY WICKETS DESC LIMIT 10");
            ?>
        <table cellpadding="10">
            <tr><th>Bowler</th><th>Innings</th><th>Wickets</th></tr>
            <?php while($bl=mysqli_fetch_assoc($r)){?>
                <tr class="player" id="<?php echo $bl['PNAME']?>"><td><?php echo $bl['PNAME']?></td><td><?php echo $bl['INNINGS_BO'];?></td><td><?php echo $bl['WICKETS'];?></td></tr>
            <?php } ?>
            <tr><td></td></tr>
        </table>
        </div>

    </div>

</div>




</body>
<?php $conn->close();?>

<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script src="hom.js"></script>

</html>
