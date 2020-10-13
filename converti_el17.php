<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
 $_GET["obj"]=11;
 include("config/local.php");
 $i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
 $query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
 $query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
 $query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
 date_default_timezone_set("Europe/London");
// phpinfo();
// print_r(get_loaded_extensions()); 
?>

<html><head>
<title>!Конвертируем из SQL Lite (QDK) в MySQL (DK)</title>
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
 $crdate-=3600*12*24;
 $crdate8=$crdate+3600*20*24;

 echo $crdate.'<br>';

 $stage0=0;
 $stage1=0;
 $stage2=0;
 $stage3=0;
 $stage4=1;

if ($_GET["stage0"]=='0')  $stage0=0;
if ($_GET["stage1"]=='0')  $stage1=0;
if ($_GET["stage2"]=='0')  $stage2=0;
if ($_GET["stage3"]=='0')  $stage3=0;
if ($_GET["stage4"]=='0')  $stage4=0;

$section_num=4;

//----------------------------------------------------------------------------------------------------------------------------
if (0 && $stage4)
{
 $query = 'SELECT * FROM dev_2ip';
 echo $query.'<br>'; $cn=0;
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a)) 
	{
	 $dev[$cn]=$uy[1]; $flt[$cn]=$uy[6]; $prd[$cn]=$uy[14];	 
	 $cn++;
	}
 $flats=$cn; 

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"];
 for ($tn=1; $tn<=38; $tn++) 
	{		
	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);
	 $query = 'SELECT * FROM prdata WHERE (prm=6 OR prm=8) AND type=2 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{		 
		 for ($rr=0;$rr<$flats;$rr++) 
		 if ($dev[$rr]==$uy[1]) 
			{
			 //if ($uy[2]==6) $tgvs[$flt[$rr]][$tn]+=$uy[5];
			 //if ($uy[2]==8) $thvs[$flt[$rr]][$tn]+=$uy[5];
			 if ($uy[2]==6 && $prd[$rr]==0) $tgvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==8 && $prd[$rr]==0) $thvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==8 && $prd[$rr]==1) $tgvs[$rr][$tn]=$uy[5];
			 if ($uy[2]==6 && $prd[$rr]==1) $thvs[$rr][$tn]=$uy[5];
			}
		}

	 if ($tn>1)
	 for ($rr=0;$rr<$flats;$rr++) 
		{
		 if ($tgvs[$rr][$tn]<0.01) $tgvs[$rr][$tn]=$tgvs[$rr][$tn-1];
		 if ($thvs[$rr][$tn]<0.01) $thvs[$rr][$tn]=$thvs[$rr][$tn-1];
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

 for ($rr=0;$rr<$flats;$rr++)
 for ($tn=1; $tn<=38; $tn++) 
	{		
  	 if ($tgvs[$rr][$tn]>0 && $tgvs[$rr][$tn+1]>0 && $tgvs[$rr][$tn]>=$tgvs[$rr][$tn+1])
		if ($tgvs[$rr][$tn]-$tgvs[$rr][$tn+1]<1) $gvs[$flt[$rr]][$tn]+=$tgvs[$rr][$tn]-$tgvs[$rr][$tn+1];
		else $gvs[$flt[$rr]][$tn]=0;
  	 if ($thvs[$rr][$tn]>0 && $thvs[$rr][$tn+1]>0 && $thvs[$rr][$tn]>=$thvs[$rr][$tn+1])
		if ($thvs[$rr][$tn]-$thvs[$rr][$tn+1]<1) $hvs[$flt[$rr]][$tn]+=$thvs[$rr][$tn]-$thvs[$rr][$tn+1];
		else $hvs[$flt[$rr]][$tn]=0;
	}

 for ($tn=1; $tn<=38; $tn++) 
 for ($cn=1; $cn<=141; $cn++) 
	{		
	 if ($hvs[$cn][$tn]<3)
		{
		 $query = 'SELECT * FROM data WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$cn.',prm=12,source=6,type=2,value='.$hvs[$cn][$tn].',date='.$date1[$tn];
		 else $query = 'UPDATE data SET value='.$hvs[$cn][$tn].',date='.$date1[$tn].' WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
		 echo '['.$thvs[$cn][$tn].' - '.$thvs[$cn][$tn+1].'] '.$query.'<br>';  $a = mysql_query ($query,$i);
		}
	 if ($gvs[$cn][$tn]<3)
		{       
		 $query = 'SELECT * FROM data WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
		 echo $query.'<br>';
		 if ($a = mysql_query ($query,$i))
		 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$cn.',prm=12,source=5,type=2,value='.$gvs[$cn][$tn].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$gvs[$cn][$tn].',date='.$date1[$tn].' WHERE flat='.$cn.' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
		 echo '['.$tgvs[$cn][$tn].' - '.$tgvs[$cn][$tn+1].'] '.$query.'<br>'; $a = mysql_query ($query,$i);
		}
	}

}
//----------------------------------------------------------------------------------------------------------------------------
 $query = 'SELECT * FROM flats';
 if ($a=mysql_query ($query,$i))
 if (0)
 while ($uy = mysql_fetch_row ($a))
       	{
	 $query = 'UPDATE flats SET name="Квартира '.$uy[1].'",fname="Квартира '.$uy[1].'" WHERE id='.$uy[0]; echo $query.'<br>';	 
	 mysql_query ($query,$i);
	}
