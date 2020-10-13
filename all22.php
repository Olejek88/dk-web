<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>Анализ энергоэффективности Системы</title>
<body leftmargin=0 topmargin=5 rightmargin=0 bottommargin=0 marginwidth=0 marginheight=0>
<table width=1200px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td valign=top>

<table width=450px cellpadding=2 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td width=440 valign=top>
<table width=440 bgcolor=#664466 valign=top cellpadding=1 cellspacing=1>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz><?php $today=getdate(); print $today["year"]; ?></font></td><td bgcolor=#ffcf68 align=center colspan=7><font class=tablz>Количество тепловой энергиий (Гкал)</font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>месяц</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>инд. часть</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>общ. часть</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>всего</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>норматив</font></td><td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>% экономии по общему объему</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>экономия в рублях</font></td></tr>
<?php
include("config/local.php");
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"]; else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn='0'.$today["mon"]; else $mn=$_GET["month"];
if ($today["mday"]<20) { $today["mon"]--; $today["mday"]=31; }

$query = 'SELECT SUM(rnum),SUM(square) FROM flats';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);  $sum=$uy[0]; $sum0=$uy[1];

$query = 'SELECT * FROM device WHERE type=2 AND (ust=1 OR devtim<20090701000000)';
//$query = 'SELECT * FROM device WHERE type=2 AND ust=1';
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e); $sum2=0;
while ($ui) 
	{
	 $query = 'SELECT SUM(rnum) FROM flats WHERE flat='.$ui[10];
	 $a = mysql_query ($query,$i);
	 if ($a) $uy = mysql_fetch_row ($a);  
	 $sum2+=$uy[0];	   
	 $ui = mysql_fetch_row ($e); 
	}

$cn=0;

$ffile="inc/all".$_GET["obj"]."_1.php";
//echo $ffile;
if (file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");
	 $contents = fread ($fp, filesize ($ffile));
	 print $contents;
         fclose($fp);
	}
