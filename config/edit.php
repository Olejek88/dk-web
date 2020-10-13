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
 $query = 'SELECT * FROM device WHERE id='.$_GET["id"];
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 //echo $query;
  print '<table bgcolor=#ffffff border=0 align=center>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Идентификатор([аппаратный])</font></td><td><input class=log name="ID" size=8 style="width: 170px; height:18px" value="'.$ui[1].'"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">SV (версия ПО)</font></td><td><input class=log name="SV" size=8 style="width: 170px; height:18px" value="'.$ui[2].'"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Интерфейс</font></td><td><select class=log name="interface" style="height:18">';
  print '<option value="0" '; if ($ui[3]==0) print 'selected'; print '>не определен';
  print '<option value="1" '; if ($ui[3]==1) print 'selected'; print '>RS-232';
  print '<option value="2" '; if ($ui[3]==2) print 'selected'; print '>RS-485';
  print '<option value="3" '; if ($ui[3]==3) print 'selected'; print '>БСС'; 
  print '<option value="4" '; if ($ui[3]==4) print 'selected'; print '>Ethernet';
  print '<option value="5" '; if ($ui[3]==5) print 'selected'; print '>модем';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Протокол (версия)</font></td><td><input class=log name="protocol" size=8 style="width: 170px; height:18px" value="'.$ui[4].'"></td></tr>
  <tr><td bgcolor=#e6e6e6 align=center><font class="main">Порт</font></td><td><select class=log name="port" style="height:18">';
  print '<option value="1" '; if ($ui[5]==1) print 'selected'; print '>/ttyM0';
  print '<option value="2" '; if ($ui[5]==2) print 'selected'; print '>/ttyM1';
  print '<option value="3" '; if ($ui[5]==3) print 'selected'; print '>/ttyS0';
  print '</select></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Скорость</font></td><td><select class=log name="speed" style="height:18">';
  print '<option value="300" '; if ($ui[6]==0) print 'selected'; print '>300';
  print '<option value="600" '; if ($ui[6]==1) print 'selected'; print '>600';
  print '<option value="1200" '; if ($ui[6]==2) print 'selected'; print '>1200';
  print '<option value="2400" '; if ($ui[6]==3) print 'selected'; print '>2400';
  print '<option value="4800" '; if ($ui[6]==4) print 'selected'; print '>4800';
  print '<option value="9600" '; if ($ui[6]==5) print 'selected'; print '>9600';
  print '<option value="19200" '; if ($ui[6]==6) print 'selected'; print '>19200';
  print '<option value="38400" '; if ($ui[6]==7) print 'selected'; print '>38400';
  print '<option value="57600" '; if ($ui[6]==8) print 'selected'; print '>57600';
  print '<option value="115200" '; if ($ui[6]==9) print 'selected'; print '>115200';
  print '</select></td></tr>';
 
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Адрес</font></td><td><input class=log name="adr" size=8 style="width: 170px; height:18px" value="'.$ui[7].'"></td></tr>';
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Тип устройства</font></td><td><select class=log name="type" style="height:18">';
	  print '<option value="0" '; if ($ui[8]==0) print 'selected'; print '>не определен';
	  print '<option value="1" '; if ($ui[8]==1) print 'selected'; print '>БИТ';
	  print '<option value="2" '; if ($ui[8]==2) print 'selected'; print '>2ИП';
	  print '<option value="3" '; if ($ui[8]==3) print 'selected'; print '>Квартирный монитор';
	  print '<option value="4" '; if ($ui[8]==4) print 'selected'; print '>МЭЭ';
	  print '<option value="5" '; if ($ui[8]==5) print 'selected'; print '>ИРП';
	  print '<option value="6" '; if ($ui[8]==6) print 'selected'; print '>ЛК';
	  print '<option value="7" '; if ($ui[8]==7) print 'selected'; print '>ДК';
	  print '<option value="8" '; if ($ui[8]==8) print 'selected'; print '>Сервер Системы';
	  print '<option value="9" '; if ($ui[8]==9) print 'selected'; print '>Клиент Системы';
	  print '<option value="10" '; if ($ui[8]==10) print 'selected'; print '>Панель оператора';
	  print '<option value="11" '; if ($ui[8]==11) print 'selected'; print '>Тэкон-19';
	  print '<option value="12" '; if ($ui[8]==12) print 'selected'; print '>Логика (СПТ961)';
	  print '<option value="13" '; if ($ui[8]==13) print 'selected'; print '>Тэкон-17';	  
	  print '</select></td></tr>';

  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Производитель</font></td><td><select class=log name="manf" style="height:18">';
	  print '<option value="0" '; if ($ui[1]/0x1000000==0) print 'selected'; print '>не определен';
	  print '<option value="1" '; if ($ui[1]/0x1000000==1) print 'selected'; print '>ЗИТЦ (Зеленоградский ИТ Центр)';
	  print '<option value="2" '; if ($ui[1]/0x1000000==2) print 'selected'; print '>Завод "Прибор", Челябинск';
	  print '<option value="3" '; if ($ui[1]/0x1000000==3) print 'selected'; print '>Спецавтоматика, Челябинск';
	  print '<option value="4" '; if ($ui[1]/0x1000000==4) print 'selected'; print '>ОАО "Крейт" Екатеринбург';
	  print '<option value="5" '; if ($ui[1]/0x1000000==5) print 'selected'; print '>ЗАО НПФ Логика';
	  print '</select></td></tr>';
	  
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Квартира</font></td><td>';
    $query = 'SELECT * FROM flats ORDER BY id';
    $e = mysql_query ($query,$i);
    print '<select class=log name="flat" style="height:18">';
    print '<option value="0">не соотносить';
    $uo = mysql_fetch_row ($e);
    while ($uo)
	{
	 print '<option value="'.$uo[0].'" '; if ($ui[10]==$uo[0]) print 'selected'; print '>'; print $uo[1].' (аб. '.$uo[5].')';
	 $uo = mysql_fetch_row ($e);
	}
  print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Название</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px" value="'.$ui[20].'"></td></tr></tr>';
  print '<tr><td colspan=2><hr></td></tr>';
  if ($ui[8]==1)
    {
     $query = 'SELECT * FROM dev_bit WHERE device='.$ui[1];
     $t = mysql_query ($query,$i);
     $uo = mysql_fetch_row ($t);
     //echo $query;
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Интервал времени между выходами в эфир</font></td><td><input class=log name="rf_int_interval" size=8 style="width: 170px; height:18px" value="'.$uo[2].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Адрес модуля</font></td><td><input class=log name="rf_int_interval" size=8 style="width: 170px; height:18px" value="'.$uo[4].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Интервал измерения</font></td><td><input class=log name="meas_interval" size=8 style="width: 170px; height:18px" value="'.$uo[5].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество интервалов для интегрирования</font></td><td><input class=log name="integ_meas_cnt" size=8 style="width: 170px; height:18px" value="'.$uo[6].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Приведенное давление среды</font></td><td><input class=log name="pi" size=8 style="width: 170px; height:18px" value="'.$uo[7].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Приведенное давление среды</font></td><td><input class=log name="strut_number" size=8 style="width: 170px; height:18px" value="'.$uo[9].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Нижняя аварийная уставка по Т</font></td><td><input class=log name="low_error_temp" size=8 style="width: 170px; height:18px" value="'.$uo[10].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Верхняя аварийная уставка по Т</font></td><td><input class=log name="high_error_temp" size=8 style="width: 170px; height:18px" value="'.$uo[11].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Нижняя предупредительная уставка по Т</font></td><td><input class=log name="low_warn_temp" size=8 style="width: 170px; height:18px" value="'.$uo[12].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Верхняя предупредительная уставка по Т</font></td><td><input class=log name="high_warn_temp" size=8 style="width: 170px; height:18px" value="'.$uo[13].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Имитационное значение параметра</font></td><td><input class=log name="imitate_tem" size=8 style="width: 170px; height:18px" value="'.$uo[14].'"></td></tr>';
     print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Мощность передатчика</font></td><td><input class=log name="pa_table" size=8 style="width: 170px; height:18px" value="'.$uo[15].'"></td></tr>';
     print '<input name="id2" style="width:1; height:1; visibility:hidden" value="'.$uo[0].'">';
    }
  print '<input name="id" style="width:1; height:1; visibility:hidden" value="'.$_GET["id"].'">';
  print '<input name="frm" style="width:1; height:1; visibility:hidden" value="11">';
  print '</td></tr>';
  print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 }
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==2)
{
 $query = 'SELECT * FROM flats WHERE id='.$_GET["id"];
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);

 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Номер квартиры</font></td><td><input class=log name="flat" size=8 style="width: 170px; height:18px" value="'.$ui[1].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Этаж</font></td><td><input class=log name="level" size=8 style="width: 170px; height:18px" value="'.$ui[2].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество комнат</font></td><td><input class=log name="rooms" size=8 style="width: 170px; height:18px" value="'.$ui[3].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество стояков</font></td><td><input class=log name="nstrut" size=8 style="width: 170px; height:18px" value="'.$ui[4].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Абонент</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px" value="'.$ui[5].'"></td></tr>';
 print '<input name="id" style="width:1; height:1; visibility:hidden" value="'.$_GET["id"].'">';
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="12">';
 print '</td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}

