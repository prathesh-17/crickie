<?php
    include("config/db_conn.php");
    $t1=$_POST['t1'];
    $t2=$_POST['t2'];
    $inn=$_POST['inn'];
    $yr=2020;
    $i=$_POST['i'];
    $row=mysqli_fetch_array(mysqli_query($conn,"SELECT MATCH_ID FROM MATCHES WHERE TEAM1=$t1 AND TEAM2=$t2 AND YEAR=$yr"));
    $mid=$row['MATCH_ID'];
?>

<?php if($i==1){?>
    <?php if($inn==1){$s="SELECT * FROM TEAM WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>

            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>

            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>

    <?php } ?>


    <?php if($inn==2){$s="SELECT * FROM TEAM2 WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr";$res=mysqli_query($conn,$s);?>
            <div class="ch"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM TEAM2 WHERE O_ST=0 AND MATCH_ID=$mid AND YEAR=$yr"))['PNAME']?></div>
            <div class="choices">
                <?php while($r1=mysqli_fetch_assoc($res)){ ?>
                <div class="yr" id="<?php echo $r1['PNAME']?>"><?php echo $r1['PNAME']?></div>
                <?php } ?>
            </div>

    <?php } ?>

<?php }?>


<?php if($i==2){ ?>
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
<?php } ?>

<?php if($i==3){ ?>

                <?php
                   if($inn==1){
                        $s="SELECT * FROM TEAM WHERE O_ST=1.5 AND MATCH_ID=$mid AND YEAR=$yr";
                        $r=mysqli_query($conn,$s);
                        $s="SELECT * FROM TEAM WHERE O_ST=1 AND MATCH_ID=$mid AND YEAR=$yr";
                        $r1=mysqli_query($conn,$s);

                    }
                    if($inn==2){
                        $s="SELECT * FROM TEAM2 WHERE O_ST=1.5 AND MATCH_ID=$mid  AND YEAR=$yr";
                        $r=mysqli_query($conn,$s);
                        $s="SELECT * FROM TEAM2 WHERE O_ST=1 AND MATCH_ID=$mid  AND YEAR=$yr";
                        $r1=mysqli_query($conn,$s);
                    }

                    $str=mysqli_fetch_assoc($r);
                    $str1=mysqli_fetch_assoc($r1);

                ?>
        <div class="fs">
            <div class="ch"><?php echo $str['PNAME']?></div>
            <div class="choices">
                <div class="yr" id="<?php echo $str['PNAME']?>"><?php echo $str['PNAME']?></div>
                <div class="yr" id="<?php echo $str1['PNAME']?>"><?php echo $str1['PNAME']?></div>
            </div>
        </div>
        <div class="fr">
            <div class="ch"><?php echo $str['PNAME']?></div>
            <div class="choices">
                <div class="yr" id="<?php echo $str['PNAME']?>"><?php echo $str['PNAME']?></div>
                <div class="yr" id="<?php echo $str1['PNAME']?>"><?php echo $str1['PNAME']?></div>
            </div>
        </div>
<?php } ?>



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



