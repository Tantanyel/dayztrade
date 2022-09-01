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
$idtrade;
$trade;
$myobm;
if($_GET["id"]){
    $idtrade = repl((int)$_GET["id"]);
    $trade = @mysql_fetch_array(@mysql_query("SELECT * FROM trade WHERE id='$idtrade'",$db));
    $namtrad = repl($trade["name"]);
    if(!$trade){
        $_SESSION['soob']=$lang['soob34'];
        header("Location: /index");
    }else{
        $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$namtrad'",$db));
        $idtrader = repl($myrow["id"]);
        if($myid==$idtrader){
            $myobm=true;
        }else{
            $myobm=false;
        }
    }
        
}else{
    $_SESSION['soob']=$lang['soob34'];
    header("Location: /index");
}
    
if(isset($_POST["delete"])){
    $itarrc = @mysql_fetch_array(@mysql_query("SELECT cont FROM trade WHERE id='$idtrade'",$db));
    $itarrc = $itarrc["cont"];
    $itarr = explode("|", $itarrc);
    $otp1 = repl($itarr[0]);
    $otp2 = repl($itarr[1]);
    $otp1 = explode(",", $otp1);
    $otp2 = explode(",", $otp2);
    for ($i = 0; $i < count($otp1); $i++) {
            $sit = explode("_", $otp1[$i]);
            $sit[0] = (int)$sit[0];
            $idit = $sit[0];
            $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
            $bobm = $bobm["obm"]-1;
            $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
        }
    for ($i = 0; $i < count($otp2); $i++) {
            $sit = explode("_", $otp2[$i]);
            $sit[0] = (int)$sit[0];
            $idit = $sit[0];
            $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
            $bobm = $bobm["obm"]-1;
            $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
        }
    $query = mysql_query("DELETE FROM trade WHERE id='$idtrade'",$db);
    $query = mysql_query("DELETE FROM comments WHERE idtrade='$idtrade'",$db);
    $query = mysql_query("DELETE FROM favorites WHERE idtrade='$idtrade'",$db);
    $_SESSION['soob']=$lang['soob35'];
    header("Location: /profile?p=".$mydataprofile["name"]);
}
if(isset($_POST["lock"])){
    $query = mysql_query("UPDATE trade SET stat='noactive' WHERE id='$idtrade'",$db);
    $_SESSION['soob']=$lang['soob36'];
    header("Location: /trade?id=".$idtrade);
}
if(isset($_POST["open"])){
    $name = repl($mydataprofile['name']);
    $rowc = @mysql_query("SELECT id FROM trade WHERE name='$name' AND stat='active'",$db);
    $actrade = mysql_num_rows($rowc);
    if($actrade<$mydataprofile["activetrade"]){
        if($mydataprofile["info"]!=""&&$mydataprofile["info"]!=",,,,,"){
            $query = mysql_query("UPDATE trade SET stat='active' WHERE id='$idtrade'",$db);
            $_SESSION['soob']=$lang['soob37'];
            header("Location: /trade?id=".$idtrade);
        }else{
            $_SESSION['soob']=$lang['soob41'];
            header("Location: /trade?id=".$idtrade);
        }
        }else{
            $_SESSION['soob']=$lang['soob5'];
            header("Location: /trade?id=".$idtrade);
        }
    
}
if(isset($_POST["unsubscribe"])){
    if($mydataprofile){
    $name = repl($mydataprofile['name']);
    $query = mysql_query("DELETE FROM favorites WHERE name='$name' AND idtrade='$idtrade'",$db);
    $_SESSION['soob']=$lang['soob38'];
    header("Location: /trade?id=".$idtrade);   
    }
}
if(isset($_POST["subscribe"])){
    if($mydataprofile){
    $name = repl($mydataprofile['name']);
    $query = mysql_query("INSERT INTO favorites VALUES('','$idtrade','$name')",$db);
    $_SESSION['soob']=$lang['soob39'];
    header("Location: /trade?id=".$idtrade);
    }
}
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <div class="tradeflex">
            <div class="tradeover">
                <div class="headerprofile">
                    <h2><?php echo $lang['trade']; ?> <span><?php echo $trade["data"]; ?></span></h2>
                    <?php
                    if($trade["stat"]=="noactive"){
                        echo '<p>'.$lang['closed'].'</p>';
                    }
                    if($myobm){
                        echo '<p>'.$lang['mytrade'].'</p>';
                    }
                    ?>
                </div>
                <div class="nametrader">
                   <?php
                    echo '<span>'.$lang['from'].'</span><a href="profile?p='.$trade["name"].'">'.$trade["name"].'</a>';
                    ?>
                </div>
                <form class="tradebtn" action="trade?id=<?php echo $idtrade; ?>" method="post">
                    <?php
                    if($myobm||$mydataprofile['priority']=="admin"){
                        echo '<input materialcircle="icon,night" name="delete" class="delete" type="submit" infohov="'.$lang['delete'].'" value="">';
                        if($trade["stat"]=="active"){
                            echo '<input materialcircle="icon,night" name="lock" class="lock" type="submit" infohov="'.$lang['closetrade'].'" value="">';
                        }else{
                            echo '<input materialcircle="icon,night" name="open" class="open" type="submit" infohov="'.$lang['opentrade'].'" value="">';
                        }
                        if(!$myobm&&$mydataprofile['priority']=="admin"){
                            $myname = repl($mydataprofile['name']);
                            $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM favorites WHERE name='$myname' AND idtrade='$idtrade'",$db));
                            if($myrow){
                                echo '<input materialcircle="icon,night" name="unsubscribe" class="unsubscribe" type="submit" infohov="'.$lang['delfav'].'" value="">';
                            }else{
                                echo '<input materialcircle="icon,night" name="subscribe" class="subscribe" type="submit" infohov="'.$lang['addfav'].'" value="">';
                            }
                        }      
                    }else{
                        if($mydataprofile){
                        $myname = repl($mydataprofile['name']);
                        $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM favorites WHERE name='$myname' AND idtrade='$idtrade'",$db));
                        if($myrow){
                            echo '<input materialcircle="icon,night" name="unsubscribe" class="unsubscribe" type="submit" infohov="'.$lang['delfav'].'" value="">';
                        }else{
                            echo '<input materialcircle="icon,night" name="subscribe" class="subscribe" type="submit" infohov="'.$lang['addfav'].'" value="">';
                        }
                        }
                    }
                    ?>
                </form>
                <?php
                if($trade["serv"]){
                    $servtr = $trade["serv"];
                    $servtext = serv($servtr);
                    echo '<span class="tradeserv">'.$lang['server'].': '.$servtext.'</span>';
                }
                if($trade["opis"]){
                    echo '<span class="tradeopisanie">'.$trade["opis"].'</span>';
                }
                ?>
                <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                <script src="//yastatic.net/share2/share.js"></script>
                <div class="socset">
                    <span><?php echo $lang['repost']; ?></span>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,gplus" data-counter="" data-description="Обмен на сайте DayzTrade.ru: <?php  echo $trade["opis"]; ?>"></div>
                </div>
                <div class="itemsover">
                <div class="nameover">
                   <span><?php echo $lang['items']; ?></span>
                    <?php
                    $nametrad = repl($trade["name"]);
                    $itarr = explode("|", $trade["cont"]);
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
                    echo '<a href="profile?p='.$nametrad.'">'.$nametrad.' '.$ban.' '.$vip.'</a>';
                        
                        
                        
                    ?></div>
                    <div class="trdeitems">
                        <?php
                        for ($i = 0; $i < count($it1); $i++) {
                        $sit = explode("_", $it1[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        echo '<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="itemsover">
                    <div class="nameover"><span><?php echo $lang['myitems']; ?></span></div>
                    <div class="trdeitems">
                       <?php
                        for ($i = 0; $i < count($it2); $i++) {
                        $sit = explode("_", $it2[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        echo '<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tradecoment">
                <h2><?php echo $lang['comments']; ?></h2>
                <div class="comment">
                    <?php
                    if($myid){
                        if($mydataprofile["ban"]!="ban"){
                        echo '
                        <div class="form">
                        <textarea onkeypress="focuscomm(this);" tr="'.$idtrade.'" placeholder="'.$lang['mycomments'].'"></textarea>
                        <button onclick="otprcomment('.$idtrade.');"></button>
                        </div>
                        ';
                        }else{
                            echo '<span class="noavtor">'.$lang['bancomments'].'</span>';
                        }
                    }else{
                        echo '<span class="noavtor">'.$lang['regcomments'].'</span>';
                    }
                    ?>
                    <div class="allcomment">
                        <?php
                        $adm = @mysql_fetch_array(@mysql_query("SELECT name FROM trade WHERE id='$idtrade'",$db));
                        $adm = $adm["name"];
                        if($adm==$mydataprofile["name"]){
                        $yadm = true;
                        }else{
                        $yadm = false;
                        }
                        $query = @mysql_query("SELECT * FROM comments WHERE idtrade='$idtrade' ORDER BY id DESC LIMIT 200",$db);
                        $myrow = @mysql_fetch_array($query);
                        do{
                        if($myrow){
                        $idkto = repl($myrow['name']);
                        if($adm==$idkto){
                        $onadm = 'class="admtrade"';
                        }else{
                        $onadm = "";
                        }
                        if($idkto==$mydataprofile["name"]||$yadm||$mydataprofile["priority"]=="admin"){
                        $delbutton = '<button onclick="delcom('.$myrow['id'].')" materialcircle="icon,night"></button>';
                        }else{
                        $delbutton = '';
                        }
                        $q = @mysql_query("SELECT * FROM users WHERE name='$idkto'",$db);
                        $m = @mysql_fetch_array($q);
                        if($m["ban"]=="ban"){
                        $ban = '<span class="banned">'.$lang['ban'].'</span>';
                        }else{
                        $ban = "";
                        }
                        if($m["priority"]=="vip"){
                        $vip = '<span class="vip">VIP</span>';
                        }else{
                        $vip = "";
                        }
                        if($m["priority"]=="admin"){
                        $vip = '<span class="vip">Admin</span>';
                        }
                        echo '
                        <div class="usercoment">
                        <a href="profile?p='.$idkto.'" class="ava"><img src="'.$m["ava"].'"></a>
                        <div class="commenttext">
                        <a href="profile?p='.$idkto.'"><span '.$onadm.'>'.$idkto.'</span> '.$ban.' '.$vip.'</a>
                        <p>'.$myrow["text"].'</p>
                        </div>
                        <div class="commentdata">
                        '.$myrow["date"].'
                        '.$delbutton.'
                        </div>
                        </div>
                        ';
                        }else{
                           echo '<span class="nocoment">'.$lang['nocomments'].'</span>'; 
                        }
                        }
                        while($myrow = @mysql_fetch_array($query));
                        
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
