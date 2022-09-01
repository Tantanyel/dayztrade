<?php
session_start();
include("../functions/connect.php");
include("../functions/mail.php");
function repl($str){
    $healthy = array("\"", "\'");
    $yummy   = array("", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
$myid;
$mydataprofile;
if($_SESSION['login']){
    $provarr = explode(",", $_SESSION['login']);
    $provlogin = repl($provarr[0]);
    $provpassword = repl($provarr[1]);
	$myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$provlogin' AND password='$provpassword'",$db));
    if($myrow["priority"]=="admin"){
        $myid = repl($myrow["id"]);
        $query = @mysql_query("SELECT * FROM users WHERE id='$myid'",$db);
        $mydataprofile = @mysql_fetch_array($query);
    }else{
        unset($_SESSION['login']);
        $_SESSION['soob']="Нет доступа.";
        header("Location: /");
        exit();
    }
}else{
    if($_COOKIE["log"]){
        $_SESSION['login']=$_COOKIE["log"];
        header("Location: /super");
        exit();
    }
}
function typerus ($type){
$ret;
if($type=="weapon"){
$ret="Оружие";
}
if($type=="amunition"){
$ret="Снаряжение";
}
if($type=="food"){
$ret="Еда";
}
if($type=="ammo"){
$ret="Боеприпасы";
}
if($type=="clothes"){
$ret="Одежда";
}
if($type=="transport"){
$ret="Транспорт";
}
if($type=="modules"){
$ret="Модули";
}
if($type=="medicines"){
$ret="Медицина";
}
if($type=="other"){
$ret="Прочее";
}
return $ret;
}

if($_GET["pol"]){
    $pol = repl($_GET["pol"]);
}

if(isset($_POST["dobavitem"])){
    $nameitem = repl($_POST["nameitem"]);
    $typeitem = repl($_POST["typeitem"]);
    if($_FILES["itemimg"]["tmp_name"]){
        if($nameitem!=""){
            $uploads_dir = 'itemimg';
            $img = $_FILES["itemimg"]["name"];
            $avasizebit = filesize($_FILES["itemimg"]["tmp_name"]);
            $info = new SplFileInfo($img);
            $info = $info->getExtension();
            $avasize = getimagesize ($_FILES["itemimg"]["tmp_name"]);
            $info = strtolower($info);
            if($avasize[0]==$avasize[1]&&$avasizebit<1000000&&$info=="png"){
                $query = mysql_query("INSERT INTO items VALUES('','','$nameitem','$typeitem','0')",$db);
                $myit = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE name='$nameitem'",$db));
                move_uploaded_file($_FILES["itemimg"]["tmp_name"],"../".$uploads_dir."/".$myit['id'].'.png');
                $img = $uploads_dir."/".$myit['id'].'.png';
                $idp = $myit['id'];
                $query = mysql_query("UPDATE items SET img='$img' WHERE id='$idp'",$db);
                $_SESSION['soob'] = "Предмет добавлен.";
                header("Location: /super");
                exit();
            }else{
                $_SESSION['soob'] = "Ошибка. Картинка должна быть квадратной и в формате PNG. Размер — не более 1 Мб.";
                header("Location: /super");
                exit();
            }
        }else{
            $_SESSION['soob'] = "Ошибка. Введите название предмета.";
            header("Location: /super");
            exit();
        }
    }else{
        $_SESSION['soob'] = "Ошибка. Картинка не выбрана.";
        header("Location: /super");
        exit();
    }
}

if(isset($_POST["izmitem"])){
    $iditem = repl($_POST["iditem"]); 
    $nameitem = repl($_POST["nameitem"]);
    $typeitem = repl($_POST["typeitem"]);
    if($_FILES["itemimg"]["tmp_name"]){
            $uploads_dir = 'itemimg';
            $img = $_FILES["itemimg"]["name"];
            $avasizebit = filesize($_FILES["itemimg"]["tmp_name"]);
            $info = new SplFileInfo($img);
            $info = $info->getExtension();
            $avasize = getimagesize ($_FILES["itemimg"]["tmp_name"]);
            if($avasize[0]==$avasize[1]&&$avasizebit<1000000&&$info=="png"){
                move_uploaded_file($_FILES["itemimg"]["tmp_name"],"../".$uploads_dir."/".$iditem.'.png');
                $img = $uploads_dir."/".$iditem.'.png';
                $query = mysql_query("UPDATE items SET img='$img' WHERE id='$iditem'",$db);
                $_SESSION['soob'] = "Предмет изменен.";
            }else{
                $_SESSION['soob'] = "Ошибка. Картинка должна быть квадратной и в формате PNG. Размер — не более 1 Мб.";
                header("Location: /super");
                exit();
            }
    }
    if($nameitem){
        $nameold = @mysql_fetch_array(@mysql_query("SELECT name FROM items WHERE id='$iditem'",$db));
        $nameold = $nameold["name"];
        $query = @mysql_query("SELECT * FROM trade WHERE ot LIKE '%$nameold%' OR na LIKE '%$nameold%'",$db);
        $num = mysql_num_rows($query);
        $iz = @mysql_fetch_array($query);
            do{
                if($iz){
                    $idtrad = $iz["id"];
                    $textot = $iz["ot"];
                    $textna = $iz["na"];
                    $newot = str_replace($nameold, $nameitem, $textot);
                    $newna = str_replace($nameold, $nameitem, $textna);
                    $query = mysql_query("UPDATE trade SET ot='$newot', na='$newna' WHERE id='$idtrad'",$db);
                }
            }
        while($iz = @mysql_fetch_array($query));
        
        $query = mysql_query("UPDATE items SET name='$nameitem', type='$typeitem' WHERE id='$iditem'",$db);
        $_SESSION['soob'] = "Предмет изменен.";
    }
    header("Location: /super");
    exit();
}

if(isset($_POST["avip"])){
    $idp = repl($_POST["idpol"]);
    $name = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$idp'",$db));
    $name = $name["name"];
    $times = time()+2500000;
    $query = mysql_query("UPDATE trade SET vip='1' WHERE name='$name'",$db);
    $query = mysql_query("UPDATE users SET priority='vip',activetrade='30',raiting='20' WHERE id='$idp'",$db);
    $query = mysql_query("INSERT INTO vip VALUES('$idp','$times')",$db);
    $_SESSION['soob'] = "Пользователю ".$name." добавлен VIP статус.";
    header("Location: /super/?pol=".$pol);
    exit();
}
if(isset($_POST["rvip"])){
    $idp = repl($_POST["idpol"]);
    $name = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$idp'",$db));
    $name = $name["name"];
    $query = mysql_query("UPDATE trade SET vip='0' WHERE name='$name'",$db);
    $query = mysql_query("UPDATE users SET priority='normal' , activetrade='5',raiting='10' WHERE id='$idp'",$db);
    $query = mysql_query("DELETE FROM vip WHERE iduser='$idp'",$db);
    $_SESSION['soob'] = "У пользователя ".$name." удален VIP статус.";
    header("Location: /super/?pol=".$pol);
    exit();
}
if(isset($_POST["pred"])){
    $idp = repl($_POST["idpol"]);
    $textban = repl($_POST["text"]);
    $row = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE id='$idp'",$db));
    $name = $row["name"];
    $ban = $row["ban"];
    $days = repl($_POST["days"]);
    if($days==""||$days==0){
        $days=30;
    }
    $times = time()+$days*86400;
    if($ban!=3){
        $ban=$ban+1;
        $query = mysql_query("UPDATE users SET ban='$ban' WHERE id='$idp'",$db);
        $query = mysql_query("INSERT INTO ban VALUES('','$idp','$times','$textban')",$db);
        $rat = mysql_query("SELECT * FROM raitingtoday WHERE kto='$idp'",$db);
        $myrow = @mysql_fetch_array($rat);
        do{
            if($myrow){
                $idraiting = $myrow["id"];
                $query = mysql_query("DELETE FROM raitingtoday WHERE id='$idraiting'",$db);
                $query = mysql_query("DELETE FROM raiting WHERE id='$idraiting'",$db);
                $idop = $myrow["komy"];
                $top = mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='like'",$db);
                $likecol = mysql_num_rows($top);
                $top = mysql_query("SELECT raiting FROM raiting WHERE komy='$idop' AND raiting='dislike'",$db);
                $dislikecol = mysql_num_rows($top);
                $top = $likecol-$dislikecol;
                $query = mysql_query("UPDATE users SET top='$top' WHERE id='$idop'",$db);
            }
        }
        while($myrow = @mysql_fetch_array($rat));
        $_SESSION['soob'] = "Пользавателю ".$name." добавленно 1 предупреждение.";
        header("Location: /super/?pol=".$pol);
        exit();
    }else{
        $query = mysql_query("UPDATE users SET ban='ban' WHERE id='$idp'",$db);
        $query = mysql_query("DELETE FROM ban WHERE iduser='$idp'",$db);
        $query = mysql_query("DELETE FROM trade WHERE name='$name'",$db);
        $query = mysql_query("UPDATE users SET priority='normal', activetrade='0' WHERE id='$idp'",$db);
        $query = mysql_query("UPDATE trade SET vip='0' WHERE name='$name'",$db);
        $query = mysql_query("DELETE FROM vip WHERE iduser='$idp'",$db);
        $_SESSION['soob'] = "У пользавателя ".$name." больше 3 предупреждений, он получает бан.";
        header("Location: /super/?pol=".$pol);
        exit();
    }
}

if(isset($_POST["aban"])){
    $idp = repl($_POST["idpol"]);
    $row = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE id='$idp'",$db));
    $name = $row["name"];
    $query = mysql_query("UPDATE users SET ban='ban' WHERE id='$idp'",$db);
    $query = mysql_query("DELETE FROM ban WHERE iduser='$idp'",$db);
    $query = mysql_query("DELETE FROM trade WHERE name='$name'",$db);
    $query = mysql_query("DELETE FROM vip WHERE iduser='$idp'",$db);
    $query = mysql_query("UPDATE users SET priority='normal', activetrade='0',raiting='0' WHERE id='$idp'",$db);
    $query = mysql_query("UPDATE trade SET vip='0' WHERE name='$name'",$db);
    $_SESSION['soob'] = "Пользователь ".$name." заблокирован.";
    header("Location: /super/?pol=".$pol);
    exit();
}

if(isset($_POST["rban"])){
    $idp = repl($_POST["idpol"]);
    $row = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE id='$idp'",$db));
    $name = $row["name"];
    $query = mysql_query("UPDATE users SET ban='' WHERE id='$idp'",$db);
    $query = mysql_query("UPDATE users SET priority='normal', activetrade='5' WHERE id='$idp'",$db);
    $_SESSION['soob'] = "Пользователю ".$name." убрана блокировка.";
    header("Location: /super/?pol=".$pol);
    exit();
}

if(isset($_POST["delitem"])){
    $idit = repl($_POST["idit"]);
    $row = @mysql_fetch_array(@mysql_query("SELECT * FROM items WHERE id='$idit'",$db));
    $nameit = $row["name"];
    $query =@mysql_query("SELECT * FROM trade WHERE ot LIKE '%$nameit%' OR na LIKE '%$nameit%'",$db);
    $del = @mysql_fetch_array($query);
        do{
            if($del){
                $itarrc = $del["cont"];
                $itarr = explode("|", $itarrc);
                $otp1 = repl($itarr[0]);
                $otp2 = repl($itarr[1]);
                $otp1 = explode(",", $otp1);
                $otp2 = explode(",", $otp2);
                for ($i = 0; $i < count($otp1); $i++) {
                    $sit = explode("_", $otp1[$i]);
                    $sit[0] = (int)$sit[0];
                    $idit = $sit[0];
                    $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
                    $bobm = $bobm["obm"]-1;
                    $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
                }
                for ($i = 0; $i < count($otp2); $i++) {
                    $sit = explode("_", $otp2[$i]);
                    $sit[0] = (int)$sit[0];
                    $idit = $sit[0];
                    $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
                    $bobm = $bobm["obm"]-1;
                    $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
                }
            }
        }
    while($del = @mysql_fetch_array($query));
    $query = mysql_query("DELETE FROM items WHERE id='$idit'",$db);
    $_SESSION['soob'] = "Предмет #".$idit." удален.";
    header("Location: /super");
    exit();
}

?>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Управление сайтом</title>
        <link rel="shortcut icon" href="../img/favicon.png">
        <script src="../libs/jquery/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" href="../css/material.css" />
        <script src="super.js"></script>
        <link rel="stylesheet" href="super.css">
        <script src="../libs/materialcircle/materialcircle.js"></script>
    </head>

    <body>
        <?php
        if(!$_SESSION['soob']==""){
        echo '
        <div id="soob">
        <span>'.$_SESSION['soob'].'</span>
        </div>
        ';
        $_SESSION['soob']="";
        }
       ?>
            <div class="head">
                <a href="/" class="logo"><img src="../img/logo.png"></a>
            </div>

            <div class="okno dobav">
                <div class="cont">
                    <h2>Добавление предмета</h2>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <div class="file">
                            <img id="preview" src="img/nofile.jpg">
                            <img class="hoverimg" src="img/upload.png">
                            <input name="itemimg" id="imagefile" onchange="filechange()" type="file">
                        </div>
                        <div class="input normalinput">
                            <input name="nameitem" type="text" value="">
                            <span>Название предмета</span>
                            <div class="line"><i></i></div>
                        </div>
                        <div class="input-field sel">
                            <select name="typeitem">
                                <option value="weapon">Оружие</option>
                                <option value="amunition">Снаряжение</option>
                                <option value="food">Еда</option>
                                <option value="ammo">Боеприпасы</option>
                                <option value="clothes">Одежда</option>
                                <option value="transport">Транспорт</option>
                                <option value="modules">Модули</option>
                                <option value="medicines">Медицина</option>
                                <option value="other">Прочее</option>
                            </select>
                        </div>
                        <div class="but">
                            <a onclick="oknoopn('.dobav')" class="button-flat">Отмена</a>
                            <input name="dobavitem" type="submit" class="button-flat" value="Добавить" materialcircle="block,#607d8b">
                        </div>
                    </form>
                </div>
            </div>

            <div class="okno izm">
                <div class="cont">
                    <h2>Изменение предмета</h2>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <div class="file">
                            <img id="preview2" src="img/nofile.jpg">
                            <img class="hoverimg" src="img/upload.png">
                            <input name="itemimg" id="imagefile2" onchange="filechange2()" type="file">
                        </div>
                        <div class="prid">
                            <input name="iditem" type="text" value="" readonly>
                        </div>
                        <div class="input normalinput">
                            <input name="nameitem" type="text" value="">
                            <span>Название предмета</span>
                            <div class="line"><i></i></div>
                        </div>
                        <div class="input-field sel">
                            <select name="typeitem">
                                <option value="weapon">Оружие</option>
                                <option value="amunition">Снаряжение</option>
                                <option value="food">Еда</option>
                                <option value="ammo">Боеприпасы</option>
                                <option value="clothes">Одежда</option>
                                <option value="transport">Транспорт</option>
                                <option value="modules">Модули</option>
                                <option value="medicines">Медицина</option>
                                <option value="other">Прочее</option>
                            </select>
                        </div>
                        <div class="but">
                            <a onclick="oknoopn('.izm')" class="button-flat">Отмена</a>
                            <input name="izmitem" type="submit" class="button-flat" value="Изменить" materialcircle="block,#607d8b">
                        </div>
                    </form>
                </div>
            </div>

            <div class="zalobai">
                <form action="index.php" method="post">
                    <h3>Дать предупреждение</h3>
                    <input name="idpol" type="text" value="0" readonly class="hid">
                    <textarea name="text" placeholder="Причина предупреждения"></textarea>
                    <input name="days" type="number" placeholder="На сколько дней? (По умолчанию 30 дней)" class="days">
                    <div class="knopki">
                        <a class="button-flat" onclick="closezalob();" materialcircle="block,light">Закрыть</a>
                        <input name="pred" type="submit" class="button-flat" value="Отправить" materialcircle="block,night">
                    </div>
                </form>
            </div>

            <div class="center">
                
                <div class="blmin">
                   <div class="paneladmin">
                    <?php 
                    $rowr = @mysql_query("SELECT id FROM users",$db);
                    $usercol = mysql_num_rows($rowr);
                    if($usercol){
                        echo'<span>Зарегестрированно пользавателей: '.$usercol.'</span>';
                    }
                    $rowc = @mysql_query("SELECT id FROM usertoday",$db);
                    $usertoday = mysql_num_rows($rowc); 
                    if($usertoday){
                        echo'<span>Уникальных пользавателей сегодня: '.$usertoday.'</span>';
                    }else{
                        echo'<span>Уникальных пользавателей сегодня: 0</span>';
                    }
                    ?>
                    </div>
                </div>
                
                <div class="bl">
                    <div class="searchpredm">
                        <div class="input normalinput">
                            <input name="" type="text" value="" onkeyup="filtertradeinp(this)">
                            <span>Поиск по названию предмета</span>
                            <div class="line"><i></i></div>
                        </div>
                        <a onclick="oknoopn('.dobav')" class="button-flat" materialcircle="block,#607d8b">Добавить</a>
                    </div>
                    <div class="items">
                        <?php
                    $query =@mysql_query("SELECT * FROM items ORDER BY id DESC",$db);
                    $itm = @mysql_fetch_array($query);
                    do{
                        if($itm){
                            echo '
                            <div class="item" num="'.$itm["id"].'">
                            <img src="../'.$itm["img"].'">
                            <div class="nameit">
                            <p title="'.$itm["name"].'">'.$itm["name"].'</p>
                            <span>'.typerus($itm["type"]).'</span>
                            <a onclick="izmen(this)" class="button-flat" materialcircle="block,#607d8b">Изменить</a>
                            <form action="index.php" method="post">
                            <input name="idit" type="text" class="hid" value="'.$itm["id"].'" readonly>
                            <input name="delitem" type="submit" class="delitem" value="" materialcircle="icon,night">
                            </form>
                            </div>
                            </div>
                            ';
                        }
                    }
                    while($itm = @mysql_fetch_array($query));
                    ?>
                    </div>
                </div>

                <div class="bl">

                    <form class="searchpol" action="/super" method="get">
                        <div class="input normalinput">
                            <input name="pol" type="text" value="<?php echo $pol; ?>">
                            <span>Поиск по имени пользователя или почте</span>
                            <div class="line"><i></i></div>
                        </div>
                        <input type="submit" class="button-flat" value="Найти" materialcircle="block,#607d8b">
                    </form>

                    <div class="users">
                        <?php
                $query = @mysql_query("SELECT * FROM users WHERE name LIKE '%$pol%' OR email LIKE '%$pol%'",$db);
                $myrow = @mysql_fetch_array($query);
                do{
                if($myrow&&$pol){
                    $namep = repl($myrow["name"]);
                    $idop = repl($myrow["id"]);
                    $vip;
                    $pred;
                    $ban;
                    if($myrow["priority"]=="vip"){
                        $vip = '<input name="rvip" type="submit" class="button-flat" value="- vip" materialcircle="block,#607d8b">';
                    }else{
                        $vip = '<input name="avip" type="submit" class="button-flat" value="+ vip" materialcircle="block,#607d8b">';
                    }
                    if($myrow["ban"]!="ban"){
                        $pred = '<a class="button-flat" onclick="numid('.$idop.')" materialcircle="block,#607d8b">Предупреждение</a>';
                        $ban = '<input name="aban" type="submit" class="button-flat" value="+ бан" materialcircle="block,#607d8b">';
                    }else{
                        $ban = '<input name="rban" type="submit" class="button-flat" value="- бан" materialcircle="block,#607d8b">';
                    }
                    if($myrow["priority"]=="admin"){
                        $vip="";
                        $pred="";
                        $ban="";
                    }
                    echo'
                    <div class="user">
                    <div class="ava">
                        <img src="../'.$myrow["ava"].'">
                    </div>
                    <div class="infouser">
                        <a href="../profile?p='.$namep.'">'.$namep.'</a>
                        <span>'.$myrow["email"].'</span>
                    </div>
                    <div class="btnuser">
                        <form action="index?pol='.$pol.'" method="post">
                            <input name="idpol" type="text" class="hid" value="'.$idop.'" readonly>
                            '.$vip.$pred.$ban.'
                        </form>
                    </div>
                    </div>
                    ';
                    }
                }
                while($myrow = @mysql_fetch_array($query));
                ?>
                    </div>

                </div>

                <div class="bl">
                    <div class="zalobi">
                        <?php
                    $query =@mysql_query("SELECT * FROM zaloba ORDER BY id DESC",$db);
                    $zal = @mysql_fetch_array($query);
                    do{
                        if($zal){
                            $na = $zal["name"];
                            $ot = $zal["ot"];
                            $myrow = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$na'",$db));
                            $na = $myrow["name"];
                            $myrow = @mysql_fetch_array(@mysql_query("SELECT name FROM users WHERE id='$ot'",$db));
                            $ot = $myrow["name"];
                            echo '
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
                    ?>
                    </div>
                </div>

            </div>

    </body>

    </html>
