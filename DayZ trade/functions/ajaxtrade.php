<?php
include("connect.php");
if($_COOKIE["lang"]){
    if($_COOKIE["lang"]=="ru"){
        include("../lang/ru.php");
    }
    if($_COOKIE["lang"]=="eng"){
        include("../lang/eng.php");
    }
}else{
    $yip=$_SERVER["REMOTE_ADDR"];
    $country = geoip_country_code3_by_name($yip);
    if ($country=="RUS"||$country=="UKR"||$country=="BLR") {
        setcookie("lang", "ru",time()+15000000);
        include("../lang/ru.php");
    }else{
        setcookie("lang", "eng",time()+15000000);
        include("../lang/eng.php");
    }
}
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
function serv($str){
    if($str == "public13"){
        $str = "Public 1st/3rd Person";
                    }
    if($str == "public1"){
        $str = "Public 1st Person";
    }
    if($str == "dayzone"){
        $str = "DAYZONE private";
    }
    return $str;
}
if($_POST["count"]){
$types = $_POST["type"];
$count = (int)$_POST["count"];
if($count==1){
    $minc=0;
}else{
    $minc = $count;
}
$maxc = 10;
$html;
    
if($types=="all"){
    $query = @mysql_query("SELECT * FROM trade WHERE stat='active' ORDER BY vip DESC , id DESC LIMIT $minc,$maxc",$db);
}
if($types=="public13"){
    $query = @mysql_query("SELECT * FROM trade WHERE serv='public13' AND stat='active' ORDER BY vip DESC , id DESC LIMIT $minc,$maxc",$db);
}
if($types=="public1"){
    $query = @mysql_query("SELECT * FROM trade WHERE serv='public1' AND stat='active' ORDER BY vip DESC , id DESC LIMIT $minc,$maxc",$db);
}
if($types=="dayzone"){
    $query = @mysql_query("SELECT * FROM trade WHERE serv='dayzone' AND stat='active' ORDER BY vip DESC , id DESC LIMIT $minc,$maxc",$db);
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
                    $itemsi1="";
                    $itemsi2="";
                    for ($i = 0; $i < count($it1); $i++) {
                        $sit = explode("_", $it1[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        $itemsi1 = $itemsi1.'<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                    }
                    for ($i = 0; $i < count($it2); $i++) {
                        $sit = explode("_", $it2[$i]);
                        $numit = repl($sit[0]);
                        $colit = repl($sit[1]);
                        $it = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$numit'",$db));
                        $itemsi2 = $itemsi2.'<div info="'.$it["name"].','.$lang[$it["type"]].','.$it["obm"].'" class="trdeitem"><img src="'.$it["img"].'"><span>'.$colit.' '.$lang['quantity'].'</span></div>';
                    }
                    if($myrow["serv"]){
                    $servtr = $myrow["serv"];
                    $servtext = serv($servtr);
                    }
                $html = $html.'
                <div '.$types.' class="trade '.$myrow["stat"].'">
                <span class="datatrade">'.$myrow["data"].'</span>
                <a class="name" href="profile?p='.$myrow["name"].'">'.$myrow["name"].' '.$vip.' '.$ban.'</a><span>'.$lang['swaps'].'</span>
                <span class="minserv">'.$servtext.'</span>
                <div class="trdeitems">
                '.$itemsi1.'
                </div>
                <span>'.$lang['on'].'</span>
                <div class="trdeitems">
                '.$itemsi2.'
                </div>
                <a href="trade?id='.$myrow["id"].'" class="button" materialcircle="block,light">'.$lang['more'].'</a>
                </div>
                ';
                }
            }
            while($myrow = @mysql_fetch_array($query));
    echo $html;
}
?>