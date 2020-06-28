 <?php
  include("config/db_conn.php");
  $res=mysqli_query($conn,"SELECT PNAME,NATION FROM PLAYER ORDER BY SEARCH DESC LIMIT 25");

?>
<!DOCTYPE html>
<html>
<head>
<title>Search</title>
<link rel="stylesheet" type="text/css" href="style_sh/search.css">
</head>
<body>
  <div class="head"><span class="name">SEARCH</span><span class="app">CRICKIE</span></div>
  <div class="search">
    <div class="bt1">TRENDING SEARCHES</div>
  <div class="stsel">
    <table cellpadding="10">
    <?php while($r=mysqli_fetch_assoc($res)){?>
        <tr class="player" id="<?php echo $r['PNAME']; ?>"><td><?php echo $r['PNAME'];?></td><td><?php echo $r['NATION']; ?></td></tr>
    <?php } ?>
    </table>
  </div>


         <div class="search-box">
            <input type="text" autocomplete="off" placeholder="PLAYERS..." />
            <div class="result"></div>
        </div>


  </div>
</body>
<?php $conn->close();?>
<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script src="search.js"></script>

</html>
