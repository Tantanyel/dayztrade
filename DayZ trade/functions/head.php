<?php 
if($_COOKIE["lang"]){
    if($_COOKIE["lang"]=="ru"){
        include("lang/ru.php");
    }
    if($_COOKIE["lang"]=="eng"){
        include("lang/eng.php");
    }
}else{
    $yip=$_SERVER["REMOTE_ADDR"];
    $country = geoip_country_code3_by_name($yip);
    if ($country=="RUS"||$country=="UKR"||$country=="BLR") {
        setcookie("lang", "ru",time()+15000000);
        include("lang/ru.php");
    }else{
        setcookie("lang", "eng",time()+15000000);
        include("lang/eng.php");
    }
}
echo '
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <title>'.$lang['namesite'].'</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css" />
    <link rel="stylesheet" href="css/material.css" />
    <script src="libs/jquery/jquery-1.11.1.min.js"></script>
    <script src="js/langjs.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="libs/owl-carousel/owl.carousel.css" />
    <script src="libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="libs/materialcircle/materialcircle.js"></script>
    <script src="libs/device/device.js"></script>
    
    <meta name="MobileOptimized" content="400"/>
    
    <link rel="alternate" hreflang="ru" href="http://dayztrade.ru/" />
    <meta name="description" content="'.$lang['description'].'" />
</head>
';
?>