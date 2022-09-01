<?php
session_start();
include("functions/connect.php");
?>
<html>
<?php include("functions/head.php");?>

<body>
<?php
if(!$_SESSION['soob']==""){
    echo '
    <div id="soob">
    <span>'.$_SESSION['soob'].'</span>
    </div>
    ';
    $_SESSION['soob']="";
}
include("functions/menu.php");
    
if(!$_SESSION['login']){
    header("Location: /registration");
    $_SESSION['soob']=$lang['soob8'];
}
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['favorite']; ?></h2>
        <div class="traders">
            <?php
            $myname = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$myid'",$db));
            $myname = $myname["name"];
            
            $query = @mysql_query("SELECT * FROM favorites WHERE name='$myname' ORDER BY id DESC",$db);
            $myrow = @mysql_fetch_array($query);
            do{
                $numtr = repl($myrow["idtrade"]);
                $fav = @mysql_fetch_array(@mysql_query("SELECT * FROM trade WHERE id='$numtr'",$db));
                if($fav){
                $nametrad = repl($fav["name"]);
                $itarr = explode("|", $fav["cont"]);
                $it1 = repl($itarr[0]);
                $it2 = repl($itarr[1]);
                $it1 = explode(",", $it1);
                $it2 = explode(",", $it2);
                $ban = @mysql_fetch_array(@mysql_query("SELECT ban FROM users WHERE name='$nametrad'",$db));
                $vip = @mysql_fetch_array(@mysql_query("SELECT priority FROM users WHERE name='$nametrad'",$db));
                if($ban["ban"]=="ban"){
                    $ban = '<span class="banned">'.$lang['ban'].'</span>';
                }else{
                    $ban = "";
                }
                if($vip["priority"]=="vip"){
                    $vip = '<span class="vip">VIP</span>';
                }else{
                    $vip = "";
                }
                echo '
                <div class="trade '.$fav["stat"].'">
                <span class="datatrade">'.$fav["data"].'</span>
                <a class="name" href="profile?p='.$fav["name"].'">'.$fav["name"].' '.$vip.' '.$ban.'</a><span>'.$lang['swaps'].'</span>';
                if($fav["serv"]){
                    $servtr = $fav["serv"];
                    $servtext = serv($servtr);
                    echo '<span class="minserv">'.$servtext.'</span>';
                }
                echo '
                <div class="trdeitems">
                ';
                    for ($i = 0; $i < count($it1); $i++) {
                        $sit = explode("_", $it1[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        echo '<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                    }
                echo '
                </div>
                <span>'.$lang['on'].'</span>
                <div class="trdeitems">
                ';
                    for ($i = 0; $i < count($it2); $i++) {
                        $sit = explode("_", $it2[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        echo '<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                    }
                echo '
                </div>
                <a href="trade?id='.$fav["id"].'" class="button" materialcircle="block,light">'.$lang['more'].'</a>
                </div>
                ';
                }
            }
            while($myrow = @mysql_fetch_array($query));
            ?>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
