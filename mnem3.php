<?php include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 
 $query = 'SELECT MAX(entrance),MAX(level) FROM mnem WHERE build='.$_GET["obj"];
 //echo $query;
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 $maxlevel=$uy[1]; $maxentrance=$uy[0];
?>

<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Система учета индивидуального потребления энергоресурсов :: Мнемосхема ИТП</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0 bgcolor=#f2f2f2>
<div style="position:absolute;top:0;left:0;width:1200;height:750;z-index:-3;visibility:visible;"><img src="mnem/itp.jpg"></div>
<?php  
 include("config/local.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM prdata WHERE type=0 AND device>80000000';
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
	{    
         if ($uy[2]==4 && $uy[7]==0) print '<div style="position:absolute;top:360;left:5;width:140;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Tпод.='.number_format($uy[5],2).'С</font></div>';
         if ($uy[2]==4 && $uy[7]==1) print '<div style="position:absolute;top:375;left:5;width:140;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Tобр.='.number_format($uy[5],2).'С</font></div>';
         if ($uy[2]==4 && $uy[7]==3) print '<div style="position:absolute;top:365;left:614;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Tпод.СО='.number_format($uy[5],2).'</font></div>';
         if ($uy[2]==4 && $uy[7]==4) print '<div style="position:absolute;top:385;left:614;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Tобр.СО='.number_format($uy[5],2).'</font></div>';

         if ($uy[2]==11 && $uy[7]==0) print '<div style="position:absolute;top:220;left:110;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Qпод.='.number_format($uy[5],2).'ГКал</font></div>';
         if ($uy[2]==11 && $uy[7]==1) print '<div style="position:absolute;top:235;left:110;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Qобр.='.number_format($uy[5],2).'ГКал</font></div>';
         if ($uy[2]==12 && $uy[7]==0) print '<div style="position:absolute;top:413;left:55;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vпод.='.number_format($uy[5],2).'м3</font></div>';
         if ($uy[2]==12 && $uy[7]==1) print '<div style="position:absolute;top:523;left:55;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vобр.='.number_format($uy[5],2).'м3</font></div>';
//         if ($uy[2]==13 && $uy[7]==0) print '<div style="position:absolute;top:500;left:30;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.number_format($uy[5],2).'</font></div>';
         if ($uy[2]==13 && $uy[7]==2) print '<div style="position:absolute;top:450;left:470;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>QСО='.number_format($uy[5],2).'ГКал</font></div>'; 
         if ($uy[2]==13 && $uy[7]==3) print '<div style="position:absolute;top:410;left:470;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Qпотр.='.number_format($uy[5],2).'ГКал</font></div>';
         if ($uy[2]==12 && $uy[7]==6) print '<div style="position:absolute;top:203;left:1;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vгвс='.number_format($uy[5],2).'м3</font></div>';
         if ($uy[2]==12 && $uy[7]==5) print '<div style="position:absolute;top:20;left:370;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vхвс='.number_format($uy[5],2).'м3</font></div>'; 
         if ($uy[2]==14 && $uy[7]==0) print '<div style="position:absolute;top:75;left:120;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>W='.number_format($uy[5],2).'кВт</font></div>';
         if ($uy[2]==14 && $uy[7]==1) print '<div style="position:absolute;top:75;left:200;width:40;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>W='.number_format($uy[5],2).'кВт</font></div>';
         if ($uy[2]==4 && $uy[7]==10) print '<div style="position:absolute;top:45;left:20;width:60;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Температура за бортом: '.number_format($uy[5],2).' С</font></div>';
	 
         $uy = mysql_fetch_row ($a);
	}   
?>
<div style="position:absolute;top:147;left:395;width:400;height:215;z-index:25;visibility:visible;">
<img src="charts/xyplot7.php?type=4&size=1&p=1&obj=<?php print $_GET["obj"]; ?>">
</div>

</body>
</html>