<?php
    include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];


    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $fb=$_POST['fb'];
    $sm=$_POST['sm'];
    $yr=2020;
    $st=$_POST['st'];
    $ro=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM MATCHES WHERE TEAM1=$t1  AND  TEAM2=$t2 AND YEAR=$yr"));
    $mid=$ro['MATCH_ID'];
    $inn=1;

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $team[$t1-1]?> vs <?php echo $team[$t2-1]?></title>
    <link rel="stylesheet" type="text/css" href="style_sh/score.css">
</head>
<body>
    <div class="head"><span>CRICKIE</span></div>
    <div><div class="nav"><span class="info">INFO </span><span class="live"> LIVE </span><span class="score"> SCORE</span></div>

    <div class="s_info">
        <div class="st_sel">
                <div class="team"><?php echo $team[$fb-1]?></div>
                <div class="team"><?php echo $team[$sm-1]?></div>
        </div>
        <div class="inf">

            <table cellpadding="10">
                <tr><td>Match</td><td><?php echo $mid;?></td></tr>
                <tr><td>Toss</td><td>
                    <?php if($st==0){echo "NOT YET STARTED";}
                            else{   $r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TOSS WHERE MATCH_ID=$mid AND YEAR=$yr"));
                                    echo $team[$r['TEAM']-1];                        }?></td></tr>
                <tr><td>Choice</td><td><?php if($st==0){echo "-";}
                            else{   echo $r['CHOICE'];    }?></td></tr>

            </table>
        </div>
        <div class="squad">
            <div class="back">BACK</div><br>
            <?php
                $sql="SELECT A.PNAME PNAME,NATION FROM PLAYER_BIO A,PLAYER B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$fb AND A.PNAME NOT IN (SELECT PNAME FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr) AND YEAR=$yr";
                $sql1="SELECT A.PNAME PNAME,NATION FROM PLAYER_BIO A,PLAYER B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$sm AND A.PNAME NOT IN (SELECT PNAME FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr) AND YEAR=$yr";
                $sql2="SELECT A.PNAME PNAME,NATION FROM TEAM A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid  AND YEAR=$yr";
                $sql3="SELECT A.PNAME PNAME,NATION FROM TEAM2 A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid  AND YEAR=$yr";

                $result=mysqli_query($conn,$sql);
                $result1=mysqli_query($conn,$sql1);
                $result2=mysqli_query($conn,$sql2);
                $result3=mysqli_query($conn,$sql3);

            ?>

            <?php if($st==0){ ?>
            <div class="<?php echo $team[$fb-1];?>">
            <?php  while($row=mysqli_fetch_assoc($result)){ ?>
                    <div class="player" id="<?php echo $row['PNAME']; ?>"><span><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
                <?php } ?>
            </div>
            <div class="<?php echo $team[$sm-1]; ?>">
            <?php while($row=mysqli_fetch_assoc($result1)){ ?>
                    <div class="player" id="<?php echo $row['PNAME']; ?>"><span><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if($st!=0){
                $r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM CAPWK WHERE MATCH_ID=$mid AND YEAR=$yr"));
                $cap1=$r['CAP1'];$cap2=$r['CAP2'];$wk1=$r['WK1'];$wk2=$r['WK2'];
                // echo "$cap1 $cap2 $wk1 $wk2";
            ?>
            <div class="<?php echo $team[$fb-1];?>">
            PLAYING XI
             <?php  while($row=mysqli_fetch_assoc($result2)){ ?>
                        <div class="player" id="<?php echo $row['PNAME']; ?>"><span><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?>
                        <?php if($row['PNAME']==$cap1){echo "(C)";}if($row['PNAME']==$wk1){echo "(WK)";}?></div>
            <?php } ?>
                <br>
            BENCH
            <?php while($row=mysqli_fetch_assoc($result)){ ?>
                    <div class="player" id="<?php echo $row['PNAME']; ?>"><span><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>

            <?php }?>
            </div>

            <div class="<?php echo $team[$sm-1];?>">
            PLAYING XI
             <?php  while($row=mysqli_fetch_assoc($result3)){ ?>
                        <div class="player" id="<?php echo $row['PNAME']; ?>"><span ><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?>
                        <?php if($row['PNAME']==$cap2){echo "(C)";}if($row['PNAME']==$wk2){echo "(WK)";}?></div>
            <?php }?>
                <br>
            BENCH
            <?php while($row=mysqli_fetch_assoc($result1)){ ?>
                    <div class="player" id="<?php echo $row['PNAME']; ?>"><span ><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>

            <?php }?>
            </div>
            <?php } ?>

        </div>
    </div>

    <div class="l_inf">
        <div class="play"><span class="team1"><?php echo $team[$t1-1]; ?></span><span class="team2"><?php echo $team[$t2-1]; ?></span></div>

        <?php if($st==0){?>
            <h1>NOT YET SCHEDULED</h1>
            <h3>STAY TUNED</h3>
        <?php } ?>
        <?php if($st!=0){?>
        <div class="Score"><br>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2 AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
        ?>
        <div class="score1"><span class="team"><?php echo $team[$row1['TEAM']-1]; ?></span> <span class="scre"><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
        <span class="scre1"><?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?></span></div><br>
        <?php $ovn=$row1['OVERS']*6+$row1['BALLS'];
              $rnn=$row1['RUNS'];   ?>

        <div class="obs"><?php if($row1['M_ST']==2 && !mysqli_num_rows($inn2)){echo "Innings Break";} ?></div>

        <?php if($row2=mysqli_fetch_assoc($inn2)){$inn=2; ?>
                <div class="score2"><span class="team"><?php echo $team[$row2['TEAM']-1]; ?></span> <span class="scre"><?php echo $row2['RUNS'] ?>-<?php echo $row2['WICKET'] ?></span>
                <span class="scre1"><?php echo $row2['OVERS'] ?>.<?php echo $row2['BALLS'] ?></span></div><br>
                <?php $ovn=$row2['OVERS']*6+$row2['BALLS'];$rnn=$row2['RUNS']; ?>
                <?php if($st==1){ ?>
                    <?php $r=$row1['RUNS']-$row2['RUNS']; ?>
                    <div class="obs"><span >Need</span>
                    <span class="runs_req"><?php echo $r+1?></span><span> from </span>
                    <span class="balls_more"><?php $b=18-($row2['OVERS']*6)-$row2['BALLS'];echo $b;?></span><span> balls</span></div>
                <?php } ?>
                <?php if($st==2){?>
                    <div class="obs">
                    <?php
                        $win=$ro['WINNER'];
                        $fb=$row1['TEAM'];
                        $sm=$row2['TEAM'];
                        if($win){

                            $r=$row1['RUNS']-$row2['RUNS'];
                            if($fb==$win){
                    ?>
                    <span class="team"></span><?php echo $team[$win-1]; ?></span> won by <?php echo $r; ?> runs
                        <?php }
                            if($sm==$win){
                                $w=10-$row2['WICKET'];
                        ?>
                    <span class="team"></span><?php echo $team[$win-1]; ?></span> won by <?php echo $w; ?>  wickets
                        <?php } ?>

                    <?php } ?>

                    <?php if(!$win){?>
                        <span class="draw">draw</span>
                    <?php } ?>
                    </div>
                <?php } ?>

        <?php }?>
        </div>
        <div class="btsmn">
            <?php if($inn==1){
                $str=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr"));
                $str1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
                $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
                $inn1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM SCORE WHERE INNINGS=1 AND MATCH_ID=$mid AND YEAR=$yr"));
                $wk=$inn1['WICKET'];
                $su=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE FOW=$wk AND MATCH_ID=$mid AND YEAR=$yr"));
                $ov=$su['FOW_B'];
                $ov=(($ov*10)%10)+((($ov*10)/10)*6);
                $rn=$su['FOW_R'];

            ?>
                <?php if($str){?><div class="player" id="<?php echo $str['PNAME'];?>"><span><?php echo $str['PNAME']; ?></span><span><?php echo $str['RUNS']; ?>(<?php echo $str['BALLS']?>)</span></div><?php } ?>
                <?php if($str1){?><div class="player" id="<?php echo $str1['PNAME'];?>"><span><?php echo $str1['PNAME']; ?></span><span><?php echo $str1['RUNS']; ?>(<?php echo $str1['BALLS']?>)</span></div><?php } ?>

                <div class="obs1"><span>Partnership <?php echo $rnn-$rn?>(<?php echo $ovn-$ov?>)</span></div>
                <div class="obs"><span>Last Wicket:<?php echo $su['PNAME']?> <?php echo $su['RUNS']?>(<?php echo $su['BALLS']?>)</span></div>
            <?php } ?>
            <?php if($inn==2){
                $str=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr"));
                $str1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
                $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
                $inn2=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM SCORE WHERE INNINGS=2 AND MATCH_ID=$mid AND YEAR=$yr"));
                $wk=$inn2['WICKET'];
                $su=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE FOW=$wk AND MATCH_ID=$mid AND YEAR=$yr"));
                $ov=$su['FOW_B'];
                $ov=(($ov*10)%10)+(intdiv(($ov*10),10)*6);//
                $rn=$su['FOW_R'];

                // echo $ov;
            ?>
                <?php if($str){?><div class="player" id="<?php echo $str['PNAME'];?>"><span><?php echo $str['PNAME']; ?></span><span><?php echo $str['RUNS']; ?>(<?php echo $str['BALLS']?>)</span></div><?php } ?>
                <?php if($str1){?><div class="player" id="<?php echo $str1['PNAME'];?>"><span><?php echo $str1['PNAME']; ?></span><span><?php echo $str1['RUNS']; ?>(<?php echo $str1['BALLS']?>)</span></div><?php } ?>
                <div class="obs1"><span>Partnership <?php echo $rnn-$rn?>(<?php echo $ovn-$ov?>)</span></div>
                <div class="obs"><span>Last Wicket:<?php echo $su['PNAME']?> <?php echo $su['RUNS']?>(<?php echo $su['BALLS']?>)</span></div>
            <?php } ?>
        </div>
        <div class="bwlr">

            <?php if($blr){?>
                <div class="player" id="<?php echo $blr['PNAME'];?>"><span><?php echo $blr['PNAME']?></span>
                    <span><?php echo $blr['OVERS']?>-<?php echo $blr['MAIDEN']?>-<?php echo $blr['RUN']?>-<?php echo $blr['WICKET']?></span>
                    </div>
            <?php }?>
        </div>
        <?php } ?>

    </div>

    <div class="sc_inf">
        <?php if($st==0){?>
            <h1>NOT YET SCHEDULED</h1>
            <h3>STAY TUNED</h3>
        <?php } ?>
        <?php if($st!=0){?>
        <?php $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=1 AND YEAR=$yr";
              $inn1=mysqli_query($conn,$s);
              $s="SELECT * FROM SCORE WHERE MATCH_ID=$mid AND INNINGS=2 AND YEAR=$yr";
              $inn2=mysqli_query($conn,$s);
              $row1=mysqli_fetch_assoc($inn1);
        ?>
        <div class="inn"><span class="team"><?php echo $team[$row1['TEAM']-1]; ?></span><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?>
        (<?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?>)</div>
        <?php
            $inn1=mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR+$yr AND ORDER_OF_BAT<>0 ORDER BY ORDER_OF_BAT ASC");
        ?>
        <div class="inn_sc">
        <table cellpadding="10">
            <tr><th>Batsman</th><th>R</th><th>B</th><th>SR</th></tr>
            <?php while($r1=mysqli_fetch_assoc($inn1)){?>

            <tr class="player" id="<?php echo $r1['PNAME'];?>">
                <td><?php echo $r1['PNAME'];if($r1['PNAME']==$str['PNAME']){echo "*";} ?>
                    <div style="font-size:12px"><?php if($r1['O_ST']==1|| $r1['O_ST']==1.5){echo "Not Out ";}
                               else if($r1['FLDR']){
                                    if($r1['FLDR']==$r1['BWLR']){echo "C & B".$r1['BWLR'];}
                                    else{ if($r1['WAY_OUT']=="STUMPED"){echo "St ";}else if($r1['WAY_OUT']=="RUN OUT"){echo "Run Out ";}else{echo "C ";} echo $r1['FLDR'];
                                        if($r1['BWLR']){echo "B ".$r1['BWLR'];}
                                    }
                                }
                                else{echo "B ".$r1['BWLR'];}?></div></td>
                <td><?php echo $r1['RUNS']?></td><td><?php echo $r1['BALLS'];?></td><td><?php echo round($r1['RUNS']/$r1['BALLS']*100,2);?></td>

            </tr>
            <?php } ?>
        </table><br><br>
        <?php
            $inn1=(mysqli_query($conn,"SELECT * FROM TEAM WHERE ORDER_OF_BAT=0 AND MATCH_ID=$mid AND YEAR=$yr"));
            if($r1=mysqli_fetch_assoc($inn1)){
                echo "<div class='DNB'>";
                if($st==2||$inn==2){echo "<span>Did Not Bat : </span>";}else if($st==1){echo "<span>Yet To Bat : </span>";}
            }
            while(1){?>
                <span style="font-size:12px"><?php echo $r1['PNAME'];if($r1=mysqli_fetch_assoc($inn1)){echo ", ";}else{echo "</span></div><br><br>";break;}?></span><?php } ?>

        <?php
            $blrs=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE B_ST<>0 and MATCH_ID=$mid AND YEAR=$yr");
        ?>
        <table cellpadding="10">
            <tr><th>Bowler</th><th>O</th><th>M</th><th>R</th><th>W</th><th>ER</th></tr>
            <?php while($bl=mysqli_fetch_assoc($blrs)){?>
                <tr class="player" id="<?php echo $bl['PNAME'];?>">
                    <td><?php echo $bl['PNAME']?></td><td><?php echo $bl['OVERS'];?></td><td><?php echo $bl['MAIDEN'];?></td><td><?php echo $bl['RUN']?></td><td><?php echo $bl['WICKET']?></td>
                        <td><?php $ov=$bl['OVERS'];$ov=(($ov*10)%10)+(intdiv(($ov*10),10)*6);echo round($bl['RUN']/$ov,2)?></td></tr>
            <?php } ?>
        </table>
        <br><br>
        <?php
            $r1=mysqli_query($conn,"SELECT * FROM TEAM WHERE FOW<>0 AND MATCH_ID=$mid AND YEAR=$yr ORDER BY FOW ASC");
        ?>
        <table cellpadding="10">
            <tr>
                <th>Fall Of Wickets</th><th>Score</th><th>Over</th>
            </tr>
            <?php while($ba=mysqli_fetch_assoc($r1)){ ?>
                <tr class="player" id="<?php echo $ba['PNAME'];?>"><td><?php echo $ba['PNAME'];?></td><td><?php echo $ba['FOW_R']."-".$ba['FOW'];?></td><td><?php echo $ba['FOW_B'];?></td></tr>
            <?php } ?>
        </table>
        </div>

    <?php if($row1=mysqli_fetch_assoc($inn2)){?>
    <div class="inn1"><span class="team"><?php echo $team[$row1['TEAM']-1]; ?></span><?php echo $row1['RUNS'] ?>-<?php echo $row1['WICKET'] ?></span>
        (<?php echo $row1['OVERS'] ?>.<?php echo $row1['BALLS'] ?>)</div>
        <?php
            $inn1=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR+$yr AND ORDER_OF_BAT<>0 ORDER BY ORDER_OF_BAT ASC");
        ?>
        <div class="inn_sc1">
        <table cellpadding="10">
            <tr><th>Batsman</th><th>R</th><th>B</th><th>SR</th></tr>
            <?php while($r1=mysqli_fetch_assoc($inn1)){?>

            <tr class="player" id="<?php echo $r1['PNAME'];?>">
                <td><?php echo $r1['PNAME'];if($r1['PNAME']==$str['PNAME']){echo "*";} ?>
                    <div style="font-size:12px"><?php if($r1['O_ST']==1|| $r1['O_ST']==1.5){echo "Not Out ";}
                               else if($r1['FLDR']){
                                    if($r1['FLDR']==$r1['BWLR']){echo "C & B".$r1['BWLR'];}
                                    else{ if($r1['WAY_OUT']=="STUMPED"){echo "St ";}else if($r1['WAY_OUT']=="RUN OUT"){echo "Run Out ";}else{echo "C ";} echo $r1['FLDR'];
                                        if($r1['BWLR']){echo "B ".$r1['BWLR'];}
                                    }
                                }
                                else{echo "B ".$r1['BWLR'];}?></div></td>
                <td><?php echo $r1['RUNS']?></td><td><?php echo $r1['BALLS'];?></td><td><?php if($r1['BALLS']!=0) {echo round($r1['RUNS']/$r1['BALLS']*100,2);}?></td>

            </tr>
            <?php } ?>
        </table><br><br>
        <?php

            $inn1=(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE ORDER_OF_BAT=0 AND MATCH_ID=$mid AND YEAR=$yr"));
            if($r1=mysqli_fetch_assoc($inn1)){echo "<div class='DNB'>";if($st==2){echo "<span>Did Not Bat : </span>";}else if($st==1||$inn==2){echo "<span>Yet To Bat : </span>";}


            while(1){?>
                <span style="font-size:12px"><?php echo $r1['PNAME'];if($r1=mysqli_fetch_assoc($inn1)){echo ", ";}else{echo "</span></div><br><br>";break;}?></span><?php } ?>
            <?php } ?>
        <?php
            $blrs=mysqli_query($conn,"SELECT * FROM TEAM WHERE B_ST<>0 and MATCH_ID=$mid AND YEAR=$yr");
        ?>
        <table cellpadding="10">
            <tr><th>Bowler</th><th>O</th><th>M</th><th>R</th><th>W</th><th>ER</th></tr>
            <?php while($bl=mysqli_fetch_assoc($blrs)){?>
                <tr class="player" id="<?php echo $bl['PNAME'];?>">
                    <td><?php echo $bl['PNAME']?></td><td><?php echo $bl['OVERS'];?></td><td><?php echo $bl['MAIDEN'];?></td><td><?php echo $bl['RUN']?></td><td><?php echo $bl['WICKET']?></td>
                        <td><?php $ov=$bl['OVERS'];$ov=(($ov*10)%10)+(intdiv(($ov*10),10)*6);if($ov!=0){echo round($bl['RUN']/$ov*6,2);}?></td></tr>
            <?php } ?>
        </table>
        <br><br>
        <?php
            $r1=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE FOW<>0 AND MATCH_ID=$mid AND YEAR=$yr ORDER BY FOW ASC");
        ?>
        <table cellpadding="10">
            <tr>
                <th>Fall Of Wickets</th><th>Score</th><th>Over</th>
            </tr>
            <?php while($ba=mysqli_fetch_assoc($r1)){ ?>
                <tr class="player" id="<?php echo $ba['PNAME'];?>"><td><?php echo $ba['PNAME'];?></td><td><?php echo $ba['FOW_R']."-".$ba['FOW'];?></td><td><?php echo $ba['FOW_B'];?></td></tr>
            <?php } ?>
        </table>
        </div>
    <?php } ?>
    <?php } ?>
    </div>
<?php $conn->close(); ?>
</body>
<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script src="scor.js"></script>
</html>