else
{
 for ($tm=1; $tm<=6; $tm++) $data2[$tm]=$data1[$tm]=$data0[$tm]=0;
 $tm=$today["mon"];
 for ($pm=1; $pm<=6; $pm++)
    {	 
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
     $sts=sprintf("%d%02d01000000",$today["year"],$tm); $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);

         $query = 'SELECT COUNT(id) FROM device WHERE type=5';
	 $a = mysql_query ($query,$i); $uy = mysql_fetch_row ($a); 
	 if ($tm==$today["mon"]) $numm=($today["mday"]-1)*$uy[0]; else $numm=31*$uy[0];

	 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND flat>0 AND prm=13';
	 //echo $query.'<br>';
	 $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0]/4168; $cntid=$ui[1];
	 //echo $data1[$cn].' '.$cntid.'<br>';
	 if ($cn==0) 
	    {
	     $query = 'SELECT AVG(value) FROM data WHERE date>'.$sts.' AND date<'.$fns.' AND type=2 AND flat=0 AND prm=13 AND source=2';
	     $e = mysql_query ($query,$i); $ui = mysql_fetch_row ($e); //$data1[$cn]+=$ui[0]*7;
	    }
	    
         if ($_GET["obj"]==1) $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND (prm=13 OR prm=11) AND value>10';
	 else $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM prdata WHERE date>='.$sts.' AND date<'.$fns.' AND type=2 AND prm=13 AND value>5';
	 $e = mysql_query ($query,$i);
	 $ui = mysql_fetch_row ($e); 
	 if ($ui[0]==0)
	    {
             $query = 'SELECT SUM(value),COUNT(id),AVG(value) FROM data WHERE date>='.$sts.' AND date<'.$fns.' AND type=4 AND flat=0 AND prm=13';
    	     $e = mysql_query ($query,$i);
	     $ui = mysql_fetch_row ($e);
	     $ui[0]*=4186; 
	    }
	    //echo $query.'<br>';	echo $numm.' '.$ui[0].' '.$ui[1].' '.$ui[2].'<br>';
					//570 165339.627 225 734.842786666666
         //if ($tm==$today["mon"] && $tm>5) $ui[0]=$ui[0]+($numm-$ui[1])*$ui[2];
	    //$ui[0]=$ui[0]+($numm-$ui[1])*$ui[2];
	    //echo $query.'<br>';	echo $numm.' '.$ui[0].' '.$ui[1].' '.$ui[2].'<br>';
	    
	    $data2[$cn]=($ui[0]/4186); 
	    $data9[$cn]=$data1[$cn];
	    echo '<br>'.$data9[$cn];
	    if ($data1[$cn]-$data2[$cn]>0) $data1[$cn]=$data1[$cn]-$data2[$cn]; 
	    else { $data2[$cn]=$data1[$cn]; $data1[$cn]=0; }

	    if ($cntid>28) $data0[$cn]=0.0322*$sum0*($tod/31);
	    else $data0[$cn]=($cntid/31)*0.0322*$sum0;
	    //if ($data2[$cn]>$data1[$cn]) 

	    if ($data0[$cn]>0) $pr[$cn]=($data0[$cn]-$data9[$cn])*100/$data0[$cn];
	    else $pr[$cn]=100;
	    $rub[$cn]=537*($data0[$cn]-$data9[$cn]);
     include("time.inc");
     if ($tm>1) $tm--;
     else { $tm=12; $today["year"]--; }
     $cn++;
  }
 $fp=fopen($ffile,"w");
 for ($cn=0; $cn<6; $cn++)
 if ($data9[$cn]>0)
    {	 
     $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat[$cn].'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data2[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data1[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data9[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data0[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff colspan=2><font class=top2>'.number_format($pr[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($rub[$cn],2).'</font></td></tr>'; fwrite ($fp,$prt);
     $it1+=$data2[$cn]; $it2+=$data1[$cn]; $it3+=$data9[$cn]; $it4+=$data0[$cn];
    }

 if ($it4>0) $it5=($it4-$it3)*100/$it4; else $it5=0;
 $it6=537*($it4-$it3);

 $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it1,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it2,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it3,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it4,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68 colspan=2><font class=tablz>'.number_format($it5,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it6,2).'</font></td></tr>'; fwrite ($fp,$prt);
 fclose($fp);

 $ffile="inc/all".$_GET["obj"]."_1g.php"; $cm=1;
 $fp=fopen($ffile,"w"); $prt='charts/barplots28.php?n1=13&obj='.$_GET["obj"]; fwrite ($fp,$prt);
 for ($cn=0; $cn<6; $cn++)
 if ($data9[$cn]>0)
    {	 
     $prt='&dat'.$cm.'='.$dat[$cn].'&da'.$cm.'='.$data2[$cn].'&db'.$cm.'='.$data1[$cn].'&dc'.$cm.'='.$data0[$cn]; fwrite ($fp,$prt); $cm++;
    }
 fclose($fp);
}
$it1=$it2=$it3=$it4=$it5=$it6=0;
?>

<tr><td bgcolor=#e8e8e8 align=center colspan=8><font class=tablz></font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz><?php print $today["year"]; ?></font></td><td bgcolor=#ffcf68 align=center colspan=7><font class=tablz>Объем ХВС (м3)</font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>месяц</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>инд. часть</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>общ. часть</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>всего</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>норматив</font></td><td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>% экономии по общему объему</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>экономия в рублях</font></td></tr>

<?php
$cn=0; $today=getdate();
$ffile="inc/all".$_GET["obj"]."_3.php";
if (file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");
	 $contents = fread ($fp, filesize ($ffile));
	 print $contents;	 
	 fclose($fp);
	}
else
{                 
 for ($tm=1; $tm<=6; $tm++) $data2[$tm]=$data1[$tm]=$data0[$tm]=0;
 $tm=$today["mon"];
 for ($pm=1; $pm<=6; $pm++)
    {	 
     for ($b=0;$b<$cm;$b++) $datad[$b]=$datas[$b]=0;

     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
     include("time.inc");
     $sts=sprintf("%d%02d01000000",$today["year"],$tm); $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);
     $stl=sprintf("%d-%02d",$today["year"],$tm);
     $data01[$cn]=$data02[$cn]=0;

     $query = 'SELECT SUM(value) FROM prdata WHERE prm=6 AND type=2 AND date='.$fns;     //echo $query.'<br>';
     if ($a = mysql_query ($query,$i))
     if ($uy = mysql_fetch_row ($a)) $gvs2=$uy[0];
     $query = 'SELECT SUM(value) FROM prdata WHERE prm=8 AND type=2 AND date='.$fns;     //echo $query.'<br>';
     if ($a = mysql_query ($query,$i))
     if ($uy = mysql_fetch_row ($a)) $hvs2=$uy[0];
     $query = 'SELECT SUM(value) FROM prdata WHERE prm=6 AND type=2 AND date='.$sts;    // echo $query.'<br>';
     if ($a = mysql_query ($query,$i))
     if ($uy = mysql_fetch_row ($a)) $gvs=$uy[0];
     $query = 'SELECT SUM(value) FROM prdata WHERE prm=8 AND type=2 AND date='.$sts;     //echo $query.'<br>';
     if ($a = mysql_query ($query,$i))
     if ($uy = mysql_fetch_row ($a)) $hvs=$uy[0];

     //$data2[$cn]=$hvs2-$hvs;
     if ($today["mon"]!=$tm) $data0[$cn]=(5.4/30)*$tod*$sum;
     else $data0[$cn]=5.4*$sum*($today["mday"]/30);

     $data2[$cn]=0;

     $query = 'SELECT * FROM device WHERE type=2';
     $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e); $cm=0;
     while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

     $query = 'SELECT * FROM prdata WHERE type=2 AND prm=6 AND date>='.$sts.' AND date<='.$fns.' GROUP BY device,date ORDER BY date DESC';
     $e = mysql_query ($query,$i); if ($e) $ui = mysql_fetch_row ($e);
     while ($ui)
	{ 
	 for ($b=0;$b<$cm;$b++) if ($dev[$b]==$ui[1]) 
		{
		 if ($datad[$b]<=0) $datad[$b]=$ui[5];
		 if ($datad[$b]>0) $datas[$b]=$ui[5];
		 break;
		}
	 $ui = mysql_fetch_row ($e);
	}

     for ($b=0;$b<$cm;$b++) if ($datad[$b]>=$datas[$b]) 
		{
		 $data2[$cn]+=$datad[$b]-$datas[$b];
		 //echo '['.$b.'] '.$datad[$b].' '.$datas[$b].' '.$data2[$cn].'<br>';
		}
     if ($_GET["obj"]>=6)
	{
	 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=12 AND source=6 AND date>='.$sts.' AND date<'.$fns;
     	 $e = mysql_query ($query,$i); 
	 if ($e) $ui = mysql_fetch_row ($e);
	 $data2[$cn]=$ui[0];
	}
     //$data2[$cn]+=$sum2*(5.4/30)*$tod;

     $data9[$cn]=$data2[$cn];
     $data1[$cn]=0;
     if ($data0[$cn]>0) $pr[$cn]=($data0[$cn]-$data9[$cn])*100/$data0[$cn];
     $rub[$cn]=12.41*($data0[$cn]-$data9[$cn]);
     //echo $data2[$cn].' '.$data1[$cn].' '.$data9[$cn].'<br>';
     include("time.inc");
     if ($tm>1) $tm--;
     else { $tm=12; $today["year"]--; }
     $cn++;
    }
