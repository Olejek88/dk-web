<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по холодной и горячей воде</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 if ($_GET["date"]=='') { $month=5; $date=$month; }
 else { $month=$_GET["date"]; $date=$month; }
 if ($_GET["year"]>2000) ; else $_GET["year"]=$today["year"];

 include("time.inc"); 

 if ($_GET["date"]=='') 
	{ 
	 $st=sprintf ("%d%02d01000000",$today["year"],$today["mon"]-1);
	 $fn=sprintf ("%d%02d01000000",$today["year"],$today["mon"]);
	 $month=$today["mon"]-1;
	 $k=1; 
	}
 else 
	{ 
	 if ($_GET["date"]!=$today["mon"]) $k=1;
	 else $k=$today["mday"]/31;
	 $st=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]);
	 $fn=sprintf ("%d%02d00000000",$today["year"],$_GET["date"]+1);
	}

?>

<table width=600px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td>
<?php
 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center>';
 print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz3>Отчет за</font></td>';
 $today=getdate();
 $tm=$today["mon"];
 $cn=12;
 while ($cn)
    {		 
     if ($tm==1) $dat='Январь';
     if ($tm==2) $dat='Февраль';
     if ($tm==3) $dat='Март';
     if ($tm==4) $dat='Апрель';
     if ($tm==5) $dat='Май';
     if ($tm==6) $dat='Июнь';
     if ($tm==7) $dat='Июль';
     if ($tm==8) $dat='Август';
     if ($tm==9) $dat='Сентябрь';
     if ($tm==10) $dat='Октябрь';
     if ($tm==11) $dat='Ноябрь';
     if ($tm==12) $dat='Декабрь';

     $sts=sprintf ("%d%02d00000000",$today["year"],$tm);
     $fns=sprintf ("%d%02d00000000",$today["year"],$tm+1);
     print '<td bgcolor=#ffffff align=center><a href="index.php?sel=lk6&obj='.$_GET["obj"].'&st='.$sts.'&fn='.$fns.'&date='.$tm.'&year='.$today["year"].'"><font class=tablz3>'.$dat.' '.$today["year"].'</font></td>';

     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;
     $cn--;
    }

 print '</tr></table>';
?>
</td></tr></table>

<br>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 $today=getdate();
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a);
 if ($uy[4]) 
 for ($ent=1;$ent<=$uy[4];$ent++)
	{ 
	 print '<tr><td><img width=1200 height=350 src="charts/barplots16.php?type=1&n1='.$ent.'&obj='.$_GET["obj"].'&date='.$date.'&year='.$today["year"].'"></td></tr>';
	 print '<tr><td><img width=1200 height=350 src="charts/barplots17.php?type=1&n1='.$ent.'&obj='.$_GET["obj"].'&date='.$date.'&year='.$today["year"].'"></td></tr>';
	}
?>
</table>
</body>
</html>