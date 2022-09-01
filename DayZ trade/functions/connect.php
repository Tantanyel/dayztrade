<?php 

$db = @mysql_connect("mysql.tanyel.myjino.ru","tanyel","qwe1qwe2");
@mysql_query("SET NAMES 'utf8'");
@mysql_select_db("tanyel_dayztrade",$db);

?>