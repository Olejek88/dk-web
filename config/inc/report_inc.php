<?php
print '<tr><td width=200><font class="down">����������</td><td align=right><select class=log id="device" name="device" style="height:18">';
$query = 'SELECT * FROM device';
$e = mysql_query ($query,$i);
$ui = mysql_fetch_row ($e);
while ($ui)
    {
     print '<option value="'.$ui[1].'">'.$ui[20];
     $ui = mysql_fetch_row ($e);
    }
print '</select></td></tr>';

print '<tr><td width=200><font class="down">��� ������</td><td align=right><select class=log id="otch" name="otch" style="height:18">';
print '<option value="0">�� ����������';
print '<option value="1">�������';
print '<option value="2" selected>�������';
print '<option value="4">�� �������';
print '</select></td></tr>';
$today = getdate ();
print '<tr><td width=120><font class="down">���� ������ ������</td><td align=right><table><tr>
<td><select class=log id="hour" name="hour" style="height:18">';
include ("inc/today_hour.inc");
print '</select></td><td><select class=log id="day" name="day" style="height:18">';
include ("inc/today_day.inc");
print '</select></td><td><select class=log id="month" name="month" style="height:18">';
include ("inc/today_mon.inc");
print '</select></td><td><select class=log id="year" name="year" style="height:18">';
include ("inc/today_year.inc");
print '</select></tr></table></tr>';
print '<tr><td width=120><font class="down">���� ����� ������</td><td align=right><table><tr>
<td><select class=log id="ehour" name="ehour" style="height:18">';
include ("inc/today_hour.inc");
print '</select></td><td><select class=log id="eday" name="eday" style="height:18">';
include ("inc/today_day.inc");
print '</select></td><td><select class=log id="emonth" name="emonth" style="height:18">';
include ("inc/today_mon.inc");
print '</select></td><td><select class=log id="eyear" name="eyear" style="height:18">';
include ("inc/today_year.inc");
print '</select></tr></table></tr></td></tr>';
print '<tr><td><font class="down">������� �����</font></td><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/outp.gif" type=image></td></tr>';
?>