<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ показаний по тепловой энергии</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 if ($_GET["date"]=='') $month=3;
 else $month=$_GET["date"];
 include("time.inc"); 

 if ($_GET["date"]=='') 
	{ 
	 $st='20090300000000'; 
	 $fn='20090400000000';
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

<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=1&n1=1&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=1&n1=2&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=2&n1=1&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=2&n1=2&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=3&n1=1&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=3&n1=2&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=4&n1=1&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';
 print '<tr><td><img width=1200 height=350 src="charts/barplots15.php?type=4&n1=2&st='.$st.'&obj='.$_GET["obj"].'&fn='.$fn.'&month='.$_GET["date"].'"></td></tr>';

?>
</table>

</body>
</html>                                                        .,