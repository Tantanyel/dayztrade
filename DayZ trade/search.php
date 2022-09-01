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
 
$ot;
$na;
    
if($_GET){
    $ot = repl($_GET["ot"]);
    $na = repl($_GET["na"]);
    $pol = repl($_GET["pol"]);
}
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['search']; ?></h2>
        <div class="searchcont">
            <form action="search" method="get">
                <span><?php echo $lang['lookingfor']; ?></span>
                <div class="input normalinput">
                    <input name="ot" type="text" autocomplete="off" value="<?php if($ot!=""){echo $ot;} ?>">
                    <span><?php echo $lang['nameitem']; ?></span>
                    <div class="line"><i></i></div>
                    <p></p>
                </div>
                <span><?php echo $lang['exchangefor']; ?></span>
                <div class="input normalinput">
                    <input name="na" type="text" autocomplete="off" value="<?php if($na!=""){echo $na;} ?>">
                    <span><?php echo $lang['nameitem']; ?></span>
                    <div class="line"><i></i></div>
                    <p></p>
                </div>
                <input type="submit" class="button-flat" value="<?php echo $lang['searchgo']; ?>" materialcircle="block,night">
            </form>
            <form action="search" method="get">
                <span><?php echo $lang['seachuser']; ?></span>
                <div class="input normalinput">
                    <input name="pol" type="text" autocomplete="off" value="<?php if($pol!=""){echo $pol;} ?>">
                    <span><?php echo $lang['loginuser']; ?></span>
                    <div class="line"><i></i></div>
                    <p></p>
                </div>
                <input type="submit" class="button-flat" value="<?php echo $lang['searchgo']; ?>" materialcircle="block,night">
            </form>
        </div>

        <div class="headerprofile">
            <h2><?php echo $lang['results']; ?></h2>
            <?php
            if($ot!=""){
                echo '<span>'.$ot.'</span>';
            }
            if($na!=""){
                echo '<span>'.$lang['on'].'</span><span>'.$na.'</span>';
            }
            ?></div>
        <div class="traders">
            <?php
            if($pol==""){
            if($na!=""&&$ot!=""){
                $query = @mysql_query("SELECT * FROM trade WHERE stat='active' AND ot LIKE '%$ot%' AND na LIKE '%$na%' ORDER BY vip DESC , id DESC LIMIT 100",$db);
            }else{
                if($ot!=""){
                    $query = @mysql_query("SELECT * FROM trade WHERE stat='active' AND ot LIKE '%$ot%' ORDER BY vip DESC , id DESC LIMIT 100",$db);
                }
                if($na!=""){
                    $query = @mysql_query("SELECT * FROM trade WHERE stat='active' AND na LIKE '%$na%' ORDER BY vip DESC , id DESC LIMIT 100",$db);
                }
            }
            $myrow = @mysql_fetch_array($query);
            do{
                if($myrow){
                $nametrad = repl($myrow["name"]);
                $itarr = explode("|", $myrow["cont"]);
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
                    if($vip["priority"]=="admin"){
                    $vip = '<span class="vip">Admin</span>';
                    }else{
                    $vip = "";
                    }
                }
                echo '
                <div class="trade '.$myrow["stat"].'">
                <span class="datatrade">'.$myrow["data"].'</span>
                <a class="name" href="profile?p='.$myrow["name"].'">'.$myrow["name"].' '.$vip.' '.$ban.'</a><span>'.$lang['swaps'].'</span>';
                if($myrow["serv"]){
                    $servtr = $myrow["serv"];
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
                <a href="trade?id='.$myrow["id"].'" class="button" materialcircle="block,light">'.$lang['more'].'</a>
                </div>
                ';
                }
            }
            while($myrow = @mysql_fetch_array($query));
            }else{
                $query = @mysql_query("SELECT * FROM users WHERE name LIKE '%$pol%'",$db);
                $myrow = @mysql_fetch_array($query);
                do{
                if($myrow){
                        $namep = repl($myrow["name"]);
                        $idop = repl($myrow["id"]);
                        if($idop==$myid||$myid==""||$mydataprofile["ban"]!=""){
                            $likenaj=false;
                        }else{
                            $likenaj=true;
                        }
                        $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='like'",$db);
                        $likecol = mysql_num_rows($rowr);
                        $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='dislike'",$db);
                        $dislikecol = mysql_num_rows($rowr);
                        $likeactive = @mysql_fetch_array(@mysql_query("SELECT raiting FROM raitingtoday WHERE kto='$myid' AND komy='$idop' AND raiting='like'",$db));
                        $dislikeactive = @mysql_fetch_array(@mysql_query("SELECT raiting FROM raitingtoday WHERE kto='$myid' AND komy='$idop' AND raiting='dislike'",$db));
                        if($likeactive){
                        $likeactive = 'class="active"';
                        }
                        if($dislikeactive){
                        $dislikeactive = 'class="active"';
                        }
                    
                    echo'
                    <div class="users">
                    <div class="ava">
                    <img src="'.$myrow['ava'].'">
                    </div>
                    <a href="profile?p='.$namep.'" class="nameus">'.$namep.'</a>';
                    if($likenaj){
                            echo'
                            <div class="profileraiting" id="collike">
                            <div class="like">
                            <button '.$likeactive.' idarr="'.$idop.',like" materialcircle="icon,#6BC43C"><img src="img/like.png"></button>
                            <span>'.$likecol.'</span>
                            </div>
                            <div class="dislike">
                            <button '.$dislikeactive.' idarr="'.$idop.',dislike" materialcircle="icon,#FF4132"><img src="img/dislike.png"></button>
                            <span>'.$dislikecol.'</span>
                            </div>
                            </div>
                            ';
                        }else{
                            echo'
                            <div class="profileraiting">
                            <div class="like">
                            <img src="img/like.png">
                            <span>'.$likecol.'</span>
                            </div>
                            <div class="dislike">
                            <img src="img/dislike.png">
                            <span>'.$dislikecol.'</span>
                            </div>
                            </div>
                            ';
                        }
                    echo'
                    <a href="profile?p='.$namep.'" class="button-flat" materialcircle="block,night">'.$lang['profile'].'</a>
                    </div>
                    ';
                    }
                }
                while($myrow = @mysql_fetch_array($query));
            }
            ?>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
