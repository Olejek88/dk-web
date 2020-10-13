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
 include("../time.inc"); 

 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=2 AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum=$ui[0]; 

 $query = 'SELECT SUM(value) FROM data WHERE type=2 AND prm=13 AND source=3 AND date<'.$fn.' AND date>'.$st;	
 $e = mysql_query ($query,$i);
 if ($e) $ui = mysql_fetch_row ($e);
 $sum12=$ui[0]; 
 $sum=$sum12-$sum;

 $query = 'SELECT * FROM flats ORDER BY flat';
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); $cm=0; $all=0; $ssum0=$ssum1=$cold0=$hot0=0;
 while ($uy)
         {
	  $query = 'SELECT * FROM flats WHERE flat='.$uy[1];
	  $e = mysql_query ($query,$i);
	  $ui = mysql_fetch_row ($e);
	  $flat=$ui[1]; $abn=$ui[5]; $square=$ui[8]; $cold=0.046*31;
	  $nab=$ui[10];  $cold0+=$cold;

	  $query = 'SELECT * FROM dev_2ip WHERE flat_number='.$uy[1];
	  $b = mysql_query ($query,$i);
	  $ut = mysql_fetch_row ($b); $data01=$data02=0;
	  while ($ut)
	         {
		  $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<'.$fn.' AND date>'.$st.' AND device='.$ut[1].' ORDER BY date LIMIT 1';
		  $e = mysql_query ($query,$i);
        	  if ($e) $ui = mysql_fetch_row ($e);
	          if ($ui) $data02=$ui[5];

	 	  $query = 'SELECT * FROM prdata WHERE (type=2 OR type=1) AND prm=8 AND date<'.$fn.' AND date>'.$st.' AND device='.$ut[1].' ORDER BY date DESC LIMIT 1';
	          $e = mysql_query ($query,$i);
	          if ($e) $ui = mysql_fetch_row ($e);
	          if ($ui) $data12=$ui[5];  
	 	  $sum1[$uy[1]]=$data12-$data02;  $ssum1+=$sum1[$uy[1]];
		  $ut = mysql_fetch_row ($b); 
		 }
	 $uy = mysql_fetch_row ($a);
	}

if ($_GET["n1"]=='1') $query = 'SELECT * FROM flats WHERE ent=1 ORDER BY flat';
else $query = 'SELECT * FROM flats WHERE ent=2 ORDER BY flat';
$a = mysql_query ($query,$i); $cn=0;
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
    {
     $data0[$cn]=$sum*($sum1[$uy[1]])/$ssum1; $data1[$cn]=0;\
     $flat[$cn]=$uy[1];	  
	//echo $data0[$cn];
     $cn++;
     $uy = mysql_fetch_row ($a);
    }

$graph = new Graph(1100,350,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$lineplot2=new BarPlot($data1);
$lineplot->SetFillColor("red");
$lineplot2->SetFillColor("orange");

$graph->xaxis->SetTickLabels($flat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
//$lineplot->value->Show();
//$lineplot2->value->Show();
//$graph->Add($l1plot);

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
//$lineplot2->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
if ($_GET["n1"]==1) $title='Расход тепловой энергии на подготовку ГВС квартиры 1 подъезда за '.$month.' 2009 (ГКал)'; 
if ($_GET["n1"]==2) $title='Расход тепловой энергии на подготовку ГВС квартиры 2 подъезда за '.$month.' 2009 (ГКал)'; 
$graph->title->Set($title);

// Add the plot to the graph
$graph->img->SetMargin(35,10,5,23);
//----------- title --------------------
$gbplot = new AccBarPlot(array($lineplot,$lineplot2));
$graph->Add($gbplot);
//$graph->Add($l1plot);
//$gbplot->value->Show();	
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>        