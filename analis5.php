<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ распределения среднечасовых значений потребления электрической энергии по времени суток и дням недели</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1100px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td colspan=2 bgcolor=#ffcf68 align=center><font class=tablz3>Анализ распределения среднечасовых значений потребления электрической энергии по времени суток и дням недели</font></td></tr>
<tr>
<td width=300px>
<table width=300px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>                                 
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Индивидуальное распределение по времени</font></td></tr>
<tr><td bgcolor=#ffffff align=center><img src="charts/pieplot18.php?type=1&obj=<?php print $_GET["obj"]; ?>" width=300 height=300></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Индивидуальное распределение по дням недели</font></td></tr>
<tr><td bgcolor=#ffffff align=center><img src="charts/pieplot18.php?type=2&obj=<?php print $_GET["obj"]; ?>" width=300 height=300></td></tr>
</table></td>
<td width=800px>
<table width=800px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Общедомовое распределение потребления ЭЭ в течении суток (кВт)</font></td></tr>
<tr><td align=center><img src="charts/mix18.php?type=1&obj=<?php print $_GET["obj"]; ?>" width=800 height=300></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Общедомовое распределение потребления ЭЭ по дням недели (кВт)</font></td></tr>
<tr><td align=center><img src="charts/mix18.php?type=2&obj=<?php print $_GET["obj"]; ?>" width=800 height=300></td></tr>
</table>
</td></tr>
</table>
</body>
</html>