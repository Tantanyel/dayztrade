<?php
include("connect.php");
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
    $query = mysql_query("DELETE FROM raitingtoday",$db);
    date_default_timezone_set('Europe/Moscow');
    $dat = date("H:i:s d.m.Y");
    echo "Успешно ".$dat;
    
    $que = @mysql_query("SELECT * FROM users",$db);
    $obn = @mysql_fetch_array($que);
    do{
        if($obn){
            $idu = $obn["id"];
            $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idu' AND raiting='like'",$db);
            $likecol = mysql_num_rows($rowr);
            $rowr = @mysql_query("SELECT raiting FROM raiting WHERE komy='$idu' AND raiting='dislike'",$db);
            $dislikecol = mysql_num_rows($rowr);
            $top = $likecol-$dislikecol;
            $query = mysql_query("UPDATE users SET top='$top' WHERE id='$idu'",$db);
            
            if($obn["info"]!=""&&$obn["info"]!=",,,,,"&&$obn["priority"]!="noemail"&&$obn["ban"]!="ban"&&$obn["priority"]!="emailreplace"){
            }else{
                $isus = $obn["name"];
                $query = mysql_query("UPDATE trade SET stst='noactive' WHERE name='$isus'",$db);
            }
            $nameus = repl($obn["name"]);
            $isus = repl($obn["id"]);
            $tim = time();
            if($obn["ban"]!="ban"&&$obn["priority"]!="noemail"){
                if($obn["priority"]=="admin"||$obn["priority"]=="vip"){
                    $query = mysql_query("UPDATE users SET raiting='20' WHERE id='$isus'",$db);
                }else{
                    $query = mysql_query("UPDATE users SET raiting='10' WHERE id='$isus'",$db);
                }
            }
            $query = @mysql_query("SELECT * FROM ban WHERE iduser='$isus'",$db);
            $ban = @mysql_fetch_array($query);
            do{
                if($ban){
                if($ban["time"]<$tim){
                    $query = mysql_query("DELETE FROM ban WHERE iduser='$isus' AND time<'$tim'",$db);
                }
                }
            }
            while($ban = @mysql_fetch_array($query));
            $bancol = @mysql_query("SELECT * FROM ban WHERE iduser='$isus'",$db);
            $bancol = mysql_num_rows($bancol);
            if($bancol==0){
                    $bancol="";
            }
            $query = mysql_query("UPDATE users SET ban='$bancol' WHERE id='$isus'",$db);
            
            $query = @mysql_query("SELECT * FROM vip WHERE iduser='$isus'",$db);
            $vip = @mysql_fetch_array($query);
            if($vip){
                if($vip["time"]<$tim){
                    $query = mysql_query("DELETE FROM vip WHERE iduser='$isus'",$db);
                    $query = mysql_query("UPDATE trade SET vip='0' WHERE name='$nameus'",$db);
                    $query = mysql_query("UPDATE users SET priority='normal' , activetrade='5' WHERE id='$isus'",$db);
                    $query = mysql_query("UPDATE users SET raiting='10' WHERE id='$isus'",$db);
                }
            }
            $query = mysql_query("DELETE FROM usertoday",$db);
        }
    }
    while($obn = @mysql_fetch_array($que));
?>