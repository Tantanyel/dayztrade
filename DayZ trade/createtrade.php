<?php
session_start();
include("functions/connect.php");
?>
<html>
<?php include("functions/head.php");?>

<body>
<?php
    
function repl1($str){
    $healthy = array("\"", "'", "|", ">", "<");
    $yummy   = array("&#34;", "&#39;", "&#124;", "", "");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
    
if(!$_SESSION['soob']==""){
    echo '
    <div id="soob">
    <span>'.$_SESSION['soob'].'</span>
    </div>
    ';
    $_SESSION['soob']="";
}
include("functions/menu.php");
    
if($_SESSION['login']){
    if($mydataprofile["info"]!=""&&$mydataprofile["info"]!=",,,,,"&&$mydataprofile["priority"]!="noemail"&&$mydataprofile["ban"]!="banned"){
        $name = repl($mydataprofile["name"]);
        $rowc = @mysql_query("SELECT id FROM trade WHERE name='$name' AND stat='active'",$db);
        $actrade = mysql_num_rows($rowc);
        $rowc = @mysql_query("SELECT id FROM trade WHERE name='$name'",$db);
        $trade = mysql_num_rows($rowc);
        if($trade<$mydataprofile["trade"]){
            if($actrade<$mydataprofile["activetrade"]){
            }else{
                $_SESSION['soob']=$lang['soob5'];
                header("Location: /profile?p=".$mydataprofile["name"]);
            }
        }else{
            $_SESSION['soob']=$lang['soob6'];
            header("Location: /profile?p=".$mydataprofile["name"]);
        }
    }else{
        $_SESSION['soob']=$lang['soob7'];
        header("Location: /profile?p=".$mydataprofile["name"]);
    }
}else{
    $_SESSION['soob']=$lang['soob8'];
    header("Location: /registration");
}
    
    
if(isset($_POST["subtrade"])){
    $itarr = explode("|", $_POST["data"]);
    $otp1 = repl($itarr[0]);
    $otp2 = repl($itarr[1]);
    $otp1 = explode(",", $otp1);
    $otp2 = explode(",", $otp2);
    $otp1name;
    $otp2name;
    if($otp1[0]!=""&&$otp2[0]!=""){
        for ($i = 0; $i < count($otp1); $i++) {
            $sit = explode("_", $otp1[$i]);
            $sit[0] = (int)$sit[0];
            $sit[1] = (int)$sit[1];
            $otp1[$i] = $sit[0]."_".$sit[1];
            $idit = $sit[0];
            $nameit = @mysql_fetch_array(@mysql_query("SELECT name FROM items WHERE id='$idit'",$db));
            $nameit = $nameit["name"];
            $otp1name = $otp1name." ".$nameit;
            $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
            $bobm = $bobm["obm"]+1;
            $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
        }
        for ($i = 0; $i < count($otp2); $i++) {
            $sit = explode("_", $otp2[$i]);
            $sit[0] = (int)$sit[0];
            $sit[1] = (int)$sit[1];
            $otp2[$i] = $sit[0]."_".$sit[1];
            $idit = $sit[0];
            $nameit = @mysql_fetch_array(@mysql_query("SELECT name FROM items WHERE id='$idit'",$db));
            $nameit = $nameit["name"];
            $otp2name = $otp2name." ".$nameit;
            $bobm = @mysql_fetch_array(@mysql_query("SELECT obm FROM items WHERE id='$idit'",$db));
            $bobm = $bobm["obm"]+1;
            $query = mysql_query("UPDATE items SET obm='$bobm' WHERE id='$idit'",$db);
        }
        if(count($otp1)<=7&&count($otp2)<=7){
            $otp1 = implode(",", $otp1);
            $otp2 = implode(",", $otp2);
            $itarr = $otp1."|".$otp2;
            $name = repl($mydataprofile["name"]);
            $opis = repl1($_POST["opis"]);
            $serv = repl1($_POST["serv"]);
            $vip = 0;
            if($mydataprofile["priority"]=="vip"||$mydataprofile["priority"]=="admin"){
                $vip = 1;
            }
            $datatrade = date("d.m.Y");
            $query = mysql_query("INSERT INTO trade VALUES('','$name','$itarr','$otp1name','$otp2name','$opis','$serv','$datatrade','active','$vip')",$db);
            $_SESSION['soob']=$lang['soob9'];
            header("Location: /profile?p=".$mydataprofile["name"]);
        }else{
            $_SESSION['soob']=$lang['soob10'];
            header("Location: /createtrade");
        }
    }else{
        $_SESSION['soob']=$lang['soob11'];
        header("Location: /createtrade");
    }
}
    

?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['addtrade']; ?></h2>
        <div class="dobpredl">
            <div class="finditems">
                <div class="filtertrade">
                    <div class="input normalinput">
                        <input type="text" value="" onkeyup="filtertradeinp(this)">
                        <span><?php echo $lang['searchitem']; ?></span>
                        <div class="line"><i></i></div>
                    </div>
                    <div class="checkfilter">
                        <div class="checkbox">
                            <input onclick="filtertrade('weapon');" type="checkbox" class="filled-in" id="weapon" />
                            <label for="weapon"><?php echo $lang['weapon']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('amunition');" type="checkbox" class="filled-in" id="amunition" />
                            <label for="amunition"><?php echo $lang['amunition']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('food');" type="checkbox" class="filled-in" id="food" />
                            <label for="food"><?php echo $lang['food']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('ammo');" type="checkbox" class="filled-in" id="ammo" />
                            <label for="ammo"><?php echo $lang['ammo']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('clothes');" type="checkbox" class="filled-in" id="clothes" />
                            <label for="clothes"><?php echo $lang['clothes']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('transport');" type="checkbox" class="filled-in" id="transport" />
                            <label for="transport"><?php echo $lang['transport']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('modules');" type="checkbox" class="filled-in" id="modules" />
                            <label for="modules"><?php echo $lang['modules']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('medicines');" type="checkbox" class="filled-in" id="medicines" />
                            <label for="medicines"><?php echo $lang['medicines']; ?></label>
                        </div>
                        <div class="checkbox">
                            <input onclick="filtertrade('other');" type="checkbox" class="filled-in" id="other" />
                            <label for="other"><?php echo $lang['other']; ?></label>
                        </div>
                    </div>
                </div>
                <div class="resultfilter">
                    <?php
                    $query =@mysql_query("SELECT * FROM items ORDER BY type",$db);
                    $itm = @mysql_fetch_array($query);
                    do{
                        if($itm){
                            echo '
                            <div class="filteritem '.$itm["type"].'" num="'.$itm["id"].'">
                            <img src="'.$itm["img"].'">
                            <span title="'.$itm["name"].'">'.$itm["name"].'</span>
                            <a>'.$lang[$it["type"]].'</a>
                            </div>
                            ';
                        }
                    }
                    while($itm = @mysql_fetch_array($query));
                    ?>
                </div>
            </div>

            <div class="otpravkatrade">
                <div class="itemotpravka" id="otpr1">
                    <div class="zagotpravka">
                        <span><?php echo $lang['itemgive']; ?></span>
                        <p></p>
                    </div>
                    <div class="otpritems">
                    </div>
                </div>
                <div class="itemotpravka" id="otpr2">
                    <div class="zagotpravka">
                        <span><?php echo $lang['itemget']; ?></span>
                        <p></p>
                    </div>
                    <div class="otpritems">
                    </div>
                </div>
                <form action="createtrade" method="post">
                    <input name="data" type="text" id="otpravka">
                    <textarea name="opis" placeholder="<?php echo $lang['descript']; ?>"></textarea>
                    <div class="servsel">
                           <span><?php echo $lang['selserver']; ?></span>
                            <select name="serv">
                                <option value="public13">Public 1st/3rd Person</option>
                                <option value="public1">Public 1st Person</option>
                                <option value="dayzone">DAYZONE private</option>
                            </select>
                    </div>
                    <input name="subtrade" type="submit" class="button-flat" materialcircle="block,night" value="<?php echo $lang['createtrade']; ?>">
                </form>
            </div>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
