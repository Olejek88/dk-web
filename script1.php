<title>Система учета индивидуального потребления энергоресурсов :: Пересчет дневных показаний</title>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr><td width=1190px bgcolor=#ffcf68 align=center><font class=tablz3>Пересчет дневных показаний на базе часовых</font></td></tr>
<tr><td style="width:1190px" valign=top>
<table cellpadding="0" cellspacing="1" border="0" style="width:1190px" align=center>
<tr>
<td style="width:800px" valign=top>
    <table width=800px cellpadding=2 cellspacing=1 bgcolor=#664466 align=center>
	<tr><td bgcolor=#ffcf68 align=center width=70px><font class=tablz>дата</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дTп,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дTо,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дQп,Г</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дQо,Г</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дG1,т</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дG2,т</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дQСО</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дQпот</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дGхв,t</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дGгв,t</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>дW,kWt</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tп,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Tо,С</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qп,Г</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qо,Г</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G1,т</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>G2,т</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>QСО</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Qпот</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gхв,t</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>Gгв,t</font></td>
	<td bgcolor=#ffcf68 align=center><font class=tablz>W,kWt</font></td>
	</tr>
	<?php  
	include("config/local.php");
	$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);

	$today=getdate();
	if ($_GET["year"]=='') $ye=$today["year"];
	else $ye=$_GET["year"];
	if ($_GET["month"]=='') $mn=$today["mon"];
	else $mn=$_GET["month"];

	$x=0; $nn=1; $ts=23;
	$tm=$dy=$today["mday"]-1;
			
	for ($tn=1; $tn<=80; $tn++)
		{		
		 $date[$x]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
		 $dat[$x]=sprintf ("%d-%02d-%02d 00:00:00",$ye,$mn,$tm);
		 //echo $date[$x].' '.$dat[$x].'<br>';
	         $x++; $tm--; 
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

	 $query = 'SELECT * FROM data WHERE type=1 AND flat=0 ORDER BY date DESC LIMIT 50000';
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);			 
	 while ($uy)
	      	{
		 $x=51;
		 $uy[2][11]='0'; $uy[2][12]='0'; $uy[2][14]='0'; $uy[2][15]='0'; $uy[2][17]='0'; $uy[2][18]='0';
		 for ($tn=0; $tn<=50; $tn++)
		 if ($uy[2]==$dat[$tn]) $x=$tn; 
					
	       	 if ($uy[8]==4 && $uy[6]==0) $data0[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==4 && $uy[6]==1) $data1[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==11 && $uy[6]==0) $data2[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==11 && $uy[6]==1) $data3[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==12 && $uy[6]==0) $data4[$x]+=number_format($uy[3],1);
	       	 if ($uy[8]==12 && $uy[6]==1) $data5[$x]+=number_format($uy[3],1);
	       	 if ($uy[8]==13 && $uy[6]==0) $data6[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==13 && $uy[6]==2) $data8[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==13 && $uy[6]==3) $data9[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==12 && $uy[6]==6) $data10[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==12 && $uy[6]==5) $data11[$x]+=number_format($uy[3],2);
	       	 if ($uy[8]==14 && $uy[6]==0) $data12[$x]+=number_format($uy[3],2);
		 $uy = mysql_fetch_row ($a);			 
	      	}

	 $query = 'SELECT * FROM data WHERE type=2 AND flat=0 ORDER BY date DESC LIMIT 8000';
	 echo $query.'<br>';
	 $a1 = mysql_query ($query,$i);
	 if ($a1) $uy1 = mysql_fetch_row ($a1);
	 while ($uy1)
		{
		 for ($tn=0; $tn<=80; $tn++) 
		 if ($uy1[2]==$dat[$tn]) $x=$tn;
		      {
		       if ($uy1[8]==4 && $uy1[6]==0) $data20[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==4 && $uy1[6]==1) $data21[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==11 && $uy1[6]==0) $data22[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==11 && $uy1[6]==1) $data23[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==12 && $uy1[6]==0) $data24[$x]=number_format($uy1[3],1);
		       if ($uy1[8]==12 && $uy1[6]==1) $data25[$x]=number_format($uy1[3],1);
		       if ($uy1[8]==13 && $uy1[6]==0) $data26[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==13 && $uy1[6]==2) $data28[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==13 && $uy1[6]==3) $data29[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==12 && $uy1[6]==6) $data30[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==12 && $uy1[6]==5) $data31[$x]=number_format($uy1[3],2);
		       if ($uy1[8]==14 && $uy1[6]==0) $data32[$x]=number_format($uy1[3],1);
		      }
	       	 $uy1 = mysql_fetch_row ($a1);	     
		}
	 for ($tn=0; $tn<=80; $tn++) 
		{
		 $data10[$tn]=$data10[$tn]-$data11[$tn];
		 $data30[$tn]=$data30[$tn]-$data31[$tn];
		 if ($data0[$tn]!='-' || $data1[$tn]!='-')
			{
			 print '<tr><td align=center bgcolor=#ffcf68><font class=top2>'.$dat[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data0[$tn]/24,2).'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.number_format($data1[$tn]/24,2).'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data2[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data3[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data4[$tn].'</font></td>';

			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data5[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data8[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data9[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data10[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data11[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data12[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data20[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data21[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data22[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data23[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data24[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data25[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data28[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data29[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data30[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data31[$tn].'</font></td>';
			 print '<td align=center bgcolor=#e8e8e8><font class=top2>'.$data32[$tn].'</font></td></tr>';
			}
		 if ($data20[$tn]>0) echo ''; 
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.number_format($data0[$tn]/24,2).'\',\'4\',\'0\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data21[$tn]>0) echo '';
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.number_format($data1[$tn]/24,2).'\',\'4\',\'1\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
 		 if ($data2[$tn]>$data22[$tn]*2) if ($data22[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data2[$tn].'\' WHERE prm=11 AND source=0 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data2[$tn].'\',\'11\',\'0\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data3[$tn]>$data23[$tn]*2) if ($data23[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data3[$tn].'\' WHERE prm=11 AND source=1 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data3[$tn].'\',\'11\',\'1\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data4[$tn]>$data24[$tn]*2) if ($data24[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data4[$tn].'\' WHERE prm=12 AND source=0 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data4[$tn].'\',\'12\',\'0\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data5[$tn]>$data25[$tn]*2) if ($data25[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data5[$tn].'\' WHERE prm=12 AND source=1 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data5[$tn].'\',\'12\',\'1\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data8[$tn]>$data28[$tn]*2) if ($data28[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data8[$tn].'\' WHERE prm=13 AND source=2 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data8[$tn].'\',\'13\',\'2\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data9[$tn]>$data29[$tn]*2) if ($data29[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data9[$tn].'\' WHERE prm=13 AND source=3 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data9[$tn].'\',\'13\',\'3\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data10[$tn]>$data30[$tn]*2) if ($data30[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data10[$tn].'\' WHERE prm=12 AND source=6 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data10[$tn].'\',\'12\',\'6\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data11[$tn]>$data31[$tn]*2) if ($data31[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data11[$tn].'\' WHERE prm=12 AND source=5 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data11[$tn].'\',\'12\',\'5\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 if ($data12[$tn]>$data32[$tn]*2) if ($data32[$tn]>0) { $query = 'UPDATE data SET date=date,value=\''.$data12[$tn].'\' WHERE prm=14 AND source=0 AND type=2 AND flat=0 AND date='.$date[$tn]; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 else { $query = 'INSERT INTO data (date,value,prm,source,type,flat) VALUES(\''.$date[$tn].'\',\''.$data12[$tn].'\',\'14\',\'0\',\'2\',\'0\')'; echo $query.'<br>'; $a1 = mysql_query ($query,$i); }
		 //$a1 = mysql_query ($query,$i);
		}
	?>
	</table>
    </td>
</tr>

</table>
</td></tr></table>