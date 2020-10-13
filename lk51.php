<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Задание исходных значений по холодной и горячей воде</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<style type="text/css">
    .mainb {font-family:tahoma; font-weight:bold; font-size: 11px; }
    .log {font-family:tahoma; font-size: 10px; }
</style>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate(); $begintime=time();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];

 $query = 'SELECT * FROM device WHERE type=11';
 $a = mysql_query ($query,$i); $cm=0;
 if ($a) $uy = mysql_fetch_row ($a);
 if ($uy) { $hv=$uy[21]; $gv=$uy[22]; }

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 if ($_GET["date"]=='') $month=1;
 else $month=$_GET["date"];
 include("time.inc"); 
 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i); $cn=0;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
    {
     $data01[$cn]=$data02[$cn]=$data11[$cn]=$data12[$cn]=0;     
     $query = 'SELECT * FROM device WHERE type=2 AND flat='.$uy[1];
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e);
     if ($ui) 
	{
	 $device[$cn]=$ui[1]; 
	 $cn++;
	}
     $uy = mysql_fetch_row ($a);
    }
 $max=$cn-1; $cn=0; 

 $query = 'SELECT * FROM prdata WHERE (type=2) AND prm=8 ORDER BY date DESC LIMIT 14000';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data01[$w]==0)  $data01[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                

 $query = 'SELECT * FROM prdata WHERE (type=2) AND prm=6 ORDER BY date DESC LIMIT 14000';	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 while ($ui)
    {
     for ($w=0;$w<=$max;$w++) if ($device[$w]==$ui[1])
     if ($data02[$w]==0)  $data02[$w]=$ui[5]; 
     $ui = mysql_fetch_row ($e);    
    }                                                

 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i); $cm=0;
 if ($a) $uy = mysql_fetch_row ($a);
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $today["mday"]=31;
	  $flat[$cm]=$ui[1]; $abn[$cm]=$ui[5]; $nab[$cm]=$ui[10];
	  $sum0[$cm]=$data01[$cm];
	  $sum1[$cm]=$data02[$cm];

	  $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$ui[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  if ($ui) { $hvs[$flat[$cm]]=$ui[14]; $gvs[$flat[$cm]]=$ui[15]; }
 	 $cm++;	         
 	 $uy = mysql_fetch_row ($a);
	}
 print '<table width=1200px cellpadding=1 cellspacing=1 bgcolor=#664466 align=center><tr bgcolor=#ffcf68 valign=top><td colspan=2 align=center><font class=tablz3>Задание исходных значений по холодной и горячей воде</font></td>';
 print '<form name="reda" method=post action="tobd.php" enctype="multipart/form-data">
 <td align=center><font class=tablz3>ХВС дом разница</font>&nbsp;&nbsp;<input name="hvs" size=7 class=log style="height:18px" value="'.$hv.'"></td>
 <td align=center><font class=tablz3>ГВС дом разница</font>&nbsp;&nbsp;<input name="gvs" size=7 class=log style="height:18px" value="'.$gv.'"></td>
 <td><input name="frm" size=1 style="height:1;width:1;visibility:hidden" value="2"></td>
 <td align=center><font class=tablz3><input name="gv" size=10 class=log style="height:18px" type=submit value="записать"></font></td></form>';
 print '</tr></table>';
?>
</tr></table>

<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>хвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>хвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>хвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>гвс</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"><font class=tablz><a href="index.html">N</a></font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>хвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>гвс</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center width="20px"></td><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>пот</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>разн</font></td>'; 
 print '</tr>'; 

?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 print '<form name="reda" method=post action="tobd.php" enctype="multipart/fom-data">';
 while ($uy)
         {
	 if ($flat[$cm]%4==1) print '<tr bgcolor=#e8e8e8>';
	 print '<td align=center bgcolor=#eeeeee><font class=top2>'.$flat[$cm].'</font></td>'; 
	 print '<td align=left bgcolor=#eeeeee><a href="lk_ch.php?flat='.$flat[$cm].'&obj='.$_GET["obj"].'&device='.$uy[1].'"><font class=top2>'.$abn[$cm].'</font></td>';
	 print '<form name="reda" method=post action="tobd.php" enctype="multipart/form-data">';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum0[$cm],2).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><input name="hvs'.$flat[$cm].'" size=5 class=log style="height:18px" value="'.$hvs[$flat[$cm]].'"></td>';
	 print '<td align=center align=left bgcolor=#ffffff><font class=top2>'.number_format($sum1[$cm],2).'</font></td>';
	 print '<td align=center align=left bgcolor=#eeeeee><input name="gvs'.$flat[$cm].'" size=5 class=log style="height:18px" value="'.$gvs[$flat[$cm]].'"></td>';
	 if ($flat[$cm]%4==0) print '</tr>';
	 $cm++;
	 $uy = mysql_fetch_row ($a);
	}
 print '<td colspan=21 bgcolor=#e8e8e8></tr>'; 
?>
</table>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td><input name="frm" size=1 style="height:1;width:1;visibility:hidden" value="1"></td></tr>
<tr><td align=center><input name="gv" size=10 class=log style="height:18px" type=submit value="Подтвердить изменения"></td></tr>
</table></form>
</body>
</html>