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
$cm=0;
$id="dat".$cm;
while ($_GET[$id])
{
 $cm++; $id="dat".$cm;
}

$start=$cm-1; $cm=0;
$id="dat".$cm;
while ($_GET[$id])
{
 if ($_GET[$id] || $_GET[$id]==0) $dat[$start-$cm]=$_GET[$id];
 $id="qe".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $data1[$start-$cm]=$_GET[$id]*1;
 if ($data1[$start-$cm]<0) $data1[$start-$cm]=0;
 $cm++;
 $id="dat".$cm;
} 

for ($y=0;$y<$cm;$y++)
{
 //echo $y.' '.$dat[$y].' '.$data1[$y].'<br>';
}

$graph = new Graph(800,280,"auto");
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("blue");

//$graph->SetScale("textlin",0,0.045);
$graph->xaxis->SetTickLabels($dat);
$graph->yaxis->HideZeroLabel();
$graph->SetMarginColor('lavender');
//$lineplot->SetShadow();

$barplot->value->SetFont(FF_ARIAL,FS_NORMAL,10); 
$graph->title->Set("Ýíòàëüïèÿ (Êäæ*ñ/êã)");

// Add the plot to the graph
$graph->img->SetMargin(40,8,20,25);
//----------- title --------------------
$graph ->legend->Pos( 0.03,0.06,"right" ,"top");

$graph->Add($barplot);
$barplot->SetWidth(0.8);

//----------- legend -------------------
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,12);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8); 
// Display the graph
$graph->Stroke();
?>                           