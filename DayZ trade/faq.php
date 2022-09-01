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
       <h2><?php echo $lang['faq']; ?></h2>
        
        <div class="faqs">
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['1faq_v']; ?></span>
                <p><?php echo $lang['1faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['2faq_v']; ?></span>
                <p><?php echo $lang['2faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['3faq_v']; ?></span>
                <p><?php echo $lang['3faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['4faq_v']; ?></span>
                <p><?php echo $lang['4faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['5faq_v']; ?></span>
                <p><?php echo $lang['5faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['6faq_v']; ?></span>
                <p><?php echo $lang['6faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['7faq_v']; ?></span>
                <p><?php echo $lang['7faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['8faq_v']; ?></span>
                <?php echo $lang['8faq_o']; ?>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['9faq_v']; ?></span>
                <p><?php echo $lang['9faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['10faq_v']; ?></span>
                <p><?php echo $lang['10faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            <div class="faq">
                <span onclick="faqopn(this);"><?php echo $lang['11faq_v']; ?></span>
                <p><?php echo $lang['11faq_o']; ?></p>
                <a onclick="faqopn(this);"></a>
            </div>
            
            
        </div>
        
    </div>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?136"></script>

<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", 134087842, {shown: "0"});
</script>
<?php include("functions/langr.php"); ?>
</body>

</html>
