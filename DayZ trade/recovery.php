<?php
session_start();
include("functions/connect.php");
?>
<html>
<?php include("functions/head.php");?>

<body>
<?php
function repinfo($str){
    $healthy = array("\"", "\'");
    $yummy   = array("&quot;", "&apos;");
    $str = str_replace($healthy, $yummy, $str);
    return $str;
}
    
$recpass;
    
if($_GET["mail"]){
    $provarr = explode(",", $_GET["mail"]);
    $login = repinfo($provarr[0]);
    $password = repinfo($provarr[1]);
    $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$login' AND password='$password'",$db));
    if($myrow){
        $idu = $myrow['id'];
        $query = mysql_query("UPDATE users SET comtomail='0' WHERE id='$idu'",$db);
        $_SESSION['soob']=$lang['soob40'];
        header("Location: /");
        exit();
    }
}

if($_GET["pass"]){
    $provarr = explode(",", $_GET["pass"]);
    $login = repinfo($provarr[0]);
    $password = repinfo($provarr[1]);
    $myrow = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE name='$login' AND password='$password'",$db));
    if($myrow){
        $recpass = $myrow['id'];
    }else{
        $_SESSION['soob']=$lang['soob28'];
        header("Location: /");
    }
}else{
    $_SESSION['soob']=$lang['soob28'];
    header("Location: /");
}
    
if(isset($_POST["recovpass"])){
    if($recpass){
    $password = repinfo($_POST["password"]);
    $twopassword = repinfo($_POST["twopassword"]);
    $passwordmd = md5($password);
        if($password==$twopassword){
        $query = mysql_query("UPDATE users SET password='$passwordmd' WHERE id='$recpass'",$db);
        $_SESSION['soob']=$lang['soob29'];
        header("Location: /");
        }else{
        $errinput = 1;
        $errinputtext = $lang['passerr'];
        }
    }
}

?>
<div class="head">
        <a href="/" class="logo"><img src="img/logo.png"></a>
</div>
    
    <div class="center">
        <div class="redpole">
            <form action="recovery?pass=<?php echo $_GET["pass"]; ?>" method="post">
                <div class="input <?php if($errinput==1){echo 'errinput';}else{echo 'normalinput';} ?>">
                    <input name="password" type="password" pattern="[A-Za-z0-9_-]{6,255}"
                    title="<?php echo $lang['errsimvol2']; ?>" required>
                    <span><?php echo $lang['newpass']; ?></span>
                    <div class="line"><i></i></div>
                    <p><?php echo $errinputtext; ?></p>
                </div>
                <div class="input <?php if($errinput==1){echo 'errinput';}else{echo 'normalinput';} ?>">
                    <input name="twopassword" type="password" pattern="[A-Za-z0-9_-]{6,255}"
                    title="<?php echo $lang['errsimvol2']; ?>" required>
                    <span><?php echo $lang['confpass']; ?></span>
                    <div class="line"><i></i></div>
                    <p><?php echo $errinputtext; ?></p>
                </div>
                <input name="recovpass" type="submit" class="button-flat" value="<?php echo $lang['replpass']; ?>" materialcircle="block,night">
            </form>
        </div>
    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
