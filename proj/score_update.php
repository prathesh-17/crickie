<?php
include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    $rn=$_POST['rns'];
    $ovr=$_POST['ovrs'];
    $bl=$_POST['blls'];
    $wk=$_POST['wks'];
    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $fb=$_POST['fb'];
    $sm=$_POST['sm'];
    $inn=$_POST['inn'];

    $yr=2020;
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];


    $sql="UPDATE SCORE SET RUNS=$rn,OVERS=$ovr,BALLS=$bl,WICKET=$wk WHERE INNINGS=$inn AND MATCH_ID=$mid AND YEAR=$yr";
    mysqli_query($conn,$sql);


    $sql="SELECT * FROM SCORE WHERE INNINGS=1 AND MATCH_ID=$mid AND YEAR=$yr";
    $result1=mysqli_query($conn,$sql);

    $sql="SELECT * FROM SCORE WHERE INNINGS=$inn AND MATCH_ID=$mid  AND YEAR=$yr";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);


?>

    <div class="score1">
    <?php if($inn==1){?><span class="fb"><?php echo $team[$fb-1]; ?></span><?php } ?>
    <?php if($inn==2){?><span class="sm"><?php echo $team[$sm-1]; ?></span><?php } ?>
    <span class="scre"><?php echo $row['RUNS'] ?></span><span class="scre">-</span><span class="scre"><?php echo $row['WICKET'] ?></span>
    <span class="scre1"><?php echo $row['OVERS'] ?></span><span class="scre1">.</span><span class="scre1"><?php echo $row['BALLS'] ?></span>
    <span class="tot_ovr">(3.0)</span><br></div>
    <div class="score2"><?php if($inn==1){?><span class="sm"><?php echo $team[$sm-1]; ?></span><?php } ?>
    <?php if($inn==2){
        $row1=mysqli_fetch_assoc($result1);
    ?><span class="fb"><?php echo $team[$fb-1]; ?></span> <span class="scre2"><?php echo $row1['RUNS'] ?></span><span class="scre2">-</span><span class="scre2"><?php echo $row1['WICKET'] ?></span>
    <?php } ?>
    </div>

    <?php if($inn==2){?>


    <?php $r=$row1['RUNS']-$row['RUNS']; ?>
    <?php if($row['OVERS']<3&&($r>=0) && $row['WICKET']<10){?>
        <div class="obs"><span >Need</span>
        <span class="runs_req"><?php echo $r+1?></span><span> from </span>
        <span class="balls_more"><?php $b=18-($row['OVERS']*6)-$row['BALLS'];echo $b;?></span><span> balls</span></div>
    <?php }?>


    <?php if(($row['OVERS']==3&&($r>0)) ||($row['WICKET']==10&& $r!=0)){?><div class="obs">
        <span class="tm_won"><?php echo $team[$fb-1]?></span><span> won by <?php echo $r;?> runs</span></div>
        <?php $s="UPDATE MATCHES SET WINNER=$fb,STATUS=2 WHERE TEAM1=$t1 AND TEAM2=$t2";mysqli_query($conn,$s);
            $s="UPDATE SCORE SET M_ST=2 WHERE INNINGS=2 AND MATCH_ID=$mid AND YEAR+$yr";mysqli_query($conn,$s);  ?>
    <?php }?>
    <?php if($r<0){?><div class="obs">
        <span class="tm_won"><?php echo $team[$sm-1]?></span><span> won by <?php echo 10-$row['WICKET']?> wickets</span></div>
        <?php $s="UPDATE MATCHES SET WINNER=$sm,STATUS=2 WHERE TEAM1=$t1 AND TEAM2=$t2";mysqli_query($conn,$s);
                $s="UPDATE SCORE SET M_ST=2 WHERE INNINGS=2 AND MATCH_ID=$mid  AND YEAR+$yr";mysqli_query($conn,$s);?>
    <?php }?>
    <?php if((($row['WICKET']==10)&&($r==0))||(($row['OVERS']==3)&&($r==0))){
        $s="UPDATE MATCHES SET STATUS=2 WHERE TEAM1=$t1 AND TEAM2=$t2";mysqli_query($conn,$s);
        $s="UPDATE SCORE SET M_ST=2 WHERE INNINGS=2 AND MATCH_ID=$mid";mysqli_query($conn,$s);?>
        <div class="obs"><span class="draw"> Draw</span></div>
    <?php }?>
    <?php }?>
        <?php if($inn==1){?><div class="obs">LIVE-INN1</div><?php } ?>
<?php $conn->close(); ?>
