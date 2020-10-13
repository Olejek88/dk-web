<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_line.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------
$k[1][0]=0; $k[1][1]=1.74; $k[1][2]=1.9; $k[1][3]=1.41; $k[1][4]=1.75; $k[1][5]=1.7; $k[1][6]=1; $k[1][7]=1.5; $k[1][8]=1.76; 
$k[2][0]=0; $k[2][1]=1.72; $k[2][2]=1.04; $k[2][3]=1.42; $k[2][4]=1.73; $k[2][5]=1.76; $k[2][6]=1.94; $k[2][7]=1.49; $k[2][8]=1.75;
$k1[1][0]=0; $k1[1][1]=1.79; $k1[1][2]=1.84; $k1[1][3]=1.37; $k1[1][4]=1.55; $k1[1][5]=1.48; $k1[1][6]=1; $k1[1][7]=1.28; $k1[1][8]=1.71; 
$k1[2][0]=0; $k1[2][1]=1.48; $k1[2][2]=1.0; $k1[2][3]=1.28; $k1[2][4]=1.71; $k1[2][5]=1.79; $k1[2][6]=1.84; $k1[2][7]=1.37; $k1[2][8]=1.55;
$k2[1][0]=0; $k2[1][1]=1.1; $k2[1][2]=1.52; $k2[1][3]=1.18; $k2[1][4]=1.62; $k2[1][5]=1.12; $k2[1][6]=1.04; $k2[1][7]=1.15; $k2[1][8]=1.49; 
$k2[2][0]=0; $k2[2][1]=1.13; $k2[2][2]=1.0; $k2[2][3]=1.28; $k2[2][4]=1.63; $k2[2][5]=1.24; $k2[2][6]=1.7; $k2[2][7]=1.35; $k2[2][8]=1.46;

 include("../time.inc"); 

 if ($_GET["p"]=='') $query = 'SELECT SUM(value) FROM data WHERE type=2 AND value>20 AND (prm=13 OR prm=11) AND source=2 AND date>'.$_GET["st"].' AND date<'.$_GET["fn"];	
 else $query = 'SELECT SUM(value) FROM data WHERE type=2 AND value>20 AND (prm=13 OR prm=11) AND source=2 AND date>'.$_GET["st"].' AND date<'.$_GET["fn"];
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; 
 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];

 $query = 'SELECT * FROM dev_irp ORDER BY adr';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $sums=0;
 while ($uy)
        {
	 if ($_GET["p"]=='') $query = 'SELECT SUM(value),AVG(value),COUNT(id) FROM prdata WHERE type=2 AND value>20 AND (prm=13 OR prm=11) AND device='.$uy[1].' AND date>'.$_GET["st"].' AND date<'.$_GET["fn"];
	 else $query = 'SELECT SUM(value),AVG(value),COUNT(id) FROM prdata WHERE type=2 AND value>20 AND (prm=13 OR prm=11) AND device='.$uy[1].' AND date>'.$_GET["st"].' AND date<'.$_GET["fn"];
	 $e = mysql_query ($query,$i);
         if ($e) $ui = mysql_fetch_row ($e);	 	 
	 if ($uy[2]==39) { $irpdata[$uy[2]]=$irpdata[29]; $sums+=$irpdata[29]; }
	 else { $irpdata[$uy[2]]=$ui[0]+(30-$ui[2])*$ui[1];  $sums+=$irpdata[$uy[2]]; }
	 $uy = mysql_fetch_row ($a); 
	}
 $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE flat=0 AND type=2 AND prm=13 AND source=2 AND date<'.$fn.' AND date>'.$st;	
 //echo $query;
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; $nday=$ui[1];

 if ($sum-($sums/4168)<0) $sums=$sum*4168;

 $query = 'SELECT SUM(square),SUM(rnum) FROM flats';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $kk=$uy[0]; $kk1=$uy[1];

 if ($_GET["n1"]=='1') $query = 'SELECT * FROM flats WHERE ent=1 ORDER BY flat';
 else $query = 'SELECT * FROM flats WHERE ent=2 ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $flat[$cm]=$uy[1]; $abn[$cm]=$uy[5]; $square[$cm]=$uy[8]; $cold=number_format($uy[8]*0.0322*$nday/31,2);
	  $nab=$uy[10]; $cold0+=$cold;

	  $query = 'SELECT * FROM dev_bit WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); 
	  while ($ut)
	         {
		  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
		  $data01[$cm]+=$irpdata[$ui[2]]/(9*4186);
		  $ut = mysql_fetch_row ($b); 
		 }	
	  if ($sum-($sums/4186)<0) $sums=$sum*4186;
	  $data001[$cm]=(($sum-$sums/4186))*($square[$cm]/$kk);
	  $data01[$cm]+=$data001[$cm];
	  $data00[$cm]=($sum)*($square[$cm]/$kk);

	  $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND (source=0 OR source=1) AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
