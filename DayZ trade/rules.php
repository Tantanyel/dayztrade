<?php
session_start();
include("functions/connect.php");
?>
<html>
<?php include("functions/head.php");?>

<body>
<?php
include("functions/menu.php");
?>
<?php include("functions/nameserv.php");?>

    <div class="center">
        <h2><?php echo $lang['rules']; ?></h2>
        <div class="rules">
        
        <?php echo $lang['rulestext']; ?>
        
        </div>

    </div>
<?php include("functions/langr.php"); ?>
</body>

</html>