//--------------------------------------------------------------------------------------
if ($_GET["menu"]==5)
{
 $query = 'SELECT * FROM users WHERE id='.$_GET["id"];
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);

 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Имя пользователя</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px" value="'.$ui[1].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Полномочия</font></td><td><select class=log name="dt" style="height:18">
 <option value="1" '; if ($ui[2]==1) print 'selected'; print '>Пользователь
 <option value="2" '; if ($ui[2]==2) print 'selected'; print '>Оператор
 <option value="3" '; if ($ui[2]==3) print 'selected'; print '>Администратор
 </select></td></tr> 
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Логин</font></td><td><input class=log name="login" size=8 style="width: 170px; height:18px" value="'.$ui[3].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Пароль</font></td><td><input class=log name="date" size=8 style="width: 170px; height:18px" value="'.$ui[4].'"></td></tr>';
 
 print '<input name="id" style="width:1; height:1; visibility:hidden" value="'.$_GET["id"].'">'; 
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="15"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==6)
{
 $query = 'SELECT * FROM var WHERE id='.$_GET["id"];
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);

 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Номер параметра</font></td><td><input class=log name="dt" size=8 style="width: 170px; height:18px" value="'.$ui[1].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Описание</font></td><td><input class=log name="descr" size=8 style="width: 170px; height:18px" value="'.$ui[2].'"></td></tr>';
 print '<input name="id" style="width:1; height:1; visibility:hidden" value="'.$_GET["id"].'">'; 
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="12"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}
//--------------------------------------------------------------------------------------
if ($_GET["menu"]==7)
{
 $query = 'SELECT * FROM edizm WHERE id='.$_GET["id"];
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 //echo $query;
 print '<table bgcolor=#ffffff border=0 align=center>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Название единицы измерения</font></td><td><input class=log name="flat" size=8 style="width: 170px; height:18px" value="'.$ui[1].'"></td></tr>
 <tr><td bgcolor=#e6e6e6 align=center><font class="main">Коэффициент соотношения</font></td><td><input class=log name="name" size=8 style="width: 170px; height:18px" value="'.$ui[2].'"></td></tr>';
 print '<input name="id" style="width:1; height:1; visibility:hidden" value="'.$_GET["id"].'">'; 
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="17"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
}
 
 
print '</body></html>';
?>