//----------------------------------------------------------------------------------------------------------------------------
if ($stage4)
{
 for ($sec=1;$sec<=$section_num;$sec++)
	{
	 $query = 'SELECT DISTINCT strut FROM field WHERE mnem='.$sec.' AND type=1 AND strut>0'; echo $query.'<br>'; $cn=0;
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 $strt[$sec][$cn]=$uy[0]; 
		 //echo '['.$sec.'/'.$cn.'] '.$strt[$sec][$cn].'<br>';
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

 $query = 'SELECT flat,square FROM flats'; echo $query.'<br>';
 if ($a = mysql_query ($query,$i))
 while ($uy = mysql_fetch_row ($a))  
    {
     $squar[$uy[0]]=$uy[1];
     $ssquar+=$squar[$uy[0]];
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
 $levels=10;

 $today=getdate();
 $ye=$today["year"];
 $mn=$today["mon"];
 $tm=$today["mday"]-1;
 for ($tn=1; $tn<=35; $tn++) 
	{		
	 $date1[$tn]=sprintf ("%d%02d%02d000000",$ye,$mn,$tm);

	 for ($sec=1;$sec<=$section_num;$sec++)
	 for ($st=0;$st<=$strut_n[$sec];$st++) 
	 for ($lv=1;$lv<=10;$lv++) 
		{
		 $strn=$strt[$sec][$st];
		 $sdh[$sec][$strn]=0;
		 $dh[$sec][$strn][$lv]=0;
		 $sdh_ok[$sec][$strn]=0;
		}

	 for ($rr=0;$rr<=$flats;$rr++) {  $Qfl[$rr]=0; $Qflo[$rr]=0; $Qflg[$rr]=0; }
	 $sumg=0;
	 $query = 'SELECT * FROM data WHERE prm=12 AND source=5 AND flat>0 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 $dgvs[$uy[4]]=$uy[3];
		 $sumg+=$uy[3];
		}

	 $query = 'SELECT * FROM prdata WHERE prm=1 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 //$data[$flt[$rr]][$str[$rr]]=$uy[5];
			 //$data[$rr]=$uy[5];
			 if ($uy[1]>30000000)
			    {
			     //echo 'sds='.$uy[7].'<br>';
			     //$data[$rr]=$uy[5];
    			     if ($uy[7]==0) $data[$rr]=$uy[5]/24;
    			    }
			 else $data[$rr]=$uy[5];
			 break;
			}
		}
	 $sumq=$qq=0;
	 $query = 'SELECT * FROM prdata WHERE prm=13 AND value>10 AND value<800 AND date='.$date1[$tn]; echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a)) 
		{
		 for ($rr=0;$rr<$devs;$rr++) 
		 if ($dev[$rr]==$uy[1])
			{
			 //$sttr=$str[$rr]-($sect[$rr]-1)*20;
			 $sttr=$str[$rr];
			 $Q[$sect[$rr]][$sttr]=$uy[5];
			 echo '['.$dev[$rr].'] Q['.$sect[$rr].']['.$sttr.'] se='.$sect[$rr].'='.$Q[$sect[$rr]][$sttr].'<br>';
			 $sumq+=$uy[5];
			 $qq++;
			 break;
			}
		}

         $QSvh=0;
         $query = 'SELECT * FROM data WHERE prm=13 AND type=2 AND flat=0 AND date='.$date1[$tn]; echo $query.'<br>';
         if ($a = mysql_query ($query,$i))
         while ($uy = mysql_fetch_row ($a)) 
            	{
    		 //$QSvh=$uy[3];
		 if ($uy[6]==0) $QSvh=$uy[3];
		 if ($uy[6]==4) $QSso=$uy[3];
		}
	 echo 'Qvh='.$QSvh.'| Qso='.$QSso.'<br>';

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

			 if ($h2 && $h1 && ($h2-$h1)<(50) && ($h2-$h1)>0) 
	    			{
	    			 $dh[$sec][$strut][$level]=$h2-$h1;
	    			 $sdh[$sec][$strut]+=($h2-$h1);
	    			}
	    		 else if ($h2 && $h1 && ($h1-$h2)<($h2/15) && ($h1-$h2)>0) 
	    			{
	    			 $dh[$sec][$strut][$level]=$h1-$h2;
	    			 $sdh[$sec][$strut]+=($h1-$h2);
	    			 $querys[$quu] = 'UPDATE field SET id1='.$uy[5].',id2='.$uy[4].' WHERE id='.$uy[0];
	    			 //echo $querys[$quu];
	    			 //mysql_query ($querys[$quu],$i);
	    			 $iddd[$quu]=$h1.'-'.$h2;
	    			 $quu++;
	    			}
	    		 else $dh[$sec][$strut][$level]=0;
	    		 //if ($level==1) $dh[$sec][$strut][$level]=$dh[$sec][$strut][$level]/3;

			 if (($h2-$h1)<=0 || ($h2-$h1)>(50)) echo '---['.$date1[$tn].'] ['.$sec.'/'.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$sec][$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			 else echo '['.$date1[$tn].'] ['.$sec.'/'.$strut.'/'.$level.'] ('.$uy[4].'='.$h2.')('.$uy[5].'='.$h1.') dh='.$dh[$sec][$strut][$level].' ['.$sdh[$sec][$strut].']<br>';
			}

		 for ($st=0;$st<=$strut_n[$sec];$st++) 
			{
			 $strn=$strt[$sec][$st]; // strut
			 $sdh[$sec][$strn]=0;
			 $sdh_ok[$sec][$strn]=0;
			 for ($lv=1;$lv<=$levels;$lv++)
				{
				 if ($dh[$sec][$strn][$lv]) //$dh[$strt[$st]][$lv]=$sdh[$strt[$st]]/$levels;
					{
					 $sdh[$sec][$strn]+=$dh[$sec][$strn][$lv];
					 $sdh_ok[$sec][$strn]++;
					}
				}

			 if ($sdh_ok[$sec][$strn]>=2)  
			 for ($lv=1;$lv<=$levels;$lv++) 
				{
				 $ssd=$sdh[$sec][$strn];
				 if ($dh[$sec][$strn][$lv]==0 || $dh[$sec][$strn][$lv]>(2*$sdh[$sec][$strn]/$sdh_ok[$sec][$strn]))
					{                                                                                        
                                         $sdh[$sec][$strn]-=$dh[$sec][$strn][$lv];
					 $dh[$sec][$strn][$lv]=$sdh[$sec][$strn]/$sdh_ok[$sec][$strn];
					 $sdh_ok[$sec][$strn]++;
                                         $sdh[$sec][$strn]+=$dh[$sec][$strn][$lv];
					}
				 echo '['.$date1[$tn].'] ('.$lv.'/'.$strn.') dH='.$dh[$sec][$strn][$lv].' ['.$sdh[$sec][$strn].']<br>';
				}

			 if ($sdh_ok[$sec][$strn]<2)  
				{
				 $sdh[$sec][$strn]=1.5*$levels;
				 for ($lv=1;$lv<=$levels;$lv++) 
					{
					 $dh[$sec][$strn][$lv]=1.5;
					 $sdh_ok[$sec][$strn]++;					
					 echo '!['.$date1[$tn].'] ('.$lv.'/'.$strn.') dH='.$dh[$sec][$strn][$lv].' ['.$sdh[$sec][$strn].']<br>';
					}
				}
			}		

		 $query = 'SELECT * FROM field WHERE type=1 AND strut>0 AND mnem='.$sec.' ORDER BY flat,strut';
