<div class="langreplace">
    <form method="post" action="/" class="langvib">
        <h3><?php echo $lang['langr']; ?></h3>
        <div class="langcont">
        <input class="button-flat lru" type="submit" value="Русский" name="rulang" materialcircle="block,night">
        <input class="button-flat leng" type="submit" value="English" name="englang" materialcircle="block,night">
        </div>
        <div class="knopki">
            <a class="button-flat" onclick="openlang();">
                <?php echo $lang['close']; ?>
            </a>
        </div>
    </form>
</div>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89279876-1', 'auto');
  ga('send', 'pageview');

    </script>