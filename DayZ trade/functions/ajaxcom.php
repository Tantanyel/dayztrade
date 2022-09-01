<?php
session_start();
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
include("mail.php");
function repl($str){
    $healthy = array("\"", "'", "|", ">", "<");
    $yummy   = array("&#34;", "&#39;", "&#124;", "", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}

if($_SESSION['login']){
    $provarr = explode(",", $_SESSION['login']);
    $provlogin = repl($provarr[0]);
    $provpassword = repl($provarr[1]);
	$myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$provlogin' AND password='$provpassword'",$db));
    if($myrow){
        if($myrow["ban"]!="ban"){
        $myid = repl($myrow["id"]);
        $name = repl($myrow["name"]);
        $iduvk = $myrow["notivk"];
        $admink = repl($myrow["priority"]);
        }else{
            echo "erravtoriz";
            exit();
        }
    }else{
        unset($_SESSION['login']);
        echo "erravtoriz";
        exit();
    }
}else{
    echo "erravtoriz";
    exit();
}

function sendmes($idvk,$mes){
    $user_id = $idvk;
    $token = "0f5c825f96d8e41b257ec39d14840b6b0b882f429317a8848a2262a870617126e73f455a960d620b0a475";
    
    $request_params = array( 
    'message' => $mes,
    'user_id' => $user_id, 
    'access_token' => $token, 
    'v' => '5.0'
    ); 

    $get_params = http_build_query($request_params);

    file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
}

if($_POST["com"]){
    $tarr = repl($_POST["com"]);
    $tarr = explode("_", $tarr);
    $idtrade = repl($tarr[0]);
    $comment = mysql_real_escape_string(repl((string)$tarr[1]));
    $comment = preg_replace('/\s{2,}/', ' ', $comment);
    date_default_timezone_set('Europe/Moscow');
    $date = date("d M Y");
    $tim = date("H:i");
    $hdate = '<span class="data">'.$date.'</span><span class="time">'.$tim.'</span>';
    $adm = @mysql_fetch_array(@mysql_query("SELECT name FROM trade WHERE id='$idtrade'",$db));
    $adm = $adm["name"];
    if($adm==$name){
        $yadm = true;
    }else{
        $yadm = false;
    }
    if($comment!=""&&$comment!=" "){
        $query = mysql_query("INSERT INTO comments VALUES('','$idtrade','$name','$comment','$hdate')",$db);
        $dataadmincom = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$adm'",$db));
        $email = $dataadmincom["email"];
        $okcom = $dataadmincom["comtomail"];
        $provdtata = $dataadmincom["name"].','.$dataadmincom["password"];
        if($okcom==1&&!$yadm){
            mail4($email,$name,$comment,$idtrade,$provdtata);
        }
        if($dataadmincom["notivk"]>1&&!$yadm){
            if($iduvk>1){
                $name = '[id'.$iduvk.'|'.$name.']';
            }
            $mesvk = '
            Уведомление!
            
            Комментарий от '.$name.':
            "'.$comment.'"
            Ссылка на обмен: http://dayztrade.ru/trade?id='.$idtrade.'
            ';
            sendmes($dataadmincom["notivk"],$mesvk);
        }
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
        if($idkto==$name||$yadm||$admink=="admin"){
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
        $html=$html.'
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
           $html='<span class="nocoment">'.$lang['nocomment'].'</span>'; 
        }
        }
        while($myrow = @mysql_fetch_array($query));
        echo $html;
}

if($_POST["del"]){
    $idcomment = repl((int)$_POST["del"]);
    $admc = @mysql_fetch_array(@mysql_query("SELECT * FROM comments WHERE id='$idcomment'",$db));
    $idtrade = $admc["idtrade"];
    $nametrader = $admc["name"];
    $admt = @mysql_fetch_array(@mysql_query("SELECT name FROM trade WHERE id='$idtrade'",$db));
    $admt = $admt["name"];
    if($nametrader==$name||$name==$admt||$admink=="admin"){
    $query = mysql_query("DELETE FROM comments WHERE id='$idcomment'",$db);    
    $query = @mysql_query("SELECT * FROM comments WHERE idtrade='$idtrade' ORDER BY id DESC LIMIT 200",$db);
    $myrow = @mysql_fetch_array($query);
    do{
        if($myrow){
        $idkto = repl($myrow['name']);
        if($admt==$idkto){
        $onadm = 'class="admtrade"';
        }else{
        $onadm = "";
        }
        if($admt==$name){
        $yadm = true;
        }else{
        $yadm = false;
        }
        if($idkto==$name||$yadm||$admink=="admin"){
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
        $html=$html.'
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
           $html='<span class="nocoment">'.$lang['nocomment'].'</span>'; 
        }
        }
        while($myrow = @mysql_fetch_array($query));
        echo $html;
        
    }else{
        echo "errdelcom";
    }
}
?>