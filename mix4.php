<?php
include ("jpgraph/jpgraph.php");
include ("jpgraph/jpgraph_line.php");
include ("jpgraph/jpgraph_log.php");
include ("jpgraph/jpgraph_bar.php");
include("config/local.php");

$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$today=getdate();

if ($_GET["type"]==' ') $_GET["type"]='1';

for ($hr=0;$hr<=23;$hr++)
 {
  if ($hr<10) $date1='%0'.$hr.':00:00%'; else $date1='%'.$hr.':00:00%';
  $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE type=1 AND prm=12 AND source=6 AND flat=0 AND date>20090320000000 AND date LIKE \''.$date1.'\'';  
  $a = mysql_query ($query,$i);
  if ($a) $uy = mysql_fetch_row ($a); $qgvs=$uy[0];
  
  $data[$hr]=$uy[0]/$uy[1];  

  if ($_GET["type"]=='1') $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE type=1 AND prm=12 AND value<10 AND source=5 AND flat=0 AND date>20090320000000 AND date LIKE \''.$date1.'\'';  
  if ($_GET["type"]=='2') $query = 'SELECT SUM(value),COUNT(id) FROM data WHERE type=1 AND prm=12 AND source=6 AND flat=0 AND date>20090301000000 AND date LIKE \''.$date1.'\'';  
  if ($_GET["type"]=='3') $query = 'SELECT SUM(value),COUNT(id) FROM prdata WHERE type=1 AND prm=14 AND value<10 AND date>20090301000000 AND date LIKE \''.$date1.'\'';
  //echo $query.'<br>';
  $a = mysql_query ($query,$i);
  if ($a) $uy = mysql_fetch_row ($a);
  
  if ($_GET["type"]=='1') $uy[0]=$uy[0]-$qgvs;
  
  $data[$hr]=$uy[0]/$uy[1];  
  $dat[$hr]=$hr.':00';
 }

$graph = new Graph(800,300,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);

if ($_GET["type"]=='1') $lineplot->SetFillColor("blue");
if ($_GET["type"]=='2') $lineplot->SetFillColor("red");

$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(5,10,10,25);
//----------- title --------------------
$graph->Add($lineplot);
//----------- legend -------------------
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 
// Display the graph
$graph->Stroke();
?>