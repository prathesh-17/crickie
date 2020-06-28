<?php
    include("config/db_conn.php");
    $team=["CSK","DC","KKR","KXIP","MI","RCB","RR","SRH"];

    $yr=2020;

if(isset($_GET['name'])){
    $pname=$_GET['name'];

    mysqli_query($conn,"UPDATE PLAYER SET SEARCH=SEARCH+1 WHERE PNAME='$pname'");
    $s="SELECT * FROM PLAYER WHERE PNAME='$pname'";
    $res=mysqli_query($conn,$s);
    $s="SELECT * FROM PLAYER_BIO WHERE PNAME='$pname'";
    $res1=mysqli_query($conn,$s);
    $s="SELECT * FROM STATS WHERE PNAME='$pname'";
    $res2=mysqli_query($conn,$s);


    $r=mysqli_fetch_assoc($res);

    $r2=mysqli_fetch_assoc($res2);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $pname;?></title>
    <link rel="stylesheet" type="text/css" href="style_sh/player.css">
</head>
<body>
<div class="head"><span class="name"><?php echo $pname;?></span><span class="app">CRICKIE</span></div>



<div class="nav"><span class="info">INFO </span><span class="season"> SEASON </span><span class="stats"> STATS</span></div>

    <div class="p_inf">
        <table cellpadding="20">
            <tr><td>Name</td><td><?php echo $pname; ?></td></tr>
            <tr><td>Nation</td><td><?php echo $r['NATION'];?></td></tr>
            <tr><td>DOB</td><td><?php $dt=date_create($r['DOB']); echo date_format($dt,"M j,Y");?></td></tr>
            <tr><td>Role</td><td><?php echo $r['ROLE'];?></td></tr>
            <tr><td>Batting Style </td><td><?php echo $r['BATTING_S'];?></td></tr>
            <tr><td>Bowling Style</td><td><?php echo $r['BOWLING_S'];?></td></tr>
        </table>

    </div>
    <div class="seas_inf">
        <div class="lst_y"><?php echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT YEAR FROM PLAYER_BIO WHERE PNAME='$pname' ORDER BY YEAR DESC"))['YEAR'];?></div>
        <div class="year">
            <div class="ch">CHANGE</div>
            <div class="choices"><?php $ro=mysqli_query($conn,"SELECT YEAR FROM PLAYER_BIO WHERE PNAME='$pname'");
                while($s=mysqli_fetch_assoc($ro)){
            ?>
                <div class="yr" id="<?php echo $s['YEAR']?>"><?php echo $s['YEAR']?></div>
            <?php  } ?></div>
        </div>
        <?php while($r1=mysqli_fetch_assoc($res1)){ ?>
            <div class="<?php echo $r1['YEAR'];?>">
                <table cellpadding="20">
                    <tr><td>Team</td><td><?php echo $team[$r1['FID_PLAYED']-1]; ?></td></tr>
                    <tr><td>Innings</td><td><?php echo $r1['INNINGS_B'];?></td></tr>
                    <tr><td>Runs</td><td><?php echo $r1['RUNS']?></td></tr>
                    <tr><td>Innings</td><td><?php echo $r1['INNINGS_BO'];?></td></tr>
                    <tr><td>Wickets</td><td><?php echo $r1['WICKETS'];?></td></tr>

                </table>

            </div>
        <?php } ?>
    </div>
    <div class="stat_inf">
        <div class="st_sel"><div class="stsel"><div class="batting">BATTING </div><div class="bowling"> BOWLING </div><div class="fielding"> FIELDING</div></div></div>
        <div class="bat_stat">
            <table cellpadding="10">
                <tr><td>Matches</td><td><?php echo $r2['MATCHES']?></td></tr>
                <tr><td>Innings</td><td><?php echo $r2['INNINGS_B']?></td></tr>
                <tr><td>Runs</td><td><?php echo $r2['RUNS']?></td></tr>
                <tr><td>Balls</td><td><?php echo $r2['BALLS_FACED']?></td></tr>
                <tr><td>Strike Rate</td><td><?php echo $r2['STRIKE_RATE']?></td></tr>
                <tr><td>Average</td><td><?php echo $r2['AVERAGE']?></td></tr>
                <tr><td>30s</td><td><?php echo $r2['THIRTIES']?></td></tr>
                <tr><td>50s</td><td><?php echo $r2['FIFTIES']?></td></tr>
                <tr><td>100s</td><td><?php echo $r2['HUNDREDS']?></td></tr>
                <tr><td>Not Outs</td><td><?php echo $r2['NOS']?></td></tr>
            </table>
        </div>
        <div class="bwl_stat">
            <table cellpadding="10">
                <tr><td>Matches</td><td><?php echo $r2['MATCHES']?></td></tr>
                <tr><td>Innings</td><td><?php echo $r2['INNINGS_BO']?></td></tr>
                <tr><td>Overs</td><td><?php echo $r2['OVERS_BOWLED']?></td></tr>
                <tr><td>Runs</td><td><?php echo $r2['RUNS_C']?></td></tr>
                <tr><td>Economy</td><td><?php echo $r2['ECONOMY']?></td></tr>
                <tr><td>Maiden</td><td><?php echo $r2['MAIDEN']?></td></tr>
                <tr><td>Wickets</td><td><?php echo $r2['WICKETS']?></td></tr>
                <tr><td>3w</td><td><?php echo $r2['THREE_HAUL']?></td></tr>
                <tr><td>5w</td><td><?php echo $r2['FIVE_HAUL']?></td></tr>


            </table>
        </div>
        <div class="fld_stat">
            <table cellpadding="10">
                <tr><td>Matches</td><td><?php echo $r2['MATCHES']?></td></tr>
                <tr><td>Catches</td><td><?php echo $r2['CATCHES']?></td></tr>
                <tr><td>Stumpings</td><td><?php echo $r2['STUMPINGS']?></td></tr>
                <tr><td>Run Outs</td><td><?php echo $r2['RUN_OUTS']?></td></tr>
            </table>
        </div>
    </div>
</div>
</body>
<?php } ?>

<?php if(!isset($_GET['name'])){ ?>
    <h1>Please specify some name (?name=) in the URL </h1>
<?php } ?>

<?php $conn->close();?>

<script src="scripts/jquery-3.4.1.js"></script>
<script src="playr.js"></script>

</html>
