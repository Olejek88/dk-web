<?php include("config/local.php"); 
header("Location: http://192.168.3.46/")
;?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=koi-8r">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Интерфейс доступа к данным и конфигурирования ДК</title>
</head>
<?php
$i=mysql_connect ($mysql_host,$mysql_user,$mysql_password);
$e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='koi8r'"; mysql_query ($query,$i);
$query = "set character_set_results='koi8r'"; mysql_query ($query,$i);
$query = "set collation_connection='koi8r_general_ci'"; mysql_query ($query,$i);

$query = 'USE dk';
?>
<body bgcolor=#ffffff leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table align=center border=0 cellspacing=0 cellpadding=0 width=100% bgcolor=#ffffff>
<tr><td><? include ("inc/menu.inc"); ?><td></tr>
<tr><td><table align=center>
<?php
if ($_GET["menu"]=='1')
{
 $query = 'SELECT * FROM device';
 $max=13;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Устройства</font><font class="main"><a style="cursor: pointer" onclick="(imgs)=window.open(\'add.php?menu=1\',\'_blank\',\'width=590,height=320,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">(добавить устройство)</a></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">ID</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Идентификатор</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">SV</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Интерфейс</font></td>'; 
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Протокол</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Порт</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Скорость</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Адрес</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Тип устройства</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Квартира</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Дата связи</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Попыток</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Ошибок</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Связь</font></td>';
 print '<td bgcolor=#e6e6e6 align=center><font class="main">Время на устройстве</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Название</font></td></tr>'; 
 
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center><a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?menu=1&id='.$ui[0].'\',\'_blank\',\'width=590,height=600,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">'.$ui[0].'</a></td>';
     print '<td align=center>'.$ui[1].'</td>';
     print '<td align=center>'.$ui[2].'</td>';
     print '<td align=center>';     
     if ($ui[3]==0) print 'не определен';
     if ($ui[3]==1) print 'RS-232';
     if ($ui[3]==2) print 'RS-485';
     if ($ui[3]==3) print 'БСС';
     if ($ui[3]==4) print 'Ethernet';
     if ($ui[3]==5) print 'модем';
     print '</td>';
     print '<td align=center>'.$ui[4].'</td>';
     print '<td align=center>';
     if ($ui[5]<10) print '/ttyM'.$ui[5];
     print '</td>';
     print '<td align=center>'.$ui[6].'</td>';
     print '<td align=center>'.$ui[7].'</td>';
     print '<td align=center>';
     if ($ui[8]==0) print 'не определен';
     if ($ui[8]==1) print 'БИТ';
     if ($ui[8]==2) print '2ИП';
     if ($ui[8]==3) print 'КМ';
     if ($ui[8]==4) print 'МЭЭ';
     if ($ui[8]==5) print 'ИРП';
     if ($ui[8]==6) print 'ЛК';
     if ($ui[8]==7) print 'ДК';
     if ($ui[8]==8) print 'Сервер';
     if ($ui[8]==9) print 'Клиент';
     if ($ui[8]==10) print 'Панель оператора';
     if ($ui[8]==11) print 'Тэкон';     
     print '</td>';
     print '<td align=center>'.$ui[10].'</td>';
     print '<td align=center>'.$ui[12].'</td>';
     print '<td align=center>'.$ui[13].'</td>';
     print '<td align=center>'.$ui[14].'</td>';
     
     print '<td align=center>';
     if ($ui[15]==1) print 'Есть'; else print 'Нет';
     print '</td>';
     print '<td align=center>'.$ui[16].'</td>';
     print '<td align=center>'.$ui[20].'</td>';     
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}

