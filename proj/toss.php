<?php
    include("config/db_conn.php");

  if(isset($_POST['t1'])){
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];
    $fb=$_POST['fb'];
    $sm=$_POST['sm'];
    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $i1=$_POST['i1'];
    $j=$_POST['j'];
    $yr=2020;
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];


 if($j==0 && $re=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TOSS WHERE MATCH_ID=$mid AND YEAR=$yr"))){
    if($re['CHOICE']=='BAT'){
        $fb=$re['TEAM'];
        if($t1==$fb){$sm=$t2;}else{$sm=$t1;}

    }
    else{
        $sm=$re['TEAM'];
        if($t1==$sm){$fb=$t2;}else{$fb=$t1;}
    }
  if(mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM CAPWK WHERE MATCH_ID=$mid AND YEAR=$yr"))){
    $j=7;
  }
  else{
    $j=1;
  }
 }
     // echo $t1." ".$t2." ".$j." ".$fb." ".$sm;

  if($j==1){
    if(isset($_POST['name'])){
        $nme=$_POST['name'];
    }
    if($i1==1){
        $sql="INSERT INTO TEAM(MATCH_ID,TEAM,PNAME,YEAR) VALUES($mid,$fb,'$nme',$yr)";
        mysqli_query($conn,$sql);
    }
    else if($i1==2){
        $sql="DELETE FROM TEAM WHERE PNAME='$nme' AND MATCH_ID=$mid AND YEAR=$yr";
        mysqli_query($conn,$sql);
    }
    else if($i1==3){
        $sq="INSERT INTO TEAM2(MATCH_ID,TEAM,PNAME,YEAR) VALUES($mid,$sm,'$nme',$yr)";
        mysqli_query($conn,$sq);
    }
    else if($i1==4){
        $sql="DELETE FROM TEAM2 WHERE PNAME='$nme' AND MATCH_ID=$mid AND YEAR=$yr";
        mysqli_query($conn,$sql);
    }
    // else if($i1==0){
    //     if($j==1){
    //         $sq="UPDATE MATCHES SET STATUS=1 WHERE TEAM1=$t1 AND TEAM2=$t2";
    //         mysqli_query($conn,$sq);
    //     }
    //     // $sql="DELETE FROM TEAM";
    //     // mysqli_query($conn,$sql);
    //     // $sql="DELETE FROM TEAM2";
    //     // mysqli_query($conn,$sql);
    // }
    $sql="SELECT A.PNAME PNAME,NATION FROM PLAYER_BIO A,PLAYER B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$fb AND A.PNAME NOT IN (SELECT PNAME FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr) AND YEAR=$yr";
    $sql1="SELECT A.PNAME PNAME,NATION FROM PLAYER_BIO A,PLAYER B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$sm AND A.PNAME NOT IN (SELECT PNAME FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr) AND YEAR=$yr";
    $sql2="SELECT A.PNAME PNAME,NATION FROM TEAM A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid  AND YEAR=$yr";
    $sql3="SELECT A.PNAME PNAME,NATION FROM TEAM2 A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid  AND YEAR=$yr";

    $result=mysqli_query($conn,$sql);
    $result1=mysqli_query($conn,$sql1);
    $result2=mysqli_query($conn,$sql2);
    $result3=mysqli_query($conn,$sql3);
}

