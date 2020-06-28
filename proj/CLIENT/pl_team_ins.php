<?php
    include("config/db_conn.php");
    $yr=$_POST['yr'];
    $t=$_POST['t'];
    $bat=mysqli_query($conn,"SELECT * FROM PLAYER A,PLAYER_BIO B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$t AND YEAR=$yr AND ROLE='BAT'");
    $all=mysqli_query($conn,"SELECT * FROM PLAYER A,PLAYER_BIO B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$t AND YEAR=$yr AND ROLE='ALLROUNDER'");
    $wkt=mysqli_query($conn,"SELECT * FROM PLAYER A,PLAYER_BIO B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$t AND YEAR=$yr AND ROLE='WK'");
    $bwl=mysqli_query($conn,"SELECT * FROM PLAYER A,PLAYER_BIO B WHERE A.PNAME=B.PNAME AND FID_PLAYED=$t AND YEAR=$yr AND ROLE='BOWL'");
?>
<table>
<div class="btsmn">
    <table cellpadding="10">
        <tr><th>BATSMEN</th><th>I</th><th>R</th><th>I</th><th>W</th></tr>
    <?php while($bt=mysqli_fetch_assoc($bat)){ ?>
        <tr class="player" id="<?php echo $bt['PNAME'];?>">
            <td><?php echo $bt['PNAME'];?> <?php if($bt['NATION']!="IND"){echo "*";}?></td>
            <td><?php echo $bt['INNINGS_B'];?></td>
            <td><?php echo $bt['RUNS']?></td>
            <td><?php echo $bt['INNINGS_BO'];?></td>
            <td><?php echo $bt['WICKETS']?></td>
        </tr>
    <?php } ?>
        <tr><td></td></tr>
    </table>

</div>
<br>
<div class="alrndr">
    <table cellpadding="10">
        <tr><th>BOWLER</th><th>I</th><th>R</th><th>I</th><th>W</th></tr>
    <?php while($bt=mysqli_fetch_assoc($all)){ ?>
        <tr class="player" id="<?php echo $bt['PNAME'];?>">
            <td><?php echo $bt['PNAME'];?> <?php if($bt['NATION']!="IND"){echo "*";}?></td>
            <td><?php echo $bt['INNINGS_B'];?></td>
            <td><?php echo $bt['RUNS']?></td>
            <td><?php echo $bt['INNINGS_BO'];?></td>
            <td><?php echo $bt['WICKETS']?></td>
        </tr>
    <?php } ?>
        <tr><td></td></tr>
    </table>
</div><br>
<div class="wktkpr">
    <table cellpadding="10">
        <tr><th>WICKET KEEPER</th><th>I</th><th>R</th></tr>
    <?php while($bt=mysqli_fetch_assoc($wkt)){ ?>
        <tr class="player" id="<?php echo $bt['PNAME'];?>">
            <td><?php echo $bt['PNAME'];?> <?php if($bt['NATION']!="IND"){echo "*";}?></td>
            <td><?php echo $bt['INNINGS_B'];?></td>
            <td><?php echo $bt['RUNS']?></td>
        </tr>
    <?php } ?>
        <tr><td></td></tr>
    </table>
</div><br>
<div class="bwlr">
    <table cellpadding="10">
        <tr><th>BOWLER</th><th>I</th><th>R</th><th>I</th><th>W</th></tr>
    <?php while($bt=mysqli_fetch_assoc($bwl)){ ?>
        <tr class="player" id="<?php echo $bt['PNAME'];?>">
            <td><?php echo $bt['PNAME'];?> <?php if($bt['NATION']!="IND"){echo "*";}?></td>
            <td><?php echo $bt['INNINGS_B'];?></td>
            <td><?php echo $bt['RUNS']?></td>
            <td><?php echo $bt['INNINGS_BO'];?></td>
            <td><?php echo $bt['WICKETS']?></td>
        </tr>
    <?php } ?>
        <tr><td></td></tr>
    </table>
</div>
</table>
<?php $conn->close(); ?>
<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script>
    $(".player").click(function(){
            // console.log($(this)[0].id);
            $.redirect("player.php",{
                name:$(this)[0].id
            },"GET");
    });
</script>
