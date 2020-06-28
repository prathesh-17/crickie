<?php

    include("config/db_conn.php");


    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $i=$_POST['i'];
    $inn=$_POST['inn'];
    $pn=$_POST['str'];
    $yr=2020;
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];
    $ab=$_POST['ab'];

    // echo $t1." ".$t2." ".$i." ".$pn." ".$mid." ".$inn;
    if($inn==1){
        if($i==0){
            mysqli_query($conn,"UPDATE TEAM SET ORDER_OF_BAT=1 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM SET O_ST=1.5 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
        }
        if($i==1){
            mysqli_query($conn,"UPDATE TEAM SET ORDER_OF_BAT=2 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM SET O_ST=1.0 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
        }
        $str=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr"));
        $str1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
    }
    if($inn==2){
        if($i==0){
            mysqli_query($conn,"UPDATE TEAM2 SET ORDER_OF_BAT=1 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.5 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
        }
        if($i==1){
            mysqli_query($conn,"UPDATE TEAM2 SET ORDER_OF_BAT=2 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
            mysqli_query($conn,"UPDATE TEAM2 SET O_ST=1.0 WHERE PNAME='$pn' AND MATCH_ID=$mid AND YEAR=$yr");
        }
        $str=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr"));
        $str1=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=1.0 AND MATCH_ID=$mid AND YEAR=$yr"));
    }



?>

<?php if($ab==1){?>

        <?php if($str){?>
            <div class="striker" ><span><?php echo $str['PNAME']?></span>
                <span ><?php echo $str['RUNS']?></span><span >(<?php echo $str['BALLS']?>)</span></div><br>
        <?php } ?>
        <?php if($str1){?>
            <div class="nonstriker" ><span><?php echo $str1['PNAME']?></span>
                <span ><?php echo $str1['RUNS']?></span><span >(<?php echo $str1['BALLS']?>)</span></div><br>
        <?php }?>
<?php }?>


<?php if($ab==0){?>
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
<?php } $conn->close();?>

    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery.redirect.js"></script>
    <script type="text/javascript">
        $(document).click(function(e){
    // console.log(e.target.className);
                if(e.target.className!="ch"){
                    $(".choices").slideUp();
                }
            });

            $(".ch").click(function(){
                    $(this).next().slideDown();
        });

                $(".yr").click(function(){
                    $(".choices").slideUp();
                    // console.log($(this)[0].id);
                    // console.log($(this).parent());
                    $(this).parent().parent().find(".ch").html($(this)[0].id);
                });


    </script>