if($j==3){
    $cap1=$_POST['cap1'];
    $cap2=$_POST['cap2'];
    $wk1=$_POST['wk1'];
    $wk2=$_POST['wk2'];

    $s="INSERT INTO CAPWK(MATCH_ID,YEAR) VALUES($mid,$yr)";mysqli_query($conn,$s);
    $s="UPDATE CAPWK SET CAP1='$cap1' WHERE MATCH_ID=$mid AND YEAR=$yr";mysqli_query($conn,$s);
    $s="UPDATE CAPWK SET CAP2='$cap2' WHERE MATCH_ID=$mid AND YEAR=$yr";mysqli_query($conn,$s);
    $s="UPDATE CAPWK SET WK1='$wk1' WHERE MATCH_ID=$mid AND YEAR=$yr";mysqli_query($conn,$s);
    $s="UPDATE CAPWK SET WK2='$wk2' WHERE MATCH_ID=$mid AND YEAR=$yr";mysqli_query($conn,$s);
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>TOSS</title>
    <link rel="stylesheet" type="text/css" href="style_sh/toss.css">
</head>
<body>
 <div class="head"><span class="name"><span class="team1"><?php echo $team[$t1-1]?></span> vs <span class="team2"><?php echo $team[$t2-1]?></span></span><span class="app">CRICKIE</span></div>

 <?php if($j==0){ ?>
    <div class="toss_choice">
        <div class="year">
            <div class="lst_y"><?php echo $team[$t1-1]?></div>
            <div class="ch">TOSS</div>
            <div class="choices">
                <div class="yr" id="<?php echo $team[$t1-1]?>"><?php echo $team[$t1-1]?></div>
                <div class="yr" id="<?php echo $team[$t2-1]?>"><?php echo $team[$t2-1]?></div>
            </div>
        </div>
        <div class="year1">
            <div class="lst_y">BAT</div>
            <div class="ch">CHOICE</div>
            <div class="choices">
                <div class="yr" id="BAT">BAT</div>
                <div class="yr" id="BOWL">BOWL</div>
            </div>
        </div>
        <button class="fb1">SUBMIT</button>
    </div>
<?php } ?>

<?php if($j==1){ ?>
    <div class="team_sel">
    <div class="team1">
    <span class="te1"><?php echo $team[$fb-1];?></span><br>
    <?php while($row=mysqli_fetch_assoc($result)){ ?>
        <div class="player"><span class="t1"><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
    <?php }?>
<br>
    PLAYING XI
    <div class="sel"><?php while($row=mysqli_fetch_assoc($result2)){ ?>
        <div class="player"><span class="t1s"><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
    <?php }?></div>
    </div>
<br>
    <div class="team2">
    <span class="te2"><?php echo $team[$sm-1];?></span><br>
    <?php while($row=mysqli_fetch_assoc($result1)){ ?>
        <div class="player"><span class="t2"><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
    <?php } ?>
<br>
    PLAYING XI
    <div class="sel"><?php while($row=mysqli_fetch_assoc($result3)){?>
        <div class="player"><span class="t2s"><?php echo $row['PNAME'];?></span><?php if($row['NATION']!="IND"){?><span class="foreign">*</span><?php }?></div>
    <?php } ?></div>
</div>
<br>
    </div>
    <button class="btn" style="display:none">C<br>O<br>N<br>F<br>I<br>R<br>M</button>
<?php } ?>

<?php if($j==2){ ?>
    <div class="team_sel">
    <div class="team3">
    <div class="te1"><?php echo $team[$fb-1]; ?></div>

        <div class="year">
            <div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="ch">CAPTAIN</div>
            <?php $s="SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>
            <div class="choices">
                <?php while($row=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $row['PNAME']?>"><?php echo $row['PNAME']?></div>
                <?php } ?>
            </div>
        </div>

        <?php
            $s="SELECT A.PNAME PNAME,ROLE FROM TEAM A,PLAYER B WHERE A.PNAME=B.PNAME ANd ROLE='WK' AND MATCH_ID=$mid AND YEAR=$yr";
            $res=mysqli_query($conn,$s);
            // echo mysqli_num_rows($res);
            if(mysqli_num_rows($res)==0){
                // echo "running";
                $s="SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr";
                $res=mysqli_query($conn,$s);
            }
        ?>
        <div class="year1">
            <div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT A.PNAME PNAME,ROLE FROM TEAM A,PLAYER B WHERE A.PNAME=B.PNAME ANd ROLE='WK' AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="ch">KEEPER</div>
            <div class="choices">
                <?php while($row=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $row['PNAME']?>"><?php echo $row['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
    </div><br>
    <div class="team4">
    <div class="te2"><?php echo $team[$sm-1]; ?></div>
        <div class="year2">
            <div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="ch">CAPTAIN</div>
            <?php $s="SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>
            <div class="choices">
                <?php while($row=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $row['PNAME']?>"><?php echo $row['PNAME']?></div>
                <?php } ?>
            </div>
        </div>
        <?php
            $s="SELECT A.PNAME PNAME,ROLE FROM TEAM2 A,PLAYER B WHERE A.PNAME=B.PNAME AND ROLE='WK' AND MATCH_ID=$mid AND YEAR=$yr";
            $res=mysqli_query($conn,$s);
            if(mysqli_num_rows($res)==0){
                $s="SELECT * FROM TEAM2 WHERE MATCH_ID=$mid AND YEAR=$yr";
                $res=mysqli_query($conn,$s);
            }
        ?>
        <div class="year3">
            <div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT A.PNAME PNAME,ROLE FROM TEAM2 A,PLAYER B WHERE A.PNAME=B.PNAME ANd ROLE='WK' AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="ch">KEEPER</div>
            <div class="choices">
                <?php while($row=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $row['PNAME']?>"><?php echo $row['PNAME']?></div>
                <?php } ?>
            </div>
        </div>

    </div>

    </div>
    <button class="btn1">S<br>U<br>B<br>M<br>I<br>T</button>
<?php } ?>

<?php if($j==7){$j=3;}?>
<?php if($j==3){ ?>
<div class="team_sel">
<?php     $sql2="SELECT A.PNAME PNAME,NATION FROM TEAM A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid AND YEAR=$yr";
          $sql3="SELECT A.PNAME PNAME,NATION FROM TEAM2 A,PLAYER B WHERE A.PNAME=B.PNAME AND MATCH_ID=$mid AND YEAR=$yr";
          $res=mysqli_query($conn,$sql2);
          $res1=mysqli_query($conn,$sql3);
          if(!($res||$res1)){echo "error";}
          $r=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM CAPWK WHERE MATCH_ID=$mid AND YEAR=$yr"));
          $cap1=$r['CAP1'];$cap2=$r['CAP2'];$wk1=$r['WK1'];$wk2=$r['WK2'];
          ?>
<div class="team1"><div class="te1"><?php echo $team[$fb-1]; ?></div>
<?php while($row=mysqli_fetch_assoc($res)){ ?>
        <div class="player"><span><?php echo $row['PNAME']; if($row['NATION']!="IND"){echo "*";}if($row['PNAME']==$cap1){echo "(C)";}if($row['PNAME']==$wk1){echo "(WK)";}?></span></div>
<?php } ?></div>
<div class="team2">
<div class="te2"><?php echo $team[$sm-1]; ?></div>
<?php while($row=mysqli_fetch_assoc($res1)){ ?>
        <div class="player"><span><?php echo $row['PNAME']; if($row['NATION']!="IND"){echo "*";}if($row['PNAME']==$cap2){echo "(C)";}if($row['PNAME']==$wk2){echo "(WK)";}?></span></div>
<?php } ?></div>

</div>
<button class="btn2">CONFIRM</button>
<?php } ?>

    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery.redirect.js"></script>
    <script src="tosss_.js"></script>

<?php $conn->close();?>
<?php } ?>



<?php if(!isset($_POST['t1'])){ ?>
<span>YOU ARE NOT AUTHORISED</span>
<?php } ?>

</body>
</html>
