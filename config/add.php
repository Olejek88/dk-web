<?php include("config/local.php"); ?>
<?php
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); 
$e = mysql_select_db ($mysql_db_name);
$query = "set character_set_client='koi8r'"; mysql_query ($query,$i);
$query = "set character_set_results='koi8r'"; mysql_query ($query,$i);
$query = "set collation_connection='koi8r_general_ci'"; mysql_query ($query,$i);
//-------------------------------------------------------------------------
print '<html><head><meta http-equiv="content-type" content="text/html; charset=koi8r">';
print '<link rel="stylesheet" href="shablon.css" type="text/css"><title>����������</title>';
print '</head>';
print '<body bgcolor=#ffffff><form name=form method=post action="tobd.php" enctype="multipart/form-data">';
//-------------------------------------------------------------------------
if ($_GET["menu"]==1)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">�������������([����������])</font></td><td><input class=log name="ID" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">SV (������ ��)</font></td><td><input class=log name="SV" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">���������</font></td><td><select class=log name="interface" style="height:18">';
  print '<option value="0">�� ���������';
  print '<option value="1">RS-232';
  print '<option value="2">RS-485';
  print '<option value="3">���'; 
  print '<option value="4">Ethernet';
  print '<option value="5">�����';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">�������� (������)</font></td><td><input class=log name="protocol" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">����</font></td><td><select class=log name="port" style="height:18">';
  print '<option value="1">/ttyM0';
  print '<option value="2">/ttyM1';
  print '<option value="3">/ttyS0';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">��������</font></td><td><select class=log name="speed" style="height:18">';
  print '<option value="300">300';
  print '<option value="600">600';
  print '<option value="1200">1200';
  print '<option value="2400">2400';
  print '<option value="4800">4800';
  print '<option value="9600">9600';
  print '<option value="19200">19200';
  print '<option value="38400">38400';
  print '<option value="57600">57600';
  print '<option value="115200">115200';
  print '</select></td></tr>';
 
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">�����</font></td><td><input class=log name="adr" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">��� ����������</font></td><td><select class=log name="type" style="height:18">';
	  print '<option value="0">�� ���������';
	  print '<option value="1">���';
	  print '<option value="2">2��';
	  print '<option value="3">���������� �������';
	  print '<option value="4">���';
	  print '<option value="5">���';
	  print '<option value="6">��';
	  print '<option value="7">��';
	  print '<option value="8">������ �������';
	  print '<option value="9">������ �������';
	  print '<option value="10">������ ���������';
	  print '<option value="11">�����-19';
	  print '<option value="12">������ (���961)';
	  print '<option value="13">�����-17';	  
	  print '</select></td></tr>';

  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">�������������</font></td><td><select class=log name="manf" style="height:18">';
	  print '<option value="0">�� ���������';
	  print '<option value="1">���� (�������������� �� �����)';
	  print '<option value="2">����� "������", ���������';
	  print '<option value="3">��������������, ���������';
	  print '<option value="4">��� "�����" ������������';
	  print '<option value="5">��� ��� ������';
	  print '</select></td></tr>';
	  
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">��������</font></td><td>';
    $query = 'SELECT * FROM flats ORDER BY id';
    $e = mysql_query ($query,$i);
    print '<select class=log name="flat" style="height:18">';
    print '<option value="0">�� ����������';
    $ui = mysql_fetch_row ($e);
    while ($ui)
	{
	 print '<option value="'.$ui[0].'">'; print $ui[1].' (��. '.$ui[5].')';
	 $ui = mysql_fetch_row ($e);
	}
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">��������</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr></tr>';
  print '<input name="frm" style="width:1; height:1; visibility:hidden" value="1">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }

//--------------------------------------------------------------------------------------
if ($_GET["menu"]==2)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">����� ��������</font></td><td><input class=log name="flat" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">����</font></td><td><input class=log name="level" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">���������� ������</font></td><td><input class=log name="rooms" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">���������� �������</font></td><td><input class=log name="nstrut" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">�������</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="2">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==5)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">��� ������������</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">����������</font></td><td><select class=log name="type" style="height:18">
  <option value="1">������������
  <option value="2">��������
  <option value="3">�������������
  </select></td></tr>   
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">�����</font></td><td><input class=log name="login" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">������</font></td><td><input class=log name="pass" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="5"></td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==6)
{
 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">����� ���������</font></td><td><input class=log name="dt" size=8 style="width: 170px; height:18px"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">��������</font></td><td><input class=log name="descr" size=8 style="width: 170px; height:18px"></td></tr>';
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="6"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==7)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">�������� ������� ���������</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">����������� �����������</font></td><td><input class=log name="knt" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="7">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
  
print '</body></html>';
?>