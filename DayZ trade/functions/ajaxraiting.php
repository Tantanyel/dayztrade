<?php
session_start();
include("connect.php");
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
$myid;
$ost;
if($_SESSION['login']){
    $provarr = explode(",", $_SESSION['login']);
    $provlogin = repl($provarr[0]);
    $provpassword = repl($provarr[1]);
	$myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$provlogin' AND password='$provpassword'",$db));
    if($myrow){
        $myid = repl($myrow["id"]);
        $ost = repl($myrow["raiting"]);
    }else{
        unset($_SESSION['login']);
        echo "erravtoriz";
        exit();
    }
}else{
    echo "erravtoriz";
    exit();
}

if($myrow["priority"]=="admin"&&$_POST["del"]){
    $idd = (int)$_POST["del"];
    $query = mysql_query("DELETE FROM raitingtoday WHERE id='$idd'",$db);
    $query = mysql_query("DELETE FROM raiting WHERE id='$idd'",$db);
    $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM raiting WHERE id='$idd'",$db));
    $idu = $myrow["komy"];
    $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idu' AND raiting='like'",$db);
    $likecol = mysql_num_rows($rowr);
    $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idu' AND raiting='dislike'",$db);
    $dislikecol = mysql_num_rows($rowr);
    $top = $likecol-$dislikecol;
    $query = mysql_query("UPDATE users SET top='$top' WHERE id='$idu'",$db);
    echo 'ok';
}

if($myid&&$_GET["idop"]&&$myrow["ban"]==""){
    $idoparr = explode(",", $_GET["idop"]);
    $idop = repl($idoparr[0]);
    $like = repl($idoparr[1]);
    $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM raitingtoday WHERE kto='$myid' AND komy='$idop'",$db));
    if($myid!=$idop){
        if($ost>0){
            if($myrow){
                if($like!=$myrow["raiting"]){
                    $idraiting = $myrow["id"];
                    $query = mysql_query("UPDATE raitingtoday SET raiting='$like' WHERE id='$idraiting'",$db);
                    $query = mysql_query("UPDATE raiting SET raiting='$like' WHERE id='$idraiting'",$db);
                    echo "aceptzam";
                    $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='like'",$db);
                    $likecol = mysql_num_rows($rowr);
                    $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='dislike'",$db);
                    $dislikecol = mysql_num_rows($rowr);
                    echo ",".$likecol."-".$dislikecol;
                    $top = $likecol-$dislikecol;
                    $query = mysql_query("UPDATE users SET top='$top' WHERE id='$idop'",$db);
                }else{
                   echo "yjelike"; 
                }
            }else{
                date_default_timezone_set('Europe/Moscow');
                $Date = date("d M Y");
                $query = mysql_query("INSERT INTO raiting VALUES('','$myid','$idop','$like','$Date')",$db);
                $myrow = @mysql_fetch_array(@mysql_query("SELECT id FROM raiting WHERE kto='$myid' AND komy='$idop' ORDER BY id DESC",$db));
                $idraiting = $myrow["id"];
                $query = mysql_query("INSERT INTO raitingtoday VALUES('$idraiting','$myid','$idop','$like','$Date')",$db);
                $myrow = @mysql_fetch_array(@mysql_query("SELECT raiting FROM users WHERE id='$myid'",$db));
                $bilo = $myrow["raiting"];
                $vicost = $bilo-1;
                $query = mysql_query("UPDATE users SET raiting='$vicost' WHERE id='$myid'",$db);
                echo "aceptnew,".$vicost;
                $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='like'",$db);
                $likecol = mysql_num_rows($rowr);
                $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='dislike'",$db);
                $dislikecol = mysql_num_rows($rowr);
                echo ",".$likecol."-".$dislikecol;
                $top = $likecol-$dislikecol;
                $query = mysql_query("UPDATE users SET top='$top' WHERE id='$idop'",$db);
            }
        }else{
            echo "errost";
        }
    }else{
        echo "errsam";
    }
}
?>