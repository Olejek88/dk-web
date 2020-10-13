<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Значения с датчиков воды</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr><td width=800px colspan=20 bgcolor=#ffcf68 align=center><font class=tablz3>Список всех водосчетчиков</font></td></tr>
<tr>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffffff align=center width="80px"><font class=tablz><a href="index.html">home</a></font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>abonent</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>date</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>Q1</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>Q2</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>V1</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>V2</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>'.$today["hours"].':00</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>-1</font></td>';
 print '<td bgcolor=#ffffff align=center><font class=tablz>-2</font></td>';  
 print '<td bgcolor=#ffffff align=center><font class=tablz>-3</font></td>'; 
 print '<td bgcolor=#ffffff align=center><font class=tablz>-4</font></td></tr>'; 
?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=2 AND ust=0 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $abn=$ui[5];
	  $query = 'SELECT * FROM dev_2ip WHERE device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $ids=$ui[3]; $ida=$ui[4];
	  
          $query = 'SELECT * FROM prdata WHERE type=0 AND (prm=5 OR prm=6 OR prm=7 OR prm=8) AND device='.$uy[1];
          $data0=$data1=$data2=$data3='-';
	  
          $e = mysql_query ($query,$i);
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
	      if ($ui[2]==5) $data0=$ui[5];
	      if ($ui[2]==7) $data1=$ui[5];
	      if ($ui[2]==6) $data2=$ui[5];
	      if ($ui[2]==8) $data3=$ui[5];
	      $dat=$ui[4];
    	      $ui = mysql_fetch_row ($e);
             }
	 if ($data0!='-') $cm++;
	 print '<tr bgcolor=#e8e8e8><td align=left bgcolor=#eeedd8><font class=top2>'.$uy[10].' ';
	 printf ("[0x%x][0x%x]",$ids,$ida);
	 print '</font></td><td align=center bgcolor=#e8e8e8><font class=top2>'.$abn.'</font></td>';
	 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$dat.'</font></td>';	 
	 print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data0,2).'</font></td><td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data1,2).'</font></td>';
	 print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data2,2).'</font></td><td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data3,2).'</font></td>';

          $query = 'SELECT * FROM prdata WHERE type=2 AND (prm=6 OR prm=8) AND device='.$uy[1].' ORDER BY date DESC,prm LIMIT 10';
          $e = mysql_query ($query,$i); $dt0=$dt1=0; $cn=0;
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
	      if ($ui[2]==6) $dt0=$ui[5];
	      if ($ui[2]==8) 
	    	{
		 $dt1=$ui[5]; $cn++;
		 if ($cn>5) break;
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($dt0,2).' | '.number_format($dt1,2).'</font></td>';
		}
    	      $ui = mysql_fetch_row ($e);
             }
	 for ($r=$cn;$r<5;$r++) print '<td bgcolor=#e8e8e8 align=center><font class=top2>-</font></td>';
	 $all++;
	 print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
   print '<tr><td bgcolor=#ffffff align=center colspan=12><font class=tablz>data frm 2ip '.$cm.'/'.$all.' ('.$cm*100/$all.'%)</font></td></tr>';
?>

</table>
</body>
</html>