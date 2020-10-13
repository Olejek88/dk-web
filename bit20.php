<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Временные графики температур</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr>
<td width=800 valign=top>
<table width=800 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

  $query = 'SELECT * FROM dev_bit WHERE strut_number=15 ORDER BY flat_number';
  $a = mysql_query ($query,$i);
  $uy = mysql_fetch_row ($a);
  while ($uy)
	{
	 print '<tr><td><img width=800 height=200 src="xyplots2.php?id='.$uy[1].'"></td></tr>';
	 $uy = mysql_fetch_row ($a);
       	}
?>
</table></td></tr></table></td>

</tr>
</table>
</body>
</html>