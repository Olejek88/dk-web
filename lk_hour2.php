<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по электроэнергии - часовые значения</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Анализ показаний по часам по электричеству в квартире '.$_GET["flat"].'. Предварительный анализ: ';
 if ($n1==1) print ' потребление электричества при отсутствии прописанных жильцов';
 if ($n1==3) print ' перерасход электроэнергии >50% по нормативу';
 if ($n1==5) print ' перерасход электроэнергии';
 if ($n1==7) print ' отсутствие показаний или датчик не установлен';
 if ($n1==0) print ' все нормально';

 print '</font></td></tr>'; 
 print '<tr><td bgcolor=#ffffff align=center><img width=1200 height=250 src="charts/barplots13-1.php?type=1&prm=14&id='.$_GET["device"].'&obj='.$_GET["obj"].'"></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1200 height=250 src="charts/barplots13-1.php?type=1&prm=2&id='.$_GET["device"].'&obj='.$_GET["obj"].'"></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1200 height=250 src="charts/barplots13-1.php?type=2&prm=2&id='.$_GET["device"].'&obj='.$_GET["obj"].'"></td></tr>';
?>
</table>
</body>
</html>