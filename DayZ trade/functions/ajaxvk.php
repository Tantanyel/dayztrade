<?php
session_start();
include("connect.php");

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

if($_POST["id"]){
    $idvk = $_POST["id"];
    $query = mysql_query("UPDATE users SET notivk='$idvk' WHERE id='$myid'",$db);
    $mes = "Здраствуйте!\n Вы подписались на уведомления вконтакте.\n Отписаться от уведомлений вы можете в настройках профиля по ссылке: dayztrade.ru/editprofile";
    sendmes($idvk,$mes);
    echo "ok";
}

if($_POST["idd"]){
    $idvk = $_POST["id"];
    $query = mysql_query("UPDATE users SET notivk='0' WHERE id='$myid'",$db);
    echo "ok";
}

?>