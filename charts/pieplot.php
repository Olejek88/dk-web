<?php
include ("../jpgraph/jpgraph.php");
include ("../jpgraph/jpgraph_pie.php");
include ("../jpgraph/jpgraph_pie3d.php");
include("../config/local.php");
$arr = get_defined_vars();
$today=getdate ();
if ($today["mon"]>1) 
 {
  if ($today["mday"]<15) $today["mon"]=$today["mon"]-1;
 }
else { $today["mon"]=12; $today["year"]=$today["year"]-1; }
$i = mysql_connect ($mysql_host,$mysql_user,$mysql_password); $e=mysql_select_db ($mysql_db_name);
if ($_GET["id"]=='') $_GET["id"]=1;
$tim=$today["year"].$today["mon"].'01000000';

$query = 'SELECT * FROM device WHERE type=2 AND flat='.$_GET["id"];
$query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["id"];
$query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["id"];

$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $cm=0;
if ($uy) $dev=$uy[1];

$tarif1=747;
$tarif2=12.41;
$tarif3=0.0467*537;
$tarif4=1.27;

$data02=$data01=0;
$query = 'SELECT SUM(square) FROM flats';
$a = mysql_query ($query,$i);  
if ($a) $uy = mysql_fetch_row ($a);
if ($uy) $ss=$uy[0];

$query = 'SELECT square FROM flats WHERE flat='.$_GET["id"];
$a = mysql_query ($query,$i);  
if ($a) $uy = mysql_fetch_row ($a);
if ($uy) $square=$uy[0];

$query = 'SELECT SUM(value)/4186 FROM data WHERE type=2 AND prm=13 AND flat='.$_GET["id"];	
$e = mysql_query ($query,$i);
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data01=$ui[0];
$data0[0]=($data01)*$tarif1;

$data02=$data01=0;
$query = 'SELECT * FROM device WHERE type=4 AND flat='.$_GET["id"];
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $cm=0;
if ($uy) $dev=$uy[1];

$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=2 AND device='.$dev.' ORDER BY date LIMIT 1';
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data01=$ui[5];

$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=2 AND device='.$dev.' ORDER BY date DESC LIMIT 1';
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data02=$ui[5];
$data0[1]=($data02-$data01)*$tarif4;



$query = 'SELECT * FROM device WHERE type=2 AND flat='.$_GET["id"];
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $cm=0;
if ($uy) $dev=$uy[1];


$data02=$data01=0;
$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=6 AND date>20090300000000 AND device='.$dev.' ORDER BY date LIMIT 1';
//echo $query;
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data01=$ui[5];
$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=6 AND device='.$dev.' ORDER BY date DESC LIMIT 1';
//echo $query;
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data02=$ui[5];
$data0[2]=($data02-$data01)*$tarif2;

$data02=$data01=0;

$query = 'SELECT * FROM device WHERE type=2 AND flat='.$_GET["id"];
$a = mysql_query ($query,$i);
$uy = mysql_fetch_row ($a); $cm=0;
if ($uy) $dev=$uy[1];

$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=8 AND date>=20090300000000 AND device='.$dev.' ORDER BY date LIMIT 1';
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data01=$ui[5];

$query = 'SELECT * FROM prdata WHERE (type=1 OR type=2) AND prm=8 AND device='.$dev.' ORDER BY date DESC LIMIT 1';
$e = mysql_query ($query,$i); $p=0;
if ($e) $ui = mysql_fetch_row ($e);
if ($ui) $data02=$ui[5];

$data0[3]=($data02-$data01)*$tarif3;

//echo $data0[0].' | '.$data0[1].' | '.$data0[2].' | '.$data0[3];

// Create the Pie Graph 
$graph = new PieGraph(300,300,"auto");
$graph->SetShadow();

// Set A title for the plot
$graph->title->SetFont(FF_ARIAL,FS_BOLD,7);

// Create
$p1 = new PiePlot3D($data0);
$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,8);
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->title->SetColor("darkblue");
$graph->img->SetMargin(20,20,0,0);

$p1->SetAngle(50);
$p1->SetSliceColors(array('red','yellow','blue','green'));
$p1->SetCenter(0.5,0.5);
$p1->SetSize(0.5);
$p1->SetStartAngle(20); 
$name='Отчет '.$month.','.$today["year"];
//$graph->title->Set($name);
$p1->value->SetColor("darkred");
$p1->SetLabelPos(0.5);
$graph->legend->SetAbsPos(10,10,'right','top');
$p1->SetLegends(array('Тепло','Электричество','ХВС','ГВС'));
//$p1->SetAngle(0);
//$p1->SetGuideLines ();
//$p1->ExplodeSlice(1);
//$p1->ExplodeAll(10);

$graph->Add($p1);
$graph->Stroke();
?>