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
$cm=1;  $id="dat".$cm;
while (!$_GET[$id] && $cm<200)
{
 $cm++; $id="dat".$cm;
}
$start=$cm;
while ($_GET[$id])
{
 $id="dat".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $dats[$cm-1-$start]=$_GET[$id];
 $id="d".$cm;
 if ($_GET[$id] || $_GET[$id]==0) $datas1[$cm-1-$start]=$_GET[$id]*1;
 $cm++;
 $id="dat".$cm;
}
$cm-=$start+1;
for ($rr=0; $rr<$cm; $rr++) 
	{ 
	 $data1[$cm-$rr-1]=$datas1[$rr]; 
	 $dat[$cm-$rr-1]=$dats[$rr]; 
	 //echo $data1[$cm-$rr-1].' '.$dat[$cm-$rr-1].'<br>';
	}

if ($_GET["size"]=='') $graph = new Graph(700,250,"auto");
else $graph = new Graph(600,250,"auto");
$graph->img->SetMargin(40,5,5,40);
$graph->SetScale("textlin");
$graph->SetShadow();
// Create the linear plot
$barplot=new BarPlot($data1);
$barplot->SetFillColor("blue");
$graph->SetMarginColor('lavender');
$graph->xaxis->SetTickLabels($dat);

//----------- title --------------------
$graph ->legend->Pos( 0.03,0.06,"right" ,"top");

$graph->Add($barplot);
$barplot->SetWidth(0.8);

$graph->title->SetFont(FF_ARIAL,FS_BOLD,9);
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,7); 

$title=$_GET["name"];
$graph->title->Set($title);
//--------------------------------------
// Display the graph
$graph->Stroke();
?>