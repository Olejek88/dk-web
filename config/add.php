<?php include("config/local.php"); ?>
<?php
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); 
$e = mysql_select_db ($mysql_db_name);
$query = "set character_set_client='koi8r'"; mysql_query ($query,$i);
$query = "set character_set_results='koi8r'"; mysql_query ($query,$i);
$query = "set collation_connection='koi8r_general_ci'"; mysql_query ($query,$i);
//-------------------------------------------------------------------------
print '<html><head><meta http-equiv="content-type" content="text/html; charset=koi8r">';
print '<link rel="stylesheet" href="shablon.css" type="text/css"><title>Добавление</title>';
print '</head>';
print '<body bgcolor=#ffffff><form name=form method=post action="tobd.php" enctype="multipart/form-data">';
//-------------------------------------------------------------------------
if ($_GET["menu"]==1)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Идентификатор([аппаратный])</font></td><td><input class=log name="ID" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">SV (версия ПО)</font></td><td><input class=log name="SV" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Интерфейс</font></td><td><select class=log name="interface" style="height:18">';
  print '<option value="0">не определен';
  print '<option value="1">RS-232';
  print '<option value="2">RS-485';
  print '<option value="3">БСС'; 
  print '<option value="4">Ethernet';
  print '<option value="5">модем';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Протокол (версия)</font></td><td><input class=log name="protocol" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Порт</font></td><td><select class=log name="port" style="height:18">';
  print '<option value="1">/ttyM0';
  print '<option value="2">/ttyM1';
  print '<option value="3">/ttyS0';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Скорость</font></td><td><select class=log name="speed" style="height:18">';
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
 
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Адрес</font></td><td><input class=log name="adr" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Тип устройства</font></td><td><select class=log name="type" style="height:18">';
	  print '<option value="0">не определен';
	  print '<option value="1">БИТ';
	  print '<option value="2">2ИП';
	  print '<option value="3">Квартирный монитор';
	  print '<option value="4">МЭЭ';
	  print '<option value="5">ИРП';
	  print '<option value="6">ЛК';
	  print '<option value="7">ДК';
	  print '<option value="8">Сервер Системы';
	  print '<option value="9">Клиент Системы';
	  print '<option value="10">Панель оператора';
	  print '<option value="11">Тэкон-19';
	  print '<option value="12">Логика (СПТ961)';
	  print '<option value="13">Тэкон-17';	  
	  print '</select></td></tr>';

  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Производитель</font></td><td><select class=log name="manf" style="height:18">';
	  print '<option value="0">не определен';
	  print '<option value="1">ЗИТЦ (Зеленоградский ИТ Центр)';
	  print '<option value="2">Завод "Прибор", Челябинск';
	  print '<option value="3">Спецавтоматика, Челябинск';
	  print '<option value="4">ОАО "Крейт" Екатеринбург';
	  print '<option value="5">ЗАО НПФ Логика';
	  print '</select></td></tr>';
	  
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Квартира</font></td><td>';
    $query = 'SELECT * FROM flats ORDER BY id';
    $e = mysql_query ($query,$i);
    print '<select class=log name="flat" style="height:18">';
    print '<option value="0">не соотносить';
    $ui = mysql_fetch_row ($e);
    while ($ui)
	{
	 print '<option value="'.$ui[0].'">'; print $ui[1].' (аб. '.$ui[5].')';
	 $ui = mysql_fetch_row ($e);
	}
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Название</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr></tr>';
  print '<input name="frm" style="width:1; height:1; visibility:hidden" value="1">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }

//--------------------------------------------------------------------------------------
if ($_GET["menu"]==2)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Номер квартиры</font></td><td><input class=log name="flat" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Этаж</font></td><td><input class=log name="level" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество комнат</font></td><td><input class=log name="rooms" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество стояков</font></td><td><input class=log name="nstrut" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Абонент</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="2">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==5)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Имя пользователя</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Полномочия</font></td><td><select class=log name="type" style="height:18">
  <option value="1">Пользователь
  <option value="2">Оператор
  <option value="3">Администратор
  </select></td></tr>   
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Логин</font></td><td><input class=log name="login" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Пароль</font></td><td><input class=log name="pass" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="5"></td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==6)
{
 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Номер параметра</font></td><td><input class=log name="dt" size=8 style="width: 170px; height:18px"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Описание</font></td><td><input class=log name="descr" size=8 style="width: 170px; height:18px"></td></tr>';
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="6"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==7)
{
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Название единицы измерения</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Коэффициент соотношения</font></td><td><input class=log name="knt" size=8 style="width: 170px; height:18px"></td></tr>';
  print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="7">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
  
print '</body></html>';
?>