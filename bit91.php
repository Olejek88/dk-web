<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Предварительное распределение тепловой энергии по квартирам</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0 align=center>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr>
<td width=1200 valign=top>
<table width=300 bgcolor=#ffffff valign=top cellpadding=1 cellspacing=1><tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i); $sumfl=0;
 $uy = mysql_fetch_row ($a);
 while ($uy)
	 {
	  $sumfl+=$uy[8];
	  $sflats[$uy[1]]=$uy[8];
	  $qflats[$uy[1]]=0;
	  $uy = mysql_fetch_row ($a);
	 }

for ($t=1;$t<=42;$t++)
{
 print '<td><img width=200 height=100 src="barplots19.php?type='.$t.'"></td>';
 if ($t%6==0) print '</tr><tr>';
}
?>
</tr></table>
</td></tr></table>
<table width=1200px cellpadding=1 cellspacing=1 align=center>
<tr>
<?php
 print '<td width=400 valign=top><table width=400 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>Стояк</font></td>';
// print '<td bgcolor=#ffcf68 align=center><font class=tablz>0-9(1-9)</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>3</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>4</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>5</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>6</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>7</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>8</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>9</font></td>';
// print '<td bgcolor=#ffcf68 align=center><font class=tablz>1-9</font></td></tr>';

 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);  $sq=0;
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $query = 'SELECT * FROM prdata WHERE type=2 AND device='.$uy[1].' AND (prm=1 OR prm=13) AND value>0 AND date<=20090402000000 ORDER BY date DESC LIMIT 4';
	  $r = mysql_query ($query,$i);
	  $ur = mysql_fetch_row ($r);
	  while ($ur)
		{
		 if ($ur[2]==1) $irp[$cn][$ur[2]][$ur[7]]=$ur[5]/3600;
		 else $irp[$cn][$ur[2]][$ur[7]]=$ur[5];
		 $ur = mysql_fetch_row ($r);
		}
	  $sq+=$irp[$cn][13][0];
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
 $irp[2][13][0]=$sq/42;  $irp[39][13][0]=$sq/42;
 $ssgvs=0;

 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=12 AND source=6 AND date=20090402000000';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 if ($ur) $sgvs=$ur[3];

 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=13 AND source=2 AND date=20090402000000';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 if ($ur) $ssq=$ur[3];

 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 AND prm=13 AND source=3 AND date=20090402000000';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 if ($ur) $ssq2=$ur[3];
 $ssq3=($ssq2-$ssq)*4168;

 $query = 'SELECT SUM(value) FROM prdata WHERE type=2 AND prm=7 AND date=20090402000000';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 if ($ur) $ssgvs=$ur[0];

 $query = 'SELECT * FROM prdata WHERE type=2 AND prm=7 AND date=20090402000000';
 $r = mysql_query ($query,$i);
 $ur = mysql_fetch_row ($r);
 while ($ur) 
	{
	 $query = 'SELECT flat_number FROM dev_2ip WHERE device='.$ur[1];
	 $a = mysql_query ($query,$i);
	 $uy = mysql_fetch_row ($a);
	 if ($uy) $qgvs[$uy[0]]=$ur[5];
	 $ssgvs+=$ur[5];	 
	 $ur = mysql_fetch_row ($r);
	}
 $ssgvs=$ssgvs;
	
 $qod=$ssq*4168-$sq;
 //echo $ssq.' '.$sq.' '.$qod.' sum='.$sumfl.'	<br>';
 $query = 'SELECT * FROM dev_irp ORDER BY strut';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cn=1;
 while ($uy)
	 {
	  $str=$uy[3];
	  print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$str.'</font></td>';
  	  $data[0]=1*($irp[$str][1][0]);
	  $data[10]=1*($irp[$str][1][1]);
	  //echo $data[10].'-'.$data[0].'<br>';
	  $query = 'SELECT COUNT(id) FROM dev_bit WHERE strut_number='.$str;
	  $b = mysql_query ($query,$i);
	  $un = mysql_fetch_row ($b); $cn=1;
	  if ($un[0]==8) { $data[1]=0; $cn++; }

	  $query = 'SELECT * FROM dev_bit WHERE strut_number='.$str.' ORDER BY flat_number';
	  $b = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($b);
	  while ($ui)
		{
		  $query = 'SELECT * FROM prdata WHERE prm=1 AND type=2 AND device='.$ui[1].' AND value>0 AND date=20090402000000';
		  $r = mysql_query ($query,$i);
		  $ur = mysql_fetch_row ($r);
		  $data[$cn]=$ur[5];
		  $col[$str][$cn]=1*255*($ui[8]%10)+(254-($ui[8]%10)); //echo ' '.$data[$cn].'<br>'; 
		  $flat[$str][$cn]=$ui[8];		  
		  $cn++;	
		  $ui = mysql_fetch_row ($b);        
		}	

	  $ct=0; $sum=0;
	  for ($u=0; $u<=8; $u++)  
		{
		 $d=$u+1;
		 //echo '['.$u.'] '.$data[$u].' '.$data[$u+1].'('.$data[9].')<br>';
		 if ($u==0)	
			{
			 $data0[0]=0; $data0[9]=0;
			 //echo '['.$u.'] '.$data[1].' '.$data[2].'('.$data[10].')<br>';
			 if (($data[1]-$data[9]<400)) 
				{
				 $data0[0]=($data[1]-$data[9]);
				 //echo '['.$u.'] '.$data[2].'-'.$data[10].'<br>';
				 $data0[9]=($data[2]-$data[10]);
				}
			 else if (($data[0]-$data[9]<400)) 
				{
				 $data0[0]=($data[0]-$data[9]);
				 //echo '['.$u.'] '.$data[1].'-'.$data[10].'<br>';
				 $data0[9]=($data[1]-$data[10]);
				}
			 //echo $data0[9].'<br>';
			 if ($data0[0]<0 || $data0[0]>1000) $data0[0]=0;
			 if ($data0[9]<0 || $data0[9]>1000) $data0[9]=0;	
		        }
		 if ($u>0)
			{
			 if (($data[$u+1]-$data[$u]<400) && ($data[$u+1]-$data[$u]>0)) $data0[$u]=($data[$u+1]-$data[$u]); 
			 else $data0[$u]=0;
			}
		 if ($data0[$u]>0) { $sum+=$data0[$u]; $ct++; }
		}
	  $dh=0;
	  for ($u=0; $u<=9; $u++) 
		{
		 if ($data0[$u]==0) $data0[$u]=$sum/$ct;
		 $dh+=$data0[$u];
		}

	  for ($u=0; $u<=8; $u++) 
	       {		
	  	if ($u>0) { $k[$str][$u]=$data0[$u]/$dh; $datas[$str][$u]=$k[$str][$u]*$irp[$str][13][0]; }
	 	else if ($data0[0]>$data0[9]) { $k[$str][$u]=$data0[9]/$dh; $datas[$str][$u]=$k[$str][$u]*$irp[$str][13][0]; }
		     else { $k[$str][$u]=$data0[0]/$dh; $datas[$str][$u]=$k[$str][0]*$irp[$str][13][0]; }
		//echo $k[$str][$u].' '.$datas[$str][$u].'<br>';
		$qflats[$flat[$str][$u+1]]+=$datas[$str][$u];
		$qoflats[$flat[$str][$u+1]]=$qod*$sflats[$flat[$str][$u+1]]/$sumfl;
	       }

	  for ($w=1;$w<10;$w++)
		{
		 if ($data0[$w]) print '<td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($data0[$w],2).'</font></td>';
		 else print '<td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
		}
	  print '</tr>';
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	 }
?>
</table></td>
<td><table cellpadding=1 cellspacing=1><tr>

