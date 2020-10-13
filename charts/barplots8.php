<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_log.php");
include ("../jpgraph/jpgraph_bar.php");
include("../config/local.php");
$arr = get_defined_vars();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$query = "set character_set_client='cp1251'"; mysql_query ($query,$i);
$query = "set character_set_results='cp1251'"; mysql_query ($query,$i);
$query = "set collation_connection='cp1251_general_ci'"; mysql_query ($query,$i);
//------------------------------------------------------------------------

$query = 'SELECT * FROM prdata WHERE type='.$_GET["type"].' AND prm='.$_GET["prm"].' AND device='.$_GET["id"].' ORDER BY date DESC';
$a = mysql_query ($query,$i);
if ($a) $uy = mysql_fetch_row ($a);
while ($uy)
     {          
      $data0[$x]=$uy[5];
      //echo $data0[$x];
      $x++; 
      if ($x>40) break;
      $uy = mysql_fetch_row ($a);	     
     } 
  for ($tm=0; $tm<$x-1; $tm++)
    {     
     $data1[$tm]=$data0[$x-$tm-1];
    }

if ($_GET["type"]==1 || $_GET["type"]=='') $graph = new Graph(590,150,"auto");
if ($_GET["type"]==2) $graph = new Graph(590,150,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data1);
$graph->xaxis->HideLabels();
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7);

if ($prm==8) $title='√ор€ча€ вода по квартире '.$_GET["flat"].' нарастающим итогом (м3)';
if ($prm==6) $title='’олодна€ вода по квартире '.$_GET["flat"].' нарастающим итогом (м3)';

$graph->title->Set($title);
// Add the plot to the graph
$graph->img->SetMargin(5,10,5,10);
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