$fp=fopen($ffile,"w");

for ($cn=0; $cn<6; $cn++)
if ($data9[$cn]>1)
    {	 
     $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat[$cn].'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data2[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data1[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data9[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data0[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff colspan=2><font class=top2>'.number_format($pr[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($rub[$cn],2).'</font></td></tr>'; fwrite ($fp,$prt);
     $sums1[$cn]=$data2[$cn]; $sums2[$cn]=$data1[$cn]; $sums3[$cn]=$data9[$cn]; $sums4[$cn]=$data0[$cn]; $sums6[$cn]=$rub[$cn];
     $it1+=$data2[$cn]; $it2+=$data1[$cn]; $it3+=$data9[$cn]; $it4+=$data0[$cn]; $it5*=$pr[$cn]; 
    }
 $it5=($it4-$it3)*100/$it4; $it6=12.41*($it4-$it3);
 $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it1,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it2,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it3,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it4,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68 colspan=2><font class=tablz>'.number_format($it5,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it6,2).'</font></td></tr>'; fwrite ($fp,$prt);
 fclose($fp);

 $ffile="inc/all".$_GET["obj"]."_3g.php"; $cm=1;
 $fp=fopen($ffile,"w"); $prt='charts/barplots28.php?n1=8&obj='.$_GET["obj"]; fwrite ($fp,$prt);
 for ($cn=0; $cn<6; $cn++)
 if ($data9[$cn]>0)
    {	 
     $prt='&dat'.$cm.'='.$dat[$cn].'&da'.$cm.'='.$data2[$cn].'&db'.$cm.'='.$data1[$cn].'&dc'.$cm.'='.$data0[$cn]; fwrite ($fp,$prt); $cm++;
    }
 fclose($fp);
}
$sumit1=$it1; $sumit2=$it2; $sumit3=$it3; $sumit4=$it4; $sumit6=$it6;
$it1=$it2=$it3=$it4=$it5=$it6=0;
$sums1[$cn]=$data2[$cn]; $sums2[$cn]=$data1[$cn]; $sums3[$cn]=$data9[$cn]; $sums4[$cn]=$data0[$cn]; $sums6[$cn]=$rub[$cn];
?>

<tr><td bgcolor=#e8e8e8 align=center colspan=8><font class=tablz></font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz><?php print $today["year"]; ?></font></td><td bgcolor=#ffcf68 align=center colspan=7><font class=tablz>Объем ГВС (м3)</font></td></tr>
<tr><td bgcolor=#ffcf68 align=center><font class=tablz>месяц</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>инд. часть</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>общ. часть</font></td><td bgcolor=#ffcf68 align=center><font class=tablz>всего</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>норматив</font></td><td bgcolor=#ffcf68 align=center colspan=2><font class=tablz>% экономии по общему объему</font></td>
<td bgcolor=#ffcf68 align=center><font class=tablz>экономия в рублях</font></td></tr>

<?php
$cn=0; $today=getdate();
$ffile="inc/all".$_GET["obj"]."_4.php";
if (file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");
	 $contents = fread ($fp, filesize ($ffile));
	 print $contents;	 
	 fclose($fp);
	}
else
{
 for ($tm=1; $tm<=6; $tm++) $data2[$tm]=$data1[$tm]=$data0[$tm]=0;
 $tm=$today["mon"];
 for ($pm=1; $pm<=6; $pm++)
    {	 
     for ($b=0;$b<$cm;$b++) $datad[$b]=$datas[$b]=0;
     $tod=31;
     if (!checkdate ($tm,31,$today["year"])) { $tod=30; }
     if (!checkdate ($tm,30,$today["year"])) { $tod=29; }
     if (!checkdate ($tm,29,$today["year"])) { $tod=28; }
     $sts=sprintf("%d%02d01000000",$today["year"],$tm); $fns=sprintf("%d%02d01000000",$today["year"],$tm+1);
     $stl=sprintf("%d-%02d",$today["year"],$tm); $st1=sprintf("%d%02d01000000",$today["year"],$tm);

     if ($today["mon"]!=$tm) $data0[$cn]=(3.6/30)*$tod*$sum;
     else $data0[$cn]=3.6*$sum*($today["mday"]/30);

     $data01[$cn]=$data02[$cn]=0;
     $data2[$cn]=0;

     $query = 'SELECT * FROM device WHERE type=2';
     $e = mysql_query ($query,$i);
     if ($e) $ui = mysql_fetch_row ($e); $cm=0;
     while ($ui) { $dev[$cm]=$ui[1];  $datas[$cm]=$datad[$cm]=-1; $cm++; $ui = mysql_fetch_row ($e); }

     $query = 'SELECT * FROM prdata WHERE type=2 AND prm=8 AND date>='.$sts.' AND date<='.$fns.' GROUP BY device,date ORDER BY date DESC';
     $e = mysql_query ($query,$i);
     if ($e) $ui = mysql_fetch_row ($e);
     while ($ui)
	{ 
	 for ($b=0;$b<$cm;$b++) if ($dev[$b]==$ui[1]) 
		{
		 if ($datad[$b]<=0) $datad[$b]=$ui[5];
		 if ($datad[$b]>0) $datas[$b]=$ui[5];
		 break;
		}
	 $ui = mysql_fetch_row ($e);
	}
     for ($b=0;$b<$cm;$b++) if ($datad[$b]>=$datas[$b]) 
	{
	 $data2[$cn]+=$datad[$b]-$datas[$b];
	 //echo '['.$cn.'] '.$datad[$b].' '.$datas[$b].' '.$data2[$cn].'<br>';
	}
     if ($_GET["obj"]>=6)
	{
	 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=12 AND source=5 AND date>='.$sts.' AND date<'.$fns;
     	 $e = mysql_query ($query,$i); 
	 if ($e) $ui = mysql_fetch_row ($e);
	 $data2[$cn]=$ui[0];
	}

	$data9[$cn]=$data2[$cn];	
    	if ($data0[$cn]>0) $pr[$cn]=($data0[$cn]-$data9[$cn])*100/$data0[$cn];
	$rub[$cn]=12.41*($data0[$cn]-$data9[$cn]);
     include("time.inc");
     if ($tm>1) $tm--;
     else { $tm=12; $today["year"]--; }
     $cn++;
    }
 $fp=fopen($ffile,"w");
 for ($cn=0; $cn<6; $cn++)
 if ($data9[$cn]>1)
    {	 
     $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>'.$dat[$cn].'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data2[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data1[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data9[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($data0[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff colspan=2><font class=top2>'.number_format($pr[$cn],2).'</font></td>'; fwrite ($fp,$prt);
     $prt='<td align=center bgcolor=#ffffff><font class=top2>'.number_format($rub[$cn],2).'</font></td></tr>'; fwrite ($fp,$prt);
     $it1+=$data2[$cn]; $it2+=$data1[$cn]; $it3+=$data9[$cn]; $it4+=$data0[$cn];
     $sums1[$cn]+=$data2[$cn]; $sums2[$cn]+=$data1[$cn]; $sums3[$cn]+=$data9[$cn]; $sums4[$cn]+=$data0[$cn]; $sums6[$cn]+=$rub[$cn];
    }
 $it5=($it4-$it3)*100/$it4; $it6=12.41*($it4-$it3);
 $prt='<tr><td bgcolor=#ffcf68 align=center><font class=tablz>Итого</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it1,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it2,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it3,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it4,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68 colspan=2><font class=tablz>'.number_format($it5,2).'</font></td>'; fwrite ($fp,$prt);
 $prt='<td align=center bgcolor=#ffcf68><font class=tablz>'.number_format($it6,2).'</font></td></tr>'; fwrite ($fp,$prt);
 fclose($fp);

 $ffile="inc/all".$_GET["obj"]."_4g.php"; $cm=1;
 $fp=fopen($ffile,"w"); $prt='charts/barplots28.php?n1=6&obj='.$_GET["obj"];  fwrite ($fp,$prt);
 for ($cn=0; $cn<6; $cn++)
 if ($data9[$cn]>0)
    {	 
     $prt='&dat'.$cm.'='.$dat[$cn].'&da'.$cm.'='.$data2[$cn].'&db'.$cm.'='.$data1[$cn].'&dc'.$cm.'='.$data0[$cn]; fwrite ($fp,$prt); $cm++;
    }
 fclose($fp);
}
$sumit1+=$it1; $sumit2+=$it2; $sumit3+=$it3; $sumit4+=$it4; $sumit6+=$it6;
$it1=$it2=$it3=$it4=$it5=$it6=0;
?>

</table></td></tr></table></td>
<td>
<table width=700px cellpadding=0 cellspacing=1 bgcolor=#ffffff align=center>
<tr><td><table width=700px cellpadding=1 cellspacing=1 bgcolor=#ffffff align=center>
<?php
 $query = 'SELECT * FROM build WHERE build_id='.$_GET["obj"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $build=$uy[1];
 print '<tr><td><font class=tablz>Отчет по потреблению энергоресурсов дома по адресу '.$build.'<font></td><td bgcolor=red align=center><font class=tablz>реальное</td><td align=center bgcolor=blue class=tablz>нормативное</td><td bgcolor=yellow align=center class=tablz>общедомовые потери</td></tr>';
?>
</td></tr></table></td></tr>
<?php
$ffile="inc/all".$_GET["obj"]."_1g.php";
if (file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");	 $contents = fread ($fp, filesize ($ffile));
	 print '<tr><td><img alt="пожалуйста подождите пока идет построение изображения" width=750 height=250 src="'.$contents.'"></td></tr>';
	 fclose($fp);
	}
$ffile="inc/all".$_GET["obj"]."_3g.php";
if ($is_2ip && file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");	 $contents = fread ($fp, filesize ($ffile));
	 print '<tr><td><img alt="пожалуйста подождите пока идет построение изображения" width=750 height=250 src="'.$contents.'"></td></tr>';
	 fclose($fp);
	}
$ffile="inc/all".$_GET["obj"]."_4g.php";
if ($is_2ip && file_exists($ffile))
	{
	 $fp=fopen($ffile,"r");	 $contents = fread ($fp, filesize ($ffile));
	 print '<tr><td><img alt="пожалуйста подождите пока идет построение изображения" width=750 height=250 src="'.$contents.'"></td></tr>';
	 fclose($fp);
	}
?>
</table>
</td></tr></table>
</body>
</html>