<link rel="stylesheet" href="shablon.css" type="text/css">
<?php
include("config/local.php");
$today=getdate ();
$bdate=$_POST["year"].$_POST["month"].$_POST["day"].'000000';
if ($today["hours"]<10) $today["hours"]='0'.$today["hours"];
if ($today["day"]==$_POST["day"])
    $edate=$_POST["eyear"].$_POST["emonth"].$_POST["eday"].$today["hours"].'0000';
else
    $edate=$_POST["eyear"].$_POST["emonth"].$_POST["eday"].'230000';
if ($_POST["otch"]==4)
{
 if ($_POST["month"]>1) $_POST["month"]--;
 else { $_POST["month"]=12; $_POST["year"]--; }
}

$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='koi8r'"; mysql_query ($query,$i);
$query = "set character_set_results='koi8r'"; mysql_query ($query,$i);
$query = "set collation_connection='koi8r_general_ci'"; mysql_query ($query,$i);

$prm=$_POST["prm"];
$max=0;

 $today=getdate();
 $beghour=$_POST["hour"]; $endhour=$ehour=$_POST["ehour"]; 
 $begday=$_POST["day"];  $endday=$day=$_POST["eday"];
 $begmonth=$_POST["month"]; $endmonth=$month=$_POST["emonth"];
 $begyear=$_POST["year"];  $endyear=$year=$_POST["eyear"];
 $btime=$begyear*100*100*100+$begmonth*100*100+$begday*100+$beghour;
 $etime=$endyear*100*100*100+$endmonth*100*100+$endday*100+$endhour;
 //echo $btime.'--'.$etime;

 if ($_POST["otch"]==0) { $mx=$_POST["hour"]; if ($begday!=$endday) $mn=0; else $mn=$beghour; $int=($etime-$btime)/300; } 
 if ($_POST["otch"]==1) { $mx=$_POST["hour"]; $mn=0; $int=($etime-$btime)/300; }
 if ($_POST["otch"]==2) { $mx=$endday; $mn=$begday; $int=($etime-$btime)/3000;}
 if ($_POST["otch"]==4) { $mx=$endmonth; $mn=$begmonth; $int=1;}

 if ($etime==$btime) 
	  {
	  //echo $btime.'='.$etime;
	   if ($_POST["day"]>1) { $_POST["day"]--; $begday--;}
			   else { $_POST["day"]=30; $_POST["month"]--; $begmonth--;}
	   $btime=$begyear*100*100*100+$_POST["month"]*100*100+$_POST["day"]*100+$beghour;
	   if ($_POST["day"]<10) $_POST["day"]='0'.$_POST["day"];
	   if ($_POST["month"]<10) $_POST["month"]='0'.$_POST["month"];
	   $bdate=$_POST["year"].$_POST["month"].$_POST["day"].'000000';
	  }

 $time=$etime;
 if ($_POST["otch"]==1) { $mx=$_POST["hour"]; $mn=0; }
 if ($_POST["otch"]==2) { $mx=$endday; $mn=$begday; }
 if ($_POST["otch"]==4) { $mx=$endmonth; $mn=$begmonth; }

 for ($pr=1;$pr<=20; $pr++) for ($o=0;$o<=10000; $o++) $data[$pr][$o]=0; $o=0;
 for ($pr=1;$pr<=20; $pr++) $sdata[$pr]=0;
 
 if ($_POST["device"]>0) $query = 'SELECT * FROM prdata WHERE type='.$_POST["otch"].' AND date>='.$bdate.' AND date<='.$edate.' AND device='.$_POST["device"].' ORDER BY date,prm DESC';
 else $query = 'SELECT * FROM prdata WHERE type='.$_POST["otch"].' AND date>='.$bdate.' AND date<='.$edate.' ORDER BY date,prm DESC'; 
 //if ($_POST["device"]>0) $query = 'SELECT * FROM prdata WHERE type='.$_POST["otch"].' AND date>='.$bdate.' AND date<='.$edate.' AND prm='.$_POST["prm"].' ORDER BY date DESC';
 //else $query = 'SELECT * FROM prdata WHERE type='.$_POST["otch"].' AND date>='.$bdate.' AND date<='.$edate.' ORDER BY date DESC'; 
 //echo $query;
 $a = mysql_query ($query,$i);
 if ($a) $uy = mysql_fetch_row ($a);
 $prtime=$uy[4];
 if ($a) while ($uy)
      {
       if ($_POST["device"]>0)
        if ($_POST["prm"]>0) $data[$_POST["prm"]][$o]=$uy[5];
        else { 
		if ($uy[7]==0) $data[$uy[2]][$o]=$uy[5];
		if ($data[$uy[2]][$o]==0 && $o>0 && $data[$uy[2]][$o-1]>0) $data[$uy[2]][$o]=$data[$uy[2]][$o-1];
		if ($uy[7]==1) $data0[$uy[2]][$o]=$uy[5];
		if ($data0[$uy[2]][$o]==0 && $o>0 && $data0[$uy[2]][$o-1]>0) $data0[$uy[2]][$o]=$data0[$uy[2]][$o-1];
		if ($uy[7]==0) $sdata[$uy[2]]=$sdata[$uy[2]]+$uy[5]; 
		if ($uy[7]==1) $sdata0[$uy[2]]=$sdata[$uy[2]]+$uy[5]; 
	     }
       $tim[$o]=$uy[4];
       //echo $o.' '.$uy[4].' '.$data[$uy[2]][$o].'<br>';
       //echo $uy[4].'='.$prtime.'<br>';
       if ($uy[4]!=$prtime) { $prtime=$uy[4]; $o++;   }
       $uy = mysql_fetch_row ($a);
      }
 $query = 'SELECT * FROM device WHERE idd='.$_POST["device"];
 $r = mysql_query ($query,$i);
 $uo = mysql_fetch_row ($r);     

 print '<table><tr><td align=center bgcolor=#c6c6c6><font class="zagl">Отчет по </font><font class="main">устройству '.$_POST["device"].' ('.$uo[20].')</font></td></tr><tr><td><table width=100%>';
 print '<tr><td bgcolor=#e6e6e6 align=center><font class="main">Время</font></td>';
	for ($pr=1;$pr<=20; $pr++) 
	    {
    	     if ($sdata[$pr]>0)
		{
	         $query = 'SELECT * FROM var WHERE dt='.$pr;
	         $a = mysql_query ($query,$i);
	         $uy = mysql_fetch_row ($a);
    	         print '<td bgcolor=#e6e6e6 align=center><font class="main">'.$uy[2].'</font></td>';
		}
    	     if ($sdata0[$pr]>0)
		{
	         $query = 'SELECT * FROM var WHERE dt='.$pr;
	         $a = mysql_query ($query,$i);
	         $uy = mysql_fetch_row ($a);
    	         print '<td bgcolor=#e6e6e6 align=center><font class="main">'.$uy[2].'[1]</font></td>';
		}
	    }
 print '</tr>';
 for ($p=0;$p<=$o; $p++)
    {
     print '<tr><td bgcolor=#e6e6e6 align=center>'.$tim[$p].'</td>';
     for ($pr=1;$pr<=20; $pr++) 
        {
         if  ($sdata[$pr]>0)
	    { 
    	     print '<td bgcolor=#ffffff align=center><font class=dwn>';
	     if ($data[$pr][$p]>0) print $data[$pr][$p];
	     print '</font></td>';
	    }
         if  ($sdata0[$pr]>0)
	    { 
    	     print '<td bgcolor=#ffffff align=center><font class=dwn>';
	     if ($data0[$pr][$p]>0) print $data0[$pr][$p];
	     print '</font></td>';
	    }
	}
    }
 print '</table></td></tr>';
 print '<tr><td><img border=0 src="xyplots6.php?otch='.$_POST["otch"].'&device='.$_POST["device"].'&year='.$_POST["year"].'&month='.$_POST["month"].'&day='.$_POST["day"].'&hour='.$_POST["hour"].'&eyear='.$_POST["eyear"].'&emonth='.$_POST["emonth"].'&eday='.$_POST["eday"].'&ehour='.$_POST["ehour"].'"></td></tr>';
?>