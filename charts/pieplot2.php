<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$arr = get_defined_vars();
$today=getdate ();

$data[0]=$_GET["n1"];
$data[1]=$_GET["n2"];
$data[2]=$_GET["n3"];
$data[3]=$_GET["n4"];
$data[4]=$_GET["n5"];
$data[5]=$_GET["n6"];

$dat[0]=$_GET["dat1"];
$dat[1]=$_GET["dat2"];
$dat[2]=$_GET["dat3"];
$dat[3]=$_GET["dat4"];
$dat[4]=$_GET["dat5"];
$dat[5]=$_GET["dat6"];

// Create the Pie Graph 
$graph = new PieGraph(300,250,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,9);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(0,0,0,0);

$p1->SetAngle(50);
$p1->SetLegends($dat);

$p1->SetSliceColors(array('green','#ee5544','#eeee33','#ee80ee','#775577','#335555'));
$p1->SetCenter(0.49,0.62);
$p1->SetSize(133);
$p1->SetStartAngle(20); 
//$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
$graph->legend->SetAbsPos(5,5,'left','down');

$graph->Add($p1);
$graph->Stroke();
?>