//echo $query;
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data02[$cm]=$ui[0]/4186; 

	  $query = 'SELECT SUM(value) FROM data WHERE value<4 AND type=2 AND prm=11 AND source=5 AND flat='.$uy[1].' AND date<'.$fn.' AND date>'.$st;	
	  $e = mysql_query ($query,$i);
	  if ($e) $ui = mysql_fetch_row ($e);
	  $data04[$cm]=$ui[0]; 

	  if ($data04[$cm]==0) $data04[$cm]=3.6*$uy[10]*$nday/30;
	  if ($data04[$cm]>50) $data04[$cm]=50;
	
	  $data03[$cm]=$cold; 
	  //echo $data00[$cm].' '.$data01[$cm].' '.$data02[$cm].' '.$data03[$cm].'<br>';
	  $data0+=$data00[$cm];
	  $data1+=$data01[$cm]; 
	  $data2+=$data02[$cm];
	  $data3+=$data03[$cm];
	  $data4+=$data04[$cm];
	  while (1)
		{
		 if ($data03[$cm]>($cold+$cold)) { $n1++; break; }
		 if ($data03[$cm]>$cold) { $n2++; break; }
		 $n0++; break;
		}
	  $sum0=$data03[$cm];
	  $cm++;	 
	  $datass[$uy[9]].='&s'.$cm.'='.number_format($data00[$cm-1],2).'&d'.$cm.'='.number_format($data01[$cm-1],2).'&n'.$cm.'='.number_format($data02[$cm-1],2);
	  $uy = mysql_fetch_row ($a);
	 }

while ($uy)
    {

	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat[$cn]=$ui[1]; $abn=$ui[5]; $square=$ui[8]; 
	  $nab=$ui[10];
	  $cold0+=$cold[$cn];

	  $query = 'SELECT * FROM dev_bit WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); $data0[$cn]=0;
	  while ($ut)
	         {
		  $query = 'SELECT * FROM dev_irp WHERE strut='.$ut[9];
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);

		  if ($ui[2]==39) { $data0[$cn]+=$irpdata[29]/(9*4168); }
		  else $data0[$cn]+=$irpdata[$ui[2]]/(9*4168);

		//echo $query.' '.$irpdata[$ui[1]];	
		  $ut = mysql_fetch_row ($b); 
		 }
	  $data0[$cn]=(1000/$square)*$data0[$cn];//+$data0[$cn]*(rand(-15,10)/100);
	  $data1[$cn]=(($sum-$sums/4168))*($square/$kk)*(1000/$square);
	  //echo $data1[$cn].' '.$sum.' '.$sums.'<br>';
	  //$sum0=$data01;
	  //$sum0=$data01+$data01*(rand(-15,10)/100);

          //if ($ui) $data01=$ui[0];
          //$sum0=$data01*($square/$kk);
	  //$sum0[$cn]=($data0[$cn]+$data0[$cn]*(rand(-15,10)/100))*(1000/$square);
	  //$sum0[$cn]=($data0[$cn]);
	  if ($type==2) { $data0[$cn]/=$k[$_GET["n1"]][$uy[11]];  }
	  if ($type==3) { $data0[$cn]/=$k1[$_GET["n1"]][$uy[11]]; }
	  if ($type==4) { $data0[$cn]/=$k2[$_GET["n1"]][$uy[11]]; }
	  $data2[$cn]=32.2;
	  $cn++;
	  $uy = mysql_fetch_row ($a);
	}

$graph = new Graph(1200,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$lineplot2=new BarPlot($data1);
$lineplot->SetFillColor("blue");
$lineplot2->SetFillColor("orange");

$l1plot=new LinePlot($data2);
$l1plot->SetColor("red");
$l1plot->SetWeight(2);

$graph->xaxis->SetTickLabels($flat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();
//$lineplot2->value->Show();
$graph->Add($l1plot);

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
//$lineplot2->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
if ($_GET["n1"]==1) $title='Удельный расход тепловой энергии на квартиры 1 подъезда за '.$month.' 2009 (ККал/м2)'; 
if ($_GET["n1"]==2) $title='Удельный расход тепловой энергии на квартиры 2 подъезда за '.$month.' 2009 (ККал/м2)'; 
$graph->title->Set($title);

// Add the plot to the graph
$graph->img->SetMargin(35,10,5,23);
//----------- title --------------------
$gbplot = new AccBarPlot(array($lineplot,$lineplot2));
$graph->Add($gbplot);
$graph->Add($l1plot);
//$gbplot->value->Show();	
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>        