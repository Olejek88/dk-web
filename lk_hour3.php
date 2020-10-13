<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Все ресурсы квартиры по дням</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1100px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td width=300px valign=top>
<table width=300px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
<tr>
<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $today=getdate();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);

 print '<td bgcolor=#ffcf68 align=center><font class=tablz>дата</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Qотоп</font></td>';
 //print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Qгвс</font></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>Qоб</font></td>';
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vгвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>Vхвс</font></td>'; 
 print '<td bgcolor=#ffcf68 colspan=2 align=center><font class=tablz>W</font></td></tr>'; 

 print '<tr><td bgcolor=#ffcf68 align=center></td>';
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>инд</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>'; 
 //print '<td bgcolor=#ffcf68 align=center><font class=tablz>инд</font></td>'; 
 //print '<td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>сум</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>инд</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>инд</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>инд</font></td>'; 
 print '<td bgcolor=#ffcf68 align=center><font class=tablz>общ</font></td>'; 
 print '</tr>'; 

 $today=getdate();
 if ($_GET["year"]=='') $ye=$today["year"];
 else $ye=$_GET["year"];
 if ($_GET["month"]=='') $mn=$today["mon"];
 else $mn=$_GET["month"];
 $x=0; $tm=$dy=$today["mday"]-1;
 for ($tn=1; $tn<=50; $tn++)
	{		
	 $date1=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $dat[$x]=sprintf ("%02d-%02d",$tm,$mn);   
	 $query = 'SELECT * FROM data WHERE type=2 AND flat='.$_GET["flat"].' AND date='.$date1;
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);
	 $data0=$data1=$data2=$data3=$data4=$data5=$data6=$data7='-';
	 while ($uy)
	      {          
	       if ($uy[8]==13 && $uy[6]==0) $data0=number_format($uy[3],2);
	       if ($uy[8]==13 && $uy[6]==1) $data1=number_format($uy[3],2);
	       if ($uy[8]==11 && $uy[6]==5) $data3=number_format($uy[3],2);
	       if ($uy[8]==11 && $uy[6]==15) $data4=number_format($uy[3],2);
	       if ($uy[8]==11 && $uy[6]==6) $data5=number_format($uy[3],1);
	       if ($uy[8]==11 && $uy[6]==16) $data6=number_format($uy[3],1);
	       if ($uy[8]==2 && $uy[6]==0) $data7=number_format($uy[3],2);
	       if ($uy[8]==2 && $uy[6]==1) $data8=number_format($uy[3],2);
	       $uy = mysql_fetch_row ($a);	     
	      }	 
	 if ($data0!='-' || $data1!='-')
		{
		 $data2=$data0+$data1;
	         print '<tr><td align=center bgcolor=#ffcf68 width=100><font class=top2>'.$dat[$x].'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data0.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data1.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data6.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data7.'</font></td>';
		 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8.'</font></td></tr>';
		 $dat0+=$data0; $dat1+=$data1; $dat2+=$data2; $dat3+=$data3; $dat4+=$data4;
		 $dat5+=$data5; $dat6+=$data6; $dat7+=$data7; $dat8+=$data8;
		 $qq.='d'.$x.'='.$dat[$x].'&e'.$x.'='.$data0.'&o'.$x.'='.$data1.'&';
		 $gg.='d'.$x.'='.$dat[$x].'&e'.$x.'='.$data3.'&o'.$x.'='.$data4.'&';
		 $hh.='d'.$x.'='.$dat[$x].'&e'.$x.'='.$data5.'&o'.$x.'='.$data6.'&';
		 $ww.='d'.$x.'='.$dat[$x].'&e'.$x.'='.$data7.'&o'.$x.'='.$data8.'&';
		 $x++;
		}
   	 $tm--;
	 if ($tm==0)
		{
		 $mn--;
		 if ($mn==0) { $mn=12; $ye--; }
		 $dy=31;
		 if (!checkdate ($mn,31,$ye)) { $dy=30; }
		 if (!checkdate ($mn,30,$ye)) { $dy=29; }
		 if (!checkdate ($mn,29,$ye)) { $dy=28; }
		 $tm=$dy;
		}
       }
   print '<tr><td align=center bgcolor=#ffcf68><font class=top2></font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat0.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat1.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat2.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat3.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat4.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat5.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat6.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat7.'</font></td>';
   print '<td align=center bgcolor=#ffcf68><font class=top2>'.$dat8.'</font></td></tr>';
?>
</table></td>
<td width=800px>
<table width=800px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<?php 
	print '<tr><td><img width=800 height=250 src="charts/barplots26.php?type=1&'.$qq.'"></td></tr>'; 
	print '<tr><td><img width=800 height=250 src="charts/barplots26.php?type=2&'.$gg.'"></td></tr>'; 
	print '<tr><td><img width=800 height=250 src="charts/barplots26.php?type=3&'.$hh.'"></td></tr>'; 
	print '<tr><td><img width=800 height=250 src="charts/barplots26.php?type=4&'.$ww.'"></td></tr>'; 
?>
</table>
</td></tr></table>
</body>
</html>