<title>Накопительный итог по всем датчикам расхода воды</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1190px cellpadding=1 cellspacing=1 align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Накопительный итог по всем датчикам расхода воды (нажать на график для подробностей)</font></td></tr>
<tr>
<td width=1190 valign=top>
<table width=1190 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

 $query = 'SELECT * FROM device WHERE type=2 AND ust=0 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 while ($uy)
	{
	 print '<tr><td><a href="http://rpk-su.info/lk_hour.php?flat='.$uy[10].'&obj='.$_GET["obj"].'&device='.$uy[1].'&n1=3"><img border=0 width=590 height=150 src="charts/barplots8.php?type=2&prm=6&flat='.$uy[10].'&id='.$uy[1].'&obj='.$_GET["obj"].'"></a></td>
		<td><a href="http://rpk-su.info/lk_hour.php?flat='.$uy[10].'&device='.$uy[1].'&n1=3&obj='.$_GET["obj"].'"><img border=0 width=590 height=150 src="charts/barplots8.php?type=2&prm=8&flat='.$uy[10].'&id='.$uy[1].'&obj='.$_GET["obj"].'"></a></td></tr>'; 
	 $uy = mysql_fetch_row ($a);	 
	}
?>
</table>
</td>
</tr>
</table>
