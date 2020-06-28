<?php
    include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    $yr=2020;
    $fb=$_POST['fb'];
    $sm=$_POST['sm'];
    $inn=$_POST['inn'];
    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $ins=$_POST['ins'];
    // echo $t1." ".$t2." ".$inn." ".$fb." ".$sm;

    $st=0;$nst=0;$bl=0;

    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];

    if($ins==1){
        $sel=0;
        if($inn==1){
            if($r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM SCORE WHERE INNINGS=1 AND MATCH_ID=$mid AND YEAR=$yr"))){
                if($r['M_ST']==1){
                    $sel=1;
                }
                if($r['M_ST']==2){
                    $inn=2;
                    if($r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM SCORE WHERE INNINGS=2 AND MATCH_ID=$mid AND YEAR=$yr"))){
                            if($r['M_ST']==1){
                                $sel=1;
                            }
                    }
                }
            }
        }

        if($inn==1){
            if($sel==0){
                mysqli_query($conn,"UPDATE MATCHES SET STATUS=1 WHERE MATCH_ID=$mid AND YEAR=$yr");
                // mysqli_query($conn,"INSERT INTO MDN VALUES($mid,0)");
                mysqli_query($conn,"INSERT INTO SCORE(MATCH_ID,INNINGS,TEAM,YEAR) VALUES($mid,$inn,$fb,$yr)");
                mysqli_query($conn,"INSERT INTO MDN(MATCH_ID) VALUES ($mid)");

            }

            mysqli_query($conn,"UPDATE SCORE SET M_ST=1.0 WHERE MATCH_ID=$mid AND YEAR=$yr AND INNINGS=1");
        }

        else if($inn==2){
          if($sel==0){
            // mysqli_query($conn,"UPDATE MDN SET MAIDEN=0 WHERE MATCH_ID=$mid");
            mysqli_query($conn,"UPDATE SCORE SET M_ST=2 WHERE INNINGS=1 AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"INSERT INTO SCORE(MATCH_ID,INNINGS,TEAM,YEAR) VALUES($mid,$inn,$sm,$yr)");

          }

        mysqli_query($conn,"UPDATE SCORE SET M_ST=1.0 WHERE MATCH_ID=$mid AND YEAR=$yr AND INNINGS=2");

        }

    }



    $sql="SELECT * FROM SCORE WHERE INNINGS=1 AND MATCH_ID=$mid  AND YEAR=$yr";
    $result1=mysqli_query($conn,$sql);

    $sql="SELECT * FROM SCORE WHERE INNINGS=$inn AND MATCH_ID=$mid  AND YEAR=$yr";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);


?>

<!DOCTYPE html>
<html>
<head>
    <title>scorecard</title>
    <link rel="stylesheet" href="style_sh/scorecard_adm.css" type="text/css">
</head>
<body>

<div class="head"><span class="mtch"><span class="tm"><?php echo $team[$t1-1];?></span><span>vs</span><span class="tm"><?php echo $team[$t2-1];?></span></span>
    <span class="app">CRICKIE</span></div>

