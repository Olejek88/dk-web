<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по всем энергоресурсам</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];
 print '<tr><td><font class=tablz>Отчет по потреблению энергоресурсов дома по адресу '.$build.'<font></td><td bgcolor=red align=center><font class=tablz>реальное</td><td align=center bgcolor=blue class=tablz>нормативное</td><td bgcolor=yellow align=center class=tablz>общедомовые потери</td></tr>';
?>
</table>

<table width=800px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php if ($is_tekon || $is_2ip) print '<tr><td><img width=800 height=250 src="charts/barplots18.php?n1=6&obj='.$_GET["obj"].'"></td></tr>'; ?>
<?php if ($is_tekon || $is_2ip) print '<tr><td><img width=800 height=250 src="charts/barplots18.php?n1=8&obj='.$_GET["obj"].'"></td></tr>'; ?>
<?php if ($is_bit) print '<tr><td><img width=800 height=250 src="charts/barplots18.php?n1=13&obj='.$_GET["obj"].'"></td></tr>'; ?>
</table>
</body>
</html>