<?php
 print '<td width=100 valign=top><table width=100 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr><td bgcolor=#ffcf68 align=center><font class=tablz>Qст</font></td></tr>';
 for ($u=1; $u<=42; $u++)  
	 print '<tr><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($irp[$u][13][0],2).'</font></td></tr>';
 print '</table></td>';

 print '<td width=500 valign=top><table width=500 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1><tr>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>1</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>2</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>3</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>4</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>5</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>6</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>7</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>8</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>9</font></td></tr>';

 for ($str=1; $str<=42; $str++)
	{
	 print '<tr>';
	 for ($u=0; $u<=8; $u++)    
	 	{ print '<td bgcolor=#aa'; printf ("%x",$col[$str][$u+1]); print ' align=center><font class=tablz>'.number_format($datas[$str][$u],2).'</font></td>'; }
	 print '</tr>';
	}
 print '</table></td>';
 

?>
</tr></table></td></tr>
</table></td></tr>

<tr>
<td width=1200 valign=top>
<table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center colspan=32><font class=tablz>Индивидуальное теплопотребление квартир, кДж</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Sэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Уд.Qэт/м2</font></td>
<?php
 for ($u=0; $u<=8; $u++)
	{
	 print '<tr>';
	 $flats=0; $cnt=0; $ss=0; $sum=0;
	 for ($fl=1; $fl<=141; $fl++)
	     {
	      for ($str=1; $str<=42; $str++)
	      if ($fl==$flat[$str][$u+1])
		{
	         print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$str][$u+1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($qflats[$flat[$str][$u+1]],2).'</font></td>';
		 $sum+=$qflats[$flat[$str][$u+1]];
		 $ss+=$sflats[$flat[$str][$u+1]];
		 $cnt++; break;
		} 
	     } 
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($ss,2).'</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum/$ss,2).'</font></td>';
	 print '</tr>';
	}
