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

 print '<td bgcolor=#ffcf68 align=center width="120px">Адрес</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Абонент</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Дата</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>H</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Hsum</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Tavg</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$today["mday"].'/'.$today["mon"].'</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>-1</font></td>';  
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>-2</font></td>';   
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>-3</font></td>';  
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>-4</font></td>';   
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>-5</font></td>';   
 print '</tr>'; 
?>
</tr>

<?php
 $query = 'SELECT * FROM device WHERE type=1 ORDER BY flat,adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[10];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $abn=$ui[5];
	  $query = 'SELECT * FROM dev_bit WHERE device='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  if ($ui) {  $ids=$ui[3]; $ida=$ui[4]; $str=$ui[9];}
//		else print 'device '.$uy[1].' not found <br>';
	  
          $query = 'SELECT * FROM prdata WHERE type=0 AND (prm=1 OR prm=31 OR prm=4) AND device='.$uy[1];
          $data0=$data1=$data2='-';
	  
          $e = mysql_query ($query,$i);
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
	      if ($ui[2]==1) $data0=$ui[5];
	      if ($ui[2]==31) $data1=$ui[5];
	      if ($ui[2]==4) $data2=$ui[5];
	      $dat=$ui[4];
    	      $ui = mysql_fetch_row ($e);
             }
	 if ($data0!='-') $cm++;
	 print '<tr bgcolor=#ffcf68><td align=left bgcolor=#ffcf68><font class="tablz">'.$uy[10].' ';
	 printf ("[0x%x][0x%x][%02d]",$ids,$ida,$str);
	 print '</font></td><td align=center bgcolor=#e8e8e8><font class=top2>'.$abn.'</font></td>';
	 print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat.'</font></td>';	 
	 print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data0,2).'</font></td><td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data1,2).'</font></td>';
	 print '<td align=center bgcolor=#eeedd8><font class=top2>'.number_format($data2,2).'</font></td>';

          $query = 'SELECT * FROM prdata WHERE type=2 AND prm=1 AND device='.$uy[1].' ORDER BY date DESC,prm LIMIT 6';
          $e = mysql_query ($query,$i); $cn=0;
          if ($e) $ui = mysql_fetch_row ($e);
          while ($ui)
             {
    	      print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($ui[5],2).'</font></td>';
	      $cn++;
    	      $ui = mysql_fetch_row ($e);
             }
	 for ($r=$cn;$r<6;$r++) print '<td bgcolor=#e8e8e8 align=center><font class=top2>-</font></td>';

	 $all++;
	 print '</tr>';
	 $uy = mysql_fetch_row ($a);
	}
   print '<tr><td bgcolor=#ffffff align=center colspan=12><font class=tablz>data from bit '.$cm.'/'.$all.' ('.$cm*100/$all.'%)</font></td></tr>';
?>

</table>