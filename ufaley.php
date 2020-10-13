<html><head>
<meta content="text/html; charset=windows-1251" http-equiv="Content-Type">
<meta name="description" content="ЖКХ, Система учета индивидуального потребления энергоресурсов, Челябинск">
<meta name='yandex-verification' content='621dd2393b620ed2' />
<meta name="google-site-verification" content="2F0fxETUDz06jt5zN0taZUmRyWQJiGa3Zg5YEfr8CYM" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">   
<link href="files/rpk.css" type="text/css" rel="stylesheet">
<link href="files/menu.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="shablon.css" type="text/css">
</head>
<body>
<div id="mmenu">
<script type="text/javascript" src="files/menu.js"></script>

<?php
   if ($_GET["obj"]!='') 
	{
	 //include ("menu.inc");
//	 else include ("menu2.inc");
	}
//   else include ("menu_main.inc");
?>
</div><script>setULPosition();</script>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr height="41">
<td width="278"><img src="files/1r1.gif" height="41" hspace="0" vspace="0" width="278"></td>
<td background="files/1r_fone.gif"><img src="files/1r2.gif" height="41" hspace="0" vspace="0" width="492"></td></tr>
<tr height="49"><td><a href="index.php"><img alt="Российская Приборостроительная Корпорация «Системы управления»" src="files/2r1.gif" border="0" height="49" hspace="0" vspace="0" width="278"></a></td><td background="files/2r_fone.gif"><img alt="Энергоэффективные инженерные решения для коммунальной инфраструктуры города" src="files/2r2.gif" height="49" hspace="0" vspace="0" width="492"></td></tr><tr height="35"><td><a href="http://rpk-su.info/site/home"><img alt="Российская Приборостроительная Корпорация «Системы управления»" src="files/3r1.gif" border="0" height="35" hspace="0" vspace="0" width="278"></a></td><td id="topnav" background="files/3r_fone.gif"></td></tr><tr><th colspan="2" background="files/4r.gif" height="26">&nbsp;</th></tr></tbody></table>
<img src="files/trsp.gif" height="15" width="774">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>

<?php
   if ($_GET["obj"]!='') 
   if ($_GET["sel"]=='' || $_GET["sel"]=='strukt' || $_GET["sel"]=='all' || $_GET["sel"]=='flat' || $_GET["sel"]=='rz2' || $_GET["sel"]=='rz3' || $_GET["sel"]=='rz4' || $_GET["sel"]=='signal' || $_GET["sel"]=='tech4' || $_GET["sel"]=='tech2') include ("info3.php");
   if ($_GET["obj"]=='') include ("info3.php")
?>

<td class="center">
	<?php	   	   
	   if ($_GET["sel"]=='' && $_GET["obj"]!='') 
		{
		 if ($_GET["obj"]<6) include ("main.php");
		 else  include ("main2.php");
		}	
	   else if ($_GET["sel"]=='' && $_GET["obj"]=='') { include ("obj.php"); print '<title>Система учета индивидуального потребления энергоресурсов :: Вход в Систему</title>'; }
	   else { $file=$_GET["sel"].'.php'; include ($file); }
	?>
</td>
</tr>
</tbody></table>

<table class="footer" border="0" cellpadding="0" cellspacing="0" width="1190">
<tbody>
<tr><td><span>                     
Copyright &copy; 2008-2013, code by <a href="mailto:shtrmvk@gmail.com">oleg</a>
<div> ЗАО РПК <b>«Системы управления»</b></div>
</span></td>
<th background="files/foot_cent.gif" width="307">&nbsp;</th>
<th background="files/foot_fone.gif" width=100%>&nbsp;</th>
<th width="284"><img alt="Доступность сложного" src="files/foot_right.gif" height="63" hspace="0" vspace="0" width="284"></th></tr>
<tr>
<th><img src="files/trsp.gif" height="15" width="278"></th>
<th><img src="files/trsp.gif" height="15" width="207"></th>
</tr>
</tbody></table>
<div></div>
</body></html>
