<?php

    include("config/db_conn.php");

    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $inn=$_POST['inn'];
    $blr=$_POST['blr'];
    $tot=$_POST['tot'];
    if(isset($_POST['k'])){
        $k=$_POST['k'];
        $q=9;
    }
    if(isset($_POST['q'])){
        $q=$_POST['q'];
        $k=3;
    }

    $ovr=$_POST['ovr'];
    $mdn=$_POST['mdn'];
    $rn=$_POST['rn'];
    $wk=$_POST['wk'];

    $mx=ceil($tot/5);
    $no=fmod($tot,5);

    $yr=2020;
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];

    if($inn==2){
        if($k==2){
            $s="UPDATE TEAM SET OVERS=$ovr,MAIDEN=$mdn,RUN=$rn,WICKET=$wk WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            if(!mysqli_query($conn,$s)){echo "error";}
        }
        if($q==0){
            $s="SELECT OVERS FROM TEAM WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            $r=mysqli_query($conn,$s);
            $row=mysqli_fetch_assoc($r);
            if($row['OVERS']==$mx){
                    $s="UPDATE TEAM SET B_ST=2 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
                    mysqli_query($conn,$s);
            }
            if($no!=0){
                $s="SELECT COUNT(PNAME) CNT FROM TEAM WHERE B_ST=2 AND MATCH_ID=$mid AND YEAR=$yr";
                $r=mysqli_query($conn,$s);
                $row=mysqli_fetch_assoc($r);
                if($row['CNT']==$no){
                    $s="UPDATE TEAM SET B_ST=1.5 WHERE OVERS=$mx-1 AND MATCH_ID=$mid AND YEAR=$yr";
                }
            }
        }

        if($k==1){

            $s="UPDATE TEAM SET B_ST=0 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s);
            $s1="UPDATE TEAM SET B_ST=1 WHERE PNAME='$blr' AND MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s1);
            $s1="SELECT * FROM TEAM WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            $r1=mysqli_query($conn,$s1);
            $blr=mysqli_fetch_assoc($r1);

            $sk=$blr['RUN'];
            $s="UPDATE MDN SET MAIDEN=$sk WHERE MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s);
        }

        $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
    }
    else if($inn==1){
        if($k==2){
            $s="UPDATE TEAM2 SET OVERS=$ovr,MAIDEN=$mdn,RUN=$rn,WICKET=$wk WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s);
        }
        else if($q==0){
            $s="SELECT OVERS FROM TEAM2 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            $r=mysqli_query($conn,$s);
            $row=mysqli_fetch_assoc($r);
            if($row['OVERS']==$mx){
                    $s="UPDATE TEAM2 SET B_ST=2 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
                    mysqli_query($conn,$s);
            }
            if($no!=0){
                $s="SELECT COUNT(PNAME) CNT FROM TEAM2 WHERE B_ST=2 AND MATCH_ID=$mid AND YEAR=$yr";
                $r=mysqli_query($conn,$s);
                $row=mysqli_fetch_assoc($r);
                if($row['CNT']==$no){
                    $s="UPDATE TEAM2 SET B_ST=1.5 WHERE OVERS=$mx-1 AND MATCH_ID=$mid AND YEAR=$yr";
                }
            }
        }


        else if($k==1){
            $s="UPDATE TEAM2 SET B_ST=0 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s);
            $s1="UPDATE TEAM2 SET B_ST=1 WHERE PNAME='$blr' AND MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s1);
            $s1="SELECT * FROM TEAM2 WHERE B_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
            $r1=mysqli_query($conn,$s1);
            $blr=mysqli_fetch_assoc($r1);

            $sk=$blr['RUN'];
            $s="UPDATE MDN SET MAIDEN=$sk WHERE MATCH_ID=$mid AND YEAR=$yr";
            mysqli_query($conn,$s);
        }
        $blr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE B_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
    }
?>


        <?php if($blr){?>
            <div class="bowle"><span class="bowler"><?php echo $blr['PNAME']?></span>
            <span class="bl_stat"><?php echo $blr['OVERS']?>-<?php echo $blr['MAIDEN']?>-<?php echo $blr['RUN']?>-<?php echo $blr['WICKET']?></span></div>
        <?php }?>
