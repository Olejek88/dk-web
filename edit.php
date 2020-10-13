<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">

<table width=1180px cellpadding=1 cellspacing=1 align=center>
<?php

 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT strut FROM dev_irp WHERE device='.$_GET["id"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 print '<tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Статистика ответов стоякового вычислителя '.$uy[0].'</font></td></tr><tr>';
 
 print '<td width=1190 valign=top><table width=1180 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>время</font></td>';
// print '<td bgcolor=#ffcf68 align=center><font class=tablz>hex</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>text</font></td></tr>';

 $query = 'SELECT * FROM answers WHERE device='.$_GET["id"].' ORDER BY date DESC';
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a); $cn=0; 
 while ($uy)
         {
	  print '<tr>';
	  print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$uy[3].'</font></td>';
	  print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.$uy[2].'</font></td></tr>';
	  $uy = mysql_fetch_row ($a);
         }
?>
</tr>


</table>
</body>
</html>