//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='2')
{
 $query = 'SELECT * FROM flats';
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Квартиры</font><font class="main"><a style="cursor: pointer" onclick="(imgs)=window.open(\'add.php?menu=2\',\'_blank\',\'width=590,height=320,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">(добавить квартиру/абонента)</a></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">ID</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Квартира</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Этаж</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Комнат</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Количество стояков</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Абонент</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Последняя часовая метка</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Последняя cуточная метка</font></td></tr>';  
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center><a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?menu=2&id='.$ui[0].'\',\'_blank\',\'width=590,height=600,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">'.$ui[0].'</a></td>';
     print '<td align=center>'.$ui[1].'</td>';
     print '<td align=center>'.$ui[2].'</td>';
     print '<td align=center>'.$ui[3].'</td>';
     print '<td align=center>'.$ui[4].'</td>';
     print '<td align=center>'.$ui[5].'</td>';
     print '<td align=center>'.$ui[6].'</td>';
     print '<td align=center>'.$ui[7].'</td>';
     print '<td align=center>'.$ui[8].'</td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='4')
{
 $query = 'SELECT * FROM prdata WHERE type=0 ORDER BY device,prm';
 $max=2;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Текущие данные</font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Устройство</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Параметр</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Время получения</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Значение</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Статус</font></td></tr>';
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     $query = 'SELECT * FROM device WHERE idd='.$ui[1];
     $r = mysql_query ($query,$i);
     $uo = mysql_fetch_row ($r);     
     print '<td align=left>['.$ui[1].'] '.$uo[20].'</td>';
     $query = 'SELECT * FROM var WHERE dt='.$ui[2];
     $r = mysql_query ($query,$i);
     $uo = mysql_fetch_row ($r);     
     $query = 'SELECT * FROM edizm WHERE id='.$uo[3];
     $r = mysql_query ($query,$i);
     $up = mysql_fetch_row ($r);     
     print '<td align=left>['.$ui[2].'] '.$uo[2].' ('.$up[1].')';
     if ($ui[7]==1) print '[пр.]';
     if ($ui[7]==2) print '[обр.]';
     print '</td>';
     print '<td align=center>'.$ui[4].'</td>';
     print '<td align=left>'.$ui[5].'</td>';
     if ($ui[6]==0) print '<td align=center><img src="../files/s11.gif"></td>';
     if ($ui[6]==1) print '<td align=center><img src="../files/s10.gif"></td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='3')
{
 $query = 'SELECT * FROM register';
 $max=2;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Журнал событий</font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">id</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Код ошибки</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Устройство</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Дата</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Расшифровка события</font></td></tr>';
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center>'.$ui[0].'</td>';
     print '<td align=center>'.$ui[1].'</td>';
     $query = 'SELECT * FROM device WHERE idd='.$ui[2];
     $r = mysql_query ($query,$i);
     $uo = mysql_fetch_row ($r);     
     print '<td align=center>['.$ui[2].'] '.$uo[20].'</td>';
     print '<td align=center>'.$ui[3].'</td>';
     print '<td align=center>';
     if (($ui[1]>>28)==3) print '<font class="td1">[Ошибка]</font> ';
     if (($ui[1]>>28)==2) print '<font class="td3">[Предупреждение]</font> ';
     if (($ui[1]>>28)==1) print '<font class="td2">[Информация]</font> ';

     if (($ui[1]&0xffff)==2) print 'ошибка приема данных';
     if (($ui[1]&0xffff)==1) print 'ошибка отправки данных';
     
     print '</td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='5')
{
 $query = 'SELECT * FROM users';
 $max=2;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Пользователи Системы</font><font class="main"><a style="cursor: pointer" onclick="(imgs)=window.open(\'add.php?menu=5\',\'_blank\',\'width=590,height=320,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">(добавить пользователя)</a></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">id</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Имя пользователя</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Полномочия</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Логин</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Пароль</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Дата последнего входа</font></td><td bgcolor=#e6e6e6 align=center><font class="main">IP-адрес</font></td></tr>';  
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center><a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?menu=5&id='.$ui[0].'\',\'_blank\',\'width=590,height=600,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">'.$ui[0].'</a></td>';
     print '<td align=center>'.$ui[1].'</td>';
     if ($ui[2]==1) print '<td align=center>Пользователь</td>';
     if ($ui[2]==2) print '<td align=center>Оператор</td>';
     if ($ui[2]==3) print '<td align=center>Администратор</td>';
     print '<td align=center>'.$ui[3].'</td>';
     print '<td align=center>*******</td>';
     print '<td align=center>'.$ui[5].'</td>';
     print '<td align=center>'.$ui[6].'</td>';
     print '<td align=center>'.$ui[7].'</td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='6')
{
 $query = 'SELECT * FROM var';
 $max=2;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Переменные системы</font><font class="main"><a style="cursor: pointer" onclick="(imgs)=window.open(\'add.php?menu=6\',\'_blank\',\'width=590,height=320,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">(добавить переменную)</a></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">id</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Номер параметра</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Описание параметра</font></td></tr>'; 
 
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center><a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?menu=6&id='.$ui[0].'\',\'_blank\',\'width=590,height=600,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">'.$ui[0].'</a></td>';
     print '<td align=center>'.$ui[1].'</td>';
     print '<td align=center>'.$ui[2].'</td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='8')
{
 print '<form name=form method=post action="tobd.php" enctype="multipart/form-data">';
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Автоматически наполнить Систему устройствами</font></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество стояков</font></td><td><input class=log name="struts" size=8 style="width: 170px; height:18px"></td></tr>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Количество этажей</font></td><td><input class=log name="levels" size=8 style="width: 170px; height:18px"></td></tr>'; 
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Квартир на этаже</font></td><td><input class=log name="flats" size=8 style="width: 170px; height:18px"></td></tr>';  
 print '<tr><td><input name="frm" style="width:1; height:1; visibility:hidden" value="8"></td></tr>';
 print '<tr><td><input alt="ok" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td><td></table>';
 print '</table></td></tr>';     
}

//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='7')
{
phpinfo();
 $query = 'SELECT * FROM edizm';
 $max=2;
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Единицы измерения</font><font class="main"><a style="cursor: pointer" onclick="(imgs)=window.open(\'add.php?menu=7\',\'_blank\',\'width=590,height=320,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">(добавить единицу измерения)</a></font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">ID</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Название</font></td><td bgcolor=#e6e6e6 align=center><font class="main">Коэффициент отношения к СИ</font></td></tr>'; 
 
 $e = mysql_query ($query,$i);
 $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     print '<tr>';
     print '<td align=center><a style="cursor: pointer" onclick="(imgs)=window.open(\'edit.php?menu=7&id='.$ui[0].'\',\'_blank\',\'width=590,height=600,toolbar=no,menubar=no,location=no,status=no,resizable=no,scrollbars=no,top=0,left=0\');">'.$ui[0].'</a></td>';
     print '<td align=center>'.$ui[1].'</td>';
     print '<td align=center>'.$ui[2].'</td>';
     print '</tr>';
     $ui = mysql_fetch_row ($e);
    }	 
 print '</table></td></tr>';     
}
//-----------------------------------------------------------------------------------------------
if ($_GET["menu"]=='9')
{
 print '<tr><td align=center bgcolor=#c6c6c6><font class="zagl">Отчеты</font></td></tr><tr><td><table width=100%>';
 print '<form name="reda" method=post action="report.php">';
 include ("inc/report_inc.php");
 print '</form></table></td></tr>';     
}


?>
