<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<!doctype php manual "-//by the PHP Documentation Group//en">
<!doctype odbc manual "-//by microsoft corp.//en">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" href="shablon.css" type="text/css">
<title>abonet report for day/month</title>

<?php
 include("config/local.php");
 $arr = get_defined_vars();
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $today=getdate ();
 $cn=12; $tep=$tep1=$gvs=$gvs1=$hvs=$hvs1=$ee=$ee1=$sum1=0;
 $mday=$today["mday"]=28; $today["mon"]=5;
 if ($_GET["id"]=='') $_GET["id"]=1;
 while ($cn)
       {	 
	$today["mon"]=0+$today["mon"];
	if ($today["mon"]<10)  $today["mon"]='0'.$today["mon"];
	if ($today["mday"]<10)  $today["mday"]='0'.$today["mday"];
	$tim[$cn]=$today["year"].$today["mon"].$today["mday"].'000000';
	$mday=$today["mday"]+1;	
	if ($mday<10) $mday='0'.$mday; 
	$tim2[$cn]=$today["year"].$today["mon"].$mday.'000000';
        if ($today["mday"]>1) $today["mday"]--; 
	else 
	   { 
	     if ($today["mon"]>1) $today["mon"]--;
	     else { $today["mon"]=12; $today["year"]--; }

	     $today["mday"]=31;
	     if (!checkdate ($today["mon"],31,$today["year"])) { $today["mday"]=30; }
	     if (!checkdate ($today["mon"],30,$today["year"])) { $today["mday"]=29; }
	     if (!checkdate ($today["mon"],29,$today["year"])) { $today["mday"]=28; }
	     //echo $today["mday"].'<br>';
	    }
	 $cn--;
	}

$query = 'SELECT * FROM data WHERE type=2 AND prm=11 AND source=6 AND date>20090301000000 AND value>1 ORDER BY date DESC';
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e); $mm=0;
while ($ui)
{
 $dev[$mm]=$ui[1];
 $prm[$mm]=$ui[2];
 $data[$mm]=$ui[5];
 $dat[$mm]=$ui[4][0].$ui[4][1].$ui[4][2].$ui[4][3].$ui[4][5].$ui[4][6].$ui[4][8].$ui[4][9].'000000';
 $mm++;
 $ui = mysql_fetch_row ($e);
}


for ($cn=1; $cn<13; $cn++)
{
 // HVS
 $query = 'SELECT * FROM dev_2ip WHERE flat_number>0';
 $r = mysql_query ($query,$i);
 if ($r) $ur = mysql_fetch_row ($r);
 while ($ur)
	{                    
	 $query = 'SELECT * FROM data WHERE type=2 AND date='.$tim[$cn].' AND flat='.$ur[6].' AND prm=11 AND source=5';
         echo $query.'<br>';		
	 $a = mysql_query ($query,$i);  
	 if ($a) $uy = mysql_fetch_row ($a);		    
         if (!$uy)
	    {
  	     $data01=$data02=0; 
	     for ($zz=0; $zz<$mm; $zz++)
	     if ($dev[$zz]==$ur[1])
	     if ($prm[$zz]==6)
		{
		 //echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].'<br>'; 
		 if ($data01==0) if ($dat[$zz]<=$tim[$cn]) { $data01=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		 if ($dat[$zz]==$tim2[$cn]) { $data02=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		}           
	     $rt1=$data02-$data01;
             if ($rt1<0) $rt1=0;   
	     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (2,'.$tim[$cn].','.$rt1.','.$ur[6].',5,11)';
	     $a = mysql_query ($query,$i);
	     echo $query.'<br>';
	    }
	 $query = 'SELECT * FROM data WHERE type=2 AND date='.$tim[$cn].' AND flat='.$ur[6].' AND prm=11 AND source=6';
         //echo $query.'<br>';		
	 $a = mysql_query ($query,$i);  
	 if ($a) $uy = mysql_fetch_row ($a);		    
         if (!$uy)
	    {
	     $data01=$data02=0;  
	     for ($zz=0; $zz<$mm; $zz++)
	     if ($dev[$zz]==$ur[1])
	     if ($prm[$zz]==8)
		{		 
		 if ($data01==0) if ($dat[$zz]<=$tim[$cn]) { $data01=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		 if ($dat[$zz]==$tim2[$cn]) { $data02=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		}           
	     $rt1=$data02-$data01;
             if ($rt1<0) $rt1=0;   
	     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (2,'.$tim[$cn].','.$rt1.','.$ur[6].',6,11)';
	     $a = mysql_query ($query,$i);
	     echo $query.'<br>';
	    }
     $ur = mysql_fetch_row ($r);
    }
 
  $query = 'SELECT * FROM device WHERE type=4 AND flat>0';
  $r = mysql_query ($query,$i);                                  	
  if ($r) $ur = mysql_fetch_row ($r);
  while ($ur)
	{
	 $query = 'SELECT * FROM data WHERE type=2 AND date='.$tim[$cn].' AND flat='.$ur[10].' AND prm=2 AND source=0';
         //echo $query.'<br>';		
	 $a = mysql_query ($query,$i);  $uy = mysql_fetch_row ($a);		    
         if (!$uy)
	    { 
	     $data01=$data02=0; 
	     for ($zz=0; $zz<$mm; $zz++)
	     if ($dev[$zz]==$ur[1])
	     if ($prm[$zz]==2)
		{
		 if ($data01==0) if ($dat[$zz]<=$tim[$cn]) { $data01=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		 if ($dat[$zz]==$tim2[$cn]) { $data02=$data[$zz]; echo $dat[$zz].' '.$tim[$cn].' '.$tim2[$cn].' '.$data01.' '.$data02.'<br>'; }
		}           
	     $rt1=$data02-$data01;
             if ($rt1<0) $rt1=0;   
	     $query = 'INSERT INTO data(type,date,value,flat,source,prm) VALUES (2,'.$tim[$cn].','.$rt1.','.$ur[10].',0,2)';
	     $a = mysql_query ($query,$i);
	     echo $query.'<br>';
 	    }
	 $ur = mysql_fetch_row ($r);
	}	
}
?>

</td></tr>
</table>
</body>
</html>
