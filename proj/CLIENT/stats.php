<?php
    include("config/db_conn.php");
    $b=$_POST['b'];
    $vr=$_POST['vr'];
    $yr=2020;
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    $t=$_POST['t'];

    if($vr=="RUNS"){
        $v="";
    }
    else if($vr=="AVERAGE"){
        $v="AV";
    }
    else if($vr=="STRIKE_RATE"){
        $v="SR";
    }
    else if($vr=="HUNDREDS"){
        $v="100s";
    }
    else if($vr=="FIFTIES"){$v="50s";}else if($vr=="THIRTIES"){$v="30s";}

    if($vr=="WICKETS"){$v="W";}else if($vr=="ECONOMY"){$v="Eco";}else if($vr=="THREE_HAUL"){$v="3W";}else if($vr=="FIVE_HAUL"){$v="5W";}

?>


<?php if($b==0){
        $s=mysqli_query($conn,"CREATE OR REPLACE VIEW MOST AS SELECT * FROM STATS WHERE PNAME IN (SELECT PNAME FROM PLAYER_BIO WHERE FID_PLAYED=$t AND YEAR=$yr) AND RUNS>0 AND $vr>0 ORDER BY $vr DESC LIMIT 10");
        // echo "SELECT * FROM STATS WHERE PNAME=(SELECT PNAME FROM PLAYER_BIO WHERE FID_PLAYED=1 AND YEAR=$yr) AND RUNS>0 ORDER BY $vr DESC";
        $s=mysqli_query($conn,"SELECT * FROM MOST");
?>
<table cellpadding="10">
    <?php if($v){?>
        <tr><th>Batsmen</th><th>M</th><th>I</th><th>R</th><th><?php echo $v?></th></tr>
        <?php while($r=mysqli_fetch_assoc($s)){?>
            <tr class="player" id="<?php echo $r['PNAME'];?>"><td><?php echo $r['PNAME']; ?></td><td><?php echo $r['MATCHES']?></td><td><?php echo $r['INNINGS_B'];?></td><td><?php echo $r['RUNS'];?></td><td><?php echo $r[$vr];?></td></tr>
        <?php } ?>
    <?php } ?>
    <?php if($v==""){?>
        <tr><th>Batsmen</th><th>M</th><th>I</th><th>R</th><th>Avg</th></tr>
        <?php while($r=mysqli_fetch_assoc($s)){?>
            <tr class="player" id="<?php echo $r['PNAME'];?>"><td><?php echo $r['PNAME']; ?></td><td><?php echo $r['MATCHES']?></td><td><?php echo $r['INNINGS_B'];?></td><td><?php echo $r['RUNS'];?></td><td><?php echo $r['AVERAGE'];?></td></tr>
        <?php } ?>
    <?php } ?>
    <tr><td></td></tr>
</table>
<?php } ?>

<?php if($b==1){

    if($vr!="ECONOMY"){
        $s=mysqli_query($conn,"CREATE OR REPLACE VIEW MOST AS SELECT * FROM STATS WHERE PNAME IN (SELECT PNAME FROM PLAYER_BIO WHERE FID_PLAYED=$t AND YEAR=$yr) AND OVERS_BOWLED>0.0 AND $vr>0 ORDER BY $vr DESC");
    }

    else{$s=mysqli_query($conn,"CREATE OR REPLACE VIEW MOST AS SELECT * FROM STATS WHERE PNAME IN (SELECT PNAME FROM PLAYER_BIO WHERE FID_PLAYED=$t AND YEAR=$yr) AND OVERS_BOWLED>0.0 ORDER BY $vr ASC");}
    // echo "SELECT * FROM STATS WHERE PNAME IN (SELECT PNAME FROM PLAYER_BIO WHERE FID_PLAYED=1 AND YEAR=$yr) AND OVERS_BOWLED>0.0 ORDER BY $vr DESC";
    $s=mysqli_query($conn,"SELECT * FROM MOST");
?>

<table cellpadding="10">
    <tr><th>Bowler</th><th>M</th><th>I</th><th>O</th><th><?php echo $v?></th></tr>
    <?php while($r=mysqli_fetch_assoc($s)){?>
        <tr class="player" id="<?php echo $r['PNAME'];?>"><td><?php echo $r['PNAME']; ?></td><td><?php echo $r['MATCHES']?></td><td><?php echo $r['INNINGS_BO'];?></td><td><?php echo $r['OVERS_BOWLED'];?></td><td><?php echo $r[$vr];?></td></tr>
    <?php } ?>
    <tr><td></td></tr>
</table>
<?php } ?>
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
