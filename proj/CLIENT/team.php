<?php
    include("config/db_conn.php");
    $t=$_GET['t'];
    $up=mysqli_query($conn,"SELECT * FROM MATCHES WHERE (TEAM1=$t OR TEAM2=$t) AND STATUS=0  ORDER BY YEAR DESC,MATCH_ID ASC");
    $rec=mysqli_query($conn,"SELECT * FROM MATCHES WHERE (TEAM1=$t OR TEAM2=$t) AND STATUS<>0 ORDER BY YEAR DESC,STATUS ASC,MATCH_ID ASC");

    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $team[$t-1]; ?></title>
    <link rel="stylesheet" type="text/css" href="style_sh/team.css">
</head>
<body>
    <div class="head"><span class="name"><?php echo $team[$t-1]; ?></span><span class="app">CRICKIE</span></div>
    <div class="nav"><span class="sch">SCHEDULE</span> <span class="res">RESULT</span> <span class="plyrs">PLAYERS</span> <span class="st">STATS</span></div>
    <div class="schedule">
    <?php while($row=mysqli_fetch_assoc($up)){?>
        <div class="topp">IPL,<?php echo $row['YEAR'];?></div>
        <div class="upcoming_match">
                <div class="top"> 3 OVER MATCH </div>
                <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>

        </div><br>
    <?php } ?>
    </div>

    <div class="result">
    <?php while($row=mysqli_fetch_assoc($rec)){?>
                <div class="topp">IPL,<?php echo $row['YEAR'];$yr=$row['YEAR'];$mid=$row['MATCH_ID']?></div>


      <?php if($row['STATUS']==1){?>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2 AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
        ?>
        <div class="live_mtch">
            <div class="top"> 3 OVER MATCH </div>
            <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>
            <div class="score1"><span class="team1"><?php echo $team[$row1['TEAM']-1]; ?></span> <span class="scre"><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
            <span class="scre1"><?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?></span></div>

        <div class="obs"><?php if($row1['M_ST']==2 && !mysqli_num_rows($inn2)){echo "Innings Break";} ?></div>
        <?php if($row2=mysqli_fetch_assoc($inn2)){ ?>
                    <div class="score2"><span class="team2"><?php echo $team[$row2['TEAM']-1]; ?></span> <span class="scre"><?php echo $row2['RUNS'] ?>-<?php echo $row2['WICKET'] ?></span>
                    <span class="scre1"><?php echo $row2['OVERS'] ?>.<?php echo $row2['BALLS'] ?></span></div>
                    <?php $r=$row1['RUNS']-$row2['RUNS']; ?>
                    <div class="obs"><span >Need</span>
                    <span class="runs_req"><?php echo $r+1?></span><span> from </span>
                    <span class="balls_more"><?php $b=18-($row2['OVERS']*6)-$row2['BALLS'];echo $b;?></span><span> balls</span></div>
        <?php }?>
        </div>
      <?php } ?>

      <?php if($row['STATUS']==2){?>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2  AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
              $row2=mysqli_fetch_assoc($inn2);
        ?>
        <div class="comp_mtch">
            <div class="top"> 3 OVER MATCH </div>
            <div class="play"><?php echo $team[$row['TEAM1']-1]; ?> vs <?php echo $team[$row['TEAM2']-1]; ?></div>
            <div class="score1"><span><?php echo $team[$row1['TEAM']-1]; ?></span> <span class="scre"><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
            <span class="scre1"><?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?></span></div>
            <div class="score2"><span><?php echo $team[$row2['TEAM']-1]; ?></span> <span class="scre"><?php echo $row2['RUNS'] ?>-<?php echo $row2['WICKET'] ?></span>
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
      <?php } ?>
    <?php } ?>
    </div>
    </div>
    </div>

    <div class="players">
        <div class="full"><div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT YEAR FROM TEAM_BIO WHERE FID=$t ORDER BY YEAR DESC"))['YEAR'];?></div></div>
        <div class="year">
            <div class="ch">CHANGE</div>
            <div class="choices"><?php $ro=mysqli_query($conn,"SELECT YEAR FROM TEAM_BIO WHERE FID=$t");
                while($s=mysqli_fetch_assoc($ro)){
            ?>
                <div class="yr" id="<?php echo $s['YEAR']?>"><?php echo $s['YEAR']?></div>
            <?php  } ?></div>
        </div>
        <div class="playerss">

        </div>
    </div>

    <div class="stats">

        <div class="bt1">BATTING</div>
        <div class="batting">
            <div class="stsel">
                <div class="bt" id="RUNS"> MOST RUNS</div>
                <div class="bt" id="AVERAGE"> BEST AVERAGE</div>
                <div class="bt" id="STRIKE_RATE"> STRIKE RATE</div>
                <div class="bt" id="THIRTIES"> MOST THIRTIES</div>
                <div class="bt" id="FIFTIES"> MOST FIFTIES</div>
                <div class="bt" id="HUNDREDS"> MOST HUNDREDS</div>
            </div>
        </div>
        <div class="bowling">
            <div class="stsel">
                <div class="bl" id="WICKETS"> MOST WICKETS</div>
                <div class="bl" id="ECONOMY"> BEST ECONOMY</div>
                <div class="bl" id="THREE_HAUL"> MOST 3 WKTS </div>
                <div class="bl" id="FIVE_HAUL"> MOST 5 WKTS</div>
            </div>
        </div>
        <div class="bt2">BOWLING</div>
        <div class="stat">
        </div>
    </div>
</body>
<?php $conn->close(); ?>
<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script src="teamss.js"></script>
</html>
