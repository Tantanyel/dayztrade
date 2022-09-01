<?php
session_start();
include("connect.php");
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
$yip=$_SERVER["REMOTE_ADDR"];
$usip = @mysql_fetch_array(@mysql_query("SELECT * FROM usertoday WHERE userip='$yip'",$db));
if(!$usip){
    $query = mysql_query("INSERT INTO usertoday VALUES('','$yip')",$db);
}

if(isset($_POST["rulang"])){
    setcookie("lang", "ru",time()+15000000);
    header("Location: /");
}
if(isset($_POST["englang"])){
    setcookie("lang", "eng",time()+15000000);
    header("Location: /");
}


$myid;
$mydataprofile;
if($_SESSION['login']){
    $provarr = explode(",", $_SESSION['login']);
    $provlogin = repl($provarr[0]);
    $provpassword = repl($provarr[1]);
	$myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$provlogin' AND password='$provpassword'",$db));
    if($myrow){
        $myid = repl($myrow["id"]);
        $query = @mysql_query("SELECT * FROM users WHERE id='$myid'",$db);
        $mydataprofile = @mysql_fetch_array($query);
    }else{
        unset($_SESSION['login']);
        setcookie("log", "");
        $_SESSION['soob']=$lang['soob1'];
        header("Location: /registration");
    }
}else{
    if($_COOKIE["log"]){
        $_SESSION['login']=$_COOKIE["log"];
        header("Location: /");
    }
}
?>
    <div class="zagl">
        <img src="img/logo2.png">
        <span><?php echo $lang['mobile']; ?></span>
    </div>
    <div id="menu" 
    <?php
    if($_COOKIE["lang"]=="ru"){
        echo 'lang="ru"';
    }else{
        if($_COOKIE["lang"]=="eng"){
        echo 'lang="eng"';
        }else{
            echo 'lang="ru"';
        }
    }
    ?>  
    >
        <fon onclick="closemen();"></fon>
        <div class="menuhor">
            <div class="pofile">
               <a class="langr" onclick="openlang()"><?php echo $lang['lang']; ?></a>
                <?php if(!$mydataprofile){echo '<a href="registration" class="button" materialcircle="block,night">'.$lang['comein'].'</a>';} ?>
                    <?php if($mydataprofile){
                echo '
                <div class="ostlike"><img src="img/ost_tumb.png"><span>'.$lang['leav'].''.$mydataprofile["raiting"].'</span></div>
                <a href="profile?p='.$mydataprofile['name'].'" class="menuprofile">
                <div class="ava"><img src="'.$mydataprofile["ava"].'"></div>
                <span>'.$mydataprofile["name"].'</span>
                <a href="profile?p='.$mydataprofile['name'].'" class="button-flat" materialcircle="block,light">'.$lang['profile'].'</a>
                <a href="registration?exit=exit" class="button-flat" materialcircle="block,light">'.$lang['exit'].'</a>
                </a>
                ';} ?>
            </div>
            <div class="menupunct">
                <?php if($mydataprofile){
                    if($mydataprofile["priority"]=="admin"){
                        echo '<a href="/super" class="punct" materialcircle="block,#607d8b"><span id="img6"></span>Управление сайтом</a>';
                    }
                    if($mydataprofile["info"]!=""&&$mydataprofile["info"]!=",,,,,"&&$mydataprofile["priority"]!="noemail"&&$mydataprofile["ban"]!="ban"&&$mydataprofile["priority"]!="emailreplace"){
                        echo '<a href="createtrade" class="punct" materialcircle="block,#607d8b"><span id="img1"></span>'.$lang['addtrade'].'</a>';
                    }
                echo '<a href="favorites" class="punct" materialcircle="block,#607d8b"><span id="img2"></span>'.$lang['fovtrade'].'</a>';} ?>
                    <a href="faq" class="punct" materialcircle="block,#607d8b"><span id="img3"></span>F.A.Q</a>
                    <a href="rules" class="punct" materialcircle="block,#607d8b"><span id="img4"></span><?php echo $lang['rulesmenu']; ?></a>
                    <a href="donate" class="punct" materialcircle="block,#607d8b"><span id="img5"></span><?php echo $lang['donate']; ?></a>
                    <a href="https://vk.com/dayzoneru" target="_blank" class="punct" materialcircle="block,#607d8b"><span id="img7"></span><?php echo $lang['dayzone']; ?></a>
            </div>
        </div>
        <div class="footer">
                <span onclick="gomopen();">DayZ Trade © 2016 Polimer</span>
                <a href="http://polimerstudios.ru" target="_blank"><img src="img/polimer.png"></a>
                <a href="http://vk.com/dayzstandalone" target="_blank"><img src="img/vk.png"></a>
                <a href="http://twitter.com/DayZTradeRu" target="_blank"><img src="img/tw.png"></a>
            </div>
    </div>

    <div class="head">
        <a href="/" class="logo"><img src="img/logo.png"></a>
        <div class="btnmenu" onclick="closemen();"><img src="img/menu.png"></div>
        <div class="search">
            <form action="search" method="get">
                <input name="ot" type="text" placeholder="<?php echo $lang['search']; ?>" autocomplete="off">
                <line>
                    <hov></hov>
                </line>
                <img src="img/close.png" class="closeimg">
                <input type="submit" class="searchimg" value="">
                <div class="closebtn"></div>
            </form>
        </div>
    </div>