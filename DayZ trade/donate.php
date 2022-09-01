<?php
session_start();
include("functions/connect.php");
?>
<html>
<?php include("functions/head.php");?>

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
include("functions/menu.php");
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['donate']; ?></h2>

        <div class="donate">
            <?php echo $lang['donatetext']; ?>

            <div class="doneblock">
                <div class="donimg"><img src="img/donateya.png"></div>
                <div class="dontext">
                    <s><?php echo $lang['yandex']; ?></s>
                    <span>410014226341942</span>
                </div>
            </div>
            <div class="doneblock">
                <div class="donimg"><img src="img/donatewm.png"></div>
                <div class="dontext">
                    <s><?php echo $lang['wmr']; ?></s>
                    <span>R164554333986</span>
                </div>
            </div>
            <div class="doneblock">
                <div class="donimg"><img src="img/donatewm.png"></div>
                <div class="dontext">
                    <s><?php echo $lang['wmd']; ?></s>
                    <span>Z274370134674</span>
                </div>
            </div>
            <div class="doneblock">
                <div class="donimg"><img src="img/donateqiwi.png"></div>
                <div class="dontext">
                    <s><?php echo $lang['qiwi']; ?></s>
                    <span>+7(916)370-19-48</span>
                </div>
            </div>
        </div>

    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
