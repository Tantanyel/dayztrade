<?php
include("connect.php");
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
if($_POST["idop"]){
$idop = repl($_POST["idop"]);
$q = @mysql_query("SELECT id FROM users WHERE name='$idop'",$db);
$m = @mysql_fetch_array($q);
$idop = repl($m["id"]);
$query = @mysql_query("SELECT * FROM raiting WHERE komy='$idop' ORDER BY id DESC",$db);
$myrow = @mysql_fetch_array($query);
    do{
        $idkto = $myrow['kto'];
        $q = @mysql_query("SELECT name FROM users WHERE id='$idkto'",$db);
        $m = @mysql_fetch_array($q);
        $namep = $m["name"];
        $html=$html.'
        <div class="info">
            <div class="icon"><img src="img/'.$myrow['raiting'].'.png"></div>
            <a href="profile?p='.$namep.'">'.$namep.'</a>
            <p>'.$myrow['data'].'</p>
        </div>
        '; 
        }
        while($myrow = @mysql_fetch_array($query));
        echo $html;
}
?>