<div class="abc"><div class="catcher">
    <div class="fc">
            <div class="ch">
                <?php if($inn==1){echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];}?>
                <?php if($inn==2){echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];}?>
            </div>

            <div class="choices">
                <?php if($inn==1){$s="SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);while($r1=mysqli_fetch_assoc($res)){?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } } ?>
                <?php if($inn==2){$s="SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);while($r1=mysqli_fetch_assoc($res)){?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } } ?>
            </div>
        </div>
    <input type="button" value="SUBMIT">
</div>

<div class="runout">
    <span class="fc">
        <span class="fs">
            <div class="ch">
                <?php if($inn==1){echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];}?>
                <?php if($inn==2){echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];}?>
            </div>

            <div class="choices">
                <?php if($inn==1){$s="SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);while($r1=mysqli_fetch_assoc($res)){?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } } ?>
                <?php if($inn==2){$s="SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);while($r1=mysqli_fetch_assoc($res)){?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } } ?>
            </div>
        </span>
        <span class="fr">
            <div class="ch">0</div>
            <div class="choices">
                <div class="yr" id="0">0</div>
                <div class="yr" id="1">1</div>
                <div class="yr" id="2">2</div>
                <div class="yr" id="3">3</div>
                <!-- <div class="yr" id="0">4</div> -->
            </div>
        </span>
    </span>
    <span class="fk"></span><input type="button" value="SUBMIT">
</div>

<div class="bts2">
    <span class="sss">
        <?php if($ins==1){?>

        <?php if($inn==1){$s="SELECT * FROM TEAM WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>

        <div class="bt">
            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>

            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>


        <?php if($inn==2){$s="SELECT * FROM TEAM2 WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>

        <div class="bt">
            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

    <?php }?>
        <button class="bts_sel2">Striker</button>
    </span>
    <button class="bts_sel1">Non Striker</button>
</div>

<div class="bwls">
    <span class="ss">


        <?php if($inn==1){$s="SELECT * FROM TEAM2 WHERE B_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>

        <div class="blll">
            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE B_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>

            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>


        <?php if($inn==2){$s="SELECT * FROM TEAM WHERE B_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>

        <div class="blll">
            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE B_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

    </span>
        <button class="bwl_sel">BOWLER</button>
</div>

<div class="nxtbt">
    <div class="nxt">
    </div>

    <input type="button" value="submit">

</div>
</div>

<div class="nxtbl">
    <div class="nxxt">

    </div>

    <input type="button" value="submit">

</div>



<div class="l">
<div class="l_inf">
  <div class="score">
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
    <?php if($inn==1){?><div class="obs">LIVE-INN1</div><?php } ?>
    <?php if($inn==2){?>

    <?php $r=$row1['RUNS']-$row['RUNS']; ?>
    <?php if($row['OVERS']<3&&($r>=0) && $row['WICKET']<10){?>
        <div class="obs"><span >Need </span>
        <span class="runs_req"> <?php echo $r+1?> </span><span> from </span>
        <span class="balls_more"> <?php $b=18-($row['OVERS']*6)-$row['BALLS'];echo $b;?> </span><span> balls</span></div>
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

  </div>


    <?php
       if($inn==1){
            $s="SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid";
            $r=mysqli_query($conn,$s);
            $s="SELECT * FROM TEAM WHERE O_ST=1 AND MATCH_ID=$mid";
            $r1=mysqli_query($conn,$s);

        }
        if($inn==2){
            $s="SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid";
            $r=mysqli_query($conn,$s);
            $s="SELECT * FROM TEAM2 WHERE O_ST=1 AND MATCH_ID=$mid";
            $r1=mysqli_query($conn,$s);
        }

        $str=mysqli_fetch_assoc($r);
        $str1=mysqli_fetch_assoc($r1);

    ?>
    <div class="bts">
        <?php if($str){?>

            <div class="striker" ><span><?php echo $str['PNAME']?></span>
                <span ><?php echo $str['RUNS']?></span><span >(<?php echo $str['BALLS']?>)</span></div><br>
        <?php } ?>
        <?php if($str1){?>
            <div class="nonstriker" ><span><?php echo $str1['PNAME']?></span>
                <span ><?php echo $str1['RUNS']?></span><span >(<?php echo $str1['BALLS']?>)</span></div><br>
        <?php }?>
    </div>


    <?php
        if($inn==1){
            $s="SELECT * FROM TEAM2 WHERE B_ST=1 AND MATCH_ID=$mid";
        }
        if($inn==2){
            $s="SELECT * FROM TEAM WHERE B_ST=1 AND MATCH_ID=$mid";
        }
        $r=mysqli_query($conn,$s);
        $blr=mysqli_fetch_assoc($r);
    ?>
    <div class="bwlr">
        <?php if($blr){?>
            <div class="bowle"><span class="bowler"><?php echo $blr['PNAME']?></span>
            <span class="bl_stat"><?php echo $blr['OVERS']?>-<?php echo $blr['MAIDEN']?>-<?php echo $blr['RUN']?>-<?php echo $blr['WICKET']?></span></div>
        <?php }?>
    </div>

</div>

<div  class="comp">
  <div class="comp1">
    <div class="runs">0</div>
    <div class="runs">1</div>
    <div class="runs">2</div>
    <div class="runs">3</div>
    <div class="runs">4</div>
    <div class="runs">6</div>

    <div class="lss"><span class="extraw">WD</span><span style="display:none" class="ext">
            <span class="run">0</span>
            <span class="run">1</span>
            <span class="run">2</span>
            <span class="run">3</span>
            <span class="run">4</span>
            <span class="wkt2">W</span>
    </span></div>

    <div class="lss"><span class="extras">B</span><span class="ext" style="display:none">
            <span class="run2">1</span>
            <span class="run2">2</span>
            <span class="run2">3</span>
            <span class="run2">4</span>
            <span class="wkt3">W</span>
        </span></div>

    <div class="lss"><span class="extras">LB</span><span class="ext" style="display:none">
            <span class="run3">1</span>
            <span class="run3">2</span>
            <span class="run3">3</span>
            <span class="run3">4</span>
            <span class="wkt3">W</span>
        </span></div>

    <div class="lss"><span class="extran">NB</span><span class="ext" style="display:none">
            <span class="run4">0</span>
            <span class="run4">1</span>
            <span class="run4">2</span>
            <span class="run4">3</span>
            <span class="run4">4</span>
            <span class="run4">6</span>
            <span class="extrs">LB</span>
            <span class="extrs">B</span>
            <span class="wkt">W</span>
        </span>
            <span class="ext1" style="display:none">
                <span class="run1">1</span>
                <span class="run1">2</span>
                <span class="run1">3</span>
                <span class="run1">4</span>
                <span class="wkt3">W</span>
            </span></div>



    <div class="lss"><span class="wicket">W</span>
            <span class="wi1" style="display:none">
                <span class="wkt1">St</span>
                <span class="wkt1">Bo</span>
                <span class="wkt1">LBW</span>
                <span class="catch">C</span>
                <span class="ro">RO</span>
            </span></div>
  </div>
</div>

<div class="complete" style="display:none"><a href="matches.php"> GO TO HOME </a></div>

<!-- <button class="swap">swap</button> -->
</div class="l">
<?php $conn->close();?>
<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script src="score_computation.js"></script>
<script src="bats_bowl_sel.js"></script>

<script type="text/javascript">
    console.log(<?php echo $inn?>);
</script>
</body>
</html>
