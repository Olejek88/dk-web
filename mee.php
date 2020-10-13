<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Стояковые</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr><td width=800px colspan=20 bgcolor=#ffcf68 align=center><font class=tablz3>Список всех счетчиков электроэнергии</font></td></tr>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffffff align=center width="120px"><font class=tablz><a href="index.html">home</a></font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>abonent</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>sum</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>curr</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>'.$today["hours"].':00</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>-1</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>-2</font></td>';  
 print '<td bgcolor=#ffffff align=center><font class=tablz>-3</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>-4</font></td>';   
 print '<td bgcolor=#ffffff align=center><font class=tablz>-5</font></td></tr>'; 
?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=4 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $abn=$ui[5];
	  $query = 'SELECT * FROM dev_mee WHERE device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $ids=$ui[7]; $ida=$ui[2];
	  
          $query = 'SELECT * FROM prdata WHERE type=0 AND (prm=14 OR prm=2) AND device='.$uy[1];
          $e = mysql_query ($query,$i); $data0=$data1=0;
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
	      if ($ui[2]==14) $data0=$ui[5];
	      if ($ui[2]==2) $data1=$ui[5];
    	      $ui = mysql_fetch_row ($e);
             }
	 print '<tr bgcolor=#e8e8e8><td align=center bgcolor=#eeedd8><font class=top2>'.$uy[10].' ';
	 printf ("[0x%x][0x%x]",$ids,$ida);
	 print '</font></td><td align=center bgcolor=#e8e8e8><font class=top2>'.$abn.'</font></td>';
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0,3).'</font></td><td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1,3).'</font></td>';

          $query = 'SELECT * FROM prdata WHERE type=1 AND prm=14 AND device='.$uy[1].' ORDER BY date DESC LIMIT 6';
          $e = mysql_query ($query,$i); $cn=0;
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
	      $cn++;
	      print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($ui[5],4).'</font></td>';
    	      $ui = mysql_fetch_row ($e);
             }
	 for ($r=$cn;$r<5;$r++) print '<td align=center bgcolor=#eeedd8><font class=top2>-</td>';
	 if ($cn==0) print '<td align=center bgcolor=#eeedd8><font class=top2>-</td>';

	 print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
?>

</table>
</body>
</html>