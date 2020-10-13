<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$arr = get_defined_vars();
$today=getdate ();
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
$data[0]=1; $data[1]=1;

 $query = 'SELECT COUNT(id) FROM device WHERE conn=0 AND ust=0 AND type='.$_GET["type"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); if ($uy) $data[0]=$uy[0];
 $query = 'SELECT COUNT(id) FROM device WHERE conn=1 AND ust=0 AND type='.$_GET["type"];
 $a = mysql_query ($query,$i);
 $uy = mysql_fetch_row ($a); if ($uy) $data[1]=$uy[0];
 //echo $data[0].' '.$data[1];
 if ($_GET["type"]==5 && $data[1]==0) $data[1]=42;
 if ($data[0]==0) { $data[0]=0; $data[1]=$data[1]*10; }
 //echo $data[0].' '.$data[1];
// Create the Pie Graph 
$graph = new PieGraph(150,150,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot($data);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,7);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,7);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(20,20,0,0);

if ($data[0]==0) { $data[0]=$data[1]; $data[1]=0; $p1->SetSliceColors(array('red','green','blue')); }
else $p1->SetSliceColors(array('red','green','blue'));

$p1->SetCenter(0.5,0.5);
$p1->SetSize(0.4);
$p1->SetStartAngle(20); 
$p1->title->Set("BIT");
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
if ($data[0]>0) $graph->Stroke();
?>