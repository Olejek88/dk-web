<title>Анализ показаний стенда</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1190px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center border=0>
<tr><td valign=top>

<table width=680px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td width=680 valign=top>
<table width=680 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz><?php $today=getdate(); print $today["mday"].'/'.$today["mon"]; ?></font></td><td bgcolor=#ffcf68 align=center colspan=23<font class=tablz>Первичные данные с приборов</font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>время</font></td>
<td bgcolor=#ffcf68 align=center colspan=11><font class=tablz>Температура</font></td>
<td bgcolor=#ffcf68 align=center colspan=6><font class=tablz>Энтальпия</font></td>
<td bgcolor=#ffcf68 align=center colspan=6><font class=tablz>Объемный расход</font></td>
</tr>
<tr>
<td bgcolor=#ffcf68 align=center><font class=tablz></font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Тпр</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Тбит1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Ткм1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dT1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Тбит2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Ткм2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dT2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Тбит3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Ткм3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dT3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Тобр</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Hпр</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Hбит1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Hбит2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Hбит3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Hобр</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dH</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Gкм</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Gирп</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Gкм1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Gкм2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Gкм3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dG</font></td>
</tr>

<?php

$query = 'SELECT * FROM device';
$e = mysql_query ($query,$i); 
$ui = mysql_fetch_row ($e);
while ($ui)
	{
	 if ($ui[8]==13) $device[0]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==1) $device[1]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==1) $device[2]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==2) $device[4]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==2) $device[5]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==3) $device[7]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==3) $device[8]=$ui[1];
	 if ($ui[8]==13) $device[10]=$ui[1];

	 if ($ui[8]==5) $device[11]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==1) $device[12]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==2) $device[13]=$ui[1];
	 if ($ui[8]==1 && $ui[10]==3) $device[14]=$ui[1];
	 if ($ui[8]==5) $device[15]=$ui[1];

	 if ($ui[8]==13 && $ui[10]==0) $device[17]=$ui[1];
	 if ($ui[8]==5) $device[18]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==1) $device[19]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==2) $device[20]=$ui[1];
	 if ($ui[8]==13 && $ui[10]==3) $device[21]=$ui[1];
	 $ui = mysql_fetch_row ($e);	 
	}

$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"]; else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn=$today["mon"]; else $mn=$_GET["month"];
if ($_GET["day"]=='') $da=$today["mday"]; else $da=$_GET["day"];
$hr=$today["hours"];
if ($hr>2) $hr-=2;

for ($tm=1; $tm<22; $tm++)
    {	 
     if ($mn<10) $mon='0'.$mn; else $mon=$mn;
     if ($da<10) $day='0'.$da; else $day=$da;
     if ($hr<10) $hour='0'.$hr; else $hour=$hr;
     $dat=$hour.'/'.$day;

     $date=$ye.$mon.$day.$hour.'0000';
     $query = 'SELECT * FROM prdata WHERE date='.$date.' AND type=1';
     //echo $query.'<br>';
     $e = mysql_query ($query,$i); 
     $ui = mysql_fetch_row ($e);
     while ($ui)
	{
	 //echo $device[2].' '.$ui[1].' '.$ui[2].' '.$ui[7].'<br>';
	 if ($ui[1]==$device[0] && $ui[2]==4 && $ui[7]==0) $data[0]=$ui[5];
	 if ($ui[1]==$device[1] && $ui[2]==4 && $ui[7]==0) $data[1]=$ui[5];
	 if ($ui[1]==$device[2] && $ui[2]==4 && $ui[7]==0) $data[2]=$ui[5];
	 if ($ui[1]==$device[4] && $ui[2]==4 && $ui[7]==0) $data[4]=$ui[5];
	 if ($ui[1]==$device[5] && $ui[2]==4 && $ui[7]==0) $data[5]=$ui[5];
	 if ($ui[1]==$device[7] && $ui[2]==4 && $ui[7]==0) $data[7]=$ui[5];
	 if ($ui[1]==$device[8] && $ui[2]==4 && $ui[7]==0) $data[8]=$ui[5];
	 if ($ui[1]==$device[10] && $ui[2]==4 && $ui[7]==1) $data[10]=$ui[5];

	 if ($ui[1]==$device[11] && $ui[2]==1 && $ui[7]==0) $data[11]=$ui[5];
	 if ($ui[1]==$device[12] && $ui[2]==1 && $ui[7]==0) $data[12]=$ui[5];	 
	 if ($ui[1]==$device[13] && $ui[2]==1 && $ui[7]==0) $data[13]=$ui[5];
	 if ($ui[1]==$device[14] && $ui[2]==1 && $ui[7]==0) $data[14]=$ui[5];
	 if ($ui[1]==$device[15] && $ui[2]==1 && $ui[7]==0) $data[15]=$ui[5];

	 if ($ui[1]==$device[17] && $ui[2]==11 && $ui[7]==0) $data[17]=$ui[5];
	 if ($ui[1]==$device[18] && $ui[2]==11 && $ui[7]==0) $data[18]=$ui[5];
	 if ($ui[1]==$device[19] && $ui[2]==11 && $ui[7]==0) $data[19]=$ui[5];
	 if ($ui[1]==$device[20] && $ui[2]==11 && $ui[7]==0) $data[20]=$ui[5];
	 if ($ui[1]==$device[21] && $ui[2]==11 && $ui[7]==0) $data[21]=$ui[5];

	 $ui = mysql_fetch_row ($e);	 
	}
  $data[3]=($data[1]-$data[2])*100/$data[2];
  $data[6]=($data[4]-$data[5])*100/$data[5];
  $data[9]=($data[7]-$data[8])*100/$data[8];
  $dh1[$cn]=($data[11]-$data[12]); $dh2[$cn]=($data[12]-$data[13]); $dh3[$cn]=($data[13]-$data[14]);
  $data[16]=(($data[11]-$data[15])-(($data[11]-$data[12])+($data[12]-$data[13])+($data[13]-$data[14])))*100/($data[11]-$data[15]); 
  $data[22]=($data[17]-$data[18])*100/$data[17];

  if ($hr>0) $hr--;
  else
	{
	  $hr=23;
	  if ($da>1) $da--;
	  else
		{
		 $mn--;
		 $da=31;
		 if (!checkdate ($mn,31,$ye)) { $da=30; }
		 if (!checkdate ($mn,30,$ye)) { $da=29; }
        	 if (!checkdate ($mn,29,$ye)) { $da=28; }
		}
	}
  print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat.'</font></td>';
  for ($cn=0; $cn<23; $cn++)
     print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data[$cn],2).'</font></td>';
  $cn++;
 }
