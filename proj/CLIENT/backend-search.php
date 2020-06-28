<?php

    include("config/db_conn.php");
    if(isset($_POST["term"])){
        $key=$_POST['term'];
        $sql = "SELECT * FROM PLAYER WHERE PNAME LIKE '%$key%' ORDER BY SEARCH DESC LIMIT 10";

        $res=mysqli_query($conn,$sql);

while($ro=mysqli_fetch_assoc($res)){
?>

<div class="player" id="<?php echo $ro['PNAME']; ?>"><?php echo $ro['PNAME']; ?></div>
<?php }} ?>

<?php $conn->close(); ?>

<script src="scripts/jquery-3.4.1.js"></script>
<script src="scripts/jquery.redirect.js"></script>
<script type="text/javascript">
        $(".player").click(function(){
        // console.log($(this)[0].id);
        $.redirect("player.php",{
            name:$(this)[0].id
        },"GET");
    });
</script>
