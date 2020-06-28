<?php
    include('config/db_conn.php');
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $inn=$_POST['inn'];
    $j=$_POST['j'];
    $run=$_POST['runs'];
    $ball=$_POST['balls'];
    $j=$_POST['j'];
    $fldr=$_POST['fldr'];
    $strk=$_POST['strk'];
    $out=$_POST['out'];
    $nxtb=$_POST['nxtb'];
    $wo=$_POST['wo'];
    $oob=$_POST['oob'];
    $yr=2020;
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];
    $k=$_POST['k'];

    $rn=$_POST['rn'];
    $ov=$_POST['ov'];

  if($j==2){
    if($inn==1){
        $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT PNAME FROM TEAM2 WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];
    }
    else{
        $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT PNAME FROM TEAM WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME'];
    }
  }

    if($inn==1){
        $r=mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
        $r1=mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
    }
    if($inn==2){
        $r=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
        $r1=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
    }
    $str=mysqli_fetch_assoc($r);
    $str1=mysqli_fetch_assoc($r1);

    if($inn==1){
        if($j==0){
            mysqli_query($conn,"UPDATE TEAM SET RUNS=$run,BALLS=$ball WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");

        }
        if($k==1){
            mysqli_query($conn,"UPDATE TEAM SET O_ST=1.1 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM SET O_ST=1.5 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM SET O_ST=1.0 WHERE O_ST=1.1 AND MATCH_ID=$mid AND YEAR=$yr");
        }
        if($j==2){
            // echo "$out $strk $nxtb";
            if($out){
                mysqli_query($conn,"UPDATE TEAM SET WAY_OUT='RUN OUT' WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                mysqli_query($conn,"UPDATE TEAM SET FLDR='$fldr' WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");

                if($out==$strk){
                    mysqli_query($conn,"UPDATE TEAM SET O_ST=1 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                    mysqli_query($conn,"UPDATE TEAM SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                    mysqli_query($conn,"UPDATE TEAM SET O_ST=1.5 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
                }
                else if($out!=$strk){
                    mysqli_query($conn,"UPDATE TEAM SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                    if($strk==$str1['PNAME']){
                           mysqli_query($conn,"UPDATE TEAM SET O_ST=1.5 WHERE PNAME='$strk' AND MATCH_ID=$mid AND YEAR=$yr");
                    }
                    mysqli_query($conn,"UPDATE TEAM SET O_ST=1 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
                }
            }
            else{
                mysqli_query($conn,"UPDATE TEAM SET WAY_OUT='$wo' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                $s="UPDATE TEAM SET FLDR='$fldr' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr";
                if($wo=="STUMPED"){
                    $s="UPDATE TEAM SET FLDR=(SELECT WK1 FROM CAPWK WHERE MATCH_ID=$mid AND YEAR=$yr) WHERE O_ST=1.5";
                }
                mysqli_query($conn,$s);

                mysqli_query($conn,"UPDATE TEAM SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov,BWLR='$blr' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                mysqli_query($conn,"UPDATE TEAM SET O_ST=1.5 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
            }

            mysqli_query($conn,"UPDATE TEAM SET ORDER_OF_BAT=$oob WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
        }
    }
    if($inn==2){
        if($j==0){
            mysqli_query($conn,"UPDATE TEAM2 SET RUNS=$run,BALLS=$ball WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
        }
        if($k==1){
            mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.1 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.5 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.0 WHERE O_ST=1.1 AND MATCH_ID=$mid AND YEAR=$yr");
        }

        if($j==2){
            // echo "$out $strk $nxtb";
            if($out){
                mysqli_query($conn,"UPDATE TEAM2 SET WAY_OUT='RUN OUT' WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                mysqli_query($conn,"UPDATE TEAM2 SET FLDR='$fldr' WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");

                if($out==$strk){
                    mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                    mysqli_query($conn,"UPDATE TEAM2 SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                    mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.5 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
                }
                else if($out!=$strk){
                    mysqli_query($conn,"UPDATE TEAM2 SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov WHERE PNAME='$out' AND MATCH_ID=$mid AND YEAR=$yr");
                    if($strk==$str1['PNAME']){
                           mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.5 WHERE PNAME='$strk' AND MATCH_ID=$mid AND YEAR=$yr");
                    }
                    mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
                }
            }
            else{
                mysqli_query($conn,"UPDATE TEAM2 SET WAY_OUT='$wo' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                $s="UPDATE TEAM2 SET FLDR='$fldr' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr";
                if($wo=="STUMPED"){
                    $s="UPDATE TEAM2 SET FLDR=(SELECT WK1 FROM CAPWK WHERE MATCH_ID=$mid AND YEAR=$yr) WHERE O_ST=1.5";
                }
                mysqli_query($conn,$s);

                mysqli_query($conn,"UPDATE TEAM2 SET O_ST=2,FOW=($oob-2),FOW_R=$rn,FOW_B=$ov,BWLR='$blr' WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
                mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.5 WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
            }

            mysqli_query($conn,"UPDATE TEAM2 SET ORDER_OF_BAT=$oob WHERE PNAME='$nxtb' AND MATCH_ID=$mid AND YEAR=$yr");
        }
    }
    if($inn==1){
        $r=mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
        $r1=mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
    }
    if($inn==2){
        $r=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr");
        $r1=mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr");
    }
    $str=mysqli_fetch_assoc($r);
    $str1=mysqli_fetch_assoc($r1);

    $fb=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr"))['TEAM'];
    $sm=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE MATCH_ID=$mid AND YEAR=$yr"))['TEAM'];

    $fb=$team[$fb-1];
    $sm=$team[$sm-1];
?>

        <?php if($str){?>
            <div class="striker" ><span><?php echo $str['PNAME']?></span>
                <span ><?php echo $str['RUNS']?></span><span >(<?php echo $str['BALLS']?>)</span></div><br>
        <?php } ?>
        <?php if($str1){?>
            <div class="nonstriker" ><span><?php echo $str1['PNAME']?></span>
                <span ><?php echo $str1['RUNS']?></span><span >(<?php echo $str1['BALLS']?>)</span></div><br>
        <?php }?>

<?php $conn->close();?>

<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script type="text/javascript">

  function func1(x){
      if(x=="CSK"){return "rgb(255,215,0)";}
      if(x=="DC"){return "rgb(0,191,255)";}
      if(x=="KXIP"){return "rgb(220,20,0)";}
      if(x=="KKR"){return "rgb(38,0,77)";}
      if(x=="MI"){return "rgb(0,0,139)";}
      if(x=="RCB"){return "rgb(220,20,60)";}
      if(x=="RR"){return "rgb(180,0,180)";}
      if(x=="SRH"){return "rgb(200,102,0)"}
  }


if(<?php echo $inn?>==1){
  var col=func1("$fb");
  console.log(col);
  $(".striker").css({background:col});
  $(".nonstriker").css({background:col});
}
else{
  var col=func1("$sm");
  console.log(col);
  $(".striker").css({background:col});
  $(".nonstriker").css({background:col});

}
</script>