?>
</table></td></tr>

<tr>
<td width=1200 valign=top><br>
<table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center colspan=32><font class=tablz>Удельное теплопотребление квартир, кДж/м3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qoэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Sэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Уд.Qэт/м2</font></td>
<?php
 for ($u=0; $u<=8; $u++)
	{
	 print '<tr>';
	 $flats=0; $cnt=0; $ss=0; $sum=0;
	 for ($fl=1; $fl<=141; $fl++)
	     {
	      for ($str=1; $str<=42; $str++)
	      if ($fl==$flat[$str][$u+1])
		{
	         print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$str][$u+1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($qflats[$flat[$str][$u+1]]/$sflats[$flat[$str][$u+1]],2).'</font></td>';
		 $sum+=$qflats[$flat[$str][$u+1]];
		 $ss+=$sflats[$flat[$str][$u+1]];
		 $cnt++; break;
		} 
	     } 
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($ss,2).'</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum/$ss,2).'</font></td>';
	 print '</tr>';
	}
?>
</table></td></tr>

<tr>
<td width=1200 valign=top><br>
<table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center colspan=32><font class=tablz>Рапределение общедомовых потерь квартир, кДж</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qoэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Sэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Уд.Qэт/м2</font></td>
<?php
 for ($u=0; $u<=8; $u++)
	{
	 print '<tr>';
	 $flats=0; $cnt=0; $ss=0; $sum=0;
	 for ($fl=1; $fl<=141; $fl++)
	     {
	      for ($str=1; $str<=42; $str++)
	      if ($fl==$flat[$str][$u+1])
		{
	         print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$str][$u+1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($qoflats[$flat[$str][$u+1]],2).'</font></td>';
		 $sum+=$qoflats[$flat[$str][$u+1]];
		 $ss+=$sflats[$flat[$str][$u+1]];
		 $cnt++; break;
		} 
	     } 
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($ss,2).'</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum/$ss,2).'</font></td>';
	 print '</tr>';
	}
?>
</table></td></tr>

<tr>
<td width=1200 valign=top><br>
<table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center colspan=32><font class=tablz>Тепловая энергия на подготовку горячей воды, кДж</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qoэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Sэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Уд.Qэт/м2</font></td>
<?php
 for ($u=0; $u<=8; $u++)
	{
	 print '<tr>';
	 $flats=0; $cnt=0; $ss=0; $sum=0;
	 for ($fl=1; $fl<=141; $fl++)
	     {
	      for ($str=1; $str<=42; $str++)
	      if ($fl==$flat[$str][$u+1])
		{
	         print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$str][$u+1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ssq3*($qgvs[$flat[$str][$u+1]]/$ssgvs),2).'</font></td>';
		 $sum+=$ssq3*($qgvs[$flat[$str][$u+1]]/$ssgvs);
		 $ss+=$sflats[$flat[$str][$u+1]];
		 $cnt++; break;
		} 
	     } 
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($ss,2).'</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum/$ss,2).'</font></td>';
	 print '</tr>';
	}
?>
</table></td></tr>

<tr>
<td width=1200 align=center valign=top><br>
<table width=1200 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center colspan=32><font class=tablz>Абонентское теплопотребление квартир, кДж</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qсум,эт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Sэт</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Уд.Qэт/м2</font></td>
<?php
 for ($u=0; $u<=8; $u++)
	{
	 print '<tr>';
	 $flats=0; $cnt=0; $ss=0; $sum=0;
	 for ($fl=1; $fl<=141; $fl++)
	     {
	      for ($str=1; $str<=42; $str++)
	      if ($fl==$flat[$str][$u+1])
		{
	         print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.$flat[$str][$u+1].'</font></td><td bgcolor=#e8e8e8 align=center><font class=tablz>'.number_format($ssq3*($qgvs[$flat[$str][$u+1]]/$ssgvs)+$qflats[$flat[$str][$u+1]]+$qoflats[$flat[$str][$u+1]],2).'</font></td>';
		 $sum+=$qoflats[$flat[$str][$u+1]]+$qflats[$flat[$str][$u+1]]+$ssq3*($qgvs[$flat[$str][$u+1]]/$ssgvs);
		 $ss+=$sflats[$flat[$str][$u+1]];
		 $cnt++; break;
		} 
	     } 
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 if ($u==0) print '<td bgcolor=#ffcf68 align=center></td><td bgcolor=#e8e8e8 align=center><font class=tablz>-</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum,2).'</font></td>';
	 print '<td bgcolor=#ffcf68 align=center><font class=tablz>'.number_format($ss,2).'</font></td>';
	 print '<td bgcolor=#eecf68 align=center><font class=tablz>'.number_format($sum/$ss,2).'</font></td>';
	 print '</tr>';
	}
?>
</table></td></tr>
</table>
</body>
</html>