for ($cn=0; $cn<19; $cn++) $data[$cn]=0;
?>
</table></td></tr>

<tr><td width=680 valign=top>
<table width=680 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz><?php $today=getdate(); print $today["mday"].'/'.$today["mon"]; ?></font></td><td bgcolor=#ffcf68 align=center colspan=19><font class=tablz>Эталонные и расчетные данные</font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>время</font></td>
<td bgcolor=#ffcf68 align=center colspan=5><font class=tablz>d Энтальпии</font></td>
<td bgcolor=#ffcf68 align=center colspan=14><font class=tablz>Тепловая энергия</font></td>
</tr>
<tr>
<td bgcolor=#ffcf68 align=center><font class=tablz>час/день</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dHсум</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dHирп</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dHбит1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dHбит2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dHбит3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qст,км</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qст,бит</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qст,ирп</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dQкм-бит</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dQкм-ирп</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qкм1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qбит1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dQ1</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qкм2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qбит2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dQ2</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qкм3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>Qбит3</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>dQ3</font></td>
</tr>

<?php

$query = 'SELECT * FROM device';
$e = mysql_query ($query,$i); 
$ui = mysql_fetch_row ($e);
while ($ui)
	{
	 if ($ui[8]==5) $device1=$ui[1];
	 if ($ui[8]==1 && $ui[10]==1) $device2=$ui[1];
	 if ($ui[8]==1 && $ui[10]==2) $device3=$ui[1];
	 if ($ui[8]==1 && $ui[10]==3) $device4=$ui[1];

	 if ($ui[8]==13 && $ui[10]==0) $device8=$ui[1];
	 if ($ui[8]==5 && $ui[10]==1) $device10=$ui[1];

	 if ($ui[8]==13 && $ui[10]==1) $device13=$ui[1];
	 if ($ui[8]==1 && $ui[10]==1) $device14=$ui[1];

	 if ($ui[8]==13 && $ui[10]==2) $device16=$ui[1];
	 if ($ui[8]==1 && $ui[10]==2) $device17=$ui[1];

	 if ($ui[8]==13 && $ui[10]==3) $device19=$ui[1];
	 if ($ui[8]==1 && $ui[10]==3) $device20=$ui[1];
	 $ui = mysql_fetch_row ($e);	 
	}


$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"]; else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn=$today["mon"]; else $mn=$_GET["month"];
if ($_GET["day"]=='') $da=$today["mday"]; else $da=$_GET["day"];
$hr=$today["hours"]; $cn=0;
if ($hr>2) $hr=$hr-2;

