<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$arr = get_defined_vars();

$data[0]=$_GET["n1"];
$data[1]=$_GET["n2"];
$data[2]=$_GET["n3"];
$data[3]=$_GET["n4"];
$data[4]=$_GET["n5"];
if ($_GET["n6"]) $data[5]=$_GET["n6"];
if ($_GET["n7"]) $data[6]=$_GET["n7"];
if ($_GET["n8"]) $data[7]=$_GET["n8"];

// Create the Pie Graph 
$graph = new PieGraph(265,200,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,7);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(40);

$p1->SetSliceColors(array('green','#ee5544','#eeee33','#ee80ee','#775577','#999999','#aaaaaa','#cabaa9'));
$p1->SetCenter(0.5,0.5);
$p1->SetSize(120);
$p1->SetStartAngle(20); 
//$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
$graph->Stroke();
?>