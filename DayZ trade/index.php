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
    
if($_POST["net"]){
    $idnot = $mydataprofile["id"];
    $query = mysql_query("UPDATE users SET notivk='0' WHERE id='$idnot'",$db);
    header("Location: /");
}
if($mydataprofile["id"]){
    $profileid = $mydataprofile["id"];
    $tim = time();
    $query = mysql_query("UPDATE users SET date='$tim' WHERE id='$profileid'",$db);
}
    
    
if($mydataprofile["notivk"]=="1"&&$_COOKIE["lang"]=="ru"){
    echo '
    <div class="notif">
        <form action="/" method="post">
            <h3>Уведомления вконтакте</h3>
            <p>Хотите, мы будем присылать вам уведомления в личные сообщения вконтакте, когда в вашем обмене остаявят коментарий?</p>
            <div class="knopki">
                <script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>
                <a class="button-flat" materialcircle="block,light"><div id="vk_allow"></div>Разрешить</a>
                <script type="text/javascript">
                    VK.Widgets.AllowMessagesFromCommunity("vk_allow", {height: 30}, 134087842);
                    VK.Observer.subscribe("widgets.allowMessagesFromCommunity.allowed", function f(userId) {
                    notyallowed(userId);
                    });
                </script>
                <input name="net" type="submit" class="button-flat" value="Нет, больше не спрашивать" materialcircle="block,night">
            </div>
        </form>
    </div>
    ';
}    
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['popularitems']; ?></h2>
        <div class="carusel">
            <div class="next"></div>
            <div class="prew"></div>
            <div class="owl-carusel">
            <?php
                $query = @mysql_query("SELECT * FROM items WHERE NOT type='0' ORDER BY obm DESC LIMIT 10",$db);
                $it = @mysql_fetch_array($query);
                do{
                    if($it){
                        echo '
                        <div title="'.$it["name"].'" class="item">
                        <img src="'.$it["img"].'">
                        <div class="name">
                        <a href="search?ot='.$it["name"].'">'.$it["name"].'</a>
                        <span>'.$lang[$it["type"]].'</span>
                        <p>'.$lang['exchanges'].' '.$it["obm"].' '.$lang['quantity'].'</p>
                        </div>
                        </div>
                        ';
                    }
                }
                while($it = @mysql_fetch_array($query));
            ?>
            </div>
        </div>

        <h2><?php echo $lang['besttraders']; ?></h2>
        <div class="besttraders">
           <?php
                $query = @mysql_query("SELECT * FROM users WHERE NOT priority='admin' ORDER BY top DESC LIMIT 10",$db);
                $traders = @mysql_fetch_array($query);
                do{
                    if($traders){
                        $idop = repl($traders["id"]);
                        if($idop==$myid||$myid==""||$mydataprofile["ban"]!=""){
                            $likenaj=false;
                        }else{
                            $likenaj=true;
                        }
                        $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='like'",$db);
                        $likecol = mysql_num_rows($rowr);
                        $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='dislike'",$db);
                        $dislikecol = mysql_num_rows($rowr);
                        if($traders["ban"]=="ban"){
                        $ban = '<span class="banned">'.$lang['ban'].'</span>';
                        }else{
                        $ban = "";
                        }
                        if($traders["priority"]=="vip"){
                        $vip = '<span class="vip">VIP</span>';
                        }else{
                        $vip = "";
                        }
                        $namep = repl($traders["name"]);
                        $rowr = @mysql_query("SELECT id FROM trade WHERE name='$namep' AND stat='active'",$db);
                        $actobm = mysql_num_rows($rowr);
                        $likeactive = @mysql_fetch_array(@mysql_query("SELECT raiting FROM raitingtoday WHERE kto='$myid' AND komy='$idop' AND raiting='like'",$db));
                        $dislikeactive = @mysql_fetch_array(@mysql_query("SELECT raiting FROM raitingtoday WHERE kto='$myid' AND komy='$idop' AND raiting='dislike'",$db));
                        $echoactive;
                        if($likeactive){
                        $likeactive = 'class="active"';
                        }
                        if($dislikeactive){
                        $dislikeactive = 'class="active"';
                        }
                        echo '
                        <div class="trader">
                        <a href="profile?p='.$namep.'" class="ava"><img src="'.$traders["ava"].'"></a>
                        <div class="infotraders">
                        <div class="nametraders">
                        <a href="profile?p='.$namep.'">'.$namep.' '.$vip.' '.$ban.'</a>
                        <p>'.$lang['activetrade'].''.$actobm.'</p>
                        </div>';
                        if($likenaj){
                            echo'
                            <div class="raiting" id="collike">
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
                            <div class="raiting">
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
                        </div>
                        </div>
                        ';
                    }
                }
                while($traders = @mysql_fetch_array($query));
            ?>
        </div>

        <h2><?php echo $lang['suggestions']; ?></h2>
        <div class="typetrade">
            <span all onclick="typeserv('all')" class="active"><?php echo $lang['all']; ?></span>
            <span public1 onclick="typeserv('public1')">Public 1st</span>
            <span public13 onclick="typeserv('public13')">Public 1st/3rd</span>
            <span dayzone onclick="typeserv('dayzone')">DAYZONE</span>
        </div>
        <div class="traders">
           <?php
            $query = @mysql_query("SELECT * FROM trade WHERE stat='active' ORDER BY vip DESC , id DESC LIMIT 10",$db);
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
            $coltrade = mysql_num_rows($query);
            if($coltrade==0){
                echo '<span>'.$lang['activesuggestions'].'</span>';
            }
            if($coltrade<10){   
            }else{
                echo '<input onclick="loadtrade(\'all\');" id="ewe" type="submit" class="button-flat" value="'.$lang['show'].'" materialcircle="block,night">';
            }
            ?>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
