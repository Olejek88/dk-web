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
if ($_GET["prm"]!='')  $query = 'SELECT * FROM prdata WHERE type=2 AND prm='.$_GET["prm"].' AND device='.$_GET["id"].' ORDER BY date DESC';
else  $query = 'SELECT * FROM prdata WHERE type=2 AND prm=1 AND device='.$_GET["id"].' ORDER BY date DESC';

  $data[0]=0; $p=0;
  if ($e2 = mysql_query ($query,$i))
  while ($ui2 = mysql_fetch_row ($e2))
     {
      $data[$p]=$ui2[5];
      //echo $data[$p].'<br>';
      if ($_GET["type"]==2) $dat[$p]=$ui2[4][8].$ui2[4][9];
      if ($_GET["type"]==1) $dat[$p]=$ui2[4][11].$ui2[4][12];	
	$p++;
     }

if ($_GET["type"]==1 || $_GET["type"]=='') $graph = new Graph(900,100,"auto");
if ($_GET["type"]==2) $graph = new Graph(900,100,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
$lineplot->SetShadow();
$lineplot->value->Show();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,7); 

// Add the plot to the graph
$graph->img->SetMargin(5,15,5,28);
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