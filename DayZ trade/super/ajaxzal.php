<?php
session_start();
include("../functions/connect.php");
function repl($str){
    $healthy = array("\"", "'", "|");
    $yummy   = array("&#34;", "&#39;", "&#124;");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}

if($_SESSION['login']){
    $provarr = explode(",", $_SESSION['login']);
    $provlogin = repl($provarr[0]);
    $provpassword = repl($provarr[1]);
	$myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$provlogin' AND password='$provpassword'",$db));
    if($myrow){
        $myid = repl($myrow["id"]);
        $name = repl($myrow["name"]);
        $admc = repl($myrow["priority"]);
    }else{
        unset($_SESSION['login']);
        echo "err";
        exit();
    }
}else{
    echo "err";
    exit();
}

if($_POST["del"]){
    $idzal = repl((int)$_POST["del"]);
    if($admc=="admin"||$idzal){
    $query = mysql_query("DELETE FROM zaloba WHERE id='$idzal'",$db);    
    $query = @mysql_query("SELECT * FROM zaloba ORDER BY id DESC",$db);
    $zal = @mysql_fetch_array($query);
        do{
            if($zal){
                            $na = $zal["name"];
                            $ot = $zal["ot"];
                            $myrow = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$na'",$db));
                            $na = $myrow["name"];
                            $myrow = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$ot'",$db));
                            $ot = $myrow["name"];
                            $html = $html.'
                            <div class="zaloba">
                            <div class="infoza">
                            <span>Жалоба на</span><a href="../profile?p='.$na.'">'.$na.'</a><span> от</span><a href="../profile?p='.$ot.'">'.$ot.'</a>
                            <s onclick="delzal('.$zal["id"].')" materialcircle="icon,night"></s>
                            </div>
                            <p>'.$zal["text"].'</p>
                            </div>
                            ';
                        }
        }
        while($zal = @mysql_fetch_array($query));
        echo $html;
    }else{
        echo "err";
    }
}
?>