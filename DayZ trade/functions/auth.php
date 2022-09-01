<?php 
session_start();
if($_COOKIE["lang"]){
    if($_COOKIE["lang"]=="ru"){
        include("../lang/ru.php");
    }
    if($_COOKIE["lang"]=="eng"){
        include("../lang/eng.php");
    }
}else{
    setcookie("lang", "eng",time()+15000000);
    include("../lang/eng.php");
}

if($_SESSION['login']){
    $_SESSION['soob']=$lang['soob1'];
    header("Location: /");
    exit();
}

$app_id = "5464510";
$sec_key= "JbYC8LodtLvx09tsW5YN";
$myurl = "http://dayztrade.ru/functions/auth.php";
$urlauth = "https://oauth.vk.com/authorize";
$urltoken = "https://oauth.vk.com/access_token";
$urlmethod = "https://api.vk.com/method/users.get";

function redirect($url){
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: ".$url, TRUE, 302);
    exit();
}

function getCurlData($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}

if(!$_GET["code"]){
    $query = "client_id=".$app_id."&display=page&redirect_uri=".$myurl."&scope=offline,email";
    redirect($urlauth."?".$query);
}

if($_GET["code"]){
    $code = $_GET["code"];
    
    $query = "client_id=".$app_id."&client_secret=".$sec_key."&code=".$code."&redirect_uri=".$myurl;
    $result = getCurlData($urltoken."?".$query);
    $objtoken = json_decode($result);
    $vktoken = $objtoken -> access_token;
    $vkiduser = $objtoken -> user_id;
    $vkemail = $objtoken -> email;
    $vkerror = $objtoken -> error;
    echo $vktoken;
    if($vkerror){
        $_SESSION['soob']=$lang['soob2'];
        header("Location: /registration");
        exit();
    }
    if($vktoken){
        $query = "user_id=".$vkiduser."&v=5.8&fields=first_name,last_name,photo_max_orig&access_token=".$vktoken;
        $result2 = getCurlData($urlmethod."?".$query);
        if($result2){
            $_SESSION['vkauth']=$result2;
            $_SESSION['vkemail']=$vkemail;
            header("Location: /registration");
            exit();
        }else{
            $_SESSION['soob']=$lang['soob2'];
            header("Location: /registration");
            exit();
        }
    }else{
        $_SESSION['soob']=$lang['soob3'];
        header("Location: /registration");
        exit();
    }
    

}

?>