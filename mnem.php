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
<title>Система учета индивидуального потребления энергоресурсов :: Мнемосхемы всех этажей дома с текущими показаниями</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
  <?php  
     if ($_GET["stg"]!='') $_POST["stg"]=$_GET["stg"];
     if ($_GET["entr"]!='') $_POST["entr"]=$_GET["entr"];

     if ($_POST["entr"]=='' || $_POST["stg"]=='') $query = 'SELECT * FROM mnem WHERE build='.$_GET["obj"].' AND level=1 AND entrance=1';
     else $query = 'SELECT * FROM mnem WHERE build='.$_GET["obj"].' AND level='.$_POST["stg"].' AND entrance='.$_POST["entr"];
     //echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     if ($_GET["obj"]==1) print '<div style="position:absolute;top:0;left:0;width:1200;height:800;z-index:0;visibility:visible;"><img src="'.$uy[1].'.bmp"></div>';
     if ($_GET["obj"]==2) print '<div style="position:absolute;top:0;left:0;width:1200;height:800;z-index:0;visibility:visible;"><img src="'.$uy[1].'.jpg"></div>';
  ?>
<div style="position:absolute;top:0;left:0;width:73;height:70;">
<table align=center border=0 cellspacing=0 cellpadding=0 width=100% bgcolor=#ffffff>
<tr><td width=100%>
	<?php print '<form name="redr" method=post action="mnem.php?obj='.$_GET["obj"].'">'; ?>
	<table align=right border=0 cellspacing=0 cellpadding=1 align=center width=100%>
	<tr><td align=center><font class=top3>Подъезды </font><br>
		<select id="entr" name="entr" style="width: 73px;">
		<?php
		  for ($lv=1;$lv<=$maxentrance; $lv++)
			{
			 print '<option value="'.$lv.'" ';
			 if ($_POST["entr"]==$lv) print 'selected';
			 print '>подъезд '.$lv.'</option>';
			}
		?>
		</select>
	</td></tr>
	<tr><td align=center><font class=top3>Этажи </font><br>
		<select id="stg" name="stg" style="width: 73px;">
		<?php
		  for ($lv=1;$lv<=$maxlevel; $lv++)
			{
			 print '<option value="'.$lv.'" ';
			 if ($_POST["stg"]==$lv) print 'selected';
			 print '>этаж '.$lv.'</option>';
			}
		?>
		</select>
	</td></tr><tr>
	<td><input alt="посмотреть" border=0 hspace=3 name=A1 align=left src="files/forward.gif" type=image></td>
	</tr>
	</table>
	</font>
</td></tr>
</table>
</div>

  <?php  
     if ($_POST["entr"]=='' || $_POST["stg"]=='') $query = 'SELECT * FROM mnem WHERE build='.$_GET["obj"].' AND level=1 AND entrance=1';
     else $query = 'SELECT * FROM mnem WHERE build='.$_GET["obj"].' AND level='.$_POST["stg"].' AND entrance='.$_POST["entr"];
     echo $query.'<br>';
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     $query = 'SELECT * FROM field WHERE mnem='.$uy[0];
     $a = mysql_query ($query,$i);
     if ($a) $uy = mysql_fetch_row ($a);
     while ($uy)
	{
	 if ($uy[7]==1) 
		{
	         if ($uy[4]>30000000) $query = 'SELECT * FROM prdata WHERE type=2 AND pipe='.$uy[8].' AND prm=1 AND device='.$uy[4].' ORDER BY date DESC';
		 else $query = 'SELECT * FROM prdata WHERE type=2 AND pipe=0 AND prm=1 AND device='.$uy[4].' ORDER BY date DESC';
		 $q = mysql_query ($query,$i); $uo[5]=0;
		 if ($q) {$uo = mysql_fetch_row ($q); $h1=$uo[5]; }
		 $top=$uy[3]; $left=$uy[2]+5; 
		 
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>H1</font></div>';
		 $top+=0; $left+=20; $dh=$uo[5];
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl style="font-weight:bold">'.number_format($h1,1).'</font></div>';
       	         if ($uy[5]>30000000) $query = 'SELECT * FROM prdata WHERE type=2 AND pipe='.$uy[8].' AND prm=1 AND device='.$uy[5].' AND date>20090401000000 ORDER BY date DESC';
		 else $query = 'SELECT * FROM prdata WHERE type=2 AND pipe=0 AND prm=1 AND device='.$uy[5].' AND date>20090401000000 ORDER BY date DESC';
		 $q = mysql_query ($query,$i); $uo[5]=0;
		 if ($q) { $uo = mysql_fetch_row ($q); $h2=$uo[5]; }
		 $top=$uy[3]+20; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>H2</font></div>';
		 $top+=0; $left+=20;
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl style="font-weight:bold">'.number_format($h2,1).'</font></div>';
		 $top=$uy[3]+40; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>dH</font></div>';
		 $left+=20; //$dh=$h1-$h2;		 
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.number_format($dh,1).'</font></div>';
		}
	 if ($uy[7]==2)
		{
	         $query = 'SELECT * FROM prdata WHERE type=0 AND pipe=0 AND prm=6 AND device='.$uy[4].' ORDER BY date';
		 $q = mysql_query ($query,$i);
		 if ($q) $uo = mysql_fetch_row ($q);
		 $top=$uy[3]; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vg</font></div>';
		 $top+=2; $left+=20; $dh=$uo[5];
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.number_format($uo[5],2).'</font></div>';

	         $query = 'SELECT * FROM prdata WHERE type=0 AND pipe=1 AND prm=8 AND device='.$uy[4].' ORDER BY date';
		 $q = mysql_query ($query,$i);
		 if ($q) $uo = mysql_fetch_row ($q);
		 $top=$uy[3]+20; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>Vh</font></div>';
		 $top+=0; $left+=20;
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.number_format($uo[5],2).'</font></div>';

	         $query = 'SELECT * FROM prdata WHERE type=2 AND prm=14 AND device='.$uy[5].' ORDER BY date';
		 $q = mysql_query ($query,$i);
		 if ($q) $uo = mysql_fetch_row ($q);
		 $top=$uy[3]+40; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>W</font></div>';
		 $left+=20; $dh-=$uo[5];
		 if ($uo) print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.number_format($uo[5],2).'</font></div>';
		}
	 if ($uy[7]==3)
		{
		 $top=$uy[3]; $left=$uy[2]+5;
		 print '<div style="position:absolute;top:'.$top.';left:'.$left.';width:30;height:15;margin-left:0;padding-left:0;visibility:visible;z-index:15"><font class=zagl>'.$uy[6].'</font></div>';
		}
	 $uy = mysql_fetch_row ($a);
	}
  ?>

</body>
</html>