//echo $query;
		 if ($a = mysql_query ($query,$i))
		 while ($uy = mysql_fetch_row ($a)) 
			{
			 $flat=$uy[6]; $strut=$uy[9]; $level=$uy[11];
			 if (0 && $dh[$sec][$strut][$level]<=0) 
				{
				 echo '>>>> '.$strut.'/'.$level.' '.$sdh[$sec][$strut].'/'.$sdh_ok[$sec][$strut];
				 //if ($sdh_ok[$sec][$strut]>0) $dh[sec][$strut][$level]=$sdh[$sec][$strut]/$sdh_ok[$sec][$strut];
				 //else $dh[sec][$strut][$level]=$sdh[$sec][$strut]/$levels;
				}
			 //echo $sdh[$sec][$strut].' '.$Qfl[$flat].' '.$Q[$sec][$strut].' '.$dh[$sec][$strut][$level].' '.$sdh[$sec][$strut];	
			 if ($qq>0 && $Q[$sec][$strut]==0) $Q[$sec][$strut]=$sumq/($qq);	 
			 if ($sdh[$sec][$strut]>0) $Qfl[$flat]+=$Q[$sec][$strut]*$dh[$sec][$strut][$level]/$sdh[$sec][$strut];			

			 echo '['.$sec.']'.'['.$date1[$tn].'] ('.$flat.'/'.$strut.'/'.$level.') '.$Q[$sec][$strut].'*'.$dh[$sec][$strut][$level].'/'.$sdh[$sec][$strut].'='.($Q[$sec][$strut]*$dh[$sec][$strut][$level]/$sdh[$sec][$strut]).' ['.$Qfl[$flat].']<br>';
			 //echo '['.$date1[$tn].'] ('.$sec.'/'.$flat.'/'.$strut.') '.$Q[$sec][$strut].'*'.$dh[sec][$strut][$level].'='.($Q[$sec][$strut]*$dh[sec][$strut][$level]).' ['.$Qfl[$flat].']<br>';
			}
		}
     $QS=0;
     for ($rr=0;$rr<=$flats;$rr++)  $QS+=$Qfl[$rr];
     $QSvh*=4186;
     $QSso*=4186;
     echo 'QSso='.$QSso.',QS='.$QS.'('.$sumq.') | S='.$ssquar.' V='.$sumq.' Vgv='.$sumg.'<br>';

     for ($rr=1;$rr<=$flats;$rr++)
     if ($QSso-$QS>0)
    	{
	 $Qflo[$rr]=($QSso-$QS)*$squar[$rr]/$ssquar;
        }
     else	
        {
         $Qflo[$rr]=0;
         if ($QSso==0) $Qfl[$rr]=0;
        }

	 $query = 'SELECT DISTINCT flat FROM field WHERE type=1 AND flat>0 ORDER BY flat';
	 if ($a = mysql_query ($query,$i))
	 while ($uy = mysql_fetch_row ($a))
		{
		 $flat=$uy[0];
		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=0,type=2,value='.$Qfl[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qfl[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=0 AND date='.$date1[$tn];
		 echo $query.' | '.$uy2[3].' | '.$Qfl[$flat].'<br>'; 
		 $a2 = mysql_query ($query,$i);	

		 $query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=1 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 if ($a2 = mysql_query ($query,$i))
		 if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=1,type=2,value='.$Qflo[$flat].',date='.$date1[$tn];
		 else	 $query = 'UPDATE data SET value='.$Qflo[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=1 AND date='.$date1[$tn];
		 echo $query.' | '.$uy2[3].' | '.$Qflo[$flat].'<br>'; 
		 $a2 = mysql_query ($query,$i);

		 //$query = 'SELECT * FROM data WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=2 AND date='.$date1[$tn];
		 //echo $query.'<br>';
		 //if ($a2 = mysql_query ($query,$i))
		 //if (!$uy2 = mysql_fetch_row ($a2)) $query = 'INSERT INTO data SET flat='.$flat.',prm=13,source=2,type=2,value='.$Qflg[$flat].',date='.$date1[$tn];
		 //else	 $query = 'UPDATE data SET value='.$Qflg[$flat].',date='.$date1[$tn].' WHERE flat='.$flat.' AND prm=13 AND type=2 AND source=2 AND date='.$date1[$tn];
		 //echo $query.' | '.$uy2[3].' | '.$Qflg[$flat].'<br>'; 
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
 if (0) 
 for ($tn=1; $tn<=90; $tn++) 
 for ($cn=0; $cn<$flats; $cn++) 
	{		
	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=6,type=2,value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else $query = 'UPDATE data SET value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=6 AND date='.$date1[$tn];
	 echo $query.'<br>'; $a = mysql_query ($query,$i);

	 $query = 'SELECT * FROM data WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 echo $query.'<br>';
	 if ($a = mysql_query ($query,$i))
	 if (!$uy = mysql_fetch_row ($a)) $query = 'INSERT INTO data SET flat='.$flt[$cn].',prm=12,source=5,type=2,value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn];
	 else	 $query = 'UPDATE data SET value='.$hvs[$flt[$cn]][$tn].',date='.$date1[$tn].' WHERE flat='.$flt[$cn].' AND prm=12 AND type=2 AND source=5 AND date='.$date1[$tn];
	 echo $query.'<br>'; $a = mysql_query ($query,$i);
	}
}

?>
                