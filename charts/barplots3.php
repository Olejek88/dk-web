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
$today=getdate();
if ($_GET["year"]=='') $ye=$today["year"];
else $ye=$_GET["year"];
if ($_GET["month"]=='') $mn='0'.$today["mon"];
else $mn=$_GET["month"];
if ($today["mday"]<20) { $today["mon"]--; $today["mday"]=31; }

$query = 'SELECT SUM(rnum),SUM(square) FROM flats';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);  $sum=$uy[0]; $sum0=$uy[1];

$query = 'SELECT * FROM device WHERE type=2 AND ust=1';
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

if ($_GET["size"]=='') $start=4;
$cn=8; $count=8;
$tm=$today["mon"];

while ($cn>=0)
    {	 
     if ($tm<10) $tm='0'.$tm;  $tn=$tm+1;
     if ($tn<10) $tn='0'.$tn;
     $tod=31;

     if ($tm==$today["mon"])
    	 $query = 'SELECT SUM(value) FROM data WHERE date LIKE \'%'.$today["year"].'-'.$tm.'%\' AND type=2 AND flat=0 AND prm=12 AND source=5';
     else
	 $query = 'SELECT SUM(value) FROM data WHERE date='.$today["year"].$tm.'01000000 AND type=4 AND flat=0 AND prm=12 AND source=5';
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e); $data0[$cn]=$ui[0];

     if ($tm==$today["mon"])
    	 $query = 'SELECT SUM(value) FROM data WHERE date LIKE \'%'.$today["year"].'-'.$tm.'%\' AND type=2 AND flat=0 AND prm=12 AND source=6';
	else $query = 'SELECT SUM(value) FROM data WHERE date='.$today["year"].$tm.'01000000 AND type=4 AND flat=0 AND prm=12 AND source=6';   
     $e = mysql_query ($query,$i);
     $ui = mysql_fetch_row ($e); $data1[$cn]=$ui[0];
     $data1[$cn]=$data1[$cn]-$data0[$cn];

     if ($tm==1) $dat[$cn]='Январь ';
     if ($tm==2) $dat[$cn]='Февраль ';
     if ($tm==3) $dat[$cn]='Март';
     if ($tm==4) $dat[$cn]='Апрель';
     if ($tm==5) $dat[$cn]='Май ';
     if ($tm==6) $dat[$cn]='Июнь';
     if ($tm==7) $dat[$cn]='Июль';
     if ($tm==8) $dat[$cn]='Август';
     if ($tm==9) $dat[$cn]='Сентябрь';
     if ($tm==10) $dat[$cn]='Октябрь';
     if ($tm==11) $dat[$cn]='Ноябрь';
     if ($tm==12) $dat[$cn]='Декабрь';
     $cn--;
     if ($tm==1) { $tm=12; $today["year"]--; }
     else $tm--;

     $uy = mysql_fetch_row ($a);
    }

$graph = new Graph(450,220,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$lineplot->SetFillColor("red");
$lineplot2=new BarPlot($data1);
$lineplot2->SetFillColor("blue");

$lineplot->SetWidth(0.8);
$lineplot2->SetWidth(0.8);

$lineplot->SetLegend("ГВС");
$lineplot2->SetLegend("ХВС");
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);
$graph->legend->SetAbsPos(70,10,'right','top');

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');

$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 
$lineplot2->value->Show();
$lineplot2->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
$graph->title->Set("Потребление ХВС и ГВС (м3)");

// Add the plot to the graph
$graph->img->SetMargin(38,8,25,25);
//----------- title --------------------
$gbplot  = new GroupBarPlot (array($lineplot ,$lineplot2)); 
$graph->Add($gbplot);
$gbplot->SetWidth(0.7);
//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>