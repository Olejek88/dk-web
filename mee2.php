<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Распределение электроэнергии</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1000px cellpadding=1 cellspacing=1 align=center>
<tr>
<td width=1000 valign=top>
<table width=1000 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 print '<tr><td><img width=1200 height=350 src="barplots10.php?type=1&n1=1&st=20090101000000&fn=20100101000000"></td></tr>'; 
 print '<tr><td><img width=1200 height=350 src="barplots10.php?type=1&n1=2&st=20090101000000&fn=20100101000000"></td></tr>'; 
?>
</table>
</td>
</tr>
</table>
</body>
</html>