<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>������ ��������� �� �������� � ������� ���� - ������� ��������</title>
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

 print '<td bgcolor=#ffcf68 align=center><font class=tablz>������ ��������� �� ����� �� �������� ���� �� �������� '.$_GET["flat"].'. ��������������� ������: ';
 if ($n1==1) print ' ����������� ���� ��� ���������� ����������� �������';
 if ($n1==2) print ' ����������� ���� ��� ����������� �������';
 if ($n1==3) print ' ���������� �������� ���� >50% �� ���������';
 if ($n1==4) print ' ���������� ������� ���� >50% �� ���������';
 if ($n1==5) print ' ���������� �������� ����';
 if ($n1==6) print ' ���������� ������� ����';
 if ($n1==7) print ' ���������� ��������� ��� ������ �� ����������';
 if ($n1==8) print ' ���������� ��������� ��� ������ �� ����������';
 if ($n1==0) print ' ��� ���������';

 print '</font></td></tr>'; 
// print '<tr><td bgcolor=#ffffff align=center><img width=1200 height=250 src="charts/barplots13.php?type=2&prm=11&source=5&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'&obj='.$_GET["obj"].'"></td></tr>';
// print '<tr><td bgcolor=#ffffff align=center><img src="charts/barplots13.php?type=2&prm=11&source=6&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'&obj='.$_GET["obj"].'"></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img src="charts/barplots13-1.php?type=2&prm=6&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'&obj='.$_GET["obj"].'"></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img src="charts/barplots13-1.php?type=2&prm=8&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'&obj='.$_GET["obj"].'"></td></tr>';
?>
</table>
</body>
</html>