for ($tm=1; $tm<25; $tm++)
    {	 
     if ($mn<10) $mon='0'.$mn; else $mon=$mn;
     if ($da<10) $day='0'.$da; else $day=$da;
     if ($hr<10) $hour='0'.$hr; else $hour=$hr;
     $dat=$hour.'/'.$day;

     $date=$ye.$mon.$day.$hour.'0000';
     $query = 'SELECT * FROM prdata WHERE date='.$date.' AND type=1';
     //echo $query.'<br>';
     $e = mysql_query ($query,$i); 
     $ui = mysql_fetch_row ($e);
     while ($ui)
	{
	 if ($ui[1]==$device1 && $ui[2]==1 && $ui[7]==0) $data[0]=$ui[5];
	 if ($ui[1]==$device1 && $ui[2]==1 && $ui[7]==1) $data[1]=$ui[5];

	 if ($ui[1]==$device8 && $ui[2]==13 && $ui[7]==0) $data[8]=$ui[5];
	 if ($ui[1]==$device10 && $ui[2]==13 && $ui[7]==0) $data[10]=$ui[5];
	 if ($ui[1]==$device13 && $ui[2]==13 && $ui[7]==0) $data[13]=$ui[5];
	 if ($ui[1]==$device16 && $ui[2]==13 && $ui[7]==0) $data[16]=$ui[5];
	 if ($ui[1]==$device19 && $ui[2]==13 && $ui[7]==0) $data[19]=$ui[5];
	 $ui = mysql_fetch_row ($e);	 
	}
     $query = 'SELECT * FROM data WHERE date='.$date.' AND type=1';
     //echo $query.'<br>';
     $e = mysql_query ($query,$i); 
     $ui = mysql_fetch_row ($e);
     while ($ui)
	{
	 if ($ui[4]==1 && $ui[8]==13 && $ui[6]==0) $data[14]=$ui[5];
	 if ($ui[4]==2 && $ui[8]==13 && $ui[6]==0) $data[17]=$ui[5];
	 if ($ui[4]==3 && $ui[8]==13 && $ui[6]==0) $data[20]=$ui[5];
	 $ui = mysql_fetch_row ($e);	 
	}
     $data[1]=$data[0]-$data[1];
     $data[0]=$dh1[$cn]+$dh2[$cn]+$dh3[$cn];
     $data[2]=$dh1[$cn];     $data[3]=$dh2[$cn];     $data[4]=$dh3[$cn];
     $data[9]=$data[14]+$data[17]+$data[20];
     $data[11]=($data[8]-$data[10])*100/$data[8]; if ($data[11]<100) $data[11]='-';
     $dq1[$cn]=$data[11];
     $data[12]=($data[8]-$data[9])*100/$data[8];  if ($data[12]<100) $data[12]='-';
     $dq2[$cn]=$data[12];
     $data[15]=($data[13]-$data[14])*100/$data[13]; if ($data[15]<100) $data[15]='-';
     $dq3[$cn]=$data[15];
     $data[18]=($data[16]-$data[17])*100/$data[16]; if ($data[18]<100) $data[18]='-';
     $dq4[$cn]=$data[18];
     $data[21]=($data[19]-$data[20])*100/$data[19]; if ($data[21]<100) $data[21]='-';
     $dq5[$cn]=$data[21];
  if ($hr>0) $hr--;
  else
	{
	  $hr=23;
	  if ($da>1) $da--;
	  else
		{
		 $mn--;
		 $da=31;
		 if (!checkdate ($mn,31,$ye)) { $da=30; }
		 if (!checkdate ($mn,30,$ye)) { $da=29; }
        	 if (!checkdate ($mn,29,$ye)) { $da=28; }
		}
	}
  $dats[$cn]=$dat;
  print '<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat.'</font></td>';
  for ($cn=0; $cn<19; $cn++)
     print '<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data[$cn],2).'</font></td>';
  $cn++;
 }
?>
</table></td></tr>
</table></td>
<td>
<table width=500px cellpadding=0 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td><table width=500px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];
?>
</td></tr></table></td></tr>
<?php
print '<tr><td><img width=500 height=250 src="charts/barplots24.php?type=1&obj='.$_GET["obj"];
for ($cn=0;$cn<25;$cn++)
    print '&dat'.$cn.'='.$dats[$cn].'&data1'.$cn.'='.$dh1[$cn].'&data2'.$cn.'='.$dh2[$cn].'&data3'.$cn.'='.$dh3[$cn];
print '"></td></tr>';
print '<tr><td><img width=500 height=250 src="charts/barplots24.php?type=2&obj='.$_GET["obj"];
for ($cn=0;$cn<25;$cn++)
    print '&dat'.$cn.'='.$dats[$cn].'&data1'.$cn.'='.$dq1[$cn].'&data2'.$cn.'='.$dq2[$cn];
print '"></td></tr>';
print '<tr><td><img width=500 height=250 src="charts/barplots24.php?type=3&obj='.$_GET["obj"];
for ($cn=0;$cn<25;$cn++)
    print '&dat'.$cn.'='.$dats[$cn].'&data1'.$cn.'='.$dq3[$cn].'&data2'.$cn.'='.$dq4[$cn].'&data3'.$cn.'='.$dq5[$cn];
print '"></td></tr>';
?>
</table>
</body>
</html>