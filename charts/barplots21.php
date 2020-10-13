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

$query = 'SELECT * FROM prdata WHERE type=0 AND prm='.$_GET["prm"].' AND pipe='.$_GET["src"].' AND device>80000000';
//echo $query;
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e);
if ($ui)
   {
    $data0[0]=$ui[5];
    $data0[1]=$_GET["ras"];
    $dat[0]="Факт";
    $dat[1]="Расч";
   }                                                

$graph = new Graph(130,100,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$lineplot=new BarPlot($data0);
$lineplot->SetFillColor("blue");

$graph->yaxis->HideZeroLabel();
//$graph->xaxis->HideLabels();
$graph->xaxis->SetTickLabels($dat);

$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();
$lineplot->value->SetFont(FF_ARIAL,FS_NORMAL,8); 
$lineplot->SetWidth(0.6); 
$lineplot->value->Show();
$lineplot->SetValuePos('center');

// Add the plot to the graph
$graph->img->SetMargin(5,10,5,25);
//----------- title --------------------
$graph->Add($lineplot);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>