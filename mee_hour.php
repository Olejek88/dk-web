<link rel="stylesheet" href="shablon.css" type="text/css">
<title>������ ��������� �� ��������������</title>
<table width=1190px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>��������� ������ ��������� �� ��������������</font></td></tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center><font class=tablz>������ ��������� �� ����� �� �������������� � �������� '.$_GET["flat"];
 print '</font></td></tr>'; 
 print '<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>�������������� ����������� ������ �� ������</font></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1190 height=250 src="charts/barplots13-1.php?type=2&prm=2&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'"></td></tr>';
 print '<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>������������� ������� �� ������</font></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1190 height=250 src="charts/barplots13-1.php?type=2&prm=14&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'"></td></tr>';
 print '<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>�������������� ����������� ������ �� �����</font></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1190 height=250 src="charts/barplots13-1.php?type=1&prm=2&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'"></td></tr>';
 print '<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>������������� ������� �� �����</font></td></tr>';
 print '<tr><td bgcolor=#ffffff align=center><img width=1190 height=250 src="charts/barplots13-1.php?type=1&prm=14&id='.$_GET["device"].'&st='.$_GET["st"].'&fn='.$_GET["fn"].'"></td></tr>';
?>
</table>
