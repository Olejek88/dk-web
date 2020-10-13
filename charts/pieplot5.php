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
$data[5]=$_GET["n6"];

// Create the Pie Graph 
$graph = new PieGraph(200,140,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,7);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(50);

//$p1->SetSliceColors(array('green','#ee5544','#eeee33','#ee80ee','#775577'));
$p1->SetSliceColors(array('#ee80ee','#ee5544','#eeee33','green','#775577'));
$p1->SetCenter(0.5,0.5);
$p1->SetSize(88);
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