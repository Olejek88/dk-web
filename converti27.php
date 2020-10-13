<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 $_GET["obj"]=50;
 include("config/local.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
?>

<html><head>
<title>Конвертируем из SQL Lite (QDK) в MySQL (DK)</title>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251">
<meta http-equiv="Pragma" content="no-cashe">
<link rel="stylesheet" href="files/structure_collage_ektron.css" type="text/css">
<link rel="stylesheet" href="files/default.css" title="default" type="text/css">
<link rel="alternate stylesheet" href="files/default_larger.css" title="big" type="text/css">
<link rel="stylesheet" type="text/css" href="files/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="files/quotetabs.css">
</head>
<body>

<?php
 $today=getdate();
 $crdate=mktime(0, 0, 0, $today["mon"], $today["mday"], $today["year"]);
 $crdate-=3600*5*24;
 echo $crdate.'<br>';

 $section_num=1;

//----------------------------------------------------------------------------------------------------------------------------
if (1)
{
 for ($sec=1;$sec<=$section_num;$sec++)
	{
	 $query = 'SELECT DISTINCT strut FROM field WHERE mnem='.$sec.' AND type=1'; echo $query.'<br>'; $cn=0;
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 $strt[$sec][$cn]=$uy[0]; 
		 //echo '['.$sec.'/'.$cn.'] '.$strt[$cn].'<br>';
		 $cn++;
		}
	 $strut_n[$sec]=$cn-1;
	}
 $strut_num=$cn-1;

 $query = 'SELECT MAX(level),MAX(flat) FROM field'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 if ($uy = mysql_fetch_row ($a))  { $levels=$uy[0]; $flats=$uy[1]; }

 $query = 'SELECT * FROM dev_bit'; echo $query.'<br>'; $cn=0;
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $flt[$cn]=$uy[8]; $str[$cn]=$uy[9]; $sect[$cn]=$uy[14]; $lvl[$cn]=$uy[15];
	 $device[$flt[$cn]][$str[$cn]]=$uy[1];
	 $devices[$sect[$cn]][$flt[$cn]][$str[$cn]]=$uy[1];
	 $cn++;
	}
 $query = 'SELECT * FROM dev_irp'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{	
	 $dev[$cn]=$uy[1]; $str[$cn]=$uy[3]; $sect[$cn]=$uy[4];
	 $cn++;
	}
 $devs=$cn; 
 echo 'devices='.$devs.'<br>';

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"]-1;
 for ($tn=1; $tn<=58; $tn++) 
	{		
	 for ($rr=0;$rr<=$flats;$rr++)  $Qfl[$rr]=0;

	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $query = 'SELECT * FROM prdata WHERE prm=1 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 //$data[$flt[$rr]][$str[$rr]]=$uy[5];
			 $data[$rr]=$uy[5];
			 break;
			}
		}
	 $sumq=$qq=0;
	 $query = 'SELECT * FROM prdata WHERE prm=13 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 $Q[$sect[$rr]][$str[$rr]]=$uy[5];
			 echo '['.$dev[$rr].'] V['.$sect[$rr].']['.$str[$rr].'] se='.$sect[$rr].'='.$Q[$sect[$rr]][$str[$rr]].'<br>';
			 $sumq+=$uy[5];
			 $qq++;
			 break;
			}
		}

	 for ($sec=1;$sec<=$section_num;$sec++)
		{
		 $query = 'SELECT * FROM field WHERE type=1 AND mnem='.$sec.' ORDER BY strut,flat';
		 if ($a = mysql_query ($query,$i))
		 while ($uy = mysql_fetch_row ($a)) 
			{
			 $h2=$h1=0;
			 $flat=$uy[6]; $strut=$uy[9]; $level=$uy[11];
			 for ($rr=0;$rr<$devs;$rr++) 
				{
				 if ($dev[$rr]==$uy[4]) $h2=$data[$rr];
				 if ($dev[$rr]==$uy[5]) $h1=$data[$rr];
				}		
			 if ($h2 && $h1 && ($h2-$h1)<($h2/15) && ($h2-$h1)>0) 
			 //if (1)
				{
				 $dh[$strut][$level]=$h2-$h1;
				 $sdh[$sec][$strut]+=($h2-$h1);
				}
			 else $dh[$strut][$level]=0;
			 if (($h2-$h1)<=0 || ($h2-$h1)>($h2/10)) echo '---['.$date1[$tn].'] ['.$sec.'/'.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			 else echo '['.$date1[$tn].'] ['.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			}

		 for ($st=0;$st<=$strut_n[$sec];$st++) 
			{
			 $strn=$strt[$sec][$st]; // strut
			 $sdh[$sec][$strn]=0;
			 $sdh_ok[$sec][$strn]=0;
			 for ($lv=1;$lv<=$levels;$lv++) 
				{
				 if ($dh[$strn][$lv]) //$dh[$strt[$st]][$lv]=$sdh[$strt[$st]]/$levels;
					{
					 $sdh[$sec][$strn]+=$dh[$strn][$lv];
					 $sdh_ok[$sec][$strn]++;
					}
				 //echo '['.$date1[$tn].'] ('.$lv.'/'.$strn.') dH='.$dh[$strn][$lv].' ['.$sdh[$sec][$strn].']<br>';
				}
			}		

		 $query = 'SELECT * FROM field WHERE type=1 AND mnem='.$sec.' ORDER BY flat,strut';
		 if ($a = mysql_query ($query,$i))
		 while ($uy = mysql_fetch_row ($a)) 
			{
			 $flat=$uy[6]; $strut=$uy[9]; $level=$uy[11];
			 if ($dh[$strut][$level]<=0) 
				{
				 if ($sdh_ok[$sec][$strn]>0) $dh[$strut][$level]=$sdh[$sec][$strut]/$sdh_ok[$sec][$strut];
				 else $dh[$strut][$level]=$sdh[$sec][$strut]/$levels;
				}
			 if ($qq>0 && $Q[$sec][$strut]==0) $Q[$sec][$strut]=$sumq/$qq; 				 
			 $Qfl[$flat]+=($Q[$sec][$strut]/10)*$dh[$strut][$level]/$sdh[$sec][$strut];
	    		 //echo '['.$date1[$tn].'] ('.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'/'.$sdh[$sec][$strut].'='.($Q[$strut]*$dh[$strut][$level]/$sdh[$sec][$strut]).' ['.$Qfl[$flat].']<br>';
			 echo '['.$date1[$tn].'] ('.$sec.'/'.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[$strut][$level].'='.($Q[$sec][$strut]*$dh[$strut][$level]).' ['.$Qfl[$flat].']<br>';
			}
		}
	 $query = 'SELECT DISTINCT flat FROM field WHERE type=1 ORDER BY flat';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a))
		{
		 $flat=$uy[0];
		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=0,type=2,value='.$Qfl[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qfl[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 echo $query.'<br>'; 
		 //$a2 = mysql_query ($query,$i);	